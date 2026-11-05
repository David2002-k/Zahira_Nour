<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Produit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CommandeController extends Controller
{
    public function index(Request $request): View
    {
        $client = Client::query()->firstOrCreate([
            'user_id' => $request->user()->getKey(),
        ]);
        $commandes = $client->commandes()
            ->withCount('lignesCommande')
            ->latest('date_commande')
            ->paginate(10);

        return view('client.commandes.index', compact('commandes'));
    }

    public function show(Request $request, int $commande): View
    {
        $client = Client::query()->firstOrCreate([
            'user_id' => $request->user()->getKey(),
        ]);
        $commande = $client->commandes()
            ->with(['lignesCommande.produit', 'paiements'])
            ->findOrFail($commande);

        return view('client.commandes.show', compact('commande'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'adresse_livraison' => ['required', 'string', 'max:5000'],
            'telephone_livraison' => ['required', 'string', 'max:20'],
        ]);
        $panier = $request->session()->get('panier', []);

        if (! is_array($panier) || $panier === []) {
            throw ValidationException::withMessages([
                'panier' => 'Votre panier est vide.',
            ]);
        }

        foreach ($panier as $produitId => $quantite) {
            if (filter_var($produitId, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) === false
                || filter_var($quantite, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) === false) {
                throw ValidationException::withMessages([
                    'panier' => 'Votre panier contient un article invalide.',
                ]);
            }
        }

        $client = Client::query()->firstOrCreate([
            'user_id' => $request->user()->getKey(),
        ]);
        $commande = DB::transaction(function () use ($client, $panier, $validated): Commande {
            $produits = [];
            $montantTotalEnCentimes = 0;

            foreach ($panier as $produitId => $quantite) {
                $produit = Produit::query()
                    ->whereKey((int) $produitId)
                    ->lockForUpdate()
                    ->firstOrFail();
                $quantite = (int) $quantite;

                if ($produit->statut !== 'disponible' || $produit->stock < $quantite) {
                    throw ValidationException::withMessages([
                        'panier' => "Le stock de « {$produit->nom} » ne permet pas de finaliser la commande.",
                    ]);
                }

                $prixEnCentimes = (int) round((float) $produit->prix * 100);
                $sousTotalEnCentimes = $prixEnCentimes * $quantite;
                $montantTotalEnCentimes += $sousTotalEnCentimes;
                $produits[] = [$produit, $quantite, $prixEnCentimes, $sousTotalEnCentimes];
            }

            $commande = $client->commandes()->create([
                'numero_commande' => 'CMD-'.Str::upper((string) Str::uuid()),
                'montant_total' => number_format($montantTotalEnCentimes / 100, 2, '.', ''),
                'adresse_livraison' => $validated['adresse_livraison'],
                'telephone_livraison' => $validated['telephone_livraison'],
                'date_commande' => now(),
            ]);

            foreach ($produits as [$produit, $quantite, $prixEnCentimes, $sousTotalEnCentimes]) {
                $nouveauStock = $produit->stock - $quantite;
                $produit->update([
                    'stock' => $nouveauStock,
                    'statut' => $nouveauStock === 0 ? 'en_rupture' : $produit->statut,
                ]);

                $commande->lignesCommande()->create([
                    'produit_id' => $produit->getKey(),
                    'quantite' => $quantite,
                    'prix_unitaire' => number_format($prixEnCentimes / 100, 2, '.', ''),
                    'sous_total' => number_format($sousTotalEnCentimes / 100, 2, '.', ''),
                ]);
            }

            return $commande;
        });

        $request->session()->forget('panier');

        return to_route('client.commandes.show', $commande)
            ->with('success', 'Votre commande a été enregistrée.');
    }
}
