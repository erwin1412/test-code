<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Customer>
 */
class CustomerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'customer_code' => (string) fake()->unique()->numberBetween(1300000000, 1399999999),
            'name' => fake()->name(),
            'phone' => '08'.fake()->numerify('##########'),
            'address' => fake()->address(),
        ];
    }
}
