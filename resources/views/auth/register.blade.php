<x-guest-layout>
    <div class="mb-8">
        <p class="text-xs font-bold uppercase tracking-[0.2em] text-stone-700">Rejoignez-nous</p>
        <h1 class="mt-2 font-serif text-3xl font-semibold tracking-tight text-stone-900 sm:text-4xl">Créer un compte</h1>
        <p class="mt-3 text-sm leading-6 text-stone-500">Inscrivez-vous pour retrouver vos commandes et découvrir nos nouveautés.</p>
    </div>

    @php
        $selectedPhoneCountry = $phoneCountries[old('telephone_country', 'BF')] ?? $phoneCountries['BF'];
    @endphp

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
            <div class="mt-2 grid grid-cols-1 gap-3 sm:grid-cols-[minmax(0,0.9fr)_minmax(0,1.1fr)]">
                <div>
                    <x-input-label for="telephone_country" value="Pays / indicatif" class="auth-label" />
                    <select id="telephone_country" name="telephone_country" class="auth-input mt-2">
                        @foreach ($phoneCountries as $code => $country)
                            <option
                                value="{{ $code }}"
                                data-national-prefix="{{ $country['national_prefix'] ?? '' }}"
                                data-min-digits="{{ $country['min_digits'] }}"
                                data-max-digits="{{ $country['max_digits'] }}"
                                @selected(old('telephone_country', 'BF') === $code)
                            >{{ $country['name'] }} ({{ $country['dial_code'] }})</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('telephone_country')" class="mt-2 text-sm text-rose-600" />
                </div>
                <div>
                    <x-text-input id="telephone" class="auth-input mt-2 sm:mt-8" type="tel" name="telephone" :value="old('telephone')" inputmode="numeric" minlength="{{ $selectedPhoneCountry['min_digits'] + strlen($selectedPhoneCountry['national_prefix'] ?? '') }}" maxlength="{{ $selectedPhoneCountry['max_digits'] + strlen($selectedPhoneCountry['national_prefix'] ?? '') }}" autocomplete="tel-national" aria-describedby="telephone-errors" />
                    <x-input-error id="telephone-errors" :messages="$errors->get('telephone')" class="mt-2 text-sm text-rose-600" />
                </div>
            </div>
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

    <script>
        const phoneCountry = document.getElementById('telephone_country');
        const phoneInput = document.getElementById('telephone');
        function updatePhoneLength() {
            const option = phoneCountry.selectedOptions[0];
            const minDigits = Number(option.dataset.minDigits);
            const maxDigits = Number(option.dataset.maxDigits);
            const nationalPrefixLength = option.dataset.nationalPrefix.length;
            const inputMinDigits = minDigits + nationalPrefixLength;
            const inputMaxDigits = maxDigits + nationalPrefixLength;

            phoneInput.minLength = inputMinDigits;
            phoneInput.maxLength = inputMaxDigits;
        }

        phoneCountry.addEventListener('change', updatePhoneLength);
        updatePhoneLength();
    </script>
</x-guest-layout>
