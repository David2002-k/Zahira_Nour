<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $produit->nom }} - Zahira Nour</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="client-dashboard">
    <nav class="dashboard-nav navbar navbar-expand-lg">
        <div class="container py-3">
            <a class="brand-mark navbar-brand fw-semibold" href="{{ route('client.dashboard') }}">Zahira Nour</a>
            <div class="d-flex align-items-center gap-2 gap-sm-3 ms-auto">
                <a href="{{ route('client.panier.index') }}" class="btn btn-outline-dark btn-sm">Mon panier</a>
                <a href="{{ route('client.dashboard') }}" class="btn btn-outline-dark btn-sm">Mon espace</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-dark btn-sm">Déconnexion</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        <p class="mb-4"><a href="{{ route('client.boutique.index') }}" class="link-dark">← Retour à la boutique</a></p>

        @if (session('success'))
            <div class="alert alert-success" role="status">{{ session('success') }}</div>
        @endif

        <article class="card border-0 shadow-sm overflow-hidden">
            <div class="row g-0">
                <div class="col-12 col-lg-6">
                    @if ($produit->photo)
                        <img
                            src="{{ Storage::url($produit->photo) }}"
                            class="w-100 h-100 object-fit-cover"
                            alt="{{ $produit->nom }}"
                            style="min-height: 20rem;"
                        >
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light text-secondary h-100" style="min-height: 20rem;">
                            Photo à venir
                        </div>
                    @endif
                </div>
                <div class="col-12 col-lg-6">
                    <div class="card-body p-4 p-lg-5">
                        <p class="small text-uppercase text-secondary mb-2">Sélection Zahira Nour</p>
                        <h1 class="display-6 fw-semibold">{{ $produit->nom }}</h1>
                        <p class="h3 fw-semibold mb-3">{{ number_format((float) $produit->prix, 2, ',', ' ') }} FCFA</p>

                        @if ($produit->description)
                            <p class="text-secondary">{{ $produit->description }}</p>
                        @else
                            <p class="text-secondary">Découvrez ce produit de notre sélection.</p>
                        @endif

                        <p class="small text-secondary">
                            @if ($produit->stock > 0)
                                {{ $produit->stock }} {{ $produit->stock === 1 ? 'article disponible' : 'articles disponibles' }}
                            @else
                                En rupture de stock
                            @endif
                        </p>

                        <form method="POST" action="{{ route('client.panier.add', $produit) }}" class="mt-4">
                            @csrf
                            <div class="mb-3">
                                <label for="quantite" class="form-label">Quantité</label>
                                <input
                                    type="number"
                                    name="quantite"
                                    id="quantite"
                                    class="form-control @error('quantite') is-invalid @enderror"
                                    value="{{ old('quantite', 1) }}"
                                    min="1"
                                    max="{{ $produit->stock }}"
                                    required
                                    @disabled($produit->stock < 1)
                                >
                                @error('quantite')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-dark w-100" @disabled($produit->stock < 1)>
                                {{ $produit->stock > 0 ? 'Ajouter au panier' : 'Indisponible' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </article>
    </main>
</body>
</html>