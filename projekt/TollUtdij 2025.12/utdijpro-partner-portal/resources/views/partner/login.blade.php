<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ÚtdíjPro - Partner Portál Bejelentkezés</title>

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
            overflow-x: hidden;
            padding: 1rem;
        }
        .font-poppins { font-family: 'Poppins', sans-serif; }
        .login-container {
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            border: 1px solid var(--color-border);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.5);
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
        .logo-container i {
            text-shadow: 0 0 15px var(--color-primary);
        }
    </style>
</head>

<body class="antialiased">
    <div class="login-container w-full max-w-md p-8 md:p-12 rounded-2xl">

        <!-- Logo -->
        <div class="logo-container text-center mb-10">
            <a href="/" class="flex items-center justify-center space-x-3" title="Vissza a főoldalra">
                <i class="fas fa-road-bridge fa-3x text-[var(--color-primary)]"></i>
                <span class="font-poppins self-center text-4xl font-bold whitespace-nowrap text-white">
                    Útdíj<span class="text-[var(--color-primary)]">Pro</span>
                </span>
            </a>
            <p class="text-[var(--color-primary)] mt-2 text-lg font-medium">Partner Portál</p>
        </div>

        <!-- Hibaüzenetek -->
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-lg bg-red-900/40 border border-red-600 text-sm text-red-200">
                <ul class="space-y-1">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Bejelentkezés form -->
        <form method="POST" action="{{ route('partner.login.post') }}">
            @csrf

            <div class="mb-6">
                <label for="email" class="block mb-2 text-sm font-medium text-sky-200">Email cím</label>
                <input type="email" id="email" name="email" class="form-input text-sm rounded-lg block w-full p-3.5"
                       placeholder="azonosito@cegnev.hu" required>
            </div>

            <div class="mb-8">
                <label for="password" class="block mb-2 text-sm font-medium text-sky-200">Jelszó</label>
                <input type="password" id="password" name="password" class="form-input text-sm rounded-lg block w-full p-3.5"
                       placeholder="••••••••" required>
            </div>

            <button type="submit"
                    class="submit-button w-full text-white font-semibold rounded-lg text-lg px-5 py-3.5 text-center">
                <i class="fas fa-sign-in-alt mr-2"></i>Bejelentkezés
            </button>
        </form>

        <p class="text-sm text-gray-500 text-center mt-8">
            Nincs még hozzáférése?
            <a href="{{ route('partner.register') }}" class="font-medium text-[var(--color-primary)] hover:underline">
                Regisztráljon partnerként
            </a>
        </p>

    </div>
</body>
</html>
