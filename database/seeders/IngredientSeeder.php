<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Product;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Validation\Rules\In;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        Ingredient::factory()
            ->hasAttached(
                Product::inRandomOrder()->get(),
                [
                    'price' => $faker->randomFloat(0, 25, 100)
                ]
            )
            ->count(3)->create();
    }
}
