<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Item;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Database\Factories\OrderFactory;
use Faker\Factory;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $order = Order::create([
            'user_id' => User::inRandomOrder()->first()->id,
        ]);

        $item = new Item();
        $item->product_id = Product::inRandomOrder()->first()->id;

        $order->items()->save($item);
        $order->items->first()->ingredients()->attach(
            Ingredient::inRandomOrder()->first(),
            ['price' => $faker->randomFloat(0, 30, 150)]
        );
    }
}
