<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Paiement;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class PaiementController extends Controller
{
    public function index(Request $request): View
    {
        $client = Client::query()->firstOrCreate([
            'user_id' => $request->user()->getKey(),
        ]);
        $paiements = Paiement::query()
            ->whereHas('commande', fn (Builder $query) => $query->where('client_id', $client->getKey()))
            ->with('commande')
            ->latest('date_paiement')
            ->paginate(10);

        return view('client.paiements.index', compact('paiements'));
    }

    public function download(Request $request, Paiement $paiement): Response
    {
        $client = Client::query()->firstOrCreate([
            'user_id' => $request->user()->getKey(),
        ]);
        $paiement = Paiement::query()
            ->whereKey($paiement->getKey())
            ->where('statut', 'confirme')
            ->whereHas('commande', fn (Builder $query) => $query->where('client_id', $client->getKey()))
            ->with(['commande.client.user', 'commande.lignesCommande.produit'])
            ->firstOrFail();

        $commande = $paiement->commande;
        $clientName = trim($commande->client->user->prenom.' '.$commande->client->user->nom);
        $modesPaiement = [
            'especes' => 'Espèces',
            'orange_money' => 'Orange Money',
            'moov_money' => 'Moov Money',
            'wave' => 'Wave',
            'autre' => 'Autre',
        ];
        $modePaiement = $modesPaiement[$paiement->mode_paiement] ?? $paiement->mode_paiement;

        return Pdf::loadView('client.paiements.recu', [
            'paiement' => $paiement,
            'commande' => $commande,
            'clientName' => $clientName,
            'modePaiement' => $modePaiement,
        ])
            ->setPaper('a4')
            ->download('recu-'.Str::slug($commande->numero_commande).'.pdf');
    }
}
