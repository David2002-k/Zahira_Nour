<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\ReseauSocial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReseauSocialController extends Controller
{
    public function index(): View
    {
        $reseauxSociaux = ReseauSocial::query()
            ->with('admin.user')
            ->orderBy('nom')
            ->paginate(15);

        return view('admin.reseaux-sociaux.index', compact('reseauxSociaux'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'url' => ['required', 'url:http,https', 'max:2048'],
            'icone' => ['nullable', 'string', 'max:255'],
        ]);
        $admin = Admin::query()->firstOrCreate([
            'user_id' => $request->user()->getKey(),
        ]);

        $admin->reseauxSociaux()->create($validated);

        return to_route('admin.reseaux-sociaux.index')
            ->with('success', 'Réseau social ajouté.');
    }

    public function update(Request $request, ReseauSocial $reseauSocial): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'url' => ['required', 'url:http,https', 'max:2048'],
            'icone' => ['nullable', 'string', 'max:255'],
        ]);

        $reseauSocial->update($validated);

        return to_route('admin.reseaux-sociaux.index')
            ->with('success', 'Réseau social mis à jour.');
    }

    public function destroy(ReseauSocial $reseauSocial): RedirectResponse
    {
        $reseauSocial->delete();

        return to_route('admin.reseaux-sociaux.index')
            ->with('success', 'Réseau social supprimé.');
    }
}
