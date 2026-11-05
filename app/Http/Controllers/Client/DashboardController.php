<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $client = Client::query()->firstOrCreate([
            'user_id' => $request->user()->getKey(),
        ]);
        $commandesRecentes = $client->commandes()
            ->latest('date_commande')
            ->limit(5)
            ->get();
        $commandesEnCours = $client->commandes()
            ->whereIn('statut', ['en_attente', 'confirmee', 'en_preparation', 'expediee'])
            ->count();

        return view('client.dashboard', compact('client', 'commandesRecentes', 'commandesEnCours'));
    }
}
