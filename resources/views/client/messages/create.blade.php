<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacter Zahira Nour</title>
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
        <section class="mb-4">
            <p class="text-uppercase small fw-semibold text-secondary mb-2">Nous contacter</p>
            <h1 class="display-5 fw-semibold mb-2">Nouveau message</h1>
            <p class="text-secondary mb-0">Envoyez-nous votre question, notre équipe vous répondra dès que possible.</p>
        </section>

        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <p class="fw-semibold mb-2">Vérifiez les informations suivantes :</p>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="card border-0 shadow-sm">
            <div class="card-body p-4 p-lg-5">
                <form method="POST" action="{{ route('client.messages.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="sujet" class="form-label">Sujet</label>
                        <input
                            type="text"
                            name="sujet"
                            id="sujet"
                            value="{{ old('sujet') }}"
                            class="form-control @error('sujet') is-invalid @enderror"
                            maxlength="255"
                            required
                            autofocus
                        >
                        @error('sujet')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="contenu" class="form-label">Votre message</label>
                        <textarea
                            name="contenu"
                            id="contenu"
                            rows="7"
                            class="form-control @error('contenu') is-invalid @enderror"
                            maxlength="10000"
                            required
                        >{{ old('contenu') }}</textarea>
                        @error('contenu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Maximum 10 000 caractères.</div>
                    </div>
                    <div class="d-flex flex-column flex-sm-row gap-2">
                        <button type="submit" class="btn btn-dark">Envoyer le message</button>
                        <a href="{{ route('client.messages.index') }}" class="btn btn-outline-dark">Annuler</a>
                    </div>
                </form>
            </div>
        </section>
    </main>
</body>
</html>