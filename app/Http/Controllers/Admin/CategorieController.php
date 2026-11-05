<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CategorieController extends Controller
{
    public function index(): View
    {
        $categories = Categorie::query()
            ->withCount('produits')
            ->orderBy('nom')
            ->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255', 'unique:categories,nom'],
            'description' => ['nullable', 'string'],
        ]);

        Categorie::create([
            'nom' => $validated['nom'],
            'slug' => $this->uniqueSlug($validated['nom']),
            'description' => $validated['description'] ?? null,
        ]);

        return to_route('admin.categories.index')
            ->with('success', 'Catégorie ajoutée avec succès.');
    }

    public function update(Request $request, Categorie $categorie): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'nom')->ignore($categorie),
            ],
            'description' => ['nullable', 'string'],
        ]);

        $categorie->update([
            'nom' => $validated['nom'],
            'slug' => $this->uniqueSlug($validated['nom'], $categorie),
            'description' => $validated['description'] ?? null,
        ]);

        return to_route('admin.categories.index')
            ->with('success', 'Catégorie modifiée avec succès.');
    }

    public function destroy(Categorie $categorie): RedirectResponse
    {
        if ($categorie->produits()->exists()) {
            throw ValidationException::withMessages([
                'categorie' => 'Cette catégorie contient encore des produits.',
            ]);
        }

        $categorie->delete();

        return to_route('admin.categories.index')
            ->with('success', 'Catégorie supprimée avec succès.');
    }

    private function uniqueSlug(string $nom, ?Categorie $categorie = null): string
    {
        $baseSlug = Str::slug($nom) ?: Str::random(12);
        $slug = $baseSlug;
        $suffix = 2;

        while (Categorie::query()
            ->where('slug', $slug)
            ->when($categorie, fn (Builder $query) => $query->where('id', '!=', $categorie->getKey()))
            ->exists()) {
            $slug = $baseSlug.'-'.$suffix;
            $suffix++;
        }

        return $slug;
    }
}
