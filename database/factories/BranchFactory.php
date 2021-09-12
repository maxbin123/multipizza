<?php

namespace Database\Factories;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\Factory;

class BranchFactory extends Factory
{
    protected $model = Branch::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company(),
            'slug' => $this->faker->word(),
            'logo' => $this->faker->image('public/storage',640,480, null, false),
            'min_price' => $this->faker->numberBetween(0, 800),
            'delivery_price' => $this->faker->numberBetween(40, 140),
            'free_delivery_sum' => $this->faker->numberBetween(500, 1200),
        ];
    }
}
