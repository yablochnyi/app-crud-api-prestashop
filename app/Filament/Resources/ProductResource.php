<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Http\Controllers\Prestashop\DeleteController;
use App\Models\Product;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ButtonAction;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Facades\Excel;

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
            ->headerActions([
                ButtonAction::make('Export')->url(route('export'))->color('primary')->icon('heroicon-o-document-text'),
                ButtonAction::make('Import')->color('primary')->icon('heroicon-o-document-text')
                    ->action(function ($data) {
                        Excel::import(new \App\Imports\Products(), storage_path('app/public/' . $data['import']));
                        Filament::notify('success', 'Import Has Been updated successfully');
                    })
                    ->form([
                        Forms\Components\FileUpload::make('import')
                            ->required()
                    ])
            ])
            ->actions([
                Action::make('Add to prestashop')
                    ->url(fn (Product $record): string => route('add.prestashop', $record))
                    ->icon('heroicon-o-check'),
                Action::make('Update price')
                    ->url(fn (Product $record): string => route('update.price.prestashop', $record))
                    ->icon('heroicon-o-currency-dollar'),
                Action::make('Update quantity')
                    ->url(fn (Product $record): string => route('update.quantity.prestashop', $record))
                    ->icon('heroicon-o-collection'),

            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('Delete selected')
                    ->action(fn (Collection $records) => DeleteController::deleteToPrestashopAndDatabase($records))
                    ->requiresConfirmation()
                    ->color('danger')
                    ->icon('heroicon-s-trash')
                    ->successNotificationMessage('Products deleted'),
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

