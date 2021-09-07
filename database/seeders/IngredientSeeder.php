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

        Ingredient::factory()->count(25)->create();

        Ingredient::all()->each(function ($ingredient) use ($faker) {
            $ingredient->products()->attach(
                Product::inRandomOrder()->first()->id,
                [
                    'price' => $faker->randomFloat(0, 25, 100),
                ]
            );
        });

    }
}
