<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use TimeInfo;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->start();
        $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(AdSeeder::class);
        $this->call(PhotoSeeder::class);
        $this->end();
    }
}
