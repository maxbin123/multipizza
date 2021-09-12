<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        return [
            'name' => ucfirst($this->faker->word),
            'slug' => $this->faker->word,
            'branch_id' => Branch::inRandomOrder()->first()->id,
            'parent_id' => (rand(0, 1) && Category::inRandomOrder()->first()) ? Category::inRandomOrder()->first()->id : null,
        ];
    }
}
