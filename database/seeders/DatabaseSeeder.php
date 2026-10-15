<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Service;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * 20 pelanggan. Sebagian punya lebih dari satu layanan (rumah + kantor),
     * dengan campuran status aktif, isolir, dan putus.
     */
    public function run(): void
    {
        Customer::factory(20)->create()->each(function (Customer $customer, int $i) {
            Service::factory()->for($customer)->create();

            if ($i % 3 === 0) {
                Service::factory()->for($customer)->isolated()->create();
            }

            if ($i % 5 === 0) {
                Service::factory()->for($customer)->terminated()->create();
            }
        });
    }
}
