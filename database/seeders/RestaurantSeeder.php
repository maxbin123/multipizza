<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Restaurant;
use Illuminate\Database\Seeder;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Restaurant::insert([
            [
                'branch_id' => Branch::where('slug', 'mcdonalds')->first()->id,
                'address' => 'Краснодар, ул. Красная 176',
                'phone' => '+7 (495) 190‒99‒99',
                'start_hour' => 8,
                'finish_hour' => 5,
                'longitude' => 38.980731,
                'latitude' => 45.045466
            ],
            [
                'branch_id' => Branch::where('slug', 'mcdonalds')->first()->id,
                'address' => 'Краснодар, ул. Московская 162',
                'phone' => '+7 (495) 190‒99‒99',
                'start_hour' => 8,
                'finish_hour' => 23,
                'longitude' => 39.003514,
                'latitude' => 45.093925
            ],
            [
                'branch_id' => Branch::where('slug', 'kfc')->first()->id,
                'address' => 'Краснодар, ул. Ставропольская 95',
                'phone' => '+7‒938‒473‒14‒92',
                'start_hour' => 8,
                'finish_hour' => 23,
                'longitude' => 39.013999,
                'latitude' => 45.021406
            ],
        ]);
    }
}
