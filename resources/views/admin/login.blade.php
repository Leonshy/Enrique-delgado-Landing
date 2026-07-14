<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Admin — Enrique Delgado</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @if($hcaptchaEnabled && $hcaptchaSiteKey)
    <script src="https://js.hcaptcha.com/1/api.js" async defer></script>
    @endif
</head>
<body class="min-h-screen flex items-center justify-center" style="background: linear-gradient(135deg, var(--color-brand-light), var(--color-brand-muted));">

<div class="w-full max-w-md px-4">
    <div class="text-center mb-8">
        <div class="w-16 h-16 rounded-2xl mx-auto mb-4 flex items-center justify-center" style="background: linear-gradient(135deg, var(--color-primary), var(--color-primary-light));">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                <path d="M7 11V7a5 5 0 0110 0v4"/>
            </svg>
        </div>
        <h1 class="font-serif text-2xl font-semibold" style="color: var(--color-brand-dark);">Panel Administrativo</h1>
        <p class="text-sm text-gray-500 mt-1">Enrique Delgado</p>
    </div>

    <div class="card">
        @if(session('error'))
        <div class="mb-4 px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-sm text-red-600">
            {{ session('error') }}
        </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="input-field @error('email') border-red-400 @enderror"
                       placeholder="admin@enriquedelgado.com">
                @error('email')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Contraseña</label>
                <input type="password" name="password" required
                       class="input-field @error('password') border-red-400 @enderror"
                       placeholder="••••••••">
            </div>
            <div class="flex items-center justify-between mb-6">
                <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded" style="accent-color: var(--color-primary);">
                    Recordarme
                </label>
            </div>
            @if($hcaptchaEnabled && $hcaptchaSiteKey)
            <div class="mb-6">
                <div class="h-captcha" data-sitekey="{{ $hcaptchaSiteKey }}"></div>
                @error('h-captcha-response')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            @endif
            <button type="submit" class="btn-primary w-full justify-center">
                Iniciar sesión
            </button>
        </form>
    </div>

    <p class="text-center text-xs text-gray-400 mt-6">
        <a href="{{ route('home') }}" style="color: var(--color-primary);">← Volver al sitio web</a>
    </p>
</div>

</body>
</html>
