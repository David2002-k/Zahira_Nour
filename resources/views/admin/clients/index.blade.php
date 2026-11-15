<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comptes clients - Zahira Nour</title>
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
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark btn-sm">Retour au tableau de bord</a>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        @if (session('success'))
            <div class="alert alert-success mb-4" role="status">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body border-bottom">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <p class="eyebrow mb-1">Comptes</p>
                        <h2 class="h4 mb-0">Gestion des comptes clients</h2>
                    </div>
                    <span class="badge text-bg-light border">{{ $clients->total() }} client(s)</span>
                </div>
            </div>

            <div class="list-group list-group-flush">
                @forelse ($clients as $client)
                    <div class="list-group-item py-4">
                        <div class="d-flex justify-content-between flex-column flex-lg-row align-items-lg-center gap-3">
                            <div>
                                <div class="d-flex align-items-center flex-wrap gap-2 mb-2">
                                    <h5 class="mb-0">{{ trim(($client->prenom ?? '').' '.$client->nom) }}</h5>
                                    <span class="badge {{ $client->statut === 'actif' ? 'text-bg-success' : ($client->statut === 'bloque' ? 'text-bg-danger' : 'text-bg-secondary') }}">
                                        {{ $client->statut === 'actif' ? 'Actif' : ($client->statut === 'bloque' ? 'Bloqué' : 'Inactif') }}
                                    </span>
                                </div>
                                <p class="mb-1 text-muted">{{ $client->email }}</p>
                                @if ($client->telephone)
                                    <p class="mb-0 text-muted">{{ $client->telephone }}</p>
                                @endif
                            </div>

                            <form
                                method="POST"
                                action="{{ route('admin.clients.update-status', $client) }}"
                                onsubmit="return confirm('Confirmer cette action sur le compte client ?');"
                            >
                                @csrf
                                @method('PATCH')
                                <input
                                    type="hidden"
                                    name="statut"
                                    value="{{ $client->statut === 'bloque' ? 'actif' : 'bloque' }}"
                                >
                                <button
                                    type="submit"
                                    class="btn {{ $client->statut === 'bloque' ? 'btn-outline-dark' : 'btn-dark' }} btn-sm"
                                >
                                    {{ $client->statut === 'bloque' ? 'Débloquer le compte' : 'Bloquer le compte' }}
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="p-5 text-center">
                        <h4 class="mb-2">Aucun compte client</h4>
                        <p class="text-muted mb-0">Les comptes clients apparaîtront ici après leur inscription.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="mt-4">
            {{ $clients->links() }}
        </div>
    </main>
</body>
</html>
