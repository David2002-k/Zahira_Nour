<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commandes - Zahira Nour</title>
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
                        <p class="eyebrow mb-1">Commandes</p>
                        <h2 class="h4 mb-0">Gestion des commandes</h2>
                    </div>
                    <span class="badge text-bg-light border">{{ $commandes->total() }} commande(s)</span>
                </div>
            </div>

            <div class="list-group list-group-flush">
                @forelse ($commandes as $commande)
                    <div class="list-group-item py-4">
                        <div class="d-flex gap-3 justify-content-between flex-column flex-lg-row">
                            <div>
                                <div class="d-flex align-items-center flex-wrap gap-2 mb-2">
                                    <h5 class="mb-0">{{ $commande->numero_commande }}</h5>
                                    <span class="badge text-bg-secondary text-uppercase">{{ str_replace('_', ' ', $commande->statut) }}</span>
                                </div>
                                <p class="mb-1 text-muted">Client : {{ optional($commande->client?->user)->name ?? 'Client inconnu' }}</p>
                                <p class="mb-1 text-muted">Date : {{ $commande->date_commande?->format('d/m/Y H:i') ?? '—' }}</p>
                                <p class="mb-0 text-muted">Montant total : {{ number_format($commande->montant_total, 2, ',', ' ') }} €</p>
                            </div>

                            <div class="d-flex flex-column gap-2">
                                <a href="{{ route('admin.commandes.show', $commande) }}" class="btn btn-dark btn-sm">Détails</a>
                                <form method="POST" action="{{ route('admin.commandes.update', $commande) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="input-group input-group-sm">
                                        <select name="statut" class="form-select">
                                            @foreach (['en_attente', 'confirmee', 'en_preparation', 'expediee', 'livree', 'annulee'] as $statut)
                                                <option value="{{ $statut }}" @selected($commande->statut === $statut)>{{ str_replace('_', ' ', $statut) }}</option>
                                            @endforeach
                                        </select>
                                        <button class="btn btn-outline-secondary" type="submit">OK</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-5 text-center">
                        <h4 class="mb-2">Aucune commande</h4>
                        <p class="text-muted">Les commandes apparaîtront ici dès qu’elles seront passées.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="mt-4">
            {{ $commandes->links() }}
        </div>
    </main>
</body>
</html>
