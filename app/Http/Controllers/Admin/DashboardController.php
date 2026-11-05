<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Message;
use App\Models\Paiement;
use App\Models\Produit;
use App\Models\Temoignage;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $commandesEnAttente = Commande::query()
            ->where('statut', 'en_attente')
            ->count();
        $produitsEnRupture = Produit::query()
            ->where('statut', 'en_rupture')
            ->orWhere('stock', 0)
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
        $dernieresCommandes = Commande::query()
            ->with('client.user')
            ->latest('date_commande')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'commandesEnAttente',
            'produitsEnRupture',
            'messagesNonLus',
            'temoignagesEnAttente',
            'montantPaye',
            'dernieresCommandes',
        ));
    }
}
