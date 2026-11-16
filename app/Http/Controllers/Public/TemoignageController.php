<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Temoignage;
use Illuminate\View\View;

class TemoignageController extends Controller
{
    public function index(): View
    {
        $temoignages = Temoignage::query()
            ->with('client.user')
            ->where('statut', 'approuve')
            ->orderByDesc('date_publication')
            ->orderByDesc('id')
            ->paginate(9);

        return view('temoignage', compact('temoignages'));
    }
}
