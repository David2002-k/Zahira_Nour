<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta-description', 'Découvrez Zahira Nour et sa sélection de cadeaux.')">
    <title>@yield('title', 'Zahira Nour')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="public-layout bg-light">
    <header class="border-bottom bg-white">
        <nav class="container d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 py-3" aria-label="Navigation principale">
            <a class="public-brand navbar-brand mb-0 fw-semibold text-dark text-decoration-none" href="{{ url('/') }}">
                <img src="{{ asset('front-end/images/zahira-nour-logo.jpeg') }}" alt="" class="public-brand-logo">
                <span>Zahira Nour</span>
            </a>

            <div class="d-flex flex-wrap gap-3">
                <a class="link-dark text-decoration-none" href="{{ url('/') }}">Accueil</a>
                <a class="link-dark text-decoration-none" href="{{ route('public.boutique') }}">Boutique</a>
                <a class="link-dark text-decoration-none" href="{{ route('public.pourquoi-nous') }}">Pourquoi nous</a>
                <a class="link-dark text-decoration-none" href="{{ route('public.temoignages') }}">Témoignages</a>
                <a class="link-dark text-decoration-none" href="{{ route('public.contact') }}">Contact</a>
            </div>

            <div class="d-flex flex-wrap gap-2">
                @if (Auth::check())
                    @if (Auth::user()->role === 'admin')
                        <a class="btn btn-outline-dark btn-sm" href="{{ route('admin.dashboard') }}">Mon tableau de bord</a>
                    @else
                        <a class="btn btn-outline-dark btn-sm" href="{{ route('client.dashboard') }}">Mon espace</a>
                    @endif
                @else
                    <a class="btn btn-outline-dark btn-sm" href="{{ route('login') }}">Se connecter</a>
                    <a class="btn btn-dark btn-sm" href="{{ route('register') }}">Créer un compte</a>
                @endif
            </div>
        </nav>
    </header>

    @yield('content')

    <footer class="border-top bg-white py-4">
        <div class="container d-flex flex-column flex-sm-row justify-content-between gap-2 text-secondary">
            <span>&copy; {{ now()->year }} Zahira Nour</span>
            <a href="{{ url('/') }}" class="link-dark">Retour à l’accueil</a>
        </div>
    </footer>
</body>

</html>
