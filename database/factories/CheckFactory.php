<?php

namespace Database\Factories;

use App\Models\Check;
use Illuminate\Database\Eloquent\Factories\Factory;

class CheckFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Check::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $statuses = [200, 404, 403, 500];
        $status = $statuses[rand(0, count($statuses) - 1)];
        return [
            'status' => $status,
            'online' => $status === 200,
        ];
    }

}
