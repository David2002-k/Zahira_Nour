<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $message->sujet }} - Zahira Nour</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="client-dashboard">
    <nav class="dashboard-nav navbar navbar-expand-lg">
        <div class="container py-3">
            <a class="brand-mark navbar-brand fw-semibold" href="{{ route('client.dashboard') }}">Zahira Nour</a>
            <div class="d-flex align-items-center gap-2 gap-sm-3 ms-auto">
                <a href="{{ route('client.messages.index') }}" class="btn btn-outline-dark btn-sm">Mes messages</a>
                <a href="{{ route('client.dashboard') }}" class="btn btn-outline-dark btn-sm">Mon espace</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-dark btn-sm">Déconnexion</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        <p class="mb-4"><a href="{{ route('client.messages.index') }}" class="link-dark">← Retour à mes messages</a></p>
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-start gap-3 mb-4">
            <div>
                <p class="text-uppercase small fw-semibold text-secondary mb-2">Conversation</p>
                <h1 class="h2 fw-semibold mb-1">{{ $message->sujet }}</h1>
                <p class="small text-secondary mb-0">Envoyé le {{ $message->created_at?->format('d/m/Y à H:i') ?? '—' }}</p>
            </div>
            <div class="d-flex align-items-sm-end flex-column gap-2">
                <span class="badge text-bg-light border text-dark">{{ ucfirst(str_replace('_', ' ', $message->statut)) }}</span>
                <form method="POST" action="{{ route('client.messages.destroy', $message) }}" onsubmit="return confirm('Voulez-vous supprimer ce message ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm">Supprimer le message</button>
                </form>
            </div>
        </div>

        <section class="card border-0 shadow-sm mb-4" aria-label="Contenu du message">
            <div class="card-body p-4">
                <p class="small text-secondary mb-2">Votre message</p>
                <div class="text-break" style="white-space: pre-line;">{{ $message->contenu }}</div>
            </div>
        </section>

        <section aria-labelledby="reponses-title">
            <h2 id="reponses-title" class="h4 mb-3">Réponses de notre équipe</h2>
            @if ($message->reponses->isNotEmpty())
                <div class="alert alert-success" role="status">
                    Vous avez reçu {{ $message->reponses->count() === 1 ? 'une réponse' : $message->reponses->count().' réponses' }} de notre équipe.
                </div>
            @endif
            @forelse ($message->reponses as $reponse)
                <article class="card border-0 shadow-sm mb-3">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between flex-wrap gap-2 mb-2">
                            <strong>{{ trim(($reponse->admin?->user?->prenom ?? '').' '.($reponse->admin?->user?->nom ?? '')) ?: 'Équipe Zahira Nour' }}</strong>
                            <span class="small text-secondary">{{ $reponse->created_at?->format('d/m/Y à H:i') ?? '' }}</span>
                        </div>
                        <div class="text-break" style="white-space: pre-line;">{{ $reponse->contenu }}</div>
                    </div>
                </article>
            @empty
                <div class="alert alert-light border mb-0">
                    Nous n’avons pas encore répondu à votre message. Vous serez informé dès que notre équipe vous répondra.
                </div>
            @endforelse
        </section>
    </main>
</body>
</html>