<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Message;
use App\Models\Paiement;
use App\Models\Produit;
use App\Models\Temoignage;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'periode' => ['nullable', Rule::in(['semaine', 'mois'])],
        ], [
            'periode.in' => 'La période sélectionnée est invalide.',
        ]);
        $periodePaiements = $validated['periode'] ?? 'semaine';

        $produitsTotal = Produit::query()->count();
        $totalClients = User::query()
            ->where('role', 'client')
            ->count();

        $commandesEnAttente = Commande::query()
            ->where('statut', 'en_attente')
            ->count();

        $produitsEnRupture = Produit::query()
            ->where('stock', 0)
            ->count();

        $messagesNonLus = Message::query()
            ->where('statut', 'non_lu')
            ->count();

        $temoignagesEnAttente = Temoignage::query()
            ->where('statut', 'en_attente')
            ->count();

        $montantPaye = Paiement::query()
            ->where('statut', 'confirme')
            ->sum('montant_paye');

        $dateFinPaiements = now();
        $dateDebutPaiements = $periodePaiements === 'semaine'
            ? $dateFinPaiements->copy()->startOfDay()->subDays(6)
            : $dateFinPaiements->copy()->startOfMonth()->startOfDay();

        $montantsParJour = Paiement::query()
            ->where('statut', 'confirme')
            ->whereBetween('date_paiement', [$dateDebutPaiements, $dateFinPaiements])
            ->selectRaw('DATE(date_paiement) as jour, SUM(montant_paye) as montant_total')
            ->groupByRaw('DATE(date_paiement)')
            ->pluck('montant_total', 'jour');

        $courbePaiements = [];

        foreach (CarbonPeriod::create($dateDebutPaiements, '1 day', $dateFinPaiements) as $date) {
            $dateJour = $date->toDateString();
            $courbePaiements[] = [
                'date' => $dateJour,
                'label' => $date->format('d/m'),
                'montant' => (float) ($montantsParJour[$dateJour] ?? 0),
            ];
        }

        $totalPaiementsPeriode = array_sum(array_column($courbePaiements, 'montant'));

        $dernieresCommandes = Commande::query()
            ->with('client.user')
            ->latest('date_commande')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'produitsTotal',
            'totalClients',
            'commandesEnAttente',
            'produitsEnRupture',
            'messagesNonLus',
            'temoignagesEnAttente',
            'montantPaye',
            'periodePaiements',
            'courbePaiements',
            'totalPaiementsPeriode',
            'dernieresCommandes',
        ));
    }
}
