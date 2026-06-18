<x-guest-layout>
    <h2 class="font-display text-2xl text-slate-900 text-center mb-1">Bienvenido de nuevo</h2>
    <p class="text-sm text-slate-500 text-center mb-8">Ingresa a tu cuenta para continuar</p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Correo electrónico')" class="text-sm font-medium text-slate-700 mb-1.5" />
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                class="input-field block w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 transition-colors"
                placeholder="tu@correo.com">
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Contraseña')" class="text-sm font-medium text-slate-700 mb-1.5" />
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="input-field block w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 transition-colors"
                placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center gap-2">
                <input id="remember_me" type="checkbox" name="remember"
                    class="rounded-lg border-slate-300 text-credit-500 focus:ring-credit-500 focus:ring-offset-0">
                <span class="text-sm text-slate-600">Recordarme</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm font-medium text-credit-600 hover:text-credit-700 transition-colors">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif
        </div>

        <button type="submit"
            class="w-full py-3 px-4 bg-slate-900 text-white font-semibold rounded-xl hover:bg-slate-800 transition-colors shadow-sm text-sm">
            Iniciar sesión
        </button>

        <p class="text-center text-sm text-slate-500">
            ¿No tienes cuenta?
            <a href="{{ route('register') }}" class="font-semibold text-credit-600 hover:text-credit-700 transition-colors">Regístrate</a>
        </p>
    </form>
</x-guest-layout>