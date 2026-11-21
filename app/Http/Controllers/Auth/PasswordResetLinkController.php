<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'required' => 'Veuillez saisir votre adresse e-mail.',
            'email' => 'Veuillez saisir une adresse e-mail valide.',
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        $message = match ($status) {
            Password::RESET_LINK_SENT => 'Un lien de réinitialisation a été envoyé à votre adresse e-mail.',
            Password::INVALID_USER => 'Aucun compte ne correspond à cette adresse e-mail.',
            Password::RESET_THROTTLED => 'Veuillez patienter avant de demander un nouveau lien.',
            default => 'Impossible d’envoyer le lien pour le moment. Veuillez réessayer.',
        };

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', $message)
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => $message]);
    }
}
