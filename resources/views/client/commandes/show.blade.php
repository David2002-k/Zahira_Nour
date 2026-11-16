<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $commande->numero_commande }} - Zahira Nour</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="client-dashboard">
    <nav class="dashboard-nav navbar navbar-expand-lg">
        <div class="container py-3">
            <a class="brand-mark navbar-brand fw-semibold" href="{{ route('client.dashboard') }}">Zahira Nour</a>
            <div class="d-flex align-items-center gap-2 gap-sm-3 ms-auto">
                <a href="{{ route('client.commandes.index') }}" class="btn btn-outline-dark btn-sm">Mes commandes</a>
                <a href="{{ route('client.dashboard') }}" class="btn btn-outline-dark btn-sm">Mon espace</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-dark btn-sm">Déconnexion</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        <p class="mb-4"><a href="{{ route('client.commandes.index') }}" class="link-dark">← Retour à mes commandes</a></p>

        @if (session('success'))
            <div class="alert alert-success" role="status">{{ session('success') }}</div>
        @endif

        @if ($errors->has('commande'))
            <div class="alert alert-danger" role="alert">{{ $errors->first('commande') }}</div>
        @endif

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <p class="text-uppercase small fw-semibold text-secondary mb-2">Détail de la commande</p>
                <h1 class="h2 fw-semibold mb-0">{{ $commande->numero_commande }}</h1>
            </div>
            <span class="badge text-bg-light border text-dark fs-6">
                {{ [
                    'en_attente' => 'En attente',
                    'confirmee' => 'Confirmée',
                    'en_preparation' => 'En préparation',
                    'expediee' => 'Expédiée',
                    'livree' => 'Livrée',
                    'annulee' => 'Annulée',
                ][$commande->statut] ?? ucfirst(str_replace('_', ' ', $commande->statut)) }}
            </span>
        </div>

        <div class="row g-4 align-items-start">
            <div class="col-12 col-lg-8">
                <section class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h2 class="h5 mb-3">Articles commandés</h2>
                        <div class="list-group list-group-flush">
                            @forelse ($commande->lignesCommande as $ligne)
                                <div class="list-group-item px-0 py-3 d-flex justify-content-between align-items-start gap-3">
                                    <div>
                                        <h3 class="h6 mb-1">{{ $ligne->produit?->nom ?? 'Produit indisponible' }}</h3>
                                        <p class="small text-secondary mb-0">
                                            {{ $ligne->quantite }} × {{ number_format((float) $ligne->prix_unitaire, 2, ',', ' ') }} FCFA
                                        </p>
                                    </div>
                                    <strong class="text-nowrap">{{ number_format((float) $ligne->sous_total, 2, ',', ' ') }} FCFA</strong>
                                </div>
                            @empty
                                <p class="text-secondary mb-0">Aucun article n’est associé à cette commande.</p>
                            @endforelse
                        </div>
                        <div class="d-flex justify-content-between border-top pt-3 mt-3">
                            <span class="fw-semibold">Total de la commande</span>
                            <strong>{{ number_format((float) $commande->montant_total, 2, ',', ' ') }} FCFA</strong>
                        </div>
                    </div>
                </section>

                <section class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="h5 mb-3">Paiements</h2>
                        @forelse ($commande->paiements as $paiement)
                            <div class="d-flex flex-column flex-sm-row justify-content-between gap-2 py-2 {{ $loop->last ? '' : 'border-bottom' }}">
                                <div>
                                    <p class="fw-semibold mb-1">{{ $paiement->reference_paiement }}</p>
                                    <p class="small text-secondary mb-0">{{ $paiement->date_paiement?->format('d/m/Y H:i') ?? 'Date non renseignée' }}</p>
                                </div>
                                <div class="text-sm-end">
                                    <p class="fw-semibold mb-1">{{ number_format((float) $paiement->montant_paye, 2, ',', ' ') }} FCFA</p>
                                    <span class="badge text-bg-light border text-dark">{{ ucfirst(str_replace('_', ' ', $paiement->statut)) }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-secondary mb-0">Aucun paiement n’a encore été enregistré pour cette commande.</p>
                        @endforelse
                        <a href="{{ route('client.paiements.index') }}" class="btn btn-outline-dark btn-sm mt-3">Voir tous mes paiements</a>
                    </div>
                </section>
            </div>

            <aside class="col-12 col-lg-4">
                <section class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="h5 mb-3">Livraison</h2>
                        <dl class="mb-0">
                            <dt class="small text-secondary">Date de commande</dt>
                            <dd class="mb-3">{{ $commande->date_commande?->format('d/m/Y H:i') ?? '—' }}</dd>
                            <dt class="small text-secondary">Téléphone</dt>
                            <dd class="mb-3">{{ $commande->telephone_livraison }}</dd>
                            <dt class="small text-secondary">Adresse</dt>
                            <dd class="mb-0">{{ $commande->adresse_livraison }}</dd>
                        </dl>
                    </div>
                </section>
            </aside>
        </div>
    </main>
</body>
</html>