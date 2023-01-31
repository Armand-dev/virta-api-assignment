<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Station>
 */
class StationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'latitude' => rand(-900000000, 900000000) / 10000000,
            'longitude' => rand(-1800000000, 1800000000) / 10000000,
            'company_id' => Company::all()->random(),
            'address' => $this->faker->address
        ];
    }
}
