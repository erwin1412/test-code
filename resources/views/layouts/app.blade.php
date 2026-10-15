<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') · {{ config('app.name') }}</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: system-ui, sans-serif; color: #1b2430; background: #f4f6f8; }
        nav { background: #0f2a3d; padding: 12px 24px; display: flex; gap: 20px; align-items: center; }
        nav a { color: #cadce3; text-decoration: none; }
        nav a.active, nav a:hover { color: #fff; }
        nav .brand { color: #fff; font-weight: 700; margin-right: 12px; }
        main { max-width: 1100px; margin: 24px auto; padding: 0 16px; }
        h1 { font-size: 24px; margin: 0 0 16px; }
        .card { background: #fff; border-radius: 8px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,.08); overflow-x: auto; }
        form.filter { display: flex; gap: 8px; margin-bottom: 16px; align-items: center; }
        select, button { padding: 6px 10px; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th, td { text-align: left; padding: 10px 8px; border-bottom: 1px solid #e3e8ec; white-space: nowrap; }
        th { background: #eef3f5; }
        .badge { padding: 2px 8px; border-radius: 10px; font-size: 12px; color: #fff; }
        .badge-active { background: #2e9e5b; }
        .badge-isolated { background: #d9a21b; }
        .badge-terminated { background: #7a8794; }
        .empty { text-align: center; color: #7a8794; padding: 24px; }
        .pagination { margin-top: 16px; display: flex; gap: 16px; font-size: 14px; }
    </style>
</head>
<body>
    <nav>
        <span class="brand">Test Code</span>
        <a href="{{ route('services.index') }}" @class(['active' => request()->routeIs('services.*')])>Layanan</a>
        {{-- Tambahkan menu halaman baru di sini. --}}
    </nav>
    <main>
        @yield('content')
    </main>
</body>
</html>
