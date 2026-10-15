<?php

namespace Tests\Feature;

use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServicePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_halaman_daftar_layanan_bisa_dibuka(): void
    {
        $service = Service::factory()->create();

        $this->get('/services')
            ->assertOk()
            ->assertSee($service->service_code);
    }
}
