<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'url' => $this->faker->url,
            'price' => $this->faker->numberBetween(1, 1000),
            'store' => 'Steam',
            'store_id' => random_int(1, 10),
            'bought' => $this->faker->boolean,
            'deleted' => false,
            'wishlist_id' => 1,
            'auto' => true,
        ];
    }
}
