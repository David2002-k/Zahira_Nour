<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(Request $request): View
    {
        $client = Client::query()->firstOrCreate([
            'user_id' => $request->user()->getKey(),
        ]);
        $messages = $client->messages()
            ->with('reponses.admin.user')
            ->latest()
            ->paginate(10);

        return view('client.messages.index', compact('messages'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'sujet' => ['required', 'string', 'max:255'],
            'contenu' => ['required', 'string', 'max:10000'],
        ]);
        $user = $request->user();
        $client = Client::query()->firstOrCreate([
            'user_id' => $user->getKey(),
        ]);

        $client->messages()->create([
            'prenom' => $user->prenom ?? '',
            'nom' => $user->nom,
            'email' => $user->email,
            'sujet' => $validated['sujet'],
            'contenu' => $validated['contenu'],
        ]);

        return to_route('client.messages.index')
            ->with('success', 'Votre message a été envoyé.');
    }
}
