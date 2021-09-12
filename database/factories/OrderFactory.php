<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Order;
use App\Models\Role;
use App\Models\User;
use Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        $branch = Branch::inRandomOrder()->first();

        return [
            'state' => Arr::random(['confirmed', 'taken', 'ready', 'delivering', 'done', 'failed']),
            'longitude' => $this->faker->longitude(38.9, 39.1),
            'latitude' => $this->faker->latitude(45, 45.2),
            'address' => $this->faker->streetAddress,
            'door' => $this->faker->numberBetween(1, 6),
            'floor' => $this->faker->numberBetween(1, 16),
            'flat' => $this->faker->numberBetween(1, 1600),
            'code' => $this->faker->numerify('####'),
            'user_id' => User::where('role_id', Role::CUSTOMER)->inRandomOrder()->first()->id,
            'delivery_id' => User::where('role_id', Role::DELIVERY)->inRandomOrder()->first()->id,
            'branch_id' => $branch->id,
            'restaurant_id' => $branch->restaurants()->inRandomOrder()->first()->id
        ];
    }
}
