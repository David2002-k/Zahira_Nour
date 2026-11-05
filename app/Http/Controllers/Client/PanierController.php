<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PanierController extends Controller
{
    public function index(Request $request): View
    {
        $panier = $request->session()->get('panier', []);
        $produits = is_array($panier)
            ? Produit::query()->whereIn('id', array_keys($panier))->get()->keyBy('id')
            : collect();

        return view('client.panier.index', compact('panier', 'produits'));
    }

    public function store(Request $request, Produit $produit): RedirectResponse
    {
        $validated = $request->validate([
            'quantite' => ['nullable', 'integer', 'min:1'],
        ]);
        $quantite = (int) ($validated['quantite'] ?? 1);
        $panier = $request->session()->get('panier', []);
        $panier = is_array($panier) ? $panier : [];
        $nouvelleQuantite = (int) ($panier[$produit->getKey()] ?? 0) + $quantite;

        $this->ensureStockIsAvailable($produit, $nouvelleQuantite);

        $panier[$produit->getKey()] = $nouvelleQuantite;
        $request->session()->put('panier', $panier);

        return to_route('client.panier.index')
            ->with('success', 'Produit ajouté au panier.');
    }

    public function update(Request $request, Produit $produit): RedirectResponse
    {
        $validated = $request->validate([
            'quantite' => ['required', 'integer', 'min:1'],
        ]);
        $quantite = (int) $validated['quantite'];

        $this->ensureStockIsAvailable($produit, $quantite);

        $panier = $request->session()->get('panier', []);
        $panier = is_array($panier) ? $panier : [];
        $panier[$produit->getKey()] = $quantite;
        $request->session()->put('panier', $panier);

        return to_route('client.panier.index')
            ->with('success', 'Panier mis à jour.');
    }

    public function destroy(Request $request, Produit $produit): RedirectResponse
    {
        $panier = $request->session()->get('panier', []);

        if (is_array($panier)) {
            unset($panier[$produit->getKey()]);
            $request->session()->put('panier', $panier);
        }

        return to_route('client.panier.index')
            ->with('success', 'Produit retiré du panier.');
    }

    public function clear(Request $request): RedirectResponse
    {
        $request->session()->forget('panier');

        return to_route('client.panier.index')
            ->with('success', 'Panier vidé.');
    }

    private function ensureStockIsAvailable(Produit $produit, int $quantite): void
    {
        if ($produit->statut !== 'disponible' || $produit->stock < $quantite) {
            throw ValidationException::withMessages([
                'quantite' => "La quantité demandée pour « {$produit->nom} » n'est pas disponible.",
            ]);
        }
    }
}
