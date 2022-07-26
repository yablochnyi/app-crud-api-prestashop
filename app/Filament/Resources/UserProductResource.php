<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserProductResource\Pages;
use App\Filament\Resources\UserProductResource\RelationManagers;
use App\Models\UserProduct;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class UserProductResource extends Resource
{
    protected static ?string $model = UserProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationLabel = 'Products RME';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('item_code')->required()->rule('integer'),
                Forms\Components\TextInput::make('product_number')->required()->rule('string'),
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
            ])
            ->bulkActions([
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
            'index' => Pages\ListUserProducts::route('/'),
        ];
    }
}
