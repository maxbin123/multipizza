<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

class RestaurantFactory extends Factory
{
    protected $model = Restaurant::class;

    public function definition()
    {
        return [
            'address' => $this->faker->streetAddress,
            'phone' => $this->faker->phoneNumber,
            'start_hour' => $this->faker->numberBetween(7, 10),
            'finish_hour' => $this->faker->numberBetween(20, 23),
            'longitude' => $this->faker->longitude(38.9, 39.1),
            'latitude' => $this->faker->latitude(45, 45.2),
            'branch_id' => Branch::inRandomOrder()->first()->id,
        ];
    }
}
