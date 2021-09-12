<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => ucfirst($this->faker->words(2, true)),
            'description' => $this->faker->sentences(3, true),
//            'image' => $this->faker->image('public/storage',640,480, null, false),
            'category_id' => Category::inRandomOrder()->first()->id,
            'price' => $this->faker->randomFloat(0, 90, 400),
        ];
    }
}
