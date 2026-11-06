<x-guest-layout>
    <div class="mb-8">
        <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#c43759]">Rejoignez-nous</p>
        <h1 class="mt-2 font-serif text-3xl font-semibold tracking-tight text-stone-900 sm:text-4xl">Créer un compte</h1>
        <p class="mt-3 text-sm leading-6 text-stone-500">Inscrivez-vous pour retrouver vos commandes et découvrir nos nouveautés.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <x-input-label for="prenom" value="Prénom" class="auth-label" />
                <x-text-input id="prenom" class="auth-input mt-2" type="text" name="prenom" :value="old('prenom')" required autocomplete="given-name" />
                <x-input-error :messages="$errors->get('prenom')" class="mt-2 text-sm text-rose-600" />
            </div>

            <div>
                <x-input-label for="nom" value="Nom" class="auth-label" />
                <x-text-input id="nom" class="auth-input mt-2" type="text" name="nom" :value="old('nom')" required autofocus autocomplete="family-name" />
                <x-input-error :messages="$errors->get('nom')" class="mt-2 text-sm text-rose-600" />
            </div>
        </div>

        <div>
            <x-input-label for="telephone" value="Téléphone (facultatif)" class="auth-label" />
            <x-text-input id="telephone" class="auth-input mt-2" type="tel" name="telephone" :value="old('telephone')" maxlength="20" autocomplete="tel" />
            <x-input-error :messages="$errors->get('telephone')" class="mt-2 text-sm text-rose-600" />
        </div>

        <div>
            <x-input-label for="email" value="Adresse e-mail" class="auth-label" />
            <x-text-input id="email" class="auth-input mt-2" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-rose-600" />
        </div>

        <div>
            <x-input-label for="password" value="Mot de passe" class="auth-label" />
            <x-text-input id="password" class="auth-input mt-2" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-rose-600" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Confirmer le mot de passe" class="auth-label" />
            <x-text-input id="password_confirmation" class="auth-input mt-2" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-rose-600" />
        </div>

        <button type="submit" class="auth-submit-button">
            Créer mon compte
        </button>

        <div class="pt-1 text-center text-sm text-stone-500">
            Vous avez déjà un compte ?
            <a class="auth-text-link" href="{{ route('login') }}">Se connecter</a>
        </div>
    </form>
</x-guest-layout>
