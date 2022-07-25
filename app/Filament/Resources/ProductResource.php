<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationGroup = 'App - crud RME';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('item_code')->required()->rule('integer'),
                Forms\Components\TextInput::make('product_number')->required()->rule('string')->unique(),
                Forms\Components\TextInput::make('product_name')->required()->rule('string'),
                Forms\Components\BelongsToSelect::make('category_id')
                    ->relationship('category', 'title')->required(),
                Forms\Components\RichEditor::make('description')->rule('string'),
                Forms\Components\RichEditor::make('short_description')->rule('string'),
                Forms\Components\TextInput::make('unit')->required(),
                Forms\Components\TextInput::make('quantity')->required(),
                Forms\Components\TextInput::make('price_aed')->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('item_code')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('product_number')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('product_name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('category.title')->sortable()->searchable(),
                Tables\Columns\BooleanColumn::make('description')->sortable()
                    ->getStateUsing(fn ($record): bool => filled($record->description)),
                Tables\Columns\BooleanColumn::make('short_description')->sortable()
                    ->getStateUsing(fn ($record): bool => filled($record->short_description)),
                Tables\Columns\TextColumn::make('unit')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('quantity')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('price_aed')->sortable()->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                BulkAction::make('Add to prestashop')
                    ->action(fn (Product $record) => route('add.prestashop', ['product' => $record]))
                    ->requiresConfirmation()
                    ->color('success')
                    ->icon('heroicon-o-check'),
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
