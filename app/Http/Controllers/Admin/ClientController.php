<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(): View
    {
        $clients = User::query()
            ->where('role', 'client')
            ->orderBy('nom')
            ->paginate(15);

        return view('admin.clients.index', compact('clients'));
    }

    public function updateStatus(Request $request, User $user): RedirectResponse
    {
        abort_unless($user->role === 'client', 404);

        $validated = $request->validate([
            'statut' => ['required', Rule::in(['actif', 'bloque'])],
        ]);

        $user->statut = $validated['statut'];
        $user->save();

        $message = $user->statut === 'bloque'
            ? 'Le compte client a été bloqué.'
            : 'Le compte client a été débloqué.';

        return to_route('admin.clients.index')->with('success', $message);
    }
}
