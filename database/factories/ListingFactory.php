<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Listing>
 */
class ListingFactory extends Factory
{

    public function definition(): array
    {
        return [
            'pavadinimas' => $this->faker->word(),
            'aprasymas' => $this->faker->sentence(),
            'kaina' => 10,
            'tipas' => 'preke',
            'statusas' => 'aktyvus',
            'user_id' => \App\Models\User::factory(),
            'category_id' => 1,
            'is_hidden' => false
        ];
    }
}
