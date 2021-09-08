<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            BranchSeeder::class,
            RestaurantSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            IngredientSeeder::class,
            OrderSeeder::class,
            CartSeeder::class,
        ]);
    }
}
