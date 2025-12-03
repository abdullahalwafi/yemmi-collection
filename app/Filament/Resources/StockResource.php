<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockResource\Pages;
use App\Filament\Resources\StockResource\RelationManagers;
use App\Models\Product;
use App\Models\Stock;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StockResource extends Resource
{
    protected static ?string $model = Stock::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Stock';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Radio::make('tipe')
                ->options([
                    'in' => 'IN (Masuk)',
                    'out' => 'OUT (Keluar)',
                ])
                ->required(),
            DatePicker::make('date')->label('Tanggal')->required(),
            Select::make('product_id')
                ->label('Produk')
                ->options(Product::query()->orderBy('name')->pluck('name', 'id')->toArray())
                ->searchable()
                ->required(),
            TextInput::make('qty')->numeric()->required()->minValue(1),
            TextInput::make('price')->label('Harga per unit')->numeric()->default(0),
            Textarea::make('ket')->label('Keterangan')->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->label('ID')->sortable(),
            Tables\Columns\BadgeColumn::make('tipe')
                ->label('Tipe')
                ->colors([
                    'success' => 'in',
                    'danger'  => 'out',
                ])
                ->formatStateUsing(fn($state) => $state === 'in' ? 'Masuk' : 'Keluar')
                ->sortable(),

            Tables\Columns\TextColumn::make('date')->date()->sortable(),
            Tables\Columns\TextColumn::make('product.name')->label('Produk')->searchable(),
            Tables\Columns\TextColumn::make('qty')->label('Qty')->sortable(),
            Tables\Columns\TextColumn::make('price')->label('Harga')->money('idr'),
            Tables\Columns\TextColumn::make('ket')->label('Keterangan')->limit(40),
        ])->filters([
            Tables\Filters\SelectFilter::make('product')->relationship('product', 'name'),
            Tables\Filters\Filter::make('tipe')->form([
                Forms\Components\Select::make('tipe')->options([
                    'in' => 'in',
                    'out' => 'out',
                ]),
            ]),
        ])->actions([
            Tables\Actions\EditAction::make(),
        ])->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
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
            'index' => Pages\ListStocks::route('/'),
            'create' => Pages\CreateStock::route('/create'),
            'edit' => Pages\EditStock::route('/{record}/edit'),
        ];
    }
}
