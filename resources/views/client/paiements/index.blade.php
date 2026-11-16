<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes paiements - Zahira Nour</title>
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
        <section class="mb-4">
            <p class="text-uppercase small fw-semibold text-secondary mb-2">Votre activité</p>
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3">
                <div>
                    <h1 class="display-5 fw-semibold mb-2">Mes paiements</h1>
                    <p class="text-secondary mb-0">Consultez les paiements enregistrés pour vos commandes.</p>
                </div>
                <span class="text-secondary">{{ $paiements->total() }} {{ $paiements->total() === 1 ? 'paiement' : 'paiements' }}</span>
            </div>
        </section>

        @if ($paiements->isEmpty())
            <section class="card border-0 shadow-sm text-center">
                <div class="card-body p-5">
                    <h2 class="h4 mb-2">Aucun paiement enregistré</h2>
                    <p class="text-secondary mb-4">Les paiements de vos commandes apparaîtront ici.</p>
                    <a href="{{ route('client.commandes.index') }}" class="btn btn-dark">Voir mes commandes</a>
                </div>
            </section>
        @else
            <section class="card border-0 shadow-sm" aria-label="Historique des paiements">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Référence</th>
                                <th scope="col">Commande</th>
                                <th scope="col">Date</th>
                                <th scope="col">Mode</th>
                                <th scope="col">Montant</th>
                                <th scope="col">Statut</th>
                                <th scope="col"><span class="visually-hidden">Reçu</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paiements as $paiement)
                                <tr>
                                    <th scope="row" class="text-nowrap">{{ $paiement->reference_paiement }}</th>
                                    <td>
                                        @if ($paiement->commande)
                                            <a href="{{ route('client.commandes.show', $paiement->commande) }}" class="link-dark">{{ $paiement->commande->numero_commande }}</a>
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td class="text-nowrap">{{ $paiement->date_paiement?->format('d/m/Y') ?? '—' }}</td>
                                    <td>{{ [
                                        'especes' => 'Espèces',
                                        'orange_money' => 'Orange Money',
                                        'moov_money' => 'Moov Money',
                                        'wave' => 'Wave',
                                        'autre' => 'Autre',
                                    ][$paiement->mode_paiement] ?? ucfirst(str_replace('_', ' ', $paiement->mode_paiement)) }}</td>
                                    <td class="text-nowrap">{{ number_format((float) $paiement->montant_paye, 2, ',', ' ') }} FCFA</td>
                                    <td><span class="badge text-bg-light border text-dark">{{ ucfirst(str_replace('_', ' ', $paiement->statut)) }}</span></td>
                                    <td class="text-end">
                                        @if ($paiement->statut === 'confirme')
                                            <a href="{{ route('client.paiements.recu', $paiement) }}" class="btn btn-outline-dark btn-sm">Télécharger</a>
                                        @else
                                            <span class="small text-secondary">Disponible après confirmation</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
            <div class="d-flex justify-content-center mt-4">
                {{ $paiements->links() }}
            </div>
        @endif
    </main>
</body>
</html>