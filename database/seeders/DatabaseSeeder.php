<?php

namespace Database\Seeders;

use App\Models\Check;
use App\Models\Url;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(2)
            ->has(
                Url::factory()
                    ->count(5)
                    ->state(
                        new Sequence(
                            ['url' => 'https://gooddomain.com'],
                            ['url' => 'https://baddomain.com'],
                        )
                    )
                    ->has(Check::factory()->count(100))
            )
            ->create();
    }
}
