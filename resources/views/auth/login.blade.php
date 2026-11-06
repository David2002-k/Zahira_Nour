<x-guest-layout>
    <div class="mb-8">
        <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#c43759]">Votre espace personnel</p>
        <h1 class="mt-2 font-serif text-3xl font-semibold tracking-tight text-stone-900 sm:text-4xl">Heureuse de vous retrouver</h1>
        <p class="mt-3 text-sm leading-6 text-stone-500">Connectez-vous pour accéder à votre compte et à vos commandes.</p>
    </div>

    <x-auth-session-status class="mb-5 rounded-xl bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" value="Adresse e-mail" class="auth-label" />
            <x-text-input id="email" class="auth-input mt-2" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-rose-600" />
        </div>

        <div>
            <div class="flex items-center justify-between gap-3">
                <x-input-label for="password" value="Mot de passe" class="auth-label" />
                @if (Route::has('password.request'))
                    <a class="text-sm font-semibold text-[#c43759] transition hover:text-[#a72d4b]" href="{{ route('password.request') }}">
                        Mot de passe oublié ?
                    </a>
                @endif
            </div>
            <x-text-input id="password" class="auth-input mt-2" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-rose-600" />
        </div>

        <div class="flex items-center">
            <label for="remember_me" class="inline-flex cursor-pointer items-center gap-2 text-sm text-stone-600">
                <input id="remember_me" type="checkbox" class="h-4 w-4 rounded border-stone-300 accent-[#db4566] focus:ring-[#db4566]" name="remember">
                <span>Se souvenir de moi</span>
            </label>
        </div>

        <button type="submit" class="auth-submit-button">
            Se connecter
        </button>

        <div class="pt-1 text-center text-sm text-stone-500">
            Pas encore de compte ?
            <a class="auth-text-link" href="{{ route('register') }}">Créer un compte</a>
        </div>
    </form>
</x-guest-layout>
