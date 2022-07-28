<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\RelationManagers;
use Filament\Resources\Resource;
use Filament\Navigation\NavigationItem;
class PrestaShopResource extends Resource
{

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'PrestaShop';

    public static function getNavigationItems(): array
    {
        return [
            NavigationItem::make()
                ->icon('heroicon-o-check')
                ->label('Add all products')
                ->group('PrestaShop')
                ->isActiveWhen(fn (): bool => request()->routeIs('add.all.prestashop'))
                ->url(route('add.all.prestashop')),
            NavigationItem::make()
                ->icon('heroicon-o-currency-dollar')
                ->label('Update all price')
                ->group('PrestaShop')
                ->isActiveWhen(fn (): bool => request()->routeIs('update.all.price.prestashop'))
                ->url(route('update.all.price.prestashop')),
            NavigationItem::make()
                ->icon('heroicon-o-collection')
                ->label('Update all quantity')
                ->group('PrestaShop')
                ->isActiveWhen(fn (): bool => request()->routeIs('update.all.quantity.prestashop'))
                ->url(route('update.all.quantity.prestashop')),
            NavigationItem::make()
                ->icon('heroicon-o-collection')
                ->label('Get categories from PrestaShop')
                ->group('App - crud RME')
                ->isActiveWhen(fn (): bool => request()->routeIs('get.category'))
                ->url(route('get.category'))
                ->sort(2),
            NavigationItem::make()
                ->icon('heroicon-o-collection')
                ->label('Get products from PrestaShop')
                ->group('App - crud RME')
                ->isActiveWhen(fn (): bool => request()->routeIs('get.product'))
                ->url(route('get.product'))
                ->sort(3),
        ];
    }

}

