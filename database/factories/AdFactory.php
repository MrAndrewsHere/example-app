<?php

namespace Database\Factories;

use App\Domain\Models\Ad;
use App\Domain\Services\Utils\DateSequence;
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
        $dateTime = DateSequence::next(); //sorting by created_at
        return [
            'name' => fake()->realText(100),
            'description' => fake()->realText(1000),
            'price' => random_int(50, 200000),
            'created_at' => $dateTime,
            'updated_at' => $dateTime,
        ];
    }
}
