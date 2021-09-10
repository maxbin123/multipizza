<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert([
            [
                'name' => 'Administrator',
                'slug' => 'admin'
            ],
            [
                'name' => 'Customer',
                'slug' => 'customer'
            ],
            [
                'name' => 'Manager',
                'slug' => 'manager'
            ],
            [
                'name' => 'Delivery',
                'slug' => 'delivery'
            ],
            [
                'name' => 'Cook',
                'slug' => 'cook'
            ],
        ]);
    }
}
