<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Zahira Nour</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="Dashboard-shell">
    <nav class="dashboard-nav navbar navbar-expand-lg">
        <div class="container py-3">
            <a class="brand-mark navbar-brand" href="{{ route('client.dashboard') }}">Zahira Nour</a>
            <div class="d-flex align-items-center gap-3 ms-auto">
                <span class="d-none d-sm-inline text-secondary">{{ auth()->user()->email }}</span>
                <a href="{{ route('profile.edit') }}" class="btn btn-outline-dark btn-sm d-inline-flex align-items-center" aria-label="Modifier mes informations" title="Modifier mes informations">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M12.854.146a.5.5 0 0 0-.708 0L3 9.293V13h3.707l9.146-9.146a.5.5 0 0 0 0-.708l-3-3zM4 10l7.5-7.5 2 2L6 12H4v-2z" />
                        <path fill-rule="evenodd" d="M1.5 15a.5.5 0 0 1-.5-.5v-3a.5.5 0 0 1 1 0V14h2.5a.5.5 0 0 1 0 1h-3z" />
                    </svg>
                    <span class="visually-hidden">Modifier mes informations</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-dark btn-sm">Déconnexion</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        <section class="mb-5">
            <p class="eyebrow mb-3">Tableau de bord</p>
            <h1 class="hero-title mb-3">Bonjour, <em>{{ auth()->user()->prenom }}</em>.</h1>
            <p class="lead text-secondary mb-0">Votre espace est prête à être gérée.</p>
        </section>

        <section class="dashboard-summary row g-3 mb-5" aria-label="Statistiques du site">
            <div class="col-12 col-sm-6 col-lg-3">
                <article class="stat-card h-100 p-3">
                    <p class="stat-label mb-2">Messages non lus</p>
                    <p class="stat-value mb-1">#</p>
                    <span class="text-success small">A consulter rapidement</span>
                </article>
            </div> 
            <div class="col-12 col-sm-6 col-lg-3">
                <article class="stat-card h-100 p-3">
                    <p class="stat-label mb-2">Produits commandés</p>
                    <p class="stat-value mb-1">#</p>
                    <span class="text-success small">#</span>
                </article>
            </div>    
        </section>

        <section class="dashboard-activity row g-4 align-items-stretch">
            <div class="col-12 col-lg-7">
                <div class="activity-panel h-100 p-4 p-lg-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="h4 mb-0">Bienvenue dans votre atelier</h2>
                        <span class="badge rounded-pill text-bg-success">En ligne</span>
                    </div>
                    <p class="text-secondary mb-4">Votre espace est prêt. Commencez par gérer votre panier.</p>
                </div>
            </div>
        </section>   
    </main>      
                    

</body>
</html>