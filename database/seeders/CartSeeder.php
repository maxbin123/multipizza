<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Cart;
use App\Models\Ingredient;
use App\Models\Item;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $cart = Cart::create([
            'user_id' => User::inRandomOrder()->first()->id,
            'branch_id' => Branch::inRandomOrder()->first()->id,
        ]);

        $item = new Item();
        $item->product_id = Product::inRandomOrder()->first()->id;

        $cart->items()->save($item);
        $cart->items->first()->ingredients()->attach(
            Ingredient::inRandomOrder()->first(),
            ['price' => $faker->randomFloat(0, 30, 150)]
        );
    }
}
