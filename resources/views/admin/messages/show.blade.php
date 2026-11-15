<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $message->sujet }} - Zahira Nour</title>
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
                <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-dark btn-sm">Retour</a>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        @if (session('success'))
            <div class="alert alert-success mb-4">{{ session('success') }}</div>
        @endif

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <p class="eyebrow mb-1">Message</p>
                                <h2 class="h4 mb-0">{{ $message->sujet }}</h2>
                            </div>
                            <span class="badge text-bg-secondary text-uppercase">{{ str_replace('_', ' ', $message->statut) }}</span>
                        </div>

                        <div class="bg-light rounded p-3 mb-4">
                            <div class="d-flex justify-content-between flex-wrap gap-2 mb-2">
                                <strong>{{ $message->prenom }} {{ $message->nom }}</strong>
                                <span class="text-muted small">{{ $message->email }}</span>
                            </div>
                            <p class="mb-0">{{ $message->contenu }}</p>
                        </div>

                        @forelse ($message->reponses as $reponse)
                            <div class="border rounded p-3 mb-3 bg-success-subtle">
                                <div class="d-flex justify-content-between flex-wrap gap-2 mb-2">
                                    <strong>{{ optional($reponse->admin?->user)->name ?? 'Administrateur' }}</strong>
                                    <span class="small text-success">Réponse</span>
                                </div>
                                <p class="mb-0">{{ $reponse->contenu }}</p>
                            </div>
                        @empty
                            <p class="text-muted mb-0">Aucune réponse envoyée pour le moment.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <p class="eyebrow mb-2">Statut</p>
                        <form method="POST" action="{{ route('admin.messages.update', $message) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <select name="statut" class="form-select">
                                    @foreach (['non_lu', 'lu', 'traite'] as $statut)
                                        <option value="{{ $statut }}" @selected($message->statut === $statut)>{{ str_replace('_', ' ', $statut) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-dark w-100">Enregistrer</button>
                        </form>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <p class="eyebrow mb-2">Répondre</p>
                        <form method="POST" action="{{ route('admin.messages.reply', $message) }}">
                            @csrf
                            <div class="mb-3">
                                <textarea name="contenu" rows="5" class="form-control" placeholder="Saisissez votre réponse..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Envoyer la réponse</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
