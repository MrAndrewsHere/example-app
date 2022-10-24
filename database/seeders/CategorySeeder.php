<?php

namespace Database\Seeders;

use App\Domain\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        if (!Category::query()->count()) {
            Category::factory(10)->create();
        }
    }
}
