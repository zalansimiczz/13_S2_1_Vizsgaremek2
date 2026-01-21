{{-- resources/views/partner/layout.blade.php --}}
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'ÚtdíjPro Partner Portál')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Tailwind CDN (mint a régi kódban) --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen">
    <div class="max-w-4xl mx-auto py-10">
        <h1 class="text-3xl font-bold mb-6 text-sky-400">
            Útdíj<span class="text-sky-300">Pro</span> – Partner Portál
        </h1>

        @yield('content')
    </div>
</body>
</html>
