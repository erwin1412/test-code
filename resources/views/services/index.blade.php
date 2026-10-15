@extends('layouts.app')

@section('title', 'Daftar Layanan')

@section('content')
    <h1>Daftar Layanan</h1>

    <div class="card">
        <form class="filter" method="GET" action="{{ route('services.index') }}">
            <label for="status">Status</label>
            <select name="status" id="status">
                <option value="">Semua</option>
                @foreach ($statuses as $status)
                    <option value="{{ $status->value }}" @selected($selectedStatus === $status->value)>
                        {{ $status->label() }}
                    </option>
                @endforeach
            </select>
            <button type="submit">Terapkan</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Kode Layanan</th>
                    <th>Pelanggan</th>
                    <th>Paket</th>
                    <th>Harga / bulan</th>
                    <th>Status</th>
                    <th>Aktif sejak</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($services as $service)
                    <tr>
                        <td>{{ $service->service_code }}</td>
                        <td>{{ $service->customer->name }} ({{ $service->customer->customer_code }})</td>
                        <td>{{ $service->package_name }} · {{ $service->bandwidth_mbps }} Mbps</td>
                        <td>Rp {{ number_format($service->monthly_price, 0, ',', '.') }}</td>
                        <td><span class="badge badge-{{ $service->status->value }}">{{ $service->status->label() }}</span></td>
                        <td>{{ $service->activated_at->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="empty">Tidak ada layanan.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination">
            @if ($services->previousPageUrl())
                <a href="{{ $services->previousPageUrl() }}">&laquo; Sebelumnya</a>
            @endif
            <span>Halaman {{ $services->currentPage() }} dari {{ $services->lastPage() }}</span>
            @if ($services->nextPageUrl())
                <a href="{{ $services->nextPageUrl() }}">Berikutnya &raquo;</a>
            @endif
        </div>
    </div>
@endsection
