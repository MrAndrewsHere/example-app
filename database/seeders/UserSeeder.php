<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->firstOrCreate(
            ['email' => env('USER_DEFAULT_EMAIL', 'test@example.com')],
            ['name' => env('USER_DEFAULT_USERNAME', 'Test User'),
                'password' => bcrypt(env('USER_DEFAULT_PASSWORD', '12345678'))]
        );
    }
}
