<?php

namespace Database\Seeders;

use App\Models\Customer;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $values = range(1, 10);

        foreach ($values as $value) {
            $newCustomer = Customer::create([
                'business_id' => 1,
                'name' =>  $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'phone' => $faker->phoneNumber(),
            ]);
        }
    }
}
