{{-- resources/views/partner/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="hu">
<head>
    <!--fejlec-->
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Útdí­jPro - Partner Irányítópult</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        /*basic szinek*/
        :root {
            --color-primary: #0ea5e9; /* sky-500 */
            --color-secondary: #6366f1; /* indigo-500 */
            --color-background: #030712; /* gray-950 */
            --color-surface: #0f172a; /* slate-900 */
            --color-surface-light: #1e293b; /* slate-800 */
            --color-text-base: #e2e8f0; /* slate-200 */
            --color-text-muted: #94a3b8; /* slate-400 */
            --color-border: rgba(56, 189, 248, 0.2);
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--color-background);
            color: var(--color-text-base);
        }
        .font-poppins { font-family: 'Poppins', sans-serif; }

        .glassmorphism-element {
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(12px) saturate(150%);
            -webkit-backdrop-filter: blur(12px) saturate(150%);
            border: 1px solid var(--color-border);
        }
        .sidebar {
            width: 260px;
            transition: transform 0.3s ease-in-out;
            border-right: 1px solid var(--color-border);
        }
        .sidebar-link {
            transition: background-color 0.2s ease, color 0.2s ease, padding-left 0.2s ease, border-left-color 0.2s ease;
            border-left: 4px solid transparent;
        }
        .sidebar-link:hover, .sidebar-link.active {
            background-color: rgba(14,165,233,0.12);
            color: var(--color-primary);
            border-left-color: var(--color-primary);
            padding-left: 1.25rem;
        }
        .sidebar-link.active { font-weight: 600; }
        .sidebar-link i { transition: transform 0.3s ease; }
        .sidebar-link:hover i { transform: scale(1.1); }

        .stat-card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(14,165,233,0.2);
        }
        
        .calculator-input-group label { color: var(--color-text-muted); }
        .calculator-input, .calculator-select {
            background-color: var(--color-surface-light);
            border: 1px solid #374151;
            color: white;
            padding: 0.875rem 1.25rem;
            border-radius: 0.5rem;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .calculator-input:focus, .calculator-select:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(14,165,233,0.3);
            outline: none;
        }
        .calculator-button-primary {
            background: linear-gradient(90deg, var(--color-primary), var(--color-secondary));
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(14,165,233,0.2);
        }
        .calculator-button-primary:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(14,165,233,0.3);
        }
        .calculator-button-secondary {
            background-color: rgba(14,165,233,0.1);
            border: 1px solid rgba(14,165,233,0.3);
            color: var(--color-primary);
        }
        .calculator-button-secondary:hover { background-color: rgba(14,165,233,0.2); }
        .results-text strong { color: var(--color-primary); }
        .leaflet-container { border-radius: 0.5rem; border: 1px solid #374151; }
        #mobileMenuBtn { z-index: 60; }
        .content-section { display: none; }
        .content-section.active { display: block; }
        .notification-panel {
            width: min(24rem, calc(100vw - 2rem));
        }
    </style>
</head>
<body class="flex h-screen overflow-hidden">

    @php
    $partnerName = $userName ?? session('user_name', 'Partner felhasználó');
    @endphp


    <!-- mobilos nezethez hamburger gomb-->
    <button id="mobileMenuBtn" class="lg:hidden fixed top-4 left-4 p-3 bg-gray-800/80 text-white rounded-md backdrop-blur-sm shadow-lg">
        <i class="fas fa-bars fa-lg"></i>
    </button>

    <!--sidebar navi-->
    <aside id="sidebar" class="sidebar glassmorphism-element p-5 space-y-6 flex-shrink-0 h-full overflow-y-auto transform -translate-x-full lg:translate-x-0 fixed lg:static z-40">
        <div class="logo-container text-center mb-6 pt-8 lg:pt-0">
            <a href="/" class="flex items-center justify-center space-x-2" title="Vissza a főoldalra">
                <i class="fas fa-road-bridge fa-2x text-[var(--color-primary)]"></i>
                <span class="font-poppins self-center text-2xl font-bold whitespace-nowrap text-white">Útdíj<span class="text-[var(--color-primary)]">Pro</span></span>
            </a>
        </div>
        <nav class="space-y-1.5">
            <a href="#dashboard-main-content" id="dashboard" class="sidebar-link active flex items-center space-x-3 px-4 py-2.5 rounded-md text-gray-300">
                <i class="fas fa-tachometer-alt fa-fw w-5 text-center"></i><span class="font-medium">Irányítópult</span>
            </a>
            <a href="#calculatorSectionContent" id="openCalculator" class="sidebar-link flex items-center space-x-3 px-4 py-2.5 rounded-md text-gray-300">
                <i class="fas fa-calculator fa-fw w-5 text-center"></i><span class="font-medium">Útdíj Kalkulátor</span>
            </a>
            <a href="#addUserContent" id="alkalmazottak" class="sidebar-link flex items-center space-x-3 px-4 py-2.5 rounded-md text-gray-300">
                <i class="fas fa-users-cog fa-fw w-5 text-center"></i><span class="font-medium">Alkalmazottak</span>
            </a>
            <a href="#driversContent" id="soforok" class="sidebar-link flex items-center space-x-3 px-4 py-2.5 rounded-md text-gray-300">
                <i class="fas fa-id-card fa-fw w-5 text-center"></i><span class="font-medium">Sofőrök</span>
            </a>
            <a href="#trucksContent" id="flotta" class="sidebar-link flex items-center space-x-3 px-4 py-2.5 rounded-md text-gray-300">
                <i class="fas fa-truck fa-fw w-5 text-center"></i><span class="font-medium">Flotta</span>
            </a>
            <a href="#reportsContent" id="riportok" class="sidebar-link flex items-center space-x-3 px-4 py-2.5 rounded-md text-gray-300">
                <i class="fas fa-chart-bar fa-fw w-5 text-center"></i><span class="font-medium">Riportok</span>
            </a>
            <a href="#settingsContent" id="beallitasok" class="sidebar-link flex items-center space-x-3 px-4 py-2.5 rounded-md text-gray-300">
                <i class="fas fa-cog fa-fw w-5 text-center"></i><span class="font-medium">Beállítások</span>
            </a>
        </nav>
        <div class="pt-6 mt-auto border-t border-[var(--color-border)]">
            <!--logout link-->
            <a href="{{ route('partner.logout') }}" class="block px-4 py-2 text-sm text-red-400 hover:bg-red-500/20 hover:text-white">
    Kijelentkezés
</a>
        </div>
    </aside>

    <!--main content-->
    <main class="flex-1 p-6 md:p-10 overflow-y-auto" id="mainContentArea">
        <header class="mb-8 md:mb-10">
            <div class="flex justify-between items-center">
                <div id="pageTitleContainer">
                    <h1 class="font-poppins text-2xl md:text-3xl font-bold text-white">Irányítópult</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <button
                            id="notificationBtn"
                            type="button"
                            class="text-gray-400 hover:text-[var(--color-primary)] relative transition-colors"
                            aria-label="Értesítések"
                            aria-expanded="false"
                            aria-controls="notificationPanel"
                        >
                            <i class="fas fa-bell fa-lg"></i>
                            <span id="notificationDot" class="absolute -top-1 -right-1 block h-2.5 w-2.5 rounded-full bg-red-500 ring-2 ring-[var(--color-background)]"></span>
                        </button>

                        <div
                            id="notificationPanel"
                            class="notification-panel hidden absolute right-0 top-full mt-3 rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)]/95 shadow-2xl shadow-black/30 backdrop-blur-xl overflow-hidden z-50"
                        >
                            <div class="flex items-center justify-between px-5 py-4 border-b border-white/10">
                                <div>
                                    <p class="font-poppins text-sm font-semibold text-white">Értesítések</p>
                                    <p id="notificationSummary" class="text-xs text-gray-400">3 olvasatlan értesítés</p>
                                </div>
                                <button
                                    id="markNotificationsReadBtn"
                                    type="button"
                                    class="text-xs font-medium text-sky-400 hover:text-sky-300 transition-colors"
                                >
                                    Összes olvasottnak
                                </button>
                            </div>

                            <div id="notificationList" class="max-h-80 overflow-y-auto divide-y divide-white/5">
                                <button type="button" class="notification-item w-full text-left px-5 py-4 hover:bg-white/5 transition bg-sky-500/5" data-unread="true">
                                    <div class="flex items-start gap-3">
                                        <span class="mt-1 h-2.5 w-2.5 rounded-full bg-sky-400 shrink-0"></span>
                                        <div>
                                            <p class="text-sm font-semibold text-white">Új alkalmazott került rögzítésre</p>
                                            <p class="mt-1 text-xs text-gray-400">Ellenőrizd az alkalmazotti listát és az aktív állapotot.</p>
                                        </div>
                                    </div>
                                </button>

                                <button type="button" class="notification-item w-full text-left px-5 py-4 hover:bg-white/5 transition bg-sky-500/5" data-unread="true">
                                    <div class="flex items-start gap-3">
                                        <span class="mt-1 h-2.5 w-2.5 rounded-full bg-sky-400 shrink-0"></span>
                                        <div>
                                            <p class="text-sm font-semibold text-white">Új jármű vár ellenőrzésre</p>
                                            <p class="mt-1 text-xs text-gray-400">Nézd át a flotta adatlapját, mielőtt tovább lépsz.</p>
                                        </div>
                                    </div>
                                </button>

                                <button type="button" class="notification-item w-full text-left px-5 py-4 hover:bg-white/5 transition bg-sky-500/5" data-unread="true">
                                    <div class="flex items-start gap-3">
                                        <span class="mt-1 h-2.5 w-2.5 rounded-full bg-sky-400 shrink-0"></span>
                                        <div>
                                            <p class="text-sm font-semibold text-white">Partner cégadat módosítás elérhető</p>
                                            <p class="mt-1 text-xs text-gray-400">A beállítások menüpontban frissítheted a cégprofil adatait.</p>
                                        </div>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block text-right mr-2 text-sm text-gray-300">
                        <div class="font-semibold">{{ $partnerName }}</div>
                        <div class="text-xs text-gray-400">Partner felhasználó</div>
                    </div>
                    <div class="relative group">
                        <img src="https://placehold.co/40x40/7F9CF5/E0E7FF?text=P" alt="Partner Profilkép" class="w-10 h-10 rounded-full cursor-pointer border-2 border-transparent group-hover:border-[var(--color-primary)] transition-colors">
                        <div class="absolute right-0 mt-2 w-48 bg-[var(--color-surface-light)] rounded-md shadow-lg py-1 hidden group-hover:block z-50 border border-[var(--color-border)]">
                            <span class="block px-4 py-2 text-xs text-gray-400">{{ $partnerName }}</span>
                            <a href="#settingsContent" class="sidebar-link-trigger block px-4 py-2 text-sm text-gray-300 hover:bg-[var(--color-primary)]/20 hover:text-white">Beállítások</a>
                            <a href="{{ route('partner.logout') }}" class="block px-4 py-2 text-sm text-red-400 hover:bg-red-500/20 hover:text-white">Kijelentkezés</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!--iranyitopult-->
        <div id="dashboard-main-content" class="content-section active" data-page-title="Irányítópult">
            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <div class="stat-card glassmorphism-element p-6 rounded-xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-sky-300 font-medium">Mai Kalkulációk</p>
                            <p class="text-3xl font-bold text-white">12</p>
                        </div>
                        <i class="fas fa-calculator fa-3x text-sky-500 opacity-30"></i>
                    </div>
                </div>
                <div class="stat-card glassmorphism-element p-6 rounded-xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-sky-300 font-medium">Megtakarítás (Havi)</p>
                            <p class="text-3xl font-bold text-white">~350e Ft</p>
                        </div>
                        <i class="fas fa-piggy-bank fa-3x text-green-500 opacity-30"></i>
                    </div>
                </div>
                <div class="stat-card glassmorphism-element p-6 rounded-xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-sky-300 font-medium">Aktív Járművek</p>
                            <p class="text-3xl font-bold text-white">8</p>
                        </div>
                        <i class="fas fa-truck-moving fa-3x text-amber-500 opacity-30"></i>
                    </div>
                </div>
                <div class="stat-card glassmorphism-element p-6 rounded-xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-sky-300 font-medium">Nyitott Számlák</p>
                            <p class="text-3xl font-bold text-white">3</p>
                        </div>
                        <i class="fas fa-file-invoice fa-3x text-red-500 opacity-30"></i>
                    </div>
                </div>
            </section>
            <div class="glassmorphism-element p-6 rounded-xl">
                <h3 class="font-poppins text-lg font-semibold text-white mb-4">Legutóbbi tevékenységek</h3>
                <p class="text-muted">Itt jelennek majd meg a legutóbbi kalkulációk, riportok stb.</p>
            </div>
        </div>

        <!--kalkulator-->
        <div id="calculatorSectionContent" class="content-section" data-page-title="Útdíj Kalkulátor">
            <section class="glassmorphism-element p-6 md:p-8 rounded-2xl">
                <div class="flex justify-end items-center mb-6">
                    <button class="text-sky-400 hover:text-sky-300 text-sm"><i class="fas fa-history mr-1"></i> Korábbi Kalkulációk</button>
                </div>
                <div class="calculator-container space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 calculator-input-group">
                        <div>
                            <label for="from-loc" class="block mb-1 text-sm font-medium">Induló hely:</label>
                            <input type="text" id="from-loc" placeholder="Pl. Szeged, Magyarország" class="w-full calculator-input">
                        </div>
                        <div>
                            <label for="to-loc" class="block mb-1 text-sm font-medium">Célhely:</label>
                            <input type="text" id="to-loc" placeholder="Pl. Győr, Magyarország" class="w-full calculator-input">
                        </div>
                    </div>
                    <div class="calculator-input-group">
                        <label for="truck-type-select" class="block mb-1 text-sm font-medium">Járműtípus:</label>
                        <select id="truck-type-select" class="w-full calculator-select">
                            <option value="">Válasszon járműtípust...</option>
                            <option value="2AxlesTruck">2 tengelyes teherautó</option>
                            <option value="3AxlesTruck">3 tengelyes teherautó</option>
                            <option value="4AxlesTruck">4 tengelyes teherautó</option>
                            <option value="5AxlesTruck">5 tengelyes teherautó</option>
                            <option value="6AxlesTruck">6 tengelyes teherautó</option>
                            <option value="7AxlesTruck">7 tengelyes teherautó</option>
                        </select>
                    </div>
                    <div id="waypointsContainer" class="calculator-input-group">
                        <label class="block mb-2 text-sm font-medium">Köztes megállók (opcionális):</label>
                    </div>
                    <button id="addWaypointBtn" class="calculator-button-secondary text-sm font-medium py-2 px-4 rounded-md flex items-center">
                        <i class="fas fa-plus mr-2"></i>Új megálló
                    </button>
                    <div class="pt-4">
                        <button id="portalCalculateBtn" class="calculator-button-primary w-full sm:w-auto text-white font-semibold py-3 px-10 rounded-lg text-lg flex items-center justify-center">
                            <i class="fas fa-cogs mr-2"></i>Kalkuláció
                        </button>
                    </div>
                    <div id="portalResultsSection" class="mt-8 pt-6 border-t border-[var(--color-border)] space-y-4 hidden">
                        <h3 class="font-poppins text-xl font-semibold text-white mb-3">Eredmények:</h3>
                        <p class="text-lg results-text"><strong>Becsült útdíj:</strong> <span id="portalTollResult" class="font-bold text-white text-xl">N/A</span></p>
                        <p class="text-lg results-text"><strong>Távolság:</strong> <span id="portalDistanceResult" class="font-bold text-white text-xl">N/A</span></p>
                        <div id="portalMapContainer" class="w-full h-80 md:h-96 bg-gray-800 rounded-lg mt-4 border border-gray-700/50"></div>
                        <div id="portalExternalLinkContainer" class="mt-4 text-center"></div>
                    </div>
                    <div id="portalErrorMessages" class="text-red-400 mt-4 hidden p-3 bg-red-900/30 rounded-md border border-red-700/50"></div>
                </div>
            </section>
        </div>

        <!--alkalmazottak-->
        <div id="addUserContent" class="content-section" data-page-title="Alkalmazottak kezelése">
            <div class="glassmorphism-element p-6 rounded-xl space-y-6">

                @if (request('msg') === 'success_user_added')
                    <div class="mb-4 p-4 rounded-lg border border-green-500 bg-green-900/40 text-sm text-green-100">
                        <i class="fas fa-check-circle mr-2"></i>Az új felhasználó sikeresen hozzáadásra került.
                    </div>
                @endif

                <h3 class="font-poppins text-lg font-semibold text-sky-300 mb-2">
                    Új alkalmazott hozzáadása
                </h3>

                <form method="POST" action="{{ route('partner.users.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @csrf

                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm text-gray-300">Név</label>
                        <input type="text" name="full_name" class="calculator-input w-full" placeholder="Pl. Nagy Béla" required>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm text-gray-300">Email</label>
                        <input type="email" name="email" class="calculator-input w-full" placeholder="alkalmazott@ceg.hu" required>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm text-gray-300">Jelszó</label>
                        <input type="password" name="password" class="calculator-input w-full" placeholder="Erős jelszó..." required>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm text-gray-300">Jelszó megerősítése</label>
                        <input type="password" name="password_confirm" class="calculator-input w-full" placeholder="Írd be újra a jelszót" required>
                    </div>

                    <div class="md:col-span-2">
                        <button type="submit" class="calculator-button-primary w-full md:w-auto py-3 px-8 rounded-lg text-white font-semibold flex items-center justify-center">
                            <i class="fas fa-user-plus mr-2"></i>Alkalmazott létrehozása
                        </button>
                    </div>
                </form>

                <hr class="border-[var(--color-border)]">

                <h3 class="font-poppins text-lg font-semibold text-sky-300 mb-2">
                    Létező alkalmazottak
                </h3>
                <div class="overflow-x-auto">
    <table class="w-full text-sm text-left">
        <thead class="text-gray-400 border-b border-[var(--color-border)]">
            <tr>
                <th class="py-3">Név</th>
                <th>Email</th>
                <th>Státusz</th>
                <th class="text-right">Művelet</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $emp)
                <tr class="border-b border-gray-800">
                    <td class="py-3">{{ $emp->teljes_nev }}</td>
                    <td>{{ $emp->email }}</td>
                    <td>
                        @if ($emp->aktiv)
                            <span class="text-green-400">Aktív</span>
                        @else
                            <span class="text-red-400">Inaktív</span>
                        @endif
                    </td>
                    <td class="text-right">
                        <form method="POST"
                              action="{{ route('partner.users.toggle', $emp->id) }}">
                            @csrf
                            <button class="text-sm px-3 py-1 rounded
                                {{ $emp->aktiv ? 'bg-red-500/20 text-red-400' : 'bg-green-500/20 text-green-400' }}">
                                {{ $emp->aktiv ? 'Letiltás' : 'Aktiválás' }}
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
            </div>
        </div>
   <!--soforok-->
<div id="driversContent" class="content-section" data-page-title="Sofőrök nyilvántartása">
    <div class="glassmorphism-element p-6 rounded-xl">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-5">
            <div class="flex-1">
                <input id="driverSearch" type="text"
                       class="w-full bg-transparent border border-white/10 rounded-lg px-4 py-2 text-gray-200 outline-none focus:border-white/20"
                       placeholder="Keresés név, telefon alapján...">
            </div>

            <button type="button" id="addDriverBtn"
                    class="px-4 py-2 rounded-lg bg-blue-600/80 hover:bg-blue-600 text-white font-medium transition">
                + Új sofőr
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-gray-300 border-b border-white/10">
                        <th class="py-3 pr-4">Név</th>
                        <th class="py-3 pr-4">Telefon</th>
                        <th class="py-3 pr-4">Személyi ID</th>
                        <th class="py-3 pr-4">Státusz</th>
                        <th class="py-3 text-right">Műveletek</th>
                    </tr>
                </thead>
                <tbody class="text-gray-200" id="driverTableBody">
                @forelse($drivers as $d)
                    <tr class="border-b border-white/10 hover:bg-white/5 transition">
                        <td class="py-3 pr-4">{{ $d->nev }}</td>
                        <td class="py-3 pr-4">{{ $d->telefonszam }}</td>
                        <td class="py-3 pr-4">{{ $d->szemelyi_azonosito ?? '-' }}</td>
                        <td class="py-3 pr-4">
                            @if($d->aktiv)
                                <span class="px-2 py-1 rounded-md text-sm bg-green-600/25 text-green-200">Aktív</span>
                            @else
                                <span class="px-2 py-1 rounded-md text-sm bg-gray-600/25 text-gray-200">Inaktív</span>
                            @endif
                        </td>
                        <td class="py-3 text-right space-x-2">
                            <form action="{{ route('partner.soforok.toggle', $d->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" title="Státusz változtatása" class="text-sky-400 hover:text-sky-300">
                                    <i class="fas fa-power-off"></i>
                                </button>
                            </form>

                            <button onclick='editDriver(@json($d))' title="Szerkesztés" class="text-amber-400 hover:text-amber-300">
                                <i class="fas fa-edit"></i>
                            </button>

                            <form action="{{ route('partner.soforok.destroy', $d->id) }}" method="POST" class="inline" onsubmit="return confirm('Biztosan törölni szeretnéd ezt a sofőrt?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Törlés" class="text-red-400 hover:text-red-300">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-10 text-center text-gray-500 italic">Nincs m még rögzített sofőr.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div id="driversEmptyState" class="mt-6 text-gray-400 {{ (count($drivers) > 0) ? 'hidden' : '' }}">
            Nincs m még rögzített sofőr. Kattints az <b>Új sofőr</b> gombra a felvitelhez.
        </div>
    </div>

    <div id="driverModal" class="fixed inset-0 z-50 hidden items-center justify-center">
        <div id="driverModalBackdrop" class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

        <div class="relative w-[95%] max-w-2xl glassmorphism-element p-6 rounded-xl shadow-2xl">
            <div class="flex items-center justify-between mb-4">
                <h3 id="driverModalTitle" class="text-white text-lg font-semibold">Új sofőr</h3>
                <button type="button" id="closeDriverModal"
                        class="text-gray-300 hover:text-white text-xl leading-none">Ă—</button>
            </div>

            <form id="driverForm" method="POST" action="{{ route('partner.soforok.store') }}"
                  class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf
                <div id="driverMethodField"></div>

                <div>
                    <label class="block text-gray-300 mb-1">Aktív</label>
                    <select id="driverActive" name="aktiv" required
                            class="w-full bg-slate-800 border border-white/10 rounded-lg px-4 py-2 text-gray-200 outline-none focus:border-white/20">
                        <option value="1">Igen</option>
                        <option value="0">Nem</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-300 mb-1">Név</label>
                    <input id="driverName" name="nev" type="text" required
                           class="w-full bg-slate-800 border border-white/10 rounded-lg px-4 py-2 text-gray-200 outline-none focus:border-white/20">
                </div>

                <div>
                    <label class="block text-gray-300 mb-1">Személyi azonosító</label>
                    <input id="driverPersonalId" name="szemelyi_azonosito" type="text"
                           class="w-full bg-slate-800 border border-white/10 rounded-lg px-4 py-2 text-gray-200 outline-none focus:border-white/20">
                </div>

                <div>
                    <label class="block text-gray-300 mb-1">Születési dátum</label>
                    <input id="driverBirthDate" name="szuletesi_datum" type="date"
                           class="w-full bg-slate-800 border border-white/10 rounded-lg px-4 py-2 text-gray-200 outline-none focus:border-white/20">
                </div>

                <div>
                    <label class="block text-gray-300 mb-1">Telefonszám</label>
                    <input id="driverPhone" name="telefonszam" type="text" required
                           class="w-full bg-slate-800 border border-white/10 rounded-lg px-4 py-2 text-gray-200 outline-none focus:border-white/20">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-300 mb-1">Cím</label>
                    <input id="driverAddress" name="cim" type="text"
                           class="w-full bg-slate-800 border border-white/10 rounded-lg px-4 py-2 text-gray-200 outline-none focus:border-white/20">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-300 mb-1">Adószám</label>
                    <input id="driverTax" name="adoszam" type="text"
                           class="w-full bg-slate-800 border border-white/10 rounded-lg px-4 py-2 text-gray-200 outline-none focus:border-white/20">
                </div>

                <div class="md:col-span-2 flex justify-end gap-2 pt-2">
                    <button type="button" id="cancelDriverModal"
                            class="px-4 py-2 rounded-lg bg-white/5 hover:bg-white/10 text-gray-200 transition">
                        Mégse
                    </button>
                    <button type="submit"
                            class="px-4 py-2 rounded-lg bg-blue-600/80 hover:bg-blue-600 text-white font-medium transition">
                        Mentés
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


        <!--jarmuvek-->
<div id="trucksContent" class="content-section" data-page-title="Járművek nyilvántartása">
    <div class="glassmorphism-element p-6 rounded-xl">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-5">
            <div class="flex-1">
                <input id="truckSearch" type="text"
                       class="w-full bg-transparent border border-white/10 rounded-lg px-4 py-2 text-gray-200 outline-none focus:border-white/20"
                       placeholder="Keresés rendszám, márká alapján...">
            </div>

            <button type="button" id="addTruckBtn"
                    class="px-4 py-2 rounded-lg bg-blue-600/80 hover:bg-blue-600 text-white font-medium transition">
                + Új jármű
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-gray-300 border-b border-white/10">
                        <th class="py-3 pr-4">Rendszám</th>
                        <th class="py-3 pr-4">Márka</th>
                        <th class="py-3 pr-4">Kategória</th>
                        <th class="py-3 pr-4">Státusz</th>
                        <th class="py-3 text-right">Műveletek</th>
                    </tr>
                </thead>
                <tbody class="text-gray-200" id="truckTableBody">
                @forelse($trucks as $t)
                    <tr class="border-b border-white/10 hover:bg-white/5 transition">
                        <td class="py-3 pr-4">{{ $t->rendszam }}</td>
                        <td class="py-3 pr-4">{{ $t->marka }}</td>
                        <td class="py-3 pr-4">{{ $t->kategoria }}</td>
                        <td class="py-3 pr-4">
                            @if($t->aktiv)
                                <span class="px-2 py-1 rounded-md text-sm bg-green-600/25 text-green-200">Aktív</span>
                            @else
                                <span class="px-2 py-1 rounded-md text-sm bg-gray-600/25 text-gray-200">Inaktív</span>
                            @endif
                        </td>
                        <td class="py-3 text-right space-x-2">
                            <form action="{{ route('partner.jarmuvek.toggle', $t->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" title="Státusz változtatása" class="text-sky-400 hover:text-sky-300">
                                    <i class="fas fa-power-off"></i>
                                </button>
                            </form>

                            <button onclick='editTruck(@json($t))' title="Szerkesztés" class="text-amber-400 hover:text-amber-300">
                                <i class="fas fa-edit"></i>
                            </button>

                            <form action="{{ route('partner.jarmuvek.destroy', $t->id) }}" method="POST" class="inline" onsubmit="return confirm('Biztosan törölni szeretné ezt a járművet?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Törlés" class="text-red-400 hover:text-red-300">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-10 text-center text-gray-500 italic">Nincs még rögzített jármű.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div id="trucksEmptyState" class="mt-6 text-gray-400 {{ (count($trucks) > 0) ? 'hidden' : '' }}">
            Nincs még rögzített jármű. Kattints az <b>Új jármű</b> gombra a felvitelhez.
        </div>
    </div>

    <div id="truckModal" class="fixed inset-0 z-50 hidden items-center justify-center">
        <div id="truckModalBackdrop" class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

        <div class="relative w-[95%] max-w-2xl glassmorphism-element p-6 rounded-xl shadow-2xl">
            <div class="flex items-center justify-between mb-4">
                <h3 id="truckModalTitle" class="text-white text-lg font-semibold">Új jármű</h3>
                <button type="button" id="closeTruckModal"
                        class="text-gray-300 hover:text-white text-xl leading-none">Ă—</button>
            </div>

            <form id="truckForm" method="POST" action="{{ route('partner.jarmuvek.store') }}"
                  class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf
                <div id="truckMethodField"></div>

                <div>
                    <label class="block text-gray-300 mb-1">Aktív</label>
                    <select id="truckAktiv" name="aktiv" required
                            class="w-full bg-slate-800 border border-white/10 rounded-lg px-4 py-2 text-gray-200 outline-none focus:border-white/20">
                        <option value="1">Igen</option>
                        <option value="0">Nem</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-300 mb-1">Rendszám</label>
                    <input id="truckRendszam" name="rendszam" type="text" required
                           class="w-full bg-slate-800 border border-white/10 rounded-lg px-4 py-2 text-gray-200 outline-none focus:border-white/20">
                </div>

                <div>
                    <label class="block text-gray-300 mb-1">Márka</label>
                    <input id="truckMarka" name="marka" type="text"
                           class="w-full bg-slate-800 border border-white/10 rounded-lg px-4 py-2 text-gray-200 outline-none focus:border-white/20">
                </div>

                <div>
                    <label class="block text-gray-300 mb-1">Kategória</label>
                    <select id="truckKategoria" name="kategoria" required
                            class="w-full bg-slate-800 border border-white/10 rounded-lg px-4 py-2 text-gray-200 outline-none focus:border-white/20">
                        <option value="Tehergépkocsi">Tehergépkocsi</option>
                        <option value="Személygépkocsi">Személygépkocsi</option>
                        <option value="Kisteherautó">Kisteherautó</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-300 mb-1">Típus</label>
                    <input id="truckTipus" name="tipus" type="text" required
                           class="w-full bg-slate-800 border border-white/10 rounded-lg px-4 py-2 text-gray-200 outline-none focus:border-white/20">
                </div>

                <div>
                    <label class="block text-gray-300 mb-1">Tengelyszám</label>
                    <select id="truckTengelyszam" name="tengelyszam" required
                            class="w-full bg-slate-800 border border-white/10 rounded-lg px-4 py-2 text-gray-200 outline-none focus:border-white/20">
                        <option value="0">-</option>
                        <option value="1">1 tengelyes</option>
                        <option value="2">2 tengelyes</option>
                        <option value="3">3 tengelyes</option>
                        <option value="4">4 tengelyes</option>
                        <option value="5">5 tengelyes</option>
                        <option value="6">6 tengelyes</option>
                        <option value="7">7 tengelyes</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-300 mb-1">Alvázszám</label>
                    <input id="truckAlvazszam" name="vin" type="text"
                           class="w-full bg-slate-800 border border-white/10 rounded-lg px-4 py-2 text-gray-200 outline-none focus:border-white/20">
                </div>

                <div>
                    <label class="block text-gray-300 mb-1">Euro besorolás</label>
                    <select id="truckEurobesorolas" name="euro_besorolas" required
                            class="w-full bg-slate-800 border border-white/10 rounded-lg px-4 py-2 text-gray-200 outline-none focus:border-white/20">
                        <option value="3">Euro 3</option>
                        <option value="4">Euro 4</option>
                        <option value="5">Euro 5</option>
                        <option value="6">Euro 6</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-300 mb-1">Össztömeg</label>
                    <input id="truckOssztomeg" name="ossztomeg_kg" type="text"
                           class="w-full bg-slate-800 border border-white/10 rounded-lg px-4 py-2 text-gray-200 outline-none focus:border-white/20">
                </div>

                                <div>
                    <label class="block text-gray-300 mb-1">Pótkocsi képes?</label>
                    <select id="truckPotkocsikepes" name="potkocsi_kepes" required
                            class="w-full bg-slate-800 border border-white/10 rounded-lg px-4 py-2 text-gray-200 outline-none focus:border-white/20">
                        <option value="1">Igen</option>
                        <option value="0">Nem</option>
                    </select>
                </div>

                <div class="md:col-span-2 flex justify-end gap-2 pt-2">
                    <button type="button" id="cancelTruckModal"
                            class="px-4 py-2 rounded-lg bg-white/5 hover:bg-white/10 text-gray-200 transition">
                        Mégse
                    </button>
                    <button type="submit"
                            class="px-4 py-2 rounded-lg bg-blue-600/80 hover:bg-blue-600 text-white font-medium transition">
                        Mentés
                    </button>
                     </div>
                </div>
            </form>
        </div>
    </div>
</div>

       <!--riportok-->
<div id="reportsContent" class="content-section hidden" data-page-title="Riportok">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="glassmorphism-element p-6 rounded-xl">
            <p class="text-gray-400">Sofőrök száma</p>
            <h3 class="text-2xl text-white font-bold mt-2">
                {{ collect($drivers ?? [])->count() }}
            </h3>
        </div>

        <div class="glassmorphism-element p-6 rounded-xl">
            <p class="text-gray-400">Aktív sofőrök</p>
            <h3 class="text-2xl text-green-400 font-bold mt-2">
                {{ collect($drivers ?? [])->where('aktiv', 1)->count() }}
            </h3>
        </div>

        <div class="glassmorphism-element p-6 rounded-xl">
            <p class="text-gray-400">Járművek száma</p>
            <h3 class="text-2xl text-white font-bold mt-2">
                {{ collect($trucks ?? [])->count() }}
            </h3>
        </div>

        <div class="glassmorphism-element p-6 rounded-xl">
            <p class="text-gray-400">Aktív járművek</p>
            <h3 class="text-2xl text-green-400 font-bold mt-2">
                {{ collect($trucks ?? [])->where('aktiv', 1)->count() }}
            </h3>
        </div>

        <div class="glassmorphism-element p-6 rounded-xl">
            <p class="text-gray-400">Alkalmazottak száma</p>
            <h3 class="text-2xl text-white font-bold mt-2">
                {{ collect($employees ?? [])->count() }}
            </h3>
        </div>

        <div class="glassmorphism-element p-6 rounded-xl">
            <p class="text-gray-400">Aktív alkalmazottak</p>
            <h3 class="text-2xl text-green-400 font-bold mt-2">
                {{ collect($employees ?? [])->where('aktiv', 1)->count() }}
            </h3>
        </div>

    </div>
</div>

         <!--beallitasok-->
<div id="settingsContent" class="content-section" data-page-title="Beállítások">
    <div class="mb-6">
        <p class="text-slate-400 text-sm">A partnercég adatainak kezelése.</p>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-emerald-300">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-red-300">
            <ul class="space-y-1 text-sm">
                @foreach($errors->all() as $error)
                    <li>â€˘ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="glassmorphism-element p-6 md:p-8 rounded-2xl border border-cyan-500/10">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h3 class="font-poppins text-xl font-semibold text-white">Cégadatok</h3>
                <p class="text-sm text-slate-400 mt-1">
                    A bejelentkezett partnercég adatainak módosítása.
                </p>
            </div>

            <div class="hidden md:flex items-center gap-2 px-3 py-2 rounded-lg bg-cyan-500/10 border border-cyan-400/20 text-cyan-300 text-sm">
                <i class="fas fa-building"></i>
                <span>Cégprofil</span>
            </div>
        </div>

        <form action="{{ route('partner.settings.company.update') }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nev" class="block mb-2 text-sm font-medium text-slate-300">
                        Cégneve
                    </label>
                    <input
                        type="text"
                        id="nev"
                        name="nev"
                        value="{{ old('nev', auth()->user()->ceg->nev ?? '') }}"
                        placeholder="Pl. ÚtdíjPro Logisztika Kft."
                        class="w-full rounded-xl border border-slate-700 bg-slate-900/70 px-4 py-3 text-white placeholder-slate-500 focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-500/20"
                    >
                </div>

                <div>
                    <label for="adoszam" class="block mb-2 text-sm font-medium text-slate-300">
                        Adószám
                    </label>
                    <input
                        type="text"
                        id="adoszam"
                        name="adoszam"
                        value="{{ old('adoszam', auth()->user()->ceg->adoszam ?? '') }}"
                        placeholder="Pl. 12345678-1-26"
                        class="w-full rounded-xl border border-slate-700 bg-slate-900/70 px-4 py-3 text-white placeholder-slate-500 focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-500/20"
                    >
                </div>
            </div>

            <div>
                <label for="cim" class="block mb-2 text-sm font-medium text-slate-300">
                    Cím / székhely
                </label>
                <input
                    type="text"
                    id="cim"
                    name="cim"
                    value="{{ old('cim', auth()->user()->ceg->cim ?? '') }}"
                    placeholder="Pl. 6724 Szeged, Példa utca 12."
                    class="w-full rounded-xl border border-slate-700 bg-slate-900/70 px-4 py-3 text-white placeholder-slate-500 focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-500/20"
                >
            </div>

            <div class="border-t border-slate-700/60 pt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="text-sm text-slate-400">
                    Csak a bejelentkezett partnerhez tartozó cég adatai módosíthatók.
                </div>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center px-6 py-3 rounded-xl font-semibold text-white bg-gradient-to-r from-cyan-500 to-indigo-500 hover:opacity-90 transition shadow-lg shadow-cyan-500/10"
                >
                    <i class="fas fa-save mr-2"></i>
                    Cégadatok mentése
                </button>
            </div>
        </form>
    </div>
</div>
    </main>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
//js: menu, tartalomvaltas(menupont), kalkulator, modalok.
document.addEventListener('DOMContentLoaded', () => {
    //gombok es panelok dom-bol
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const sidebar = document.getElementById('sidebar');
    const mainContentArea = document.getElementById('mainContentArea');
    const pageTitleContainer = document.getElementById('pageTitleContainer');

    const sidebarLinks = document.querySelectorAll('.sidebar-link');
    const contentSections = document.querySelectorAll('.content-section');
    const sidebarLinkTriggers = document.querySelectorAll('.sidebar-link-trigger');

    //kalkulator dom elemek
    const portalCalculateBtn = document.getElementById('portalCalculateBtn');
    const portalResultsSection = document.getElementById('portalResultsSection');
    const portalErrorMessages = document.getElementById('portalErrorMessages');
    const portalTollResult = document.getElementById('portalTollResult');
    const portalDistanceResult = document.getElementById('portalDistanceResult');
    const portalMapContainer = document.getElementById('portalMapContainer');
    const portalExternalLinkContainer = document.getElementById('portalExternalLinkContainer');
    const waypointsContainer = document.getElementById('waypointsContainer');
    const addWaypointBtn = document.getElementById('addWaypointBtn');
    const calculatorLink = document.getElementById('openCalculator');
    const notificationBtn = document.getElementById('notificationBtn');
    const notificationPanel = document.getElementById('notificationPanel');
    const notificationDot = document.getElementById('notificationDot');
    const notificationSummary = document.getElementById('notificationSummary');
    const notificationItems = document.querySelectorAll('.notification-item');
    const markNotificationsReadBtn = document.getElementById('markNotificationsReadBtn');

    let waypointCounter = 0;
    let map = null;
    let routePolyline = null;
    let markers = [];

    //ertesitesek allapotanak frissitese
    function updateNotificationState() {
        const unreadItems = Array.from(notificationItems).filter(item => item.dataset.unread === 'true');
        const unreadCount = unreadItems.length;

        if (notificationSummary) {
            notificationSummary.textContent = unreadCount > 0
                ? `${unreadCount} olvasatlan ertesites`
                : 'Nincs uj ertesites';
        }

        if (notificationDot) {
            notificationDot.classList.toggle('hidden', unreadCount === 0);
        }
    }

    //ertesitesi panel nyitasa es zarasa
    function toggleNotificationPanel(forceOpen = null) {
        if (!notificationBtn || !notificationPanel) {
            return;
        }

        const shouldOpen = forceOpen === null
            ? notificationPanel.classList.contains('hidden')
            : forceOpen;

        notificationPanel.classList.toggle('hidden', !shouldOpen);
        notificationBtn.setAttribute('aria-expanded', shouldOpen ? 'true' : 'false');
    }

    //mobil menu, sidebar
    if (mobileMenuBtn && sidebar) {
        mobileMenuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebar.classList.toggle('-translate-x-full');
        });

        document.addEventListener('click', (e) => {
            if (
                window.innerWidth < 1024 &&
                !sidebar.contains(e.target) &&
                !mobileMenuBtn.contains(e.target) &&
                !sidebar.classList.contains('-translate-x-full')
            ) {
                sidebar.classList.add('-translate-x-full');
            }
        });
    }

    //ertesitesi panel es olvasatlan elemek kezelese
    if (notificationBtn && notificationPanel) {
        notificationBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleNotificationPanel();
        });

        notificationPanel.addEventListener('click', (e) => {
            e.stopPropagation();
        });

        document.addEventListener('click', (e) => {
            if (!notificationPanel.contains(e.target) && !notificationBtn.contains(e.target)) {
                toggleNotificationPanel(false);
            }
        });
    }

    if (markNotificationsReadBtn) {
        markNotificationsReadBtn.addEventListener('click', () => {
            notificationItems.forEach(item => {
                item.dataset.unread = 'false';
                item.classList.remove('bg-sky-500/5');

                const itemBadge = item.querySelector('span');
                if (itemBadge) {
                    itemBadge.classList.add('hidden');
                }
            });

            updateNotificationState();
        });
    }

    notificationItems.forEach(item => {
        item.addEventListener('click', () => {
            item.dataset.unread = 'false';
            item.classList.remove('bg-sky-500/5');

            const itemBadge = item.querySelector('span');
            if (itemBadge) {
                itemBadge.classList.add('hidden');
            }

            updateNotificationState();
        });
    });

    updateNotificationState();

    //tartalomvaltas
    function renderPageTitle(title) {
        if (!pageTitleContainer || !title) {
            return;
        }

        pageTitleContainer.innerHTML =
            `<h1 class="font-poppins text-2xl md:text-3xl font-bold text-white">${title}</h1>`;
    }

    function switchContent(targetId) {
        const targetBaseId = targetId.startsWith('#') ? targetId.substring(1) : targetId;

        contentSections.forEach(section => {
            if (section.id === targetBaseId) {
                section.classList.add('active');
                const pageTitle = section.dataset.pageTitle || 'Irányítópult';
                renderPageTitle(pageTitle);
            } else {
                section.classList.remove('active');
            }
        });

        sidebarLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === '#' + targetBaseId) {
                link.classList.add('active');
            }
        });

        if (sidebar && !sidebar.classList.contains('-translate-x-full') && window.innerWidth < 1024) {
            sidebar.classList.add('-translate-x-full');
        }

        if (mainContentArea) {
            mainContentArea.scrollTop = 0;
        }
    }

    sidebarLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');

            if (targetId && targetId.startsWith('#') && targetId.length > 1) {
                e.preventDefault();
                switchContent(targetId);
            }
        });
    });

    sidebarLinkTriggers.forEach(link => {
        link.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');

            if (targetId && targetId.startsWith('#') && targetId.length > 1) {
                e.preventDefault();
                switchContent(targetId);
            }
        });
    });

    //kalkulator: leaflet terkep inicializalasa
    function initMap() {
        if (!map && portalMapContainer) {
            map = L.map(portalMapContainer).setView([47.1625, 19.5033], 7);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);
        }
    }

    //kalkulacio eredmenyek es terkep tisztitasa uj kalkulacio elott
    function clearMapAndResults() {
        if (routePolyline && map) {
            map.removeLayer(routePolyline);
            routePolyline = null;
        }

        if (map) {
            markers.forEach(marker => map.removeLayer(marker));
        }

        markers = [];

        if (portalTollResult) portalTollResult.textContent = 'N/A';
        if (portalDistanceResult) portalDistanceResult.textContent = 'N/A';
        if (portalExternalLinkContainer) portalExternalLinkContainer.innerHTML = '';

        if (portalErrorMessages) {
            portalErrorMessages.textContent = '';
            portalErrorMessages.classList.add('hidden');
        }

        if (portalResultsSection) {
            portalResultsSection.classList.add('hidden');
        }
    }

    //uj waypoint hozzaadasa a kalkulatorhoz
    function addWaypointInput() {
        if (!waypointsContainer) return;

        waypointCounter++;

        const waypointDiv = document.createElement('div');
        waypointDiv.className = 'flex items-center space-x-2 mb-2 waypoint-entry mt-2';
        waypointDiv.innerHTML = `
            <input type="text" placeholder="Köztes megálló ${waypointCounter}" class="flex-grow calculator-input waypoint-address">
            <button type="button" class="remove-waypoint-btn text-red-500 hover:text-red-400 p-2 rounded-md hover:bg-red-500/10" title="Megálló törlése">
                <i class="fas fa-trash-alt"></i>
            </button>
        `;

        waypointsContainer.appendChild(waypointDiv);

        const removeBtn = waypointDiv.querySelector('.remove-waypoint-btn');
        removeBtn?.addEventListener('click', () => waypointDiv.remove());
    }

    if (addWaypointBtn) {
        addWaypointBtn.addEventListener('click', addWaypointInput);
    }

    if (calculatorLink) {
        calculatorLink.addEventListener('click', () => {
            setTimeout(() => {
                initMap();
                if (map) {
                    map.invalidateSize();
                }
            }, 150);
        });
    }

    //kalkulacio gomb es logika (adatgyujtes, szerverhivas, eredmeny megjelenites)
    if (portalCalculateBtn) {
        portalCalculateBtn.addEventListener('click', async () => {
            const from = document.getElementById('from-loc')?.value.trim() || '';
            const to = document.getElementById('to-loc')?.value.trim() || '';
            const truckType = document.getElementById('truck-type-select')?.value || '';

            const waypointInputs = document.querySelectorAll('#waypointsContainer .waypoint-address');
            const waypoints = Array.from(waypointInputs)
                .map(input => input.value.trim())
                .filter(address => address !== '')
                .map(address => ({ address }));

            if (!from || !to || !truckType) {
                portalErrorMessages.textContent = 'Kérem, töltse ki az indulási hely, célhely és járműtípus mezőket.';
                portalErrorMessages.classList.remove('hidden');
                return;
            }

            initMap();
            clearMapAndResults();

            portalCalculateBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Kalkuláció...';
            portalCalculateBtn.disabled = true;

            try {
                const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

                //a szerveroldali kalkulacios endpoint '/calculate', ami a kalkulacio logikat kezeli es visszaadja az eredmenyeket JSON formatumban.
                const response = await fetch('/calculate', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        from,
                        to,
                        vehicleType: truckType,
                        waypoints
                    })
                });

                const result = await response.json();

                if (!response.ok) {
                    throw new Error(result.details?.message || result.error || `Hiba a szervertől: ${response.status}`);
                }

                portalTollResult.textContent = `${Number(result.costHUF).toLocaleString('hu-HU')} ${result.currency}`;
                portalDistanceResult.textContent = `${Number(result.distanceKm).toLocaleString('hu-HU')} km`;

                if (result.routeLink && portalExternalLinkContainer) {
                    const link = document.createElement('a');
                    link.href = result.routeLink;
                    link.target = '_blank';
                    link.rel = 'noopener noreferrer';
                    link.className = 'calculator-button-secondary inline-flex items-center py-2 px-4 rounded-md text-sm font-medium';
                    link.innerHTML = '<i class="fas fa-external-link-alt mr-2"></i>Útvonal megtekintése új ablakban';
                    portalExternalLinkContainer.appendChild(link);
                }

                if (map && Array.isArray(result.locations)) {
                    const boundsArray = [];

                    result.locations.forEach((loc) => {
                        const marker = L.marker([loc.lat, loc.lng])
                            .addTo(map)
                            .bindPopup(`<b>${loc.name}</b><br>${loc.displayName}`);
                        markers.push(marker);
                        boundsArray.push([loc.lat, loc.lng]);
                    });

                    if (Array.isArray(result.routeCoords) && result.routeCoords.length > 0) {
                        routePolyline = L.polyline(result.routeCoords, {
                            color: '#0ea5e9',
                            weight: 6,
                            opacity: 0.85
                        }).addTo(map);

                        map.fitBounds(routePolyline.getBounds(), { padding: [30, 30] });
                    } else if (boundsArray.length > 0) {
                        map.fitBounds(boundsArray, { padding: [30, 30], maxZoom: 12 });
                    }

                    setTimeout(() => {
                        if (map) map.invalidateSize();
                    }, 200);
                }

                portalResultsSection.classList.remove('hidden');
            } catch (err) {
                console.error('Kalkuláció hiba a portálon:', err);
                portalErrorMessages.textContent = err.message || 'Ismeretlen hiba történt a kalkuláció során.';
                portalErrorMessages.classList.remove('hidden');
            } finally {
                portalCalculateBtn.innerHTML = '<i class="fas fa-cogs mr-2"></i>Kalkuláció';
                portalCalculateBtn.disabled = false;
            }
        });
    }

    const params = new URLSearchParams(window.location.search);
    const tab = params.get('tab');

    if (tab) {
        switchContent('#' + tab);
    } else if (sidebarLinks.length > 0) {
        switchContent(sidebarLinks[0].getAttribute('href'));
    }

    //sofor modal (hozzaadas es szerkesztes) funkciok
    const driverModal = document.getElementById('driverModal');
    const addDriverBtn = document.getElementById('addDriverBtn');
    const closeDriverModal = document.getElementById('closeDriverModal');
    const cancelDriverModal = document.getElementById('cancelDriverModal');
    const driverModalBackdrop = document.getElementById('driverModalBackdrop');
    const driverForm = document.getElementById('driverForm');

    function openDriverModal() {
        if (!driverModal) return;
        driverModal.classList.remove('hidden');
        driverModal.classList.add('flex');
    }

    function closeDriverModalFn() {
        if (!driverModal) return;
        driverModal.classList.add('hidden');
        driverModal.classList.remove('flex');
    }

    addDriverBtn?.addEventListener('click', () => {
        if (driverForm) driverForm.reset();
        document.getElementById('driverModalTitle').innerText = 'Új sofőr hozzáadása';
        driverForm.action = "{{ route('partner.soforok.store') }}";
        document.getElementById('driverMethodField').innerHTML = '';
        openDriverModal();
    });

    closeDriverModal?.addEventListener('click', closeDriverModalFn);
    cancelDriverModal?.addEventListener('click', closeDriverModalFn);
    driverModalBackdrop?.addEventListener('click', closeDriverModalFn);

    //jarmu modal (hozzaadas es szerkesztes) funkciok
    const truckModal = document.getElementById('truckModal');
    const addTruckBtn = document.getElementById('addTruckBtn');
    const closeTruckModal = document.getElementById('closeTruckModal');
    const cancelTruckModal = document.getElementById('cancelTruckModal');
    const truckModalBackdrop = document.getElementById('truckModalBackdrop');
    const truckForm = document.getElementById('truckForm');

    function openTruckModal() {
        if (!truckModal) return;
        truckModal.classList.remove('hidden');
        truckModal.classList.add('flex');
    }

    function closeTruckModalFn() {
        if (!truckModal) return;
        truckModal.classList.add('hidden');
        truckModal.classList.remove('flex');
    }

    addTruckBtn?.addEventListener('click', () => {
        if (truckForm) truckForm.reset();
        document.getElementById('truckModalTitle').innerText = 'Új jármű hozzáadása';
        truckForm.action = "{{ route('partner.jarmuvek.store') }}";
        document.getElementById('truckMethodField').innerHTML = '';
        openTruckModal();
    });

    closeTruckModal?.addEventListener('click', closeTruckModalFn);
    cancelTruckModal?.addEventListener('click', closeTruckModalFn);
    truckModalBackdrop?.addEventListener('click', closeTruckModalFn);

    //esc gomb modal bezarasahoz
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeDriverModalFn();
            closeTruckModalFn();
        }
    });

    //riport
    const generateBtn = document.getElementById('generateReportBtn');
    const tableBody = document.getElementById('reportTableBody');
    const emptyState = document.getElementById('reportsEmptyState');

    if (generateBtn && tableBody && emptyState) {
        generateBtn.addEventListener('click', function () {
            tableBody.innerHTML = `
                <tr class="border-b border-white/10 hover:bg-white/5 transition">
                    <td class="py-3 pr-4">GenerĂˇlt riport</td>
                    <td class="py-3 pr-4">${document.getElementById("reportType")?.value || ''}</td>
                    <td class="py-3 pr-4">${document.getElementById("reportFrom")?.value || ''} - ${document.getElementById("reportTo")?.value || ''}</td>
                    <td class="py-3 pr-4">
                        <span class="px-2 py-1 rounded-md text-sm bg-green-600/25 text-green-200">Elkészült</span>
                    </td>
                    <td class="py-3 text-right space-x-2">
                        <button type="button" class="text-sky-400 hover:text-sky-300"><i class="fas fa-eye"></i></button>
                        <button type="button" class="text-amber-400 hover:text-amber-300"><i class="fas fa-download"></i></button>
                        <button type="button" class="text-red-400 hover:text-red-300"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            `;
            emptyState.classList.add('hidden');
        });
    }
});

//globalis fuggvenyek a modalok megnyitasa es adatokkal valo feltoltesehez szerkesztes eseten
//soforok
function editDriver(driver) {
    const modal = document.getElementById('driverModal');
    const form = document.getElementById('driverForm');
    const title = document.getElementById('driverModalTitle');
    const methodField = document.getElementById('driverMethodField');

    title.innerText = 'Sofőr adatainak módosítása';
    form.action = `/partner/soforok/${driver.id}/update`;
    methodField.innerHTML = '';

    document.getElementById('driverName').value = driver.nev || '';
    document.getElementById('driverPhone').value = driver.telefonszam || '';
    document.getElementById('driverPersonalId').value = driver.szemelyi_azonosito || '';
    document.getElementById('driverBirthDate').value = driver.szuletesi_datum || '';
    document.getElementById('driverAddress').value = driver.cim || '';
    document.getElementById('driverTax').value = driver.adoszam || '';
    document.getElementById('driverActive').value = driver.aktiv ? 1 : 0;

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
//jarmu
function editTruck(truck) {
    const modal = document.getElementById('truckModal');
    const form = document.getElementById('truckForm');
    const title = document.getElementById('truckModalTitle');
    const methodField = document.getElementById('truckMethodField');

    title.innerText = 'Jármű adatainak módosítása';
    form.action = `/partner/jarmuvek/${truck.id}/update`;
    methodField.innerHTML = '';

    document.getElementById('truckAktiv').value = truck.aktiv ? 1 : 0;
    document.getElementById('truckRendszam').value = truck.rendszam || '';
    document.getElementById('truckMarka').value = truck.marka || '';
    document.getElementById('truckKategoria').value = truck.kategoria || '';
    document.getElementById('truckTipus').value = truck.tipus || '';
    document.getElementById('truckTengelyszam').value = truck.tengelyszam || '';
    document.getElementById('truckAlvazszam').value = truck.vin || '';
    document.getElementById('truckEurobesorolas').value = truck.euro_besorolas || '';
    document.getElementById('truckOssztomeg').value = truck.ossztomeg_kg || '';
    document.getElementById('truckPotkocsikepes').value = truck.potkocsi_kepes ? 1 : 0;

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
</script>
</body>
</html>
