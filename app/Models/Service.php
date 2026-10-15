<?php

namespace App\Models;

use App\Enums\ServiceStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'service_code',
        'package_name',
        'bandwidth_mbps',
        'monthly_price',
        'status',
        'activated_at',
        'terminated_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => ServiceStatus::class,
            'bandwidth_mbps' => 'integer',
            'monthly_price' => 'integer',
            'activated_at' => 'datetime',
            'terminated_at' => 'datetime',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
