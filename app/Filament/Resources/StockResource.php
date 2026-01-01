<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockResource\Pages;
use App\Models\Product;
use App\Models\Stock;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Tabs\Tab;
use Filament\Forms\Get;
use Filament\Forms\Set;

class StockResource extends Resource
{
    protected static ?string $model = Stock::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Stock';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = null;

    public static function form(Form $form): Form
    {
        return $form->schema([

            /* =====================================================
            * INFORMASI TRANSAKSI
            * ===================================================== */
            Section::make('Informasi Transaksi')
                ->schema([
                    Radio::make('tipe')
                        ->label('Jenis Transaksi')
                        ->options([
                            'in'  => 'Penambahan Stok',
                            'out' => 'Penjualan',
                        ])
                        ->required()
                        ->reactive(),

                    DatePicker::make('date')
                        ->label('Tanggal')
                        ->required(),
                ])
                ->columns(2),

            /* =====================================================
            * DETAIL PRODUK
            * ===================================================== */
            Section::make('Detail Produk')
                ->schema([
                    Repeater::make('items')
                        ->label('Daftar Produk')
                        ->relationship('items')
                        ->schema([

                            /* ========================
                            * PRODUK
                            * ======================== */
                            Select::make('product_id')
                                ->label('Produk')
                                ->options(
                                    fn() =>
                                    Product::orderBy('name')
                                        ->get()
                                        ->mapWithKeys(fn($p) => [
                                            $p->id => "{$p->name} (Stok: {$p->qty})"
                                        ])
                                        ->toArray()
                                )
                                ->searchable()
                                ->required()
                                ->reactive()
                                ->disableOptionsWhenSelectedInSiblingRepeaterItems()

                                // 🔑 SAAT EDIT: isi ulang price, stock, total
                                ->afterStateHydrated(function ($state, Set $set, Get $get) {
                                    if (! $state) return;

                                    $product = Product::find($state);
                                    if (! $product) return;

                                    $tipe = $get('../../tipe');

                                    $price = $tipe === 'in'
                                        ? $product->capital_price
                                        : $product->price;

                                    $set('price', $price);
                                    $set('current_stock', $product->qty);

                                    $qty = (int) ($get('qty') ?? 0);
                                    $set('total', $qty * $price);
                                })

                                // 🔁 SAAT CREATE / GANTI PRODUK
                                ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                    if (! $state) return;

                                    $product = Product::find($state);
                                    if (! $product) return;

                                    $tipe = $get('../../tipe');

                                    $price = $tipe === 'in'
                                        ? $product->capital_price
                                        : $product->price;

                                    $set('price', $price);
                                    $set('current_stock', $product->qty);

                                    $qty = (int) ($get('qty') ?? 0);
                                    $set('total', $qty * $price);

                                    // update grand total
                                    $items = $get('../../items') ?? [];
                                    $grand = collect($items)->sum(fn($i) => $i['total'] ?? 0);
                                    $set('../../grand_total', $grand);
                                }),

                            /* ========================
                            * QTY
                            * ======================== */
                            TextInput::make('qty')
                                ->label('Qty')
                                ->numeric()
                                ->minValue(1)
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                    $price = (float) ($get('price') ?? 0);
                                    $total = $state * $price;
                                    $set('total', $total);

                                    // update grand total
                                    $items = $get('../../items') ?? [];
                                    $grand = collect($items)->sum(fn($i) => $i['total'] ?? 0);
                                    $set('../../grand_total', $grand);
                                }),

                            /* ========================
                 * HARGA / UNIT
                 * ======================== */
                            TextInput::make('price')
                                ->label('Harga / Unit')
                                ->numeric()
                                ->readOnly()
                                ->dehydrated(true),

                            /* ========================
                            * TOTAL PER ITEM
                            * ======================== */
                            TextInput::make('total')
                                ->label('Total')
                                ->numeric()
                                ->readOnly()
                                ->dehydrated(false),

                            /* ========================
                            * STOK SAAT INI
                            * ======================== */
                            TextInput::make('current_stock')
                                ->label('Stok Saat Ini')
                                ->numeric()
                                ->readOnly()
                                ->dehydrated(false),
                        ])
                        ->columns(5)
                        ->minItems(1)
                        ->createItemButtonLabel('Tambah Produk')
                        ->deletable()
                        ->dehydrated(true),

                    /* ========================
                    * GRAND TOTAL
                    * ======================== */
                    TextInput::make('grand_total')
                        ->label('Total Keseluruhan')
                        ->numeric()
                        ->readOnly()
                        ->prefix('Rp')
                        ->default(0)
                        ->dehydrated(false),
                ]),
            /* =====================================================
            * KETERANGAN
            * ===================================================== */
            Section::make('Keterangan')
                ->schema([
                    Textarea::make('ket')
                        ->label('Catatan')
                        ->rows(3)
                        ->nullable(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('row_index')
                    ->label('No.')
                    ->rowIndex(),

                Tables\Columns\TextColumn::make('invoice')
                    ->label('Invoice')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('tipe')
                    ->label('Tipe')
                    ->colors([
                        'success' => 'in',
                        'danger'  => 'out',
                    ])
                    ->formatStateUsing(
                        fn($state) =>
                        $state === 'in' ? 'Penambahan' : 'Penjualan'
                    )
                    ->sortable(),

                Tables\Columns\TextColumn::make('date')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),

                // ===== PRODUK (MULTI ITEM) =====
                Tables\Columns\TextColumn::make('items')
                    ->label('Produk')
                    ->formatStateUsing(function ($record) {
                        return $record->items
                            ->map(
                                fn($item) =>
                                "{$item->product->name} ({$item->qty})"
                            )
                            ->implode(', ');
                    })
                    ->wrap()
                    ->limit(60)
                    ->tooltip(
                        fn($record) =>
                        $record->items
                            ->map(
                                fn($item) =>
                                "{$item->product->name} ({$item->qty})"
                            )
                            ->implode(', ')
                    ),

                // ===== TOTAL QTY =====
                Tables\Columns\TextColumn::make('total_qty')
                    ->label('Total Qty')
                    ->state(
                        fn($record) =>
                        $record->items->sum('qty')
                    ),

                // ===== TOTAL NILAI =====
                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total Nilai')
                    ->state(
                        fn($record) =>
                        $record->items->sum(
                            fn($item) =>
                            $item->qty * $item->price
                        )
                    )
                    ->money('idr'),

                Tables\Columns\TextColumn::make('ket')
                    ->label('Keterangan')
                    ->limit(30)
                    ->toggleable(),
            ])

            ->filters([
                Tables\Filters\SelectFilter::make('tipe')
                    ->label('Jenis Transaksi')
                    ->options([
                        'in'  => 'Penambahan',
                        'out' => 'Penjualan',
                    ]),

                Tables\Filters\Filter::make('date')
                    ->form([
                        Forms\Components\DatePicker::make('from')->label('Dari'),
                        Forms\Components\DatePicker::make('until')->label('Sampai'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['from'] ?? null,
                                fn($q) => $q->whereDate('date', '>=', $data['from'])
                            )
                            ->when(
                                $data['until'] ?? null,
                                fn($q) => $q->whereDate('date', '<=', $data['until'])
                            );
                    }),
            ])

            ->actions([
                Tables\Actions\EditAction::make(),
            ])

            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])

            ->defaultSort('date', 'desc');
    }


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListStocks::route('/'),
            'create' => Pages\CreateStock::route('/create'),
            'edit'   => Pages\EditStock::route('/{record}/edit'),
        ];
    }
}
