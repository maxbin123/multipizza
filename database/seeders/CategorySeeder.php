<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Бургеры',
            'slug' => 'burgers',
            'parent_id' => null,
            'branch_id' => Branch::where('slug', 'mcdonalds')->first()->id,
        ]);

        Category::create([
            'name' => 'Напитки',
            'slug' => 'drinks',
            'parent_id' => null,
            'branch_id' => Branch::where('slug', 'mcdonalds')->first()->id,
        ]);

        Category::create([
            'name' => 'Горячие напитки',
            'slug' => 'hot-drinks',
            'parent_id' => Category::where('slug', 'drinks')->first()->id,
            'branch_id' => Branch::where('slug', 'mcdonalds')->first()->id,
        ]);

        Category::create([
            'name' => 'Холодные напитки',
            'slug' => 'cold-drinks',
            'parent_id' => Category::where('slug', 'drinks')->first()->id,
            'branch_id' => Branch::where('slug', 'mcdonalds')->first()->id,
        ]);

        Category::create([
            'name' => 'Бургеры',
            'slug' => 'burgers',
            'parent_id' => null,
            'branch_id' => Branch::where('slug', 'kfc')->first()->id,
        ]);

        Category::create([
            'name' => 'Напитки',
            'slug' => 'beverages',
            'parent_id' => null,
            'branch_id' => Branch::where('slug', 'kfc')->first()->id,
        ]);

        Category::create([
            'name' => 'Кофе',
            'slug' => 'coffee',
            'parent_id' => Category::where('slug', 'beverages')->first()->id,
            'branch_id' => Branch::where('slug', 'kfc')->first()->id,
        ]);
    }
}
