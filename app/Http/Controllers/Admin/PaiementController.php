<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Commande;
use App\Models\Paiement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PaiementController extends Controller
{
    public function index(): View
    {
        $paiements = Paiement::query()
            ->with(['commande.client.user', 'admin.user'])
            ->latest('date_paiement')
            ->paginate(15);

        return view('admin.paiements.index', compact('paiements'));
    }

    public function show(Paiement $paiement): View
    {
        $paiement->load(['commande.client.user', 'commande.lignesCommande.produit', 'admin.user']);

        return view('admin.paiements.show', compact('paiement'));
    }

    public function store(Request $request, Commande $commande): RedirectResponse
    {
        $validated = $request->validate([
            'mode_paiement' => [
                'required',
                Rule::in(['especes', 'orange_money', 'moov_money', 'wave', 'autre']),
            ],
        ]);

        $paiement = DB::transaction(function () use ($request, $commande, $validated): Paiement {
            $commande = Commande::query()
                ->whereKey($commande->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            if ($commande->statut === 'annulee') {
                throw ValidationException::withMessages([
                    'commande' => 'Une commande annulée ne peut pas être payée.',
                ]);
            }

            if ($commande->paiements()->where('statut', 'confirme')->exists()) {
                throw ValidationException::withMessages([
                    'commande' => 'Le paiement de cette commande est déjà confirmé.',
                ]);
            }

            $admin = Admin::query()->firstOrCreate([
                'user_id' => $request->user()->getKey(),
            ]);

            return $commande->paiements()->create([
                'admin_id' => $admin->getKey(),
                'reference_paiement' => 'PAY-'.Str::upper((string) Str::uuid()),
                'montant_paye' => $commande->montant_total,
                'mode_paiement' => $validated['mode_paiement'],
                'date_paiement' => now(),
                'statut' => 'confirme',
            ]);
        });

        return to_route('admin.paiements.show', $paiement)
            ->with('success', 'Paiement à la livraison confirmé et reçu disponible pour le client.');
    }
}
