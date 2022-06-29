<?php

namespace App\Console\Commands;

use App\Http\Controllers\Prestashop\UpdateProductController;
use Illuminate\Console\Command;

class UpdateQuantity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:quantity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update quantity all products';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return UpdateProductController::updateAllProductQuantityOnPrestaShop();
    }
}
