<?php

namespace Database\Seeders;

use App\Models\Branch;
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
        Order::factory()->count(500)->hasItems(4)->create();
    }
}
