<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Http\Controllers\ExportImportController;
use App\Imports\Products;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Actions;
use Filament\Tables\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\ButtonAction;
use App\Models\User;
use Filament\Forms;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ListProducts extends ListRecords implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = ProductResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableHeaderActions(): array
    {
        return array_merge(parent::getTableHeaderActions(), [
            ButtonAction::make('Export')->url(route('export'))->color('primary')->icon('heroicon-o-document-text'),
            Action::make('updateAuthor')
                ->action(function (Request $request) {
                })
                ->form([
                    Forms\Components\FileUpload::make('attachment')
                        ->required()
                ])
    ]);
    }
}
