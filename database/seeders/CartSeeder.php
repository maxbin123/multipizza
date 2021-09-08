<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Ingredient;
use App\Models\Item;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
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
        $order = Cart::create([
            'user_id' => User::inRandomOrder()->first()->id,
        ]);

        $item = new Item();
        $item->product_id = Product::inRandomOrder()->first()->id;

        $order->items()->save($item);
        $order->items->first()->ingredients()->attach(Ingredient::inRandomOrder()->first());
    }
}
