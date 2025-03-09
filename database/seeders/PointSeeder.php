<?php

namespace Database\Seeders;

use App\Models\Point;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $values = range(1, 20);

        foreach ($values as $value) {
            $newPoint = Point::create([
                'customer_id' => rand(1, 10),
                'business_id' => 1,
                'points' =>  $faker->numberBetween(-100, 100),
                'description' => $faker->sentence(10),
            ]);
        }
    }
}
