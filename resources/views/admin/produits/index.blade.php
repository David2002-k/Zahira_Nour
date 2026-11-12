<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits - Zahira Nour</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="Dashboard-shell">
    <nav class="dashboard-nav navbar navbar-expand-lg">
        <div class="container py-3">
            <a class="brand-mark navbar-brand" href="{{ route('admin.dashboard') }}">Zahira Nour</a>
            <div class="d-flex align-items-center gap-3 ms-auto">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark btn-sm">Retour au tableau de bord</a>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        @if (session('success'))
            <div class="alert alert-success mb-4">{{ session('success') }}</div>
        @endif

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <p class="eyebrow mb-2">Catalogue</p>
                        <h2 class="mb-4">Ajouter un produit</h2>

                        <form method="POST" action="{{ route('admin.produits.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nom</label>
                                <input type="text" name="nom" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Catégorie</label>
                                <select name="categorie_id" class="form-select" required>
                                    <option value="">Choisir une catégorie</option>
                                    @foreach ($categories as $categorie)
                                        <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" rows="4" class="form-control"></textarea>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Prix</label>
                                    <input type="number" name="prix" min="0" step="0.01" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Stock</label>
                                    <input type="number" name="stock" min="0" class="form-control" required>
                                </div>
                            </div>
                            <div class="mb-3 mt-3">
                                <label class="form-label">Statut</label>
                                <select name="statut" class="form-select">
                                    <option value="disponible">Disponible</option>
                                    <option value="indisponible">Indisponible</option>
                                    <option value="en_rupture">En rupture</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Photo</label>
                                <input type="file" name="photo" accept="image/*" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-dark w-100">Créer le produit</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        <div class="border-bottom px-4 py-3">
                            <p class="eyebrow mb-1">Catalogue</p>
                            <h3 class="h4 mb-0">Liste des produits</h3>
                        </div>

                        @forelse ($produits as $produit)
                            <div class="d-flex flex-column flex-xl-row justify-content-between gap-3 border-bottom px-4 py-4">
                                <div class="d-flex gap-3">
                                    @if ($produit->photo)
                                        <img src="{{ Storage::url($produit->photo) }}" alt="{{ $produit->nom }}" class="rounded" style="width:90px; height:90px; object-fit:cover;">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center rounded bg-light text-muted" style="width:90px; height:90px;">No image</div>
                                    @endif
                                    <div>
                                        <h5 class="mb-1">{{ $produit->nom }}</h5>
                                        <p class="text-muted mb-1">{{ $produit->categorie?->nom ?? 'Sans catégorie' }}</p>
                                        <p class="small text-muted mb-2">{{ Str::limit($produit->description, 120) ?: 'Aucune description' }}</p>
                                        <div class="small text-secondary">
                                            <span class="me-3">Prix : {{ number_format($produit->prix, 2, ',', ' ') }} €</span>
                                            <span class="me-3">Stock : {{ $produit->stock }}</span>
                                            <span class="text-uppercase">{{ str_replace('_', ' ', $produit->statut) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column gap-2">
                                    <form method="POST" action="{{ route('admin.produits.update', $produit) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="row g-2">
                                            <div class="col-md-6">
                                                <input type="text" name="nom" value="{{ $produit->nom }}" class="form-control form-control-sm">
                                            </div>
                                            <div class="col-md-6">
                                                <select name="categorie_id" class="form-select form-select-sm">
                                                    @foreach ($categories as $categorie)
                                                        <option value="{{ $categorie->id }}" @selected($categorie->id === $produit->categorie_id)>{{ $categorie->nom }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="number" name="prix" min="0" step="0.01" value="{{ $produit->prix }}" class="form-control form-control-sm">
                                            </div>
                                            <div class="col-md-4">
                                                <input type="number" name="stock" min="0" value="{{ $produit->stock }}" class="form-control form-control-sm">
                                            </div>
                                            <div class="col-md-4">
                                                <select name="statut" class="form-select form-select-sm">
                                                    @foreach (['disponible', 'indisponible', 'en_rupture'] as $statut)
                                                        <option value="{{ $statut }}" @selected($produit->statut === $statut)>{{ str_replace('_', ' ', $statut) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <textarea name="description" rows="2" class="form-control form-control-sm">{{ $produit->description }}</textarea>
                                            </div>
                                            <div class="col-12">
                                                <input type="file" name="photo" accept="image/*" class="form-control form-control-sm">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-outline-warning btn-sm mt-2">Enregistrer</button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.produits.destroy', $produit) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Supprimer ce produit ?')">Supprimer</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="p-5 text-center">
                                <h4 class="mb-2">Aucun produit</h4>
                                <p class="text-muted">Ajoutez votre premier produit pour commencer la boutique.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
