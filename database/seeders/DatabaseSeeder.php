<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Option;
use App\Models\Property;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{

    use WithoutModelEvents;


    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            "email"=> "arc@boss.bj",
        ]);

        $options = Option::factory(10)->create();

        Property::factory(50)
            ->hasAttached($options->random(3))
            ->create();


    }
}
