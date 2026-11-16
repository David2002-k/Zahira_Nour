<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon panier - Zahira Nour</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="client-dashboard">
    <nav class="dashboard-nav navbar navbar-expand-lg">
        <div class="container py-3">
            <a class="brand-mark navbar-brand fw-semibold" href="{{ route('client.dashboard') }}">Zahira Nour</a>
            <div class="d-flex align-items-center gap-2 gap-sm-3 ms-auto">
                <a href="{{ route('client.boutique.index') }}" class="btn btn-outline-dark btn-sm">La boutique</a>
                <a href="{{ route('client.dashboard') }}" class="btn btn-outline-dark btn-sm">Mon espace</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-dark btn-sm">Déconnexion</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        <section class="mb-4">
            <p class="text-uppercase small fw-semibold text-secondary mb-2">Votre sélection</p>
            <h1 class="display-5 fw-semibold mb-2">Mon panier</h1>
            <p class="text-secondary mb-0">Vérifiez vos articles avant de confirmer votre commande.</p>
        </section>

        @if (session('success'))
            <div class="alert alert-success" role="status">{{ session('success') }}</div>
        @endif

        @if ($errors->has('panier'))
            <div class="alert alert-danger" role="alert">{{ $errors->first('panier') }}</div>
        @endif

        @php($total = 0)
        @php($articlesPresents = 0)
        @foreach ($panier as $produitId => $quantite)
            @if ($produits->has($produitId))
                @php($total += (float) $produits->get($produitId)->prix * (int) $quantite)
                @php($articlesPresents++)
            @endif
        @endforeach

        @if ($articlesPresents === 0)
            <section class="card border-0 shadow-sm text-center" aria-label="Panier vide">
                <div class="card-body p-5">
                    <h2 class="h4 mb-2">Votre panier est vide</h2>
                    <p class="text-secondary mb-4">Parcourez la boutique pour découvrir les produits disponibles.</p>
                    <a href="{{ route('client.boutique.index') }}" class="btn btn-dark">Découvrir la boutique</a>
                </div>
            </section>
        @else
            <div class="row g-4 align-items-start">
                <div class="col-12 col-lg-8">
                    <section class="card border-0 shadow-sm" aria-label="Articles du panier">
                        <div class="list-group list-group-flush">
                            @foreach ($panier as $produitId => $quantite)
                                @php($produit = $produits->get($produitId))
                                @if ($produit)
                                    <article class="list-group-item p-3 p-md-4">
                                        <div class="row g-3 align-items-center">
                                            <div class="col-4 col-sm-3">
                                                @if ($produit->photo)
                                                    <img src="{{ Storage::url($produit->photo) }}" class="img-fluid rounded object-fit-cover" alt="{{ $produit->nom }}" loading="lazy">
                                                @else
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center text-secondary text-center p-3" style="min-height: 6rem;">Photo à venir</div>
                                                @endif
                                            </div>
                                            <div class="col-8 col-sm-9">
                                                <div class="d-flex flex-column flex-md-row justify-content-between gap-3">
                                                    <div>
                                                        <h2 class="h5 mb-1"><a href="{{ route('client.boutique.show', $produit) }}" class="link-dark text-decoration-none">{{ $produit->nom }}</a></h2>
                                                        <p class="text-secondary small mb-2">{{ number_format((float) $produit->prix, 2, ',', ' ') }} FCFA l’unité</p>
                                                        <p class="fw-semibold mb-0">Sous-total : {{ number_format((float) $produit->prix * (int) $quantite, 2, ',', ' ') }} FCFA</p>
                                                    </div>

                                                    <div class="d-flex flex-column gap-2">
                                                        @if ($produit->statut === 'disponible' && $produit->stock > 0)
                                                            <form method="POST" action="{{ route('client.panier.update', $produit) }}" class="d-flex align-items-end gap-2">
                                                                @csrf
                                                                @method('PATCH')
                                                                <div>
                                                                    <label for="quantite-{{ $produit->id }}" class="form-label small mb-1">Quantité</label>
                                                                    <input
                                                                        type="number"
                                                                        name="quantite"
                                                                        id="quantite-{{ $produit->id }}"
                                                                        class="form-control form-control-sm @error('quantite') is-invalid @enderror"
                                                                        value="{{ $quantite }}"
                                                                        min="1"
                                                                        max="{{ $produit->stock }}"
                                                                        required
                                                                    >
                                                                </div>
                                                                <button type="submit" class="btn btn-outline-dark btn-sm">Mettre à jour</button>
                                                            </form>
                                                        @else
                                                            <p class="small text-danger mb-0">Ce produit n’est plus disponible en quantité suffisante.</p>
                                                        @endif
                                                        <form method="POST" action="{{ route('client.panier.remove', $produit) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-link link-danger p-0 text-decoration-none">Retirer</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                @endif
                            @endforeach
                        </div>
                        <div class="card-body d-flex justify-content-between align-items-center gap-3 flex-wrap">
                            <form method="POST" action="{{ route('client.panier.clear') }}" onsubmit="return confirm('Voulez-vous vraiment vider votre panier ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">Vider le panier</button>
                            </form>
                            <a href="{{ route('client.boutique.index') }}" class="btn btn-outline-dark btn-sm">Continuer mes achats</a>
                        </div>
                    </section>
                </div>

                <div class="col-12 col-lg-4">
                    <section class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h2 class="h5 mb-3">Finaliser la commande</h2>
                            <div class="d-flex justify-content-between border-bottom pb-3 mb-3">
                                <span>Total</span>
                                <strong>{{ number_format($total, 2, ',', ' ') }} FCFA</strong>
                            </div>

                            <form method="POST" action="{{ route('client.commandes.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="adresse_livraison" class="form-label">Adresse de livraison</label>
                                    <textarea
                                        name="adresse_livraison"
                                        id="adresse_livraison"
                                        rows="3"
                                        class="form-control @error('adresse_livraison') is-invalid @enderror"
                                        required
                                    >{{ old('adresse_livraison') }}</textarea>
                                    @error('adresse_livraison')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="telephone_livraison" class="form-label">Téléphone de livraison</label>
                                    <input
                                        type="tel"
                                        name="telephone_livraison"
                                        id="telephone_livraison"
                                        value="{{ old('telephone_livraison', auth()->user()->telephone) }}"
                                        class="form-control @error('telephone_livraison') is-invalid @enderror"
                                        maxlength="20"
                                        required
                                    >
                                    @error('telephone_livraison')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-dark w-100">Confirmer ma commande</button>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        @endif
    </main>
</body>
</html>