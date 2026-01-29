<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ÚtdíjPro - Partner Regisztráció</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --color-primary: #0ea5e9;
            --color-secondary: #6366f1;
            --color-background: #030712;
            --color-surface: #0f172a;
            --color-text-base: #e2e8f0;
            --color-text-muted: #94a3b8;
            --color-border: rgba(56, 189, 248, 0.2);
        }
        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--color-background);
            color: var(--color-text-base);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 1rem;
        }
        .font-poppins { font-family: 'Poppins', sans-serif; }
        .form-container {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(16px) saturate(180%);
            border: 1px solid var(--color-border);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.6);
        }
        .form-input {
            background-color: rgba(30, 41, 59, 0.8);
            border: 1px solid var(--color-border);
            color: white;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .form-input:focus {
            border-color: var(--color-primary);
            outline: none;
        }
        .form-input::placeholder {
            color: var(--color-text-muted);
        }
        .submit-button {
            background: linear-gradient(90deg, var(--color-primary), var(--color-secondary));
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0, 0.2);
        }
        .submit-button:hover {
            transform: translateY(-2px) scale(1.02);
        }
    </style>
</head>
<body class="antialiased">
    <div class="form-container w-full max-w-2xl p-8 md:p-10 rounded-2xl">
        <div class="text-center mb-8">
            <a href="{{ route('partner.login') }}" class="flex items-center justify-center space-x-3">
                <i class="fas fa-road-bridge fa-3x text-[var(--color-primary)]"></i>
                <span class="font-poppins text-4xl font-bold text-white">
                    Útdíj<span class="text-[var(--color-primary)]">Pro</span>
                </span>
            </a>
            <p class="text-[var(--color-primary)] mt-2 text-lg font-medium">Partner Regisztráció</p>
        </div>

        <!--altalanos hiba-->
        @if ($errors->has('general'))
            <div class="mb-4 p-4 rounded-lg bg-red-900/40 border border-red-600 text-sm text-red-200">
                {{ $errors->first('general') }}
            </div>
        @endif

        <!--validacios hiba-->
        @if ($errors->any() && !$errors->has('general'))
            <div class="mb-4 p-4 rounded-lg bg-red-900/40 border border-red-600 text-sm text-red-200">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('partner.register.post') }}" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf

            <!--ceg adatik bekerese-->
            <div class="md:col-span-2">
                <h2 class="font-poppins text-lg font-semibold text-sky-200 mb-2">Cég adatai</h2>
            </div>

            <div class="md:col-span-2">
                <label for="ceg_nev" class="block mb-2 text-sm font-medium text-sky-200">Cég neve *</label>
                <input type="text"
                       id="ceg_nev"
                       name="ceg_nev"
                       class="form-input text-sm rounded-lg w-full p-3.5"
                       placeholder="Pl. Demo Trans Kft."
                       value="{{ old('ceg_nev') }}"
                       required>
            </div>

            <div>
                <label for="adoszam" class="block mb-2 text-sm font-medium text-sky-200">Adószám</label>
                <input type="text"
                       id="adoszam"
                       name="adoszam"
                       class="form-input text-sm rounded-lg w-full p-3.5"
                       placeholder="12345678-1-12"
                       value="{{ old('adoszam') }}">
            </div>

            <div>
                <label for="cim" class="block mb-2 text-sm font-medium text-sky-200">Székhely / cím</label>
                <input type="text"
                       id="cim"
                       name="cim"
                       class="form-input text-sm rounded-lg w-full p-3.5"
                       placeholder="1234 Budapest, Utca 1."
                       value="{{ old('cim') }}">
            </div>

            <!--belepesi adatok bekerese-->
            <div class="md:col-span-2 mt-2">
                <h2 class="font-poppins text-lg font-semibold text-sky-200 mb-2">Kapcsolattartó és belépési adatok</h2>
            </div>

            <div>
                <label for="teljes_nev" class="block mb-2 text-sm font-medium text-sky-200">Kapcsolattartó neve *</label>
                <input type="text"
                       id="teljes_nev"
                       name="teljes_nev"
                       class="form-input text-sm rounded-lg w-full p-3.5"
                       placeholder="Pl. Kiss Péter"
                       value="{{ old('teljes_nev') }}"
                       required>
            </div>

            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-sky-200">Email cím *</label>
                <input type="email"
                       id="email"
                       name="email"
                       class="form-input text-sm rounded-lg w-full p-3.5"
                       placeholder="azonosito@cegnev.hu"
                       value="{{ old('email') }}"
                       required>
            </div>

            <div>
                <label for="password" class="block mb-2 text-sm font-medium text-sky-200">Jelszó *</label>
                <input type="password"
                       id="password"
                       name="password"
                       class="form-input text-sm rounded-lg w-full p-3.5"
                       placeholder="Legalább 8 karakter"
                       required>
            </div>

            <div>
                <label for="password_confirm" class="block mb-2 text-sm font-medium text-sky-200">Jelszó megerősítése *</label>
                <input type="password"
                       id="password_confirm"
                       name="password_confirm"
                       class="form-input text-sm rounded-lg w-full p-3.5"
                       placeholder="Írja be ismét a jelszót"
                       required>
            </div>

            <div class="md:col-span-2 flex items-center justify-between mt-4">
                <a href="{{ route('partner.login') }}" class="text-sm text-gray-400 hover:text-[var(--color-primary)]">
                    Már van fiókja? <span class="underline">Lépjen be itt</span>
                </a>
                <button type="submit" class="submit-button text-white font-semibold rounded-lg text-lg px-6 py-3">
                    <i class="fas fa-user-plus mr-2"></i>Regisztráció
                </button>
            </div>
        </form>
    </div>
</body>
</html>
