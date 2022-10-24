<?php

namespace Database\Seeders;

use App\Domain\Models\Ad;
use App\Domain\Models\Category;
use Illuminate\Database\Seeder;

class AdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $adCount = 2000;

        $categories = Category::all();

        $ads = Ad::factory($adCount)->make()->map(function ($i) use ($categories) {
            $i['category_id'] = $categories->random(1)->first()->id;
            return $i;
        });
        $ads->chunk(2000)->each(function ($chunk) {
            Ad::insert($chunk->toArray());
        });
    }
}
