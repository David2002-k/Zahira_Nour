<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réseaux sociaux - Zahira Nour</title>
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

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <p class="eyebrow mb-2">Réseaux sociaux</p>
                        <h2 class="mb-4">Ajouter un réseau</h2>

                        <form method="POST" action="{{ route('admin.reseaux-sociaux.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom</label>
                                <input id="nom" name="nom" type="text" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="url" class="form-label">URL</label>
                                <input id="url" name="url" type="url" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="icone" class="form-label">Icône</label>
                                <input id="icone" name="icone" type="text" class="form-control" placeholder="facebook, instagram, ...">
                            </div>
                            <button type="submit" class="btn btn-dark w-100">Ajouter</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        <div class="border-bottom px-4 py-3">
                            <p class="eyebrow mb-1">Liste</p>
                            <h3 class="h4 mb-0">Réseaux actifs</h3>
                        </div>

                        @forelse ($reseauxSociaux as $reseau)
                            <div class="border-bottom px-4 py-4">
                                <div class="d-flex flex-column flex-xl-row justify-content-between gap-3">
                                    <div>
                                        <h5 class="mb-1">{{ $reseau->nom }}</h5>
                                        <p class="text-muted mb-1">{{ $reseau->url }}</p>
                                        <p class="mb-0 small text-uppercase text-secondary">{{ $reseau->icone ?: 'Aucune icône' }}</p>
                                    </div>

                                    <div class="d-flex flex-wrap gap-2">
                                        <form method="POST" action="{{ route('admin.reseaux-sociaux.update', $reseau) }}" class="d-flex flex-wrap gap-2">
                                            @csrf
                                            @method('PUT')
                                            <input type="text" name="nom" value="{{ $reseau->nom }}" class="form-control form-control-sm" style="min-width: 120px;">
                                            <input type="url" name="url" value="{{ $reseau->url }}" class="form-control form-control-sm" style="min-width: 180px;">
                                            <input type="text" name="icone" value="{{ $reseau->icone }}" class="form-control form-control-sm" style="min-width: 120px;">
                                            <button type="submit" class="btn btn-outline-dark btn-sm">Modifier</button>
                                        </form>

                                        <form method="POST" action="{{ route('admin.reseaux-sociaux.destroy', $reseau) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Supprimer ce réseau social ?')">Supprimer</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-5 text-center">
                                <h4 class="mb-2">Aucun réseau social</h4>
                                <p class="text-muted">Ajoutez vos liens pour développer votre présence.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            {{ $reseauxSociaux->links() }}
        </div>
    </main>
</body>
</html>
