<?php

namespace Database\Factories;

use App\Domain\Models\Ad;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AdFactory extends Factory
{
    protected $model = Ad::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->realText(1000),
            'price' => (int) round(random_int(10000, 2000000) / 1000) * 10000,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
