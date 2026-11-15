<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $commande->numero_commande }} - Zahira Nour</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="Dashboard-shell admin-dashboard">
    <nav class="dashboard-nav navbar navbar-expand-lg">
        <div class="container py-3">
            <a class="brand-mark navbar-brand" href="{{ route('admin.dashboard') }}" aria-label="Tableau de bord Zahira Nour">
                <img class="dashboard-brand-logo" src="{{ asset('front-end/images/zahira-nour-logo.jpeg') }}" alt="">
                <span class="brand-name">Zahira Nour</span>
            </a>
            <div class="d-flex align-items-center gap-3 ms-auto">
                <a href="{{ route('admin.commandes.index') }}" class="btn btn-outline-dark btn-sm">Retour</a>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        @if (session('success'))
            <div class="alert alert-success mb-4">{{ session('success') }}</div>
        @endif

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <p class="eyebrow mb-1">Commande</p>
                                <h2 class="h4 mb-0">{{ $commande->numero_commande }}</h2>
                            </div>
                            <span class="badge text-bg-secondary text-uppercase">{{ str_replace('_', ' ', $commande->statut) }}</span>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="bg-light p-3 rounded">
                                    <small class="text-muted d-block">Client</small>
                                    <strong>{{ optional($commande->client?->user)->name ?? 'Client inconnu' }}</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-light p-3 rounded">
                                    <small class="text-muted d-block">Téléphone</small>
                                    <strong>{{ $commande->telephone_livraison }}</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-light p-3 rounded">
                                    <small class="text-muted d-block">Date</small>
                                    <strong>{{ $commande->date_commande?->format('d/m/Y H:i') ?? '—' }}</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-light p-3 rounded">
                                    <small class="text-muted d-block">Montant</small>
                                    <strong>{{ number_format($commande->montant_total, 2, ',', ' ') }} €</strong>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="bg-light p-3 rounded">
                                    <small class="text-muted d-block">Adresse</small>
                                    <strong>{{ $commande->adresse_livraison }}</strong>
                                </div>
                            </div>
                        </div>

                        <h4 class="h5 mb-3">Produits</h4>
                        <div class="list-group">
                            @forelse ($commande->lignesCommande as $ligne)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $ligne->produit?->nom ?? 'Produit supprimé' }}</strong>
                                        <div class="small text-muted">Quantité : {{ $ligne->quantite }}</div>
                                    </div>
                                    <strong>{{ number_format($ligne->sous_total, 2, ',', ' ') }} €</strong>
                                </div>
                            @empty
                                <div class="list-group-item text-muted">Aucun produit associé à cette commande.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <p class="eyebrow mb-2">Statut</p>
                        <h3 class="h5">Mettre à jour</h3>
                        <form method="POST" action="{{ route('admin.commandes.update', $commande) }}" class="mt-3">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <select name="statut" class="form-select">
                                    @foreach (['en_attente', 'confirmee', 'en_preparation', 'expediee', 'livree', 'annulee'] as $statut)
                                        <option value="{{ $statut }}" @selected($commande->statut === $statut)>{{ str_replace('_', ' ', $statut) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-dark w-100">Enregistrer</button>
                        </form>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <p class="eyebrow mb-2">Paiement</p>
                        @if ($commande->paiements->isNotEmpty())
                            @foreach ($commande->paiements as $paiement)
                                <div class="border rounded p-3 mb-3">
                                    <strong>{{ $paiement->reference_paiement }}</strong>
                                    <div class="small text-muted mt-2">Montant : {{ number_format($paiement->montant_paye, 2, ',', ' ') }} €</div>
                                    <div class="small text-muted">Mode : {{ str_replace('_', ' ', $paiement->mode_paiement) }}</div>
                                    <div class="small text-muted">Statut : {{ str_replace('_', ' ', $paiement->statut) }}</div>
                                </div>
                            @endforeach
                        @else
                            <form method="POST" action="{{ route('admin.paiements.store', $commande) }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Mode de paiement</label>
                                    <select name="mode_paiement" class="form-select">
                                        @foreach (['especes', 'orange_money', 'moov_money', 'wave', 'autre'] as $mode)
                                            <option value="{{ $mode }}">{{ str_replace('_', ' ', $mode) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success w-100">Confirmer le paiement</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
