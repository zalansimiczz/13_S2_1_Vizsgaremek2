<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Email megerősítés</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">

<div class="min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-lg bg-white rounded-2xl shadow p-8">

        <!--fejlec-->
        <div class="text-center">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-blue-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>

            <h1 class="text-2xl font-semibold text-gray-800">
                Email megerősítés szükséges
            </h1>

            <p class="mt-3 text-gray-600">
                A fiókod használatához meg kell erősítened az email címed.
                Küldtünk egy levelet a regisztrációkor megadott címre.
            </p>
        </div>

        <!--uzenetek-->
        @if (session('message'))
            <div class="mt-5 rounded-lg bg-green-50 p-4 text-green-700 border border-green-200">
                {{ session('message') }}
            </div>
        @endif

        <!--javaslatok-->
        <div class="mt-6 rounded-lg bg-gray-50 p-4 text-sm text-gray-600">
            <p class="font-medium mb-1">Nem találod az emailt?</p>
            <ul class="list-disc ml-5 space-y-1">
                <li>Ellenőrizd a spam / promóciók mappát</li>
                <li>Várj 1–2 percet a kézbesítésre</li>
                <li>Kattints az alábbi gombra az újraküldéshez</li>
            </ul>
        </div>

        <!--resend button-->
        <form method="POST" action="{{ route('verification.send') }}" class="mt-6">
            @csrf

            <button type="submit"
                class="w-full rounded-lg bg-blue-600 px-4 py-3 text-white font-medium
                       hover:bg-blue-700 transition duration-150">
                Megerősítő email újraküldése
            </button>
        </form>

        <!--footer-->
        <div class="mt-6 text-center text-sm text-gray-500">
            <p>
                Rossz email címet adtál meg?
                <br>
                Jelentkezz ki és regisztrálj újra.
            </p>

            <a href="{{ route('partner.logout') }}"
               class="inline-block mt-3 text-blue-600 hover:underline">
                Kijelentkezés
            </a>
        </div>
    </div>
</div>

</body>
</html>
