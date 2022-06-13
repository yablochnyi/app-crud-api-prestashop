<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'item_code' => $this->faker->numberBetween(1, 20),
            'product_number' => $this->faker->numberBetween(1, 20),
            'product_name' => $this->faker->text(10),
            'unit' => $this->faker->randomNumber(),
            'quantity' => $this->faker->numberBetween(1,20),
            'price_aed' =>$this->faker->randomNumber(1,20)
        ];
    }
}
