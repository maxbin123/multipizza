<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition()
    {
        return [
            'quantity' => $this->faker->numberBetween(1, 4),
            'product_id' => Product::inRandomOrder()->first()->id
        ];
    }
}
