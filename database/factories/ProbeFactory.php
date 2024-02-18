<?php

namespace Database\Factories;

use App\Models\Probe;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProbeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Probe::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'url' => 'https://google.com',
            'name' => $this->faker->sentence(3),
        ];
    }

}
