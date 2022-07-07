<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('item_code');
            $table->string('product_number')->nullable();
            $table->text('product_name');
            $table->unsignedBigInteger('category_id');
            $table->string('unit');
            $table->integer('quantity');
            $table->float('price_aed');
            $table->softDeletes();
            $table->timestamps();

            $table->index('category_id', 'product_category_idx');

            $table->foreign('category_id', 'product_category_fk')->on('categories')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
