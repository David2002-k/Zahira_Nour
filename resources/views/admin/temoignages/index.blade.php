<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Témoignages - Zahira Nour</title>
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
            <div class="alert alert-success mb-4">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body border-bottom">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <p class="eyebrow mb-1">Témoignages</p>
                        <h2 class="h4 mb-0">Modération des avis</h2>
                    </div>
                    <span class="badge text-bg-light border">{{ $temoignages->total() }} témoignage(s)</span>
                </div>
            </div>

            <div class="list-group list-group-flush">
                @forelse ($temoignages as $temoignage)
                    <div class="list-group-item py-4">
                        <div class="d-flex justify-content-between flex-column flex-lg-row gap-3">
                            <div>
                                <div class="d-flex align-items-center flex-wrap gap-2 mb-2">
                                    <h5 class="mb-0">{{ optional($temoignage->client?->user)->nom ?? 'Client' }}</h5>
                                    <span class="badge text-bg-secondary text-uppercase">{{ str_replace('_', ' ', $temoignage->statut) }}</span>
                                </div>
                                <p class="mb-2 text-secondary">{{ $temoignage->contenu }}</p>
                                <p class="mb-0 small text-muted">{{ $temoignage->date_publication?->format('d/m/Y H:i') ?? 'Non publié' }}</p>
                            </div>

                            <form method="POST" action="{{ route('admin.temoignages.update', $temoignage) }}" class="d-flex align-items-center gap-2 flex-wrap">
                                @csrf
                                @method('PUT')
                                <select name="statut" class="form-select form-select-sm">
                                    @foreach (['en_attente', 'approuve', 'rejete'] as $statut)
                                        <option value="{{ $statut }}" @selected($temoignage->statut === $statut)>
                                            {{ str_replace('_', ' ', $statut) }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-outline-dark btn-sm">Valider</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="p-5 text-center">
                        <h4 class="mb-2">Aucun témoignage</h4>
                        <p class="text-muted">Les avis clients apparaîtront ici lors de leur publication.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="mt-4">
            {{ $temoignages->links() }}
        </div>
    </main>
</body>
</html>
