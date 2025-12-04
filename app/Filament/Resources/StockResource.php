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
            Radio::make('tipe')
                ->options([
                    'in' => 'Penambahan',
                    'out' => 'Penjualan',
                ])
                ->required()
                ->reactive(),

            DatePicker::make('date')->label('Tanggal')->required(),

            Repeater::make('items')
                ->label('Items')
                ->schema([
                    Select::make('product_id')
                        ->label('Produk')
                        ->options(fn() => Product::orderBy('name')->pluck('name', 'id')->toArray())
                        ->searchable()
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set) {
                            $product = \App\Models\Product::find($state);
                            $set('price', $product ? (string) $product->price : '0');
                            $set('capital_price', $product ? (string) $product->capital_price : '0');
                        })
                        ->required(),

                    TextInput::make('qty')
                        ->label('Qty')
                        ->numeric()
                        ->required()
                        ->minValue(1)
                        ->reactive(),

                    TextInput::make('capital_price')
                        ->label('Harga modal')
                        ->numeric()
                        ->readOnly()
                        ->dehydrated(true),
                    TextInput::make('price')
                        ->label('Harga per unit')
                        ->numeric()
                        ->readOnly()
                        ->dehydrated(true),
                ])
                ->columns(2)
                ->createItemButtonLabel('Tambah Produk')
                ->minItems(1)
                ->dehydrated(true),

            Textarea::make('ket')->label('Keterangan (opsional)')->nullable()->cols(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID')->sortable(),
                Tables\Columns\BadgeColumn::make('tipe')
                    ->label('Tipe')
                    ->colors([
                        'success' => 'in',
                        'danger'  => 'out',
                    ])
                    ->formatStateUsing(fn($state) => $state === 'in' ? 'Penambahan' : 'Penjualan')
                    ->sortable(),

                Tables\Columns\TextColumn::make('date')->date()->sortable(),
                Tables\Columns\TextColumn::make('invoice')->label('Invoice')->sortable(),
                Tables\Columns\TextColumn::make('product.name')->label('Produk')->searchable(),
                Tables\Columns\TextColumn::make('qty')->label('Qty')->sortable(),
                Tables\Columns\TextColumn::make('price')->label('Harga (jual)')->money('idr'),
                Tables\Columns\TextColumn::make('product.capital_price')->label('Capital (produk)')->money('idr'),
                Tables\Columns\TextColumn::make('ket')->label('Keterangan')->limit(40),
            ])


            // FILTER BIASA (opsional, bisa tetap dipakai)
            ->filters([
                Tables\Filters\SelectFilter::make('product_id')
                    ->label('Produk')
                    ->options(fn() => Product::orderBy('name')->pluck('name', 'id')->toArray()),

                Tables\Filters\SelectFilter::make('tipe')
                    ->label('Jenis Transaksi')
                    ->options([
                        ''    => 'Semua',
                        'in'  => 'Penambahan',
                        'out' => 'Penjualan',
                    ])
                    ->default('')
                    ->native(false), // agar tampil sebagai segmented / dropdown yang rapi
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
