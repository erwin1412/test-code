<?php

namespace App\Http\Controllers;

use App\Enums\ServiceStatus;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ServicePageController extends Controller
{
    public function __invoke(Request $request): View
    {
        $request->validate([
            'status' => ['nullable', Rule::enum(ServiceStatus::class)],
        ]);

        $services = Service::query()
            ->with('customer')
            ->when($request->input('status'), fn ($query, $status) => $query->where('status', $status))
            ->latest('activated_at')
            ->paginate(15)
            ->withQueryString();

        return view('services.index', [
            'services' => $services,
            'statuses' => ServiceStatus::cases(),
            'selectedStatus' => $request->input('status'),
        ]);
    }
}
