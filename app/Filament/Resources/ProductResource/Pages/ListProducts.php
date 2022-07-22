<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Http\Controllers\ExportImportController;
use App\Imports\Products;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\ButtonAction;
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
            Action::make('settings')->color('secondary')
        ];
    }

    protected function getForms(): array
    {
        return array_merge(
            parent::getForms(),
            $this->getTableForms(),
            [
                //merge your own form with default ones
                'customForm' => $this->makeForm()
                    ->schema([
                        //your fields
                    ])
                    ->model(ProductResource::class),
            ]
        );
    }

    protected function getTableBulkActions(): array
    {
        return [
            BulkAction::make('dvdsvdf'),
        ];
    }


    protected function getTableHeaderActions(): array
    {
        return array_merge(parent::getTableHeaderActions(), [
            ButtonAction::make('Export')->url(route('export'))->color('primary')->icon('heroicon-o-document-text'),
            ButtonAction::make('Import')
                ->color('secondary')
                ->icon('heroicon-o-document-text')
                ->modalContent(view('admin.product.modal'))
                ->action(fn () => view('admin.product.modal')),
//            Action::make('import')
//                ->color('secondary')
//                ->icon('heroicon-s-duplicate')
//                ->modalContent(view('admin.product.modal'))
//                ->action(function (Request $request) {
//                    $path = $request->file('import')->getRealPath();
//                    Excel::import(new Products(), $path);
//                }),
    ]);
    }
}
