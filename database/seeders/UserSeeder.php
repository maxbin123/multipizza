<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->for(Role::bySlug('admin')->first())
            ->createOne([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'phone' => '+79898055058',
                'password' => Hash::make('admin'),
                'restaurant_id' => null,
            ]);
        User::factory()
            ->for(Role::bySlug('delivery')->first())
            ->count(100)
            ->create([
                'restaurant_id' => null,
            ]);
        User::factory()
            ->for(Role::bySlug('manager')->first())
            ->count(60)
            ->create();
        User::factory()
            ->for(Role::bySlug('cook')->first())
            ->count(60)
            ->create();
        User::factory()
            ->for(Role::bySlug('customer')->first())
            ->count(300)
            ->create([
                'email' => '',
                'password' => '',
                'restaurant_id' => null,
            ]);
    }
}
