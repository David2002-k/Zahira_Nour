<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes commandes - Zahira Nour</title>
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
            <p class="text-uppercase small fw-semibold text-secondary mb-2">Votre activité</p>
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3">
                <div>
                    <h1 class="display-5 fw-semibold mb-2">Mes commandes</h1>
                    <p class="text-secondary mb-0">Consultez le suivi et l’historique de vos commandes.</p>
                </div>
                <span class="text-secondary">{{ $commandes->total() }} {{ $commandes->total() === 1 ? 'commande' : 'commandes' }}</span>
            </div>
        </section>

        @if (session('success'))
            <div class="alert alert-success" role="status">{{ session('success') }}</div>
        @endif

        @if ($commandes->isEmpty())
            <section class="card border-0 shadow-sm text-center">
                <div class="card-body p-5">
                    <h2 class="h4 mb-2">Vous n’avez pas encore de commande</h2>
                    <p class="text-secondary mb-4">Vos commandes apparaîtront ici après votre premier achat.</p>
                    <a href="{{ route('client.boutique.index') }}" class="btn btn-dark">Découvrir la boutique</a>
                </div>
            </section>
        @else
            <section class="card border-0 shadow-sm" aria-label="Historique des commandes">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Commande</th>
                                <th scope="col">Date</th>
                                <th scope="col">Articles</th>
                                <th scope="col">Montant</th>
                                <th scope="col">Statut</th>
                                <th scope="col"><span class="visually-hidden">Détails</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($commandes as $commande)
                                <tr>
                                    <th scope="row" class="text-nowrap">{{ $commande->numero_commande }}</th>
                                    <td class="text-nowrap">{{ $commande->date_commande?->format('d/m/Y') ?? '—' }}</td>
                                    <td>{{ $commande->lignes_commande_count }}</td>
                                    <td class="text-nowrap">{{ number_format((float) $commande->montant_total, 2, ',', ' ') }} FCFA</td>
                                    <td>
                                        <span class="badge text-bg-light border text-dark">
                                            {{ [
                                                'en_attente' => 'En attente',
                                                'confirmee' => 'Confirmée',
                                                'en_preparation' => 'En préparation',
                                                'expediee' => 'Expédiée',
                                                'livree' => 'Livrée',
                                                'annulee' => 'Annulée',
                                            ][$commande->statut] ?? ucfirst(str_replace('_', ' ', $commande->statut)) }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('client.commandes.show', $commande) }}" class="btn btn-outline-dark btn-sm">Détails</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            <div class="d-flex justify-content-center mt-4">
                {{ $commandes->links() }}
            </div>
        @endif
    </main>
</body>
</html>