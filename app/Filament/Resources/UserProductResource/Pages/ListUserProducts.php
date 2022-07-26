<?php

namespace App\Filament\Resources\UserProductResource\Pages;

use App\Filament\Resources\UserProductResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserProducts extends ListRecords
{
    protected static string $resource = UserProductResource::class;

    protected static ?string $title = 'Products RME';

    protected function getActions(): array
    {
        return [
        ];
    }
}
