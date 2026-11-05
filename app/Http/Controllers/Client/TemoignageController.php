<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Temoignage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class TemoignageController extends Controller
{
    public function index(Request $request): View
    {
        $client = Client::query()->firstOrCreate([
            'user_id' => $request->user()->getKey(),
        ]);
        $temoignages = $client->temoignages()
            ->latest()
            ->paginate(10);

        return view('client.temoignages.index', compact('temoignages'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'contenu' => ['required', 'string', 'max:5000'],
        ]);
        $client = Client::query()->firstOrCreate([
            'user_id' => $request->user()->getKey(),
        ]);

        $client->temoignages()->create([
            'contenu' => $validated['contenu'],
            'statut' => 'en_attente',
        ]);

        return to_route('client.temoignages.index')
            ->with('success', 'Votre témoignage a été envoyé pour validation.');
    }

    public function update(Request $request, Temoignage $temoignage): RedirectResponse
    {
        $validated = $request->validate([
            'contenu' => ['required', 'string', 'max:5000'],
        ]);
        $client = Client::query()->firstOrCreate([
            'user_id' => $request->user()->getKey(),
        ]);
        $temoignage = $client->temoignages()
            ->whereKey($temoignage->getKey())
            ->firstOrFail();

        if ($temoignage->statut !== 'en_attente') {
            throw ValidationException::withMessages([
                'temoignage' => 'Seuls les témoignages en attente peuvent être modifiés.',
            ]);
        }

        $temoignage->update(['contenu' => $validated['contenu']]);

        return to_route('client.temoignages.index')
            ->with('success', 'Votre témoignage a été modifié.');
    }

    public function destroy(Request $request, Temoignage $temoignage): RedirectResponse
    {
        $client = Client::query()->firstOrCreate([
            'user_id' => $request->user()->getKey(),
        ]);
        $temoignage = $client->temoignages()
            ->whereKey($temoignage->getKey())
            ->firstOrFail();

        if ($temoignage->statut !== 'en_attente') {
            throw ValidationException::withMessages([
                'temoignage' => 'Seuls les témoignages en attente peuvent être supprimés.',
            ]);
        }

        $temoignage->delete();

        return to_route('client.temoignages.index')
            ->with('success', 'Votre témoignage a été supprimé.');
    }
}
