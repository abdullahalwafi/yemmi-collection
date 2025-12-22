<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockResource\Pages;
use App\Models\Product;
use App\Models\Stock;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Tabs\Tab;


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
            Forms\Components\Section::make('Informasi Transaksi')
                ->schema([
                    Radio::make('tipe')
                        ->label('Jenis Transaksi')
                        ->options([
                            'in'  => 'Penambahan Stok',
                            'out' => 'Penjualan',
                        ])
                        ->required()
                        ->inline(),

                    DatePicker::make('date')
                        ->label('Tanggal')
                        ->required(),
                ])
                ->columns(2),

            Forms\Components\Section::make('Detail Produk')
                ->schema([
                    Repeater::make('items')
                        ->relationship('items')
                        ->label('Daftar Produk')
                        ->schema([
                            Select::make('product_id')
                                ->label('Produk')
                                ->relationship('product', 'name')
                                ->searchable()
                                ->required(),

                            TextInput::make('qty')
                                ->label('Qty')
                                ->numeric()
                                ->minValue(1)
                                ->required(),

                            TextInput::make('price')
                                ->label('Harga')
                                ->numeric()
                                ->required(),
                        ])
                        ->columns(3)
                        ->minItems(1)
                        ->createItemButtonLabel('Tambah Produk')
                        ->deletable()
                        ->reorderable(false),
                ]),

            Forms\Components\Section::make('Keterangan')
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
