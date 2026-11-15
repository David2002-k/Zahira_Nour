<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $paiement->reference_paiement }} - Zahira Nour</title>
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
                <a href="{{ route('admin.paiements.index') }}" class="btn btn-outline-dark btn-sm">Retour </a>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                    <div>
                        <p class="eyebrow mb-1">Paiement</p>
                        <h2 class="h4 mb-0">{{ $paiement->reference_paiement }}</h2>
                    </div>
                    <span class="badge text-bg-secondary text-uppercase">{{ str_replace('_', ' ', $paiement->statut) }}</span>
                </div>

                <dl class="row g-3 mb-0">
                    <div class="col-md-6">
                        <dt class="text-uppercase small text-secondary">Référence</dt>
                        <dd class="mb-0">{{ $paiement->reference_paiement }}</dd>
                    </div>
                    <div class="col-md-6">
                        <dt class="text-uppercase small text-secondary">Commande</dt>
                        <dd class="mb-0">{{ optional($paiement->commande)->numero_commande ?? '?' }}</dd>
                    </div>
                    <div class="col-md-6">
                        <dt class="text-uppercase small text-secondary">Montant</dt>
                        <dd class="mb-0">{{ number_format($paiement->montant_paye, 2, ',', ' ') }} €</dd>
                    </div>
                    <div class="col-md-6">
                        <dt class="text-uppercase small text-secondary">Mode</dt>
                        <dd class="mb-0">{{ str_replace('_', ' ', $paiement->mode_paiement) }}</dd>
                    </div>
                    <div class="col-md-6">
                        <dt class="text-uppercase small text-secondary">Date</dt>
                        <dd class="mb-0">{{ $paiement->date_paiement?->format('d/m/Y H:i') ?? '?' }}</dd>
                    </div>
                    <div class="col-md-6">
                        <dt class="text-uppercase small text-secondary">Validé par</dt>
                        <dd class="mb-0">{{ optional($paiement->admin?->user)->name ?? '?' }}</dd>
                    </div>
                </dl>

                @if ($paiement->fichier_recu)
                    <div class="mt-4">
                        <a href="{{ Storage::url($paiement->fichier_recu) }}" target="_blank" class="btn btn-dark">Voir le reçu</a>
                    </div>
                @endif
            </div>
        </div>
    </main>
</body>
</html>
