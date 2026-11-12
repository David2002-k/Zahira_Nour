<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catégories - Zahira Nour</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="Dashboard-shell">
    <nav class="dashboard-nav navbar navbar-expand-lg">
        <div class="container py-3">
            <a class="brand-mark navbar-brand" href="{{ route('admin.dashboard') }}">Zahira Nour</a>
            <div class="d-flex align-items-center gap-3 ms-auto">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark btn-sm">Retour au tableau de bord</a>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-dark btn-sm">Ajouter</a>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        @if (session('success'))
            <div class="alert alert-success mb-4">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger mb-4">{{ session('error') }}</div>
        @endif

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <p class="eyebrow mb-1">Organisation</p>
                        <h2 class="h4 mb-0">Gestion des catégories</h2>
                    </div>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-dark">Ajouter une catégorie</a>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                @if ($categories->isNotEmpty())
                    @foreach ($categories as $categorie)
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 border-bottom px-4 py-4">
                            <div>
                                <h4 class="mb-1">{{ $categorie->nom }}</h4>
                                <p class="text-muted mb-1">{{ $categorie->description ?: 'Aucune description' }}</p>
                                <small class="text-uppercase text-secondary">{{ $categorie->produits_count ?? 0 }} produit(s)</small>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.categories.edit', $categorie) }}" class="btn btn-outline-warning btn-sm">Modifier</a>
                                <form method="POST" action="{{ route('admin.categories.destroy', $categorie) }}" onsubmit="return confirm('Voulez-vous vraiment supprimer cette catégorie ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Supprimer</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="p-5 text-center">
                        <h4 class="mb-2">Aucune catégorie</h4>
                        <p class="text-muted">Créez une catégorie pour organiser vos produits.</p>
                    </div>
                @endif
            </div>
        </div>
    </main>
</body>
</html>
