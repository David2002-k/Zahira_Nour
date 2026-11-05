<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Produit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use RuntimeException;

class ProduitController extends Controller
{
    public function index(): View
    {
        $produits = Produit::query()
            ->with('categorie')
            ->latest()
            ->paginate(10);
        $categories = Categorie::query()->orderBy('nom')->get();

        return view('admin.produits.index', compact('produits', 'categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255', 'unique:produits,nom'],
            'categorie_id' => ['required', 'integer', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'prix' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'statut' => ['nullable', Rule::in(['disponible', 'indisponible', 'en_rupture'])],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        $photo = $request->file('photo')?->store('produits', 'public');

        if ($request->hasFile('photo') && $photo === false) {
            throw new RuntimeException('La photo du produit n’a pas pu être enregistrée.');
        }

        $stock = (int) $validated['stock'];

        Produit::create([
            'nom' => $validated['nom'],
            'slug' => $this->uniqueSlug($validated['nom']),
            'categorie_id' => $validated['categorie_id'],
            'description' => $validated['description'] ?? null,
            'prix' => $validated['prix'],
            'stock' => $stock,
            'statut' => $stock === 0
                ? 'en_rupture'
                : ($validated['statut'] ?? 'disponible'),
            'photo' => $photo,
        ]);

        return to_route('admin.produits.index')
            ->with('success', 'Produit ajouté avec succès.');
    }

    public function update(Request $request, Produit $produit): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => [
                'required',
                'string',
                'max:255',
                Rule::unique('produits', 'nom')->ignore($produit),
            ],
            'categorie_id' => ['required', 'integer', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'prix' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'statut' => ['nullable', Rule::in(['disponible', 'indisponible', 'en_rupture'])],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        $anciennePhoto = $produit->photo;
        $nouvellePhoto = $request->file('photo')?->store('produits', 'public');

        if ($request->hasFile('photo') && $nouvellePhoto === false) {
            throw new RuntimeException('La nouvelle photo du produit n’a pas pu être enregistrée.');
        }

        $photo = is_string($nouvellePhoto) ? $nouvellePhoto : $anciennePhoto;
        $stock = (int) $validated['stock'];
        $statut = $validated['statut'] ?? $produit->statut;

        $produit->update([
            'nom' => $validated['nom'],
            'slug' => $this->uniqueSlug($validated['nom'], $produit),
            'categorie_id' => $validated['categorie_id'],
            'description' => $validated['description'] ?? null,
            'prix' => $validated['prix'],
            'stock' => $stock,
            'statut' => $stock === 0 ? 'en_rupture' : ($statut === 'en_rupture' ? 'disponible' : $statut),
            'photo' => $photo,
        ]);

        if ($photo !== $anciennePhoto && $anciennePhoto !== null) {
            Storage::disk('public')->delete($anciennePhoto);
        }

        return to_route('admin.produits.index')
            ->with('success', 'Produit mis à jour avec succès.');
    }

    public function destroy(Produit $produit): RedirectResponse
    {
        if ($produit->lignesCommande()->exists()) {
            throw ValidationException::withMessages([
                'produit' => 'Ce produit est associé à une commande et ne peut pas être supprimé.',
            ]);
        }

        $anciennePhoto = $produit->photo;
        $produit->delete();

        if ($anciennePhoto !== null && ! Storage::disk('public')->delete($anciennePhoto)) {
            throw new RuntimeException('La photo du produit n’a pas pu être supprimée.');
        }

        return to_route('admin.produits.index')
            ->with('success', 'Produit supprimé avec succès.');
    }

    private function uniqueSlug(string $nom, ?Produit $produit = null): string
    {
        $baseSlug = Str::slug($nom) ?: Str::random(12);
        $slug = $baseSlug;
        $suffix = 2;

        while (Produit::query()
            ->where('slug', $slug)
            ->when($produit, fn (Builder $query) => $query->where('id', '!=', $produit->getKey()))
            ->exists()) {
            $slug = $baseSlug.'-'.$suffix;
            $suffix++;
        }

        return $slug;
    }
}
