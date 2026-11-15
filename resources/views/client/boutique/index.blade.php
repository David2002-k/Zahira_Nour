<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique - Zahira Nour</title>
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
        <section class="mb-5" aria-labelledby="catalog-title">
            <p class="text-uppercase small fw-semibold text-secondary mb-2">Zahira Nour</p>
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3">
                <div>
                    <h1 id="catalog-title" class="display-5 fw-semibold mb-2">La boutique</h1>
                    <p class="lead text-secondary mb-0">Découvrez notre sélection et trouvez le cadeau idéal.</p>
                </div>
                <p class="text-secondary mb-0">
                    {{ $produits->total() }} {{ $produits->total() === 1 ? 'produit disponible' : 'produits disponibles' }}
                </p>
            </div>
        </section>

        @if (session('success'))
            <div class="alert alert-success" role="status">{{ session('success') }}</div>
        @endif

        @if ($produits->total() === 0)
            <section class="card border-0 shadow-sm text-center" aria-label="Boutique vide">
                <div class="card-body p-5">
                    <h2 class="h4 mb-2">La boutique est momentanément vide</h2>
                    <p class="text-secondary mb-0">Les nouveaux produits apparaîtront ici dès qu’ils seront disponibles.</p>
                </div>
            </section>
        @else
            <section aria-label="Produits disponibles">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-4">
                    @foreach ($produits as $produit)
                        <article class="col">
                            <div class="card h-100 border-0 shadow-sm">
                                @if ($produit->photo)
                                    <div class="ratio ratio-4x3">
                                        <img
                                            src="{{ Storage::url($produit->photo) }}"
                                            class="card-img-top object-fit-cover"
                                            alt="{{ $produit->nom }}"
                                            loading="lazy"
                                        >
                                    </div>
                                @else
                                    <div class="ratio ratio-4x3 bg-light text-secondary">
                                        <span class="d-flex align-items-center justify-content-center">Photo à venir</span>
                                    </div>
                                @endif

                                <div class="card-body d-flex flex-column">
                                    <p class="small text-uppercase text-secondary mb-2">{{ $produit->categorie?->nom ?? 'Sélection Zahira Nour' }}</p>
                                    <h2 class="h5">{{ $produit->nom }}</h2>
                                    <p class="text-secondary flex-grow-1">
                                        {{ \Illuminate\Support\Str::limit($produit->description ?: 'Découvrez ce produit de notre sélection.', 110) }}
                                    </p>
                                    <p class="h5 fw-semibold mb-1">{{ number_format((float) $produit->prix, 2, ',', ' ') }} FCFA</p>
                                    <p class="small text-secondary mb-3">
                                        @if ($produit->stock > 0)
                                            {{ $produit->stock }} {{ $produit->stock === 1 ? 'article disponible' : 'articles disponibles' }}
                                        @else
                                            En rupture de stock
                                        @endif
                                    </p>

                                    <form method="POST" action="{{ route('client.panier.add', $produit) }}">
                                        @csrf
                                        <input type="hidden" name="quantite" value="1">
                                        <button type="submit" class="btn btn-dark w-100" @disabled($produit->stock < 1)>
                                            {{ $produit->stock > 0 ? 'Ajouter au panier' : 'Indisponible' }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-5">
                    {{ $produits->links() }}
                </div>
            </section>
        @endif
    </main>
</body>
</html>