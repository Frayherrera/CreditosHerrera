<x-guest-layout>
    <h2 class="font-display text-2xl text-slate-900 text-center mb-1">Crea tu cuenta</h2>
    <p class="text-sm text-slate-500 text-center mb-8">Es rápido y solo necesitas unos datos</p>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Nombre completo')" class="text-sm font-medium text-slate-700 mb-1.5" />
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                class="input-field block w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 transition-colors"
                placeholder="Tu nombre">
            <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Correo electrónico')" class="text-sm font-medium text-slate-700 mb-1.5" />
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                class="input-field block w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 transition-colors"
                placeholder="tu@correo.com">
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Contraseña')" class="text-sm font-medium text-slate-700 mb-1.5" />
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="input-field block w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 transition-colors"
                placeholder="Mínimo 8 caracteres">
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" class="text-sm font-medium text-slate-700 mb-1.5" />
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                class="input-field block w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 transition-colors"
                placeholder="Repite la contraseña">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
        </div>

        <button type="submit"
            class="w-full py-3 px-4 bg-slate-900 text-white font-semibold rounded-xl hover:bg-slate-800 transition-colors shadow-sm text-sm">
            Crear cuenta
        </button>

        <p class="text-center text-sm text-slate-500">
            ¿Ya tienes cuenta?
            <a href="{{ route('login') }}" class="font-semibold text-credit-600 hover:text-credit-700 transition-colors">Inicia sesión</a>
        </p>
    </form>
</x-guest-layout>