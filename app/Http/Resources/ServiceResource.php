<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'service_code' => $this->service_code,
            'customer_code' => $this->customer->customer_code,
            'customer_name' => $this->customer->name,
            'package_name' => $this->package_name,
            'bandwidth_mbps' => $this->bandwidth_mbps,
            'monthly_price' => $this->monthly_price,
            'status' => $this->status->value,
            'status_label' => $this->status->label(),
            'activated_at' => $this->activated_at?->toIso8601String(),
            'terminated_at' => $this->terminated_at?->toIso8601String(),
        ];
    }
}
