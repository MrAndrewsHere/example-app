<?php

namespace Database\Seeders;

use App\Domain\Models\Ad;
use App\Domain\Models\Photo;
use Illuminate\Database\Seeder;

class PhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $ads = Ad::all();
        $photo = $ads->map(function ($ad) {
            return Photo::factory()->count(random_int(1, 3))->make(['ad_id' => $ad->id]);
        })->flatten(1);

        $photo->chunk(2000)->each(function ($chunk) {
            Photo::insert($chunk->toArray());
        });
    }
}
