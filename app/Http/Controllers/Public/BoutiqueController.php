<?php

namespace App\Http\Controllers\Public;

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
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(12);

        return view('boutique', compact('produits'));
    }
}
