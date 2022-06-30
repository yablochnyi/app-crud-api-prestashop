<?php

namespace App\Console\Commands;

use App\Http\Controllers\Prestashop\UpdateProductController;
use Illuminate\Console\Command;

class UpdatePrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:price';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update prices all products';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return UpdateProductController::updateAllProductPriceOnPrestaShop();
    }
}
