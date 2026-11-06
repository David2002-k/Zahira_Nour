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
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:20'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'required' => 'Le champ :attribute est obligatoire.',
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
            'email' => 'adresse e-mail',
            'password' => 'mot de passe',
        ]);

        $user = DB::transaction(function () use ($validated): User {
            $user = User::create([
                'nom' => $validated['nom'],
                'prenom' => $validated['prenom'],
                'telephone' => $validated['telephone'] ?? null,
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            $user->client()->create();

            return $user;
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
