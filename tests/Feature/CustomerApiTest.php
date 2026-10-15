<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_detail_pelanggan_menampilkan_semua_layanannya(): void
    {
        $customer = Customer::factory()->create(['customer_code' => '1356159476']);
        Service::factory()->for($customer)->create();
        Service::factory()->for($customer)->isolated()->create();

        $this->getJson('/api/customers/1356159476')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.customer_code', '1356159476')
            ->assertJsonCount(2, 'data.services');
    }

    public function test_pelanggan_yang_tidak_ada_mengembalikan_404_berformat_api(): void
    {
        $this->getJson('/api/customers/0000000000')
            ->assertNotFound()
            ->assertJsonPath('success', false)
            ->assertJsonStructure(['success', 'message', 'errors']);
    }
}
