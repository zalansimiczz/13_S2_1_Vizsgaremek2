{{-- resources/views/partner/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ÚtdíjPro - Partner Irányítópult</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
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
    </style>
</head>
<body class="flex h-screen overflow-hidden">

    @php
    $partnerName = $userName ?? session('user_name', 'Partner felhasználó');
    @endphp


    <!-- MOBIL MENÜ GOMB -->
    <button id="mobileMenuBtn" class="lg:hidden fixed top-4 left-4 p-3 bg-gray-800/80 text-white rounded-md backdrop-blur-sm shadow-lg">
        <i class="fas fa-bars fa-lg"></i>
    </button>

    <!-- OLDALSÁV -->
    <aside id="sidebar" class="sidebar glassmorphism-element p-5 space-y-6 flex-shrink-0 h-full overflow-y-auto transform -translate-x-full lg:translate-x-0 fixed lg:static z-40">
        <div class="logo-container text-center mb-6 pt-8 lg:pt-0">
            <a href="/" class="flex items-center justify-center space-x-2" title="Vissza a főoldalra">
                <i class="fas fa-road-bridge fa-2x text-[var(--color-primary)]"></i>
                <span class="font-poppins self-center text-2xl font-bold whitespace-nowrap text-white">Útdíj<span class="text-[var(--color-primary)]">Pro</span></span>
            </a>
        </div>
        <nav class="space-y-1.5">
            <a href="#dashboard-main-content" class="sidebar-link active flex items-center space-x-3 px-4 py-2.5 rounded-md text-gray-300">
                <i class="fas fa-tachometer-alt fa-fw w-5 text-center"></i><span class="font-medium">Irányítópult</span>
            </a>
            <a href="#calculatorSectionContent" id="openCalculator" class="sidebar-link flex items-center space-x-3 px-4 py-2.5 rounded-md text-gray-300">
                <i class="fas fa-calculator fa-fw w-5 text-center"></i><span class="font-medium">Útdíj Kalkulátor</span>
            </a>
            <a href="#addUserContent" class="sidebar-link flex items-center space-x-3 px-4 py-2.5 rounded-md text-gray-300">
                <i class="fas fa-users-cog fa-fw w-5 text-center"></i><span class="font-medium">Alkalmazottak</span>
            </a>
            <a href="#driversContent" class="sidebar-link flex items-center space-x-3 px-4 py-2.5 rounded-md text-gray-300">
                <i class="fas fa-id-card fa-fw w-5 text-center"></i><span class="font-medium">Sofőrök</span>
            </a>
            <a href="#fleetContent" class="sidebar-link flex items-center space-x-3 px-4 py-2.5 rounded-md text-gray-300">
                <i class="fas fa-truck fa-fw w-5 text-center"></i><span class="font-medium">Flotta</span>
            </a>
            <a href="#reportsContent" class="sidebar-link flex items-center space-x-3 px-4 py-2.5 rounded-md text-gray-300">
                <i class="fas fa-chart-bar fa-fw w-5 text-center"></i><span class="font-medium">Riportok</span>
            </a>
            <a href="#settingsContent" class="sidebar-link flex items-center space-x-3 px-4 py-2.5 rounded-md text-gray-300">
                <i class="fas fa-cog fa-fw w-5 text-center"></i><span class="font-medium">Beállítások</span>
            </a>
        </nav>
        <div class="pt-6 mt-auto border-t border-[var(--color-border)]">
            <a href="{{ route('partner.logout') }}" class="block px-4 py-2 text-sm text-red-400 hover:bg-red-500/20 hover:text-white">
    Kijelentkezés
</a>
        </div>
    </aside>

    <!-- FŐ TARTALOM -->
    <main class="flex-1 p-6 md:p-10 overflow-y-auto" id="mainContentArea">
        <header class="mb-8 md:mb-10">
            <div class="flex justify-between items-center">
                <div id="pageTitleContainer">
                    <h1 class="font-poppins text-2xl md:text-3xl font-bold text-white">Irányítópult</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="text-gray-400 hover:text-[var(--color-primary)] relative" aria-label="Értesítések">
                        <i class="fas fa-bell fa-lg"></i>
                        <span class="absolute -top-1 -right-1 block h-2.5 w-2.5 rounded-full bg-red-500 ring-2 ring-[var(--color-background)]"></span>
                    </button>
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

        <!-- IRÁNYÍTÓPULT -->
        <div id="dashboard-main-content" class="content-section active">
            <h2 class="font-poppins text-xl font-semibold text-white mb-6">Áttekintés</h2>
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

        <!-- KALKULÁTOR -->
        <div id="calculatorSectionContent" class="content-section">
            <section class="glassmorphism-element p-6 md:p-8 rounded-2xl">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="font-poppins text-2xl font-semibold text-white">Útdíj Kalkulátor</h2>
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
                        <p class="text-lg results-text"><strong>Becsült Útdíj:</strong> <span id="portalTollResult" class="font-bold text-white text-xl">N/A</span></p>
                        <p class="text-lg results-text"><strong>Távolság:</strong> <span id="portalDistanceResult" class="font-bold text-white text-xl">N/A</span></p>
                        <div id="portalMapContainer" class="w-full h-80 md:h-96 bg-gray-800 rounded-lg mt-4 border border-gray-700/50"></div>
                        <div id="portalExternalLinkContainer" class="mt-4 text-center"></div>
                    </div>
                    <div id="portalErrorMessages" class="text-red-400 mt-4 hidden p-3 bg-red-900/30 rounded-md border border-red-700/50"></div>
                </div>
            </section>
        </div>

        <!-- ALKALMAZOTTAK KEZELÉSE -->
        <div id="addUserContent" class="content-section">
            <h2 class="font-poppins text-xl font-semibold text-white mb-6">
                Alkalmazottak kezelése
            </h2>

            <div class="glassmorphism-element p-6 rounded-xl space-y-6">

                @if (request('msg') === 'success_user_added')
                    <div class="mb-4 p-4 rounded-lg border border-green-500 bg-green-900/40 text-sm text-green-100">
                        <i class="fas fa-check-circle mr-2"></i>Az új felhasználó sikeresen hozzáadásra került.
                    </div>
                @endif

                <h3 class="font-poppins text-lg font-semibold text-sky-300 mb-2">
                    Új alkalmazott hozzáadása
                </h3>

                {{-- Itt most az EREDETI PHP-s feldolgozó marad, ahogy a régi rendszerben volt --}}
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
   <!-- SOFŐRÖK -->
<div id="driversContent" class="content-section">
    <h2 class="font-poppins text-xl font-semibold text-white mb-6">Sofőrök nyilvántartása</h2>

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
                    <th class="py-3 pr-4">Státusz</th>
                    <th class="py-3 text-right">Műveletek</th>
                </tr>
                </thead>
                <tbody class="text-gray-200">
@forelse($drivers as $d)
    <tr class="border-b border-white/10 hover:bg-white/5 transition">
        <td class="py-3 pr-4">{{ $d->nev }}</td>
        <td class="py-3 pr-4">{{ $d->telefonszam }}</td>
        <td class="py-3 pr-4">-</td>
        <td class="py-3 pr-4">-</td>
        <td class="py-3 pr-4">
            @if($d->aktiv)
                <span class="px-2 py-1 rounded-md text-sm bg-green-600/25 text-green-200">Aktív</span>
            @else
                <span class="px-2 py-1 rounded-md text-sm bg-gray-600/25 text-gray-200">Inaktív</span>
            @endif
        </td>
        <td class="py-3 text-right">
            {{-- később: módosít/töröl --}}
        </td>
    </tr>
@empty
    {{-- ha nincs driver --}}
@endforelse
</tbody>
            </table>
        </div>

        <div id="driversEmptyState" class="mt-6 text-gray-400 {{ (isset($drivers) && $drivers->count() > 0) ? 'hidden' : '' }}">
    Nincs még rögzített sofőr. Kattints az <b>Új sofőr</b> gombra a felvitelhez.
</div>
    </div>

    <!-- MODAL -->
    <div id="driverModal" class="fixed inset-0 z-50 hidden items-center justify-center">
        <div id="driverModalBackdrop" class="absolute inset-0 bg-black/60"></div>

        <div class="relative w-[95%] max-w-2xl glassmorphism-element p-6 rounded-xl">
            <div class="flex items-center justify-between mb-4">
                <h3 id="driverModalTitle" class="text-white text-lg font-semibold">Új sofőr</h3>
                <button type="button" id="closeDriverModal"
                        class="text-gray-300 hover:text-white text-xl leading-none">×</button>
            </div>

            <form id="driverForm" method="POST" action="{{ route('partner.soforok.store') }}"
                  class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf

                <input type="hidden" id="driverId" name="id" value="">
                <input type="hidden" id="driverFormMethod" name="_method" value="POST">

                <div>
                    <label class="block text-gray-300 mb-1">Aktív</label>
                    <select id="driverActive" name="aktiv" required
                            class="w-full bg-transparent border border-white/10 rounded-lg px-4 py-2 text-gray-200 outline-none focus:border-white/20">
                        <option value="1">Igen</option>
                        <option value="0">Nem</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-300 mb-1">Név</label>
                    <input id="driverName" name="nev" type="text" required
                           class="w-full bg-transparent border border-white/10 rounded-lg px-4 py-2 text-gray-200 outline-none focus:border-white/20">
                </div>

                <div>
                    <label class="block text-gray-300 mb-1">Személyi azonosító</label>
                    <input id="driverPersonalId" name="szemelyi_azonosito" type="text"
                           class="w-full bg-transparent border border-white/10 rounded-lg px-4 py-2 text-gray-200 outline-none focus:border-white/20">
                </div>

                <div>
                    <label class="block text-gray-300 mb-1">Születési dátum</label>
                    <input id="driverBirthDate" name="szuletesi_datum" type="date"
                           class="w-full bg-transparent border border-white/10 rounded-lg px-4 py-2 text-gray-200 outline-none focus:border-white/20">
                </div>

                <div>
                    <label class="block text-gray-300 mb-1">Telefonszám</label>
                    <input id="driverPhone" name="telefonszam" type="text" required
                           class="w-full bg-transparent border border-white/10 rounded-lg px-4 py-2 text-gray-200 outline-none focus:border-white/20">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-300 mb-1">Cím</label>
                    <input id="driverAddress" name="cim" type="text"
                           class="w-full bg-transparent border border-white/10 rounded-lg px-4 py-2 text-gray-200 outline-none focus:border-white/20">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-300 mb-1">Adószám</label>
                    <input id="driverTax" name="adoszam" type="text"
                           class="w-full bg-transparent border border-white/10 rounded-lg px-4 py-2 text-gray-200 outline-none focus:border-white/20">
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




        <!-- FLOTTA -->
        <div id="fleetContent" class="content-section">
            <h2 class="font-poppins text-xl font-semibold text-white mb-6">Flotta Kezelés</h2>
            <div class="glassmorphism-element p-6 rounded-xl">
                <p class="text-muted">Járművek hozzáadása, szerkesztése, csoportosítása és a flottához kapcsolódó beállítások. (Fejlesztés alatt)</p>
            </div>
        </div>

        <!-- RIPORTOK -->
        <div id="reportsContent" class="content-section">
            <h2 class="font-poppins text-xl font-semibold text-white mb-6">Riportok</h2>
            <div class="glassmorphism-element p-6 rounded-xl">
                <p class="text-muted">Részletes, személyre szabható riportok a kalkulációkról, költségekről és egyéb fontos adatokról. (Fejlesztés alatt)</p>
            </div>
        </div>

        <!-- BEÁLLÍTÁSOK -->
        <div id="settingsContent" class="content-section">
            <h2 class="font-poppins text-xl font-semibold text-white mb-6">Beállítások</h2>
            <div class="glassmorphism-element p-6 rounded-xl">
                <p class="text-muted">Felhasználói profil, cégadatok, API kulcsok kezelése és egyéb platformbeállítások. (Fejlesztés alatt)</p>
            </div>
        </div>
    </main>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const sidebar = document.getElementById('sidebar');
        const mainContentArea = document.getElementById('mainContentArea');
        const pageTitleContainer = document.getElementById('pageTitleContainer');

        if (mobileMenuBtn && sidebar) {
            mobileMenuBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                sidebar.classList.toggle('-translate-x-full');
            });
            document.addEventListener('click', (e) => {
                if (window.innerWidth < 1024 && !sidebar.contains(e.target) && !mobileMenuBtn.contains(e.target) && !sidebar.classList.contains('-translate-x-full')) {
                    sidebar.classList.add('-translate-x-full');
                }
            });
        }

        const sidebarLinks = document.querySelectorAll('.sidebar-link');
        const contentSections = document.querySelectorAll('.content-section');
        const sidebarLinkTriggers = document.querySelectorAll('.sidebar-link-trigger');

        function switchContent(targetId) {
            const targetBaseId = targetId.startsWith('#') ? targetId.substring(1) : targetId;
            
            contentSections.forEach(section => {
                if (section.id === targetBaseId) {
                    section.classList.add('active');
                    if (pageTitleContainer && section.querySelector('h2')) {
                        pageTitleContainer.innerHTML = `<h1 class="font-poppins text-2xl md:text-3xl font-bold text-white">${section.querySelector('h2').textContent}</h1>`;
                    } else if (pageTitleContainer && targetBaseId === 'dashboard-main-content') {
                        pageTitleContainer.innerHTML = `<h1 class="font-poppins text-2xl md:text-3xl font-bold text-white">Irányítópult</h1>`;
                    }
                } else {
                    section.classList.remove('active');
                }
            });

            sidebarLinks.forEach(l => {
                l.classList.remove('active');
                if (l.getAttribute('href') === '#' + targetBaseId) {
                    l.classList.add('active');
                }
            });

            if (!sidebar.classList.contains('-translate-x-full') && window.innerWidth < 1024) {
                sidebar.classList.add('-translate-x-full');
            }
            if (mainContentArea) mainContentArea.scrollTop = 0;
        }
        
        sidebarLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href');
                if (targetId && targetId.startsWith('#') && targetId.length > 1) {
                    e.preventDefault();
                    switchContent(targetId);
                } else if (targetId === 'logout.php') {
                    return true;
                } else {
                    e.preventDefault();
                }
            });
        });

        sidebarLinkTriggers.forEach(link => {
            link.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href');
                if (targetId && targetId.startsWith('#') && targetId.length > 1) {
                    e.preventDefault();
                    switchContent(targetId);
                }
            });
        });

        // Útdíj kalkulátor JS – az eredeti kódod
        const portalCalculateBtn = document.getElementById('portalCalculateBtn');
        const portalResultsSection = document.getElementById('portalResultsSection');
        const portalErrorMessages = document.getElementById('portalErrorMessages');
        const portalTollResult = document.getElementById('portalTollResult');
        const portalDistanceResult = document.getElementById('portalDistanceResult');
        const portalMapContainer = document.getElementById('portalMapContainer');
        const portalExternalLinkContainer = document.getElementById('portalExternalLinkContainer');
        const waypointsContainer = document.getElementById('waypointsContainer');
        const addWaypointBtn = document.getElementById('addWaypointBtn');
        let waypointCounter = 0; 

        let map = null;
        let routePolyline = null;
        let markers = [];

        function initMap() {
            if (!map && portalMapContainer) {
                map = L.map(portalMapContainer).setView([47.1625, 19.5033], 7);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);
            }
        }
        
        const calculatorLink = document.getElementById('openCalculator');
        if (calculatorLink) {
            calculatorLink.addEventListener('click', () => {
                setTimeout(initMap, 0);
            });
        }

        function clearMapAndResults() {
            if (routePolyline) { map.removeLayer(routePolyline); routePolyline = null; }
            markers.forEach(marker => map.removeLayer(marker));
            markers = [];
            portalTollResult.textContent = "N/A";
            portalDistanceResult.textContent = "N/A";
            portalExternalLinkContainer.innerHTML = '';
            portalResultsSection.classList.add('hidden');
            portalErrorMessages.classList.add('hidden');
        }
        
        function addWaypointInput() {
            waypointCounter++;
            const waypointDiv = document.createElement('div');
            waypointDiv.classList.add('flex', 'items-center', 'space-x-2', 'mb-2', 'waypoint-entry', 'mt-2');
            waypointDiv.innerHTML = `
                <input type="text" placeholder="Köztes megálló ${waypointCounter}" class="flex-grow calculator-input waypoint-address">
                <button class="remove-waypoint-btn text-red-500 hover:text-red-400 p-2 rounded-md hover:bg-red-500/10" title="Megálló törlése">
                    <i class="fas fa-trash-alt"></i>
                </button>
            `;
            waypointsContainer.appendChild(waypointDiv);
            waypointDiv.querySelector('.remove-waypoint-btn').addEventListener('click', function() {
                this.closest('.waypoint-entry').remove();
            });
        }

        if (addWaypointBtn) {
            addWaypointBtn.addEventListener('click', addWaypointInput);
        }

        if (portalCalculateBtn) {
            portalCalculateBtn.addEventListener('click', async () => {
                const from = document.getElementById('from-loc').value;
                const to = document.getElementById('to-loc').value;
                const truckType = document.getElementById('truck-type-select').value;
                
                const waypointInputs = document.querySelectorAll('#waypointsContainer .waypoint-address');
                const waypoints = Array.from(waypointInputs)
                                     .map(input => input.value.trim())
                                     .filter(address => address !== '')
                                     .map(address => ({ address }));

                if (!from || !to || !truckType) {
                    portalErrorMessages.textContent = 'Kérjük, töltse ki az indulási hely, célhely és járműtípus mezőket!';
                    portalErrorMessages.classList.remove('hidden');
                    return;
                }

                clearMapAndResults();
                portalCalculateBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Kalkuláció...';
                portalCalculateBtn.disabled = true;

                try {
                    const response = await fetch('http://localhost:5000/api/calculate', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ from, to, vehicleType: truckType, waypoints })
                    });
                    const result = await response.json();

                    if (!response.ok) {
                        throw new Error(result.details?.serviceError || result.details?.message || result.error || `Hiba a szervertől: ${response.status}`);
                    }

                    portalTollResult.textContent = `${result.costHUF.toLocaleString('hu-HU')} ${result.currency}`;
                    portalDistanceResult.textContent = `${result.distanceKm.toLocaleString('hu-HU')} km`;
                    
                    if (result.routeLink) {
                        const link = document.createElement('a');
                        link.href = result.routeLink;
                        link.target = '_blank';
                        link.rel = 'noopener noreferrer';
                        link.classList.add('calculator-button-secondary', 'inline-flex', 'items-center', 'py-2', 'px-4', 'rounded-md', 'text-sm', 'font-medium');
                        link.innerHTML = '<i class="fas fa-external-link-alt mr-2"></i>Útvonal megtekintése új ablakban';
                        portalExternalLinkContainer.appendChild(link);
                    }

                    if (map) {
                        if (result.locations && result.locations.length > 0) {
                            const boundsArray = [];
                            result.locations.forEach((loc) => {
                                const marker = L.marker([loc.lat, loc.lng]).addTo(map)
                                    .bindPopup(`<b>${loc.name}</b><br>${loc.displayName}`);
                                markers.push(marker);
                                boundsArray.push([loc.lat, loc.lng]);
                            });
                            if (boundsArray.length > 0) {
                                map.fitBounds(boundsArray, {padding: [30,30], maxZoom: 14});
                            }
                        }
                        
                        if (result.routeCoords && result.routeCoords.length > 0) {
                            routePolyline = L.polyline(result.routeCoords, { color: '#0ea5e9', weight: 6, opacity: 0.8 }).addTo(map);
                            map.fitBounds(routePolyline.getBounds(), {padding: [30,30]});
                        }
                    }
                    portalResultsSection.classList.remove('hidden');

                } catch (err) {
                    console.error("Kalkulációs hiba a portálon:", err);
                    portalErrorMessages.textContent = err.message || "Ismeretlen hiba történt a kalkuláció során.";
                    portalErrorMessages.classList.remove('hidden');
                } finally {
                    portalCalculateBtn.innerHTML = '<i class="fas fa-cogs mr-2"></i>Kalkuláció';
                    portalCalculateBtn.disabled = false;
                }
            });
        }

        // Alap nézet – tab paraméter figyelése
const params = new URLSearchParams(window.location.search);
const tab = params.get('tab');

if (tab) {
    switchContent('#' + tab);
} else if (sidebarLinks.length > 0) {
    switchContent(sidebarLinks[0].getAttribute('href'));
}

</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('driverModal');
  const openBtn = document.getElementById('addDriverBtn');
  const closeBtn = document.getElementById('closeDriverModal');
  const cancelBtn = document.getElementById('cancelDriverModal');
  const backdrop = document.getElementById('driverModalBackdrop');

  if (!modal || !openBtn) {
    console.error("Driver modal elemek hiányoznak!", { modal, openBtn });
    return;
  }

  function openModal() {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
  }

  function closeModal() {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }

  openBtn.addEventListener('click', () => {
    console.log("Új sofőr gomb kattintva");
    openModal();
  });

  closeBtn?.addEventListener('click', closeModal);
  cancelBtn?.addEventListener('click', closeModal);
  backdrop?.addEventListener('click', closeModal);

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeModal();
  });
});
</script>



</body>
</html>
