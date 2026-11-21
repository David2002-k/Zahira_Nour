<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register', [
            'phoneCountries' => config('phone_countries'),
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $phoneCountries = config('phone_countries');

        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'telephone_country' => ['required_with:telephone', 'string', Rule::in(array_keys($phoneCountries))],
            'telephone' => [
                'nullable',
                'string',
                'max:30',
                'regex:/^[0-9\\s().-]+$/',
                function (string $attribute, mixed $value, \Closure $fail) use ($request, $phoneCountries): void {
                    if (! is_string($value) || blank($value)) {
                        return;
                    }

                    $country = $phoneCountries[$request->input('telephone_country', 'BF')] ?? null;
                    $digits = preg_replace('/\\D+/', '', $value);
                    $nationalPrefix = $country['national_prefix'] ?? null;
                    $number = $nationalPrefix && str_starts_with($digits, $nationalPrefix)
                        ? substr($digits, strlen($nationalPrefix))
                        : $digits;
                    $length = strlen($number);

                    if (! $country) {
                        $fail('Veuillez choisir un pays valide pour le téléphone.');

                        return;
                    }

                    if ($length < $country['min_digits'] || $length > $country['max_digits']) {
                        $lengthMessage = $country['min_digits'] === $country['max_digits']
                            ? "exactement {$country['min_digits']} chiffres"
                            : "entre {$country['min_digits']} et {$country['max_digits']} chiffres";

                        $fail("Le numéro de téléphone pour {$country['name']} doit contenir {$lengthMessage}.");
                    }
                },
            ],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'required' => 'Le champ :attribute est obligatoire.',
            'regex' => 'Le numéro doit contenir uniquement des chiffres et séparateurs usuels.',
            'string' => 'Le champ :attribute doit être une chaîne de caractères.',
            'max.string' => 'Le champ :attribute ne peut pas dépasser :max caractères.',
            'lowercase.email' => 'L’adresse e-mail doit être saisie en minuscules.',
            'email.email' => 'Veuillez saisir une adresse e-mail valide.',
            'unique.email' => 'Cette adresse e-mail est déjà utilisée.',
            'confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'min.string' => 'Le champ :attribute doit contenir au moins :min caractères.',
            'password.uncompromised' => 'Ce mot de passe a déjà été compromis. Veuillez en choisir un autre.',
        ], [
            'nom' => 'nom',
            'prenom' => 'prénom',
            'telephone' => 'téléphone',
            'telephone_country' => 'pays du téléphone',
            'email' => 'adresse e-mail',
            'password' => 'mot de passe',
        ]);

        $user = DB::transaction(function () use ($validated, $phoneCountries): User {
            $telephone = null;

            if (filled($validated['telephone'] ?? null)) {
                $country = $phoneCountries[$validated['telephone_country']];
                $nationalNumber = preg_replace('/\\D+/', '', $validated['telephone']);
                $nationalPrefix = $country['national_prefix'] ?? null;

                if ($nationalPrefix && str_starts_with($nationalNumber, $nationalPrefix)) {
                    $nationalNumber = substr($nationalNumber, strlen($nationalPrefix));
                }

                $telephone = $country['dial_code'].$nationalNumber;
            }

            $user = new User([
                'nom' => $validated['nom'],
                'prenom' => $validated['prenom'],
                'telephone' => $telephone,
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);
            $user->role = 'client';
            $user->save();

            $user->client()->create();

            return $user;
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect()->to(route($user->dashboardRouteName(), absolute: false));
    }
}
