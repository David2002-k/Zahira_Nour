<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes témoignages - Zahira Nour</title>
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
            <p class="text-uppercase small fw-semibold text-secondary mb-2">Votre expérience compte</p>
            <h1 class="display-5 fw-semibold mb-2">Mes témoignages</h1>
            <p class="text-secondary mb-0">Partagez votre expérience et consultez vos témoignages précédents.</p>
        </section>

        @if (session('success'))
            <div class="alert alert-success" role="status">{{ session('success') }}</div>
        @endif

        @if ($errors->has('temoignage'))
            <div class="alert alert-danger" role="alert">{{ $errors->first('temoignage') }}</div>
        @endif

        <section class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h2 class="h5 mb-3">Laisser un témoignage</h2>
                <form method="POST" action="{{ route('client.temoignages.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="contenu" class="form-label">Votre expérience avec Zahira Nour</label>
                        <textarea
                            name="contenu"
                            id="contenu"
                            rows="4"
                            maxlength="5000"
                            class="form-control @error('contenu') is-invalid @enderror"
                            required
                        >{{ old('contenu') }}</textarea>
                        @error('contenu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Votre témoignage sera soumis à validation avant publication.</div>
                    </div>
                    <button type="submit" class="btn btn-dark">Envoyer mon témoignage</button>
                </form>
            </div>
        </section>

        <section aria-labelledby="historique-title">
            <div class="d-flex justify-content-between align-items-end gap-3 mb-3">
                <h2 id="historique-title" class="h4 mb-0">Mes publications</h2>
                <span class="small text-secondary">{{ $temoignages->total() }} {{ $temoignages->total() === 1 ? 'témoignage' : 'témoignages' }}</span>
            </div>

            @if ($temoignages->isEmpty())
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 text-secondary">Vous n’avez pas encore publié de témoignage.</div>
                </div>
            @else
                <div class="d-flex flex-column gap-3">
                    @foreach ($temoignages as $temoignage)
                        <article class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="d-flex flex-column flex-sm-row justify-content-between gap-2 mb-3">
                                    <span class="badge text-bg-light border text-dark align-self-start">{{ ucfirst(str_replace('_', ' ', $temoignage->statut)) }}</span>
                                    <span class="small text-secondary">
                                        {{ $temoignage->date_publication?->format('d/m/Y') ?? 'Envoyé le '.$temoignage->created_at?->format('d/m/Y') }}
                                    </span>
                                </div>

                                @if ($temoignage->statut === 'en_attente')
                                    <div class="d-flex flex-wrap gap-2">
                                        <form method="POST" action="{{ route('client.temoignages.update', $temoignage) }}" class="d-flex flex-column align-items-start gap-3">
                                            @csrf
                                            @method('PUT')
                                            <div>
                                                <label for="temoignage-{{ $temoignage->id }}" class="form-label">Modifier votre témoignage</label>
                                                <textarea
                                                    name="contenu"
                                                    id="temoignage-{{ $temoignage->id }}"
                                                    rows="3"
                                                    maxlength="5000"
                                                    class="form-control @error('contenu') is-invalid @enderror"
                                                    required
                                                >{{ old('contenu', $temoignage->contenu) }}</textarea>
                                                @error('contenu')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <button type="submit" class="btn btn-outline-dark btn-sm">Enregistrer</button>
                                        </form>
                                        <form method="POST" action="{{ route('client.temoignages.destroy', $temoignage) }}" onsubmit="return confirm('Voulez-vous supprimer ce témoignage ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">Supprimer</button>
                                        </form>
                                    </div>
                                @else
                                    <p class="mb-0" style="white-space: pre-line;">{{ $temoignage->contenu }}</p>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $temoignages->links() }}
                </div>
            @endif
        </section>
    </main>
</body>
</html>