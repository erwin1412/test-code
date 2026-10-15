<?php

namespace App\Http\Controllers\Api;

use App\Enums\ServiceStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceIndexRequest;
use App\Http\Requests\UpdateServiceStatusRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;

class ServiceController extends Controller
{
    public function index(ServiceIndexRequest $request): JsonResponse
    {
        $services = Service::query()
            ->when($request->validated('status'), fn ($query, $status) => $query->where('status', $status))
            ->when($request->validated('search'), function ($query, $search) {
                $query->where('service_code', $search)
                    ->orWhereHas('customer', fn ($q) => $q->where('customer_code', $search));
            })
            ->latest('activated_at')
            ->paginate($request->validated('per_page', 15));

        return ApiResponse::success(ServiceResource::collection($services));
    }

    public function show(string $serviceCode): JsonResponse
    {
        $service = Service::query()
            ->with('customer')
            ->where('service_code', $serviceCode)
            ->firstOrFail();

        return ApiResponse::success(new ServiceResource($service));
    }

    /**
     * Aturan status layanan:
     * - active <-> isolated
     * - active / isolated -> terminated
     * - terminated bersifat final, tidak bisa diubah lagi.
     */
    public function updateStatus(UpdateServiceStatusRequest $request, string $serviceCode): JsonResponse
    {
        $service = Service::query()
            ->with('customer')
            ->where('service_code', $serviceCode)
            ->firstOrFail();

        $newStatus = ServiceStatus::from($request->validated('status'));

        if ($service->status === 'terminated') {
            return ApiResponse::error('Layanan yang sudah diputus tidak bisa diubah statusnya.', 422);
        }

        if ($service->status === $newStatus) {
            return ApiResponse::error("Layanan sudah berstatus {$newStatus->value}.", 422);
        }

        $service->status = $newStatus;
        $service->terminated_at = $newStatus === ServiceStatus::Terminated ? now() : null;
        $service->save();

        return ApiResponse::success(new ServiceResource($service), 'Status layanan diperbarui.');
    }
}
