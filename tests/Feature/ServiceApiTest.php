<?php

namespace Tests\Feature;

use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_daftar_layanan_bisa_difilter_berdasarkan_status(): void
    {
        Service::factory()->count(3)->create();
        Service::factory()->count(2)->isolated()->create();

        $this->getJson('/api/services?status=isolated')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.status', 'isolated');
    }

    public function test_layanan_aktif_bisa_diisolir(): void
    {
        $service = Service::factory()->create(['service_code' => 'S-000001']);

        $this->patchJson('/api/services/S-000001/status', ['status' => 'isolated'])
            ->assertOk()
            ->assertJsonPath('data.status', 'isolated');

        $this->assertSame('isolated', $service->fresh()->status->value);
    }

    public function test_layanan_yang_diputus_mencatat_waktu_putus(): void
    {
        $service = Service::factory()->create(['service_code' => 'S-000002']);

        $this->patchJson('/api/services/S-000002/status', ['status' => 'terminated'])
            ->assertOk()
            ->assertJsonPath('data.status', 'terminated');

        $this->assertNotNull($service->fresh()->terminated_at);
    }

    public function test_status_tidak_dikenal_ditolak_dengan_422(): void
    {
        Service::factory()->create(['service_code' => 'S-000003']);

        $this->patchJson('/api/services/S-000003/status', ['status' => 'suspended'])
            ->assertUnprocessable()
            ->assertJsonPath('success', false)
            ->assertJsonValidationErrors('status', 'errors');
    }
}
