<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiements - Zahira Nour</title>
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

        <div class="card shadow-sm border-0">
            <div class="card-body border-bottom">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <p class="eyebrow mb-1">Paiements</p>
                        <h2 class="h4 mb-0">Gestion des paiements</h2>
                    </div>
                    <span class="badge text-bg-light border">{{ $paiements->total() }} paiement(s)</span>
                </div>
            </div>

            <div class="list-group list-group-flush">
                @forelse ($paiements as $paiement)
                    <div class="list-group-item py-4">
                        <div class="d-flex justify-content-between flex-column flex-lg-row gap-3">
                            <div>
                                <div class="d-flex align-items-center flex-wrap gap-2 mb-2">
                                    <h5 class="mb-0">{{ $paiement->reference_paiement }}</h5>
                                    <span class="badge text-bg-secondary text-uppercase">{{ str_replace('_', ' ', $paiement->statut) }}</span>
                                </div>
                                <p class="mb-1 text-muted">Commande : {{ optional($paiement->commande)->numero_commande ?? '?' }}</p>
                                <p class="mb-1 text-muted">Montant : {{ number_format($paiement->montant_paye, 2, ',', ' ') }} €</p>
                                <p class="mb-0 text-muted">Mode : {{ str_replace('_', ' ', $paiement->mode_paiement) }}</p>
                            </div>
                            <a href="{{ route('admin.paiements.show', $paiement) }}" class="btn btn-dark btn-sm align-self-start">Voir</a>
                        </div>
                    </div>
                @empty
                    <div class="p-5 text-center">
                        <h4 class="mb-2">Aucun paiement</h4>
                        <p class="text-muted">Les paiements confirmeront ici les transactions enregistrées.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="mt-4">
            {{ $paiements->links() }}
        </div>
    </main>
</body>
</html>
