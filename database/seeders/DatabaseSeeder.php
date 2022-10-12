<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Domain\Models\Ad;
use App\Domain\Models\Photo;
use Illuminate\Console\OutputStyle;
use Illuminate\Console\View\Components\Info;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\ConsoleOutput;

class DatabaseSeeder extends Seeder
{
    protected $ad = Ad::class;
    protected $photo = Photo::class;
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $time = microtime(true);
        $adCount = 10000;
        $chunkSize = round($adCount / 2);

        $ads = $this->ad::factory($adCount)->make();
        $ads->chunk($chunkSize)->each(function ($chunk) {
            DB::table('ads')->insert($chunk->toArray());
        });
        $photo = $this->ad::all()->map(function ($ad) {
            return $this->photo::factory()->count(random_int(1, 3))->make(['ad_id' => $ad->id]);
        })->flatten(1);

        $photo->chunk($chunkSize)->each(function ($chunk) {
            DB::table('photo')->insert($chunk->toArray());
        });

        $info = implode(' ', [
            'Complete in',
            (round(microtime(true) - $time, 1)),
            'sec.'
        ]);
        (new Info(new OutputStyle(new StringInput(''), new ConsoleOutput())))
            ->render($info);


//        Ad::factory($adCount)->create()
//            ->each(function ($ad) {
//                $ad->photo()->saveMany(Photo::factory(random_int(1, 3))->make());
//            });
    }
}
