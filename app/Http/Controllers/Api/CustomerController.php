<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
        ]);

        $customers = Customer::query()
            ->when($request->input('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('customer_code', $search)
                        ->orWhere('name', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(15);

        return ApiResponse::success(CustomerResource::collection($customers));
    }

    public function show(string $customerCode): JsonResponse
    {
        $customer = Customer::query()
            ->with('services.customer')
            ->where('customer_code', $customerCode)
            ->firstOrFail();

        return ApiResponse::success(new CustomerResource($customer));
    }
}
