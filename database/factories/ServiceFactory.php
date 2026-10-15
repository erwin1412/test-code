<?php

namespace Database\Factories;

use App\Enums\ServiceStatus;
use App\Models\Customer;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    private const PACKAGES = [
        ['Home 20', 20, 175000],
        ['Home 50', 50, 250000],
        ['Home 100', 100, 350000],
        ['Bisnis 200', 200, 750000],
    ];

    public function definition(): array
    {
        [$name, $mbps, $price] = fake()->randomElement(self::PACKAGES);

        return [
            'customer_id' => Customer::factory(),
            'service_code' => 'S-'.fake()->unique()->numerify('######'),
            'package_name' => $name,
            'bandwidth_mbps' => $mbps,
            'monthly_price' => $price,
            'status' => ServiceStatus::Active,
            'activated_at' => fake()->dateTimeBetween('-2 years', '-1 month'),
            'terminated_at' => null,
        ];
    }

    public function isolated(): static
    {
        return $this->state(fn () => ['status' => ServiceStatus::Isolated]);
    }

    public function terminated(): static
    {
        return $this->state(fn () => [
            'status' => ServiceStatus::Terminated,
            'terminated_at' => now()->subDays(fake()->numberBetween(1, 60)),
        ]);
    }
}
