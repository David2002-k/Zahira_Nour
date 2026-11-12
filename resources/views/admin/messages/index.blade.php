<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages - Zahira Nour</title>
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
                        <p class="eyebrow mb-1">Messages</p>
                        <h2 class="h4 mb-0">Boîte de réception</h2>
                    </div>
                    <span class="badge text-bg-light border">{{ $messages->total() }} message(s)</span>
                </div>
            </div>

            <div class="list-group list-group-flush">
                @forelse ($messages as $message)
                    <div class="list-group-item py-4">
                        <div class="d-flex justify-content-between flex-column flex-lg-row gap-3">
                            <div>
                                <div class="d-flex align-items-center flex-wrap gap-2 mb-2">
                                    <h5 class="mb-0">{{ $message->sujet }}</h5>
                                    <span class="badge text-bg-secondary text-uppercase">{{ str_replace('_', ' ', $message->statut) }}</span>
                                </div>
                                <p class="mb-1 text-muted">{{ $message->prenom }} {{ $message->nom }}</p>
                                <p class="mb-1 text-muted">{{ $message->email }}</p>
                                <p class="mb-0 text-muted">{{ Str::limit($message->contenu, 120) }}</p>
                            </div>
                            <a href="{{ route('admin.messages.show', $message) }}" class="btn btn-dark btn-sm align-self-start">Voir</a>
                        </div>
                    </div>
                @empty
                    <div class="p-5 text-center">
                        <h4 class="mb-2">Aucun message</h4>
                        <p class="text-muted">La boîte de réception est vide pour le moment.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="mt-4">
            {{ $messages->links() }}
        </div>
    </main>
</body>
</html>
