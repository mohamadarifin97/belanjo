<?php

namespace Database\Seeders;

use App\Models\Commitment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator;

class CommitmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = app(Generator::class);
        Commitment::truncate();
        
        for ($i = 0; $i < 10; $i++) {
            Commitment::create([
                'commitment' => $faker->text($maxNbChars = 10),
                'value' => $faker->numberBetween($min = 50, $max = 500)
            ]);
        }

    }
}
