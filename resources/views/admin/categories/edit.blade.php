<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une catégorie - Zahira Nour</title>
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
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-dark btn-sm">Retour</a>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4 p-lg-5">
                        <h2 class="mb-4">Modifier la catégorie</h2>

                        <form method="POST" action="{{ route('admin.categories.update', $categorie) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom de la catégorie</label>
                                <input id="nom" name="nom" type="text" class="form-control" value="{{ old('nom', $categorie->nom) }}" required autofocus>
                                @error('nom')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="description" class="form-label">Description</label>
                                <textarea id="description" name="description" rows="5" class="form-control">{{ old('description', $categorie->description) }}</textarea>
                                @error('description')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-dark">Enregistrer</button>
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Annuler</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
