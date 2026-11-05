<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use Illuminate\View\View;

class BoutiqueController extends Controller
{
    public function index(): View
    {
        $produits = Produit::query()
            ->with('categorie')
            ->where('statut', 'disponible')
            ->latest()
            ->paginate(12);

        return view('client.boutique.index', compact('produits'));
    }

    public function show(Produit $produit): View
    {
        abort_unless($produit->statut === 'disponible', 404);

        return view('client.boutique.show', compact('produit'));
    }
}
