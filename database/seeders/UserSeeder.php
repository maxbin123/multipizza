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
            ]);
        User::factory()
            ->for(Role::bySlug('delivery')->first())
            ->count(5)
            ->create();
        User::factory()
            ->for(Role::bySlug('manager')->first())
            ->count(2)
            ->create();
        User::factory()
            ->for(Role::bySlug('cook')->first())
            ->createOne();
        User::factory()
            ->for(Role::bySlug('customer')->first())
            ->count(300)
            ->create([
                'email' => '',
                'password' => '',
            ]);
    }
}
