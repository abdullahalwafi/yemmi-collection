<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationLabel = 'Product';
    protected static ?string $slug = 'product';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = null;


    public static function form(Form $form): Form
    {
        return $form->schema([

            Tables\Columns\TextColumn::make('row_index')
                ->label('No.')
                ->rowIndex(),

            TextInput::make('name')->required()->maxLength(255),
            Select::make('category_id')
                ->label('Kategori')
                ->options(Category::query()->pluck('name', 'id')->toArray())
                ->searchable()
                ->required(),
            Select::make('supplier_id')
                ->label('Supplier')
                ->options(Supplier::query()->pluck('name', 'id')->toArray())
                ->searchable()
                ->nullable(),
            Textarea::make('deskripsi')->label('Deskripsi')->nullable(),
            TextInput::make('qty')->label('Qty')->numeric()->default(0),
            TextInput::make('price')->label('Price')->numeric()->default(0),
            TextInput::make('capital_price')->label('Capital Price')->numeric()->default(0),
            Placeholder::make('info')->content('Perubahan qty tidak merubah riwayat stok. Gunakan menu Stok untuk mutasi.'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->label('ID')->sortable(),
            Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('category.name')->label('Category')->sortable()->toggleable(),
            Tables\Columns\TextColumn::make('supplier.name')->label('Supplier')->toggleable(),
            Tables\Columns\TextColumn::make('qty')->label('Qty')->sortable(),
            Tables\Columns\TextColumn::make('price')->money('idr'),
            Tables\Columns\TextColumn::make('capital_price')->money('idr'),
            Tables\Columns\TextColumn::make('created_at')->label('Created')->dateTime(),
        ])->filters([
            //
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
