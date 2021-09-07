<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Branch::insert([
            [
                'name' => 'Макдоналдс',
                'slug' => 'mcdonalds',
                'logo' => 'https://logos-download.com/wp-content/uploads/2016/03/McDonalds_Logo_2018-700x700.png',
                'min_price' => 200,
                'delivery_price' => 139,
                'free_delivery_sum' => 799,
            ],
            [
                'name' => 'KFC',
                'slug' => 'kfc',
                'logo' => 'https://vectorseek.com/wp-content/uploads/2021/01/KFC-Logo-Vector-730x730.jpg',
                'min_price' => 0,
                'delivery_price' => 139,
                'free_delivery_sum' => 599,
            ],
        ]);
    }
}
