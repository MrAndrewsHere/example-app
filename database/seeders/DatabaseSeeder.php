<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Domain\Models\Ad;
use App\Domain\Models\Category;
use App\Domain\Models\Photo;
use Illuminate\Console\OutputStyle;
use Illuminate\Console\View\Components\Info;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\ConsoleOutput;

class DatabaseSeeder extends Seeder
{
    protected $adModel = Ad::class;

    protected $photoModel = Photo::class;

    protected $categoryModel = Category::class;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::query()->firstOrCreate(['email' => 'test@example.com'], [
            'name' => 'Test User',
            'password' => Hash::make('12345678'),
        ]);




        $time = microtime(true);
        $adCount = 2000;
        $chunkSize = round($adCount / 2);

        $categories = $this->categoryModel::factory(10)->create();

        $ads = $this->adModel::factory($adCount)->make()->map(function ($i) use ($categories) {
            $i['category_id'] = $categories->random(1)->first()->id;

            return $i;
        });
        $ads->chunk($chunkSize)->each(function ($chunk) {
            DB::table('ads')->insert($chunk->toArray());
        });
        $photo = $this->adModel::all()->map(function ($ad) {
            return $this->photoModel::factory()->count(random_int(1, 3))->make(['ad_id' => $ad->id]);
        })->flatten(1);

        $photo->chunk($chunkSize)->each(function ($chunk) {
            DB::table('photo')->insert($chunk->toArray());
        });

        $info = implode(' ', [
            'Complete in',
            (round(microtime(true) - $time, 1)),
            'sec.',
        ]);
        (new Info(new OutputStyle(new StringInput(''), new ConsoleOutput())))
            ->render($info);

//        Ad::factory($adCount)->create()
//            ->each(function ($ad) {
//                $ad->photo()->saveMany(Photo::factory(random_int(1, 3))->make());
//            });
    }
}
