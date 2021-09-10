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
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'phone' => '+79898055058',
            'password' => Hash::make('admin'),
            'role_id' => Role::where('slug', 'admin')->first()->id,
            'telegram_chat_id' => 108540759,
        ]);

        User::create([
            'name' => 'Delivery Man',
            'email' => 'delivery@delivery.com',
            'phone' => '+79898055000',
            'password' => Hash::make('delivery'),
            'role_id' => Role::where('slug', 'delivery')->first()->id,
            'telegram_chat_id' => 108540759,
        ]);

    }
}
