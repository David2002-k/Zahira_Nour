<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Temoignage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TemoignageController extends Controller
{
    public function index(): View
    {
        $temoignages = Temoignage::query()
            ->with('client.user')
            ->latest()
            ->paginate(15);

        return view('admin.temoignages.index', compact('temoignages'));
    }

    public function update(Request $request, Temoignage $temoignage): RedirectResponse
    {
        $validated = $request->validate([
            'statut' => ['required', Rule::in(['en_attente', 'approuve', 'rejete'])],
        ]);

        $temoignage->update([
            'statut' => $validated['statut'],
            'date_publication' => $validated['statut'] === 'approuve' ? now() : null,
        ]);

        return to_route('admin.temoignages.index')
            ->with('success', 'Statut du témoignage mis à jour.');
    }
}
