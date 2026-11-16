<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes messages - Zahira Nour</title>
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
            <p class="text-uppercase small fw-semibold text-secondary mb-2">Votre espace</p>
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3">
                <div>
                    <h1 class="display-5 fw-semibold mb-2">Mes messages</h1>
                    <p class="text-secondary mb-0">Retrouvez vos échanges avec l’équipe Zahira Nour.</p>
                </div>
                <a href="{{ route('client.messages.create') }}" class="btn btn-dark">Nouveau message</a>
            </div>
        </section>

        @if (session('success'))
            <div class="alert alert-success" role="status">{{ session('success') }}</div>
        @endif

        @if ($messages->isEmpty())
            <section class="card border-0 shadow-sm text-center">
                <div class="card-body p-5">
                    <h2 class="h4 mb-2">Aucun message pour le moment</h2>
                    <p class="text-secondary mb-4">Si vous avez une question, nous sommes à votre écoute.</p>
                    <a href="{{ route('client.messages.create') }}" class="btn btn-dark">Nous écrire</a>
                </div>
            </section>
        @else
            <section class="card border-0 shadow-sm" aria-label="Historique des messages">
                <div class="list-group list-group-flush">
                    @foreach ($messages as $message)
                        <article class="list-group-item p-4">
                            <div class="d-flex flex-column flex-sm-row justify-content-between gap-2">
                                <div>
                                    <div class="d-flex align-items-center flex-wrap gap-2 mb-2">
                                        <h2 class="h5 mb-0">
                                            <a href="{{ route('client.messages.show', $message) }}" class="link-dark text-decoration-none">{{ $message->sujet }}</a>
                                        </h2>
                                        <span class="badge text-bg-light border text-dark">{{ ucfirst(str_replace('_', ' ', $message->statut)) }}</span>
                                        @if ($message->reponses_count > 0)
                                            <span class="badge text-bg-success">Réponse reçue</span>
                                        @endif
                                    </div>
                                    <p class="text-secondary mb-2">{{ \Illuminate\Support\Str::limit($message->contenu, 180) }}</p>
                                    <span class="small text-secondary">
                                        {{ $message->reponses_count }} {{ $message->reponses_count === 1 ? 'réponse' : 'réponses' }}
                                    </span>
                                </div>
                                <div class="d-flex align-items-start align-items-sm-end flex-column gap-2">
                                    <span class="small text-secondary text-nowrap">{{ $message->created_at?->format('d/m/Y') ?? '—' }}</span>
                                    <form method="POST" action="{{ route('client.messages.destroy', $message) }}" onsubmit="return confirm('Voulez-vous supprimer ce message ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">Supprimer</button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
            <div class="d-flex justify-content-center mt-4">
                {{ $messages->links() }}
            </div>
        @endif
    </main>
</body>
</html>