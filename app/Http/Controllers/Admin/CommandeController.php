<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CommandeController extends Controller
{
    public function index(): View
    {
        $commandes = Commande::query()
            ->with('client.user')
            ->latest('date_commande')
            ->paginate(15);

        return view('admin.commandes.index', compact('commandes'));
    }

    public function show(Commande $commande): View
    {
        $commande->load(['client.user', 'lignesCommande.produit', 'paiements']);

        return view('admin.commandes.show', compact('commande'));
    }

    public function update(Request $request, Commande $commande): RedirectResponse
    {
        $validated = $request->validate([
            'statut' => [
                'required',
                Rule::in([
                    'en_attente',
                    'confirmee',
                    'en_preparation',
                    'expediee',
                    'livree',
                    'annulee',
                ]),
            ],
        ]);

        $commande->update(['statut' => $validated['statut']]);

        return to_route('admin.commandes.show', $commande)
            ->with('success', 'Statut de la commande mis à jour.');
    }
}
