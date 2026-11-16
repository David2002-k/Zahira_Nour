<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Zahira Nour</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="client-dashboard">
    <nav class="dashboard-nav navbar navbar-expand-lg">
        <div class="container py-3">
            <a class="brand-mark navbar-brand fw-semibold" href="{{ route('client.dashboard') }}">Zahira Nour</a>
            <div class="d-flex align-items-center gap-2 gap-sm-3 ms-auto">
                <span class="d-none d-sm-inline text-secondary">{{ auth()->user()->prenom ?: auth()->user()->nom }}</span>
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
        <section class="card border-0 shadow-sm mb-5" aria-labelledby="dashboard-title">
            <div class="card-body p-4 p-lg-5">
                <p class="text-uppercase small fw-semibold text-secondary mb-2">Espace client</p>
                <h1 id="dashboard-title" class="display-5 fw-semibold mb-3">Bonjour, {{ auth()->user()->prenom ?: auth()->user()->nom }}.</h1>
                <p class="lead text-secondary mb-0">Retrouvez ici vos commandes et les informations de votre compte.</p>
            </div>
        </section>

        <section class="dashboard-summary row g-3 mb-5" aria-label="Résumé de votre activité">
            <div class="col-12 col-sm-6 col-lg-3">
                <article class="card h-100 shadow-sm">
                    <div class="card-body">
                        <p class="text-secondary small text-uppercase fw-semibold mb-2">Commandes en cours</p>
                        <p class="display-6 fw-semibold mb-1">{{ $commandesEnCours }}</p>
                        <a href="{{ route('client.commandes.index') }}" class="small">Suivre mes commandes</a>
                    </div>
                </article>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <article class="card h-100 shadow-sm">
                    <div class="card-body">
                        <p class="text-secondary small text-uppercase fw-semibold mb-2">Commandes au total</p>
                        <p class="display-6 fw-semibold mb-1">{{ $totalCommandes }}</p>
                        <a href="{{ route('client.commandes.index') }}" class="small">Voir mon historique</a>
                    </div>
                </article>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <article class="card h-100 shadow-sm">
                    <div class="card-body">
                        <p class="text-secondary small text-uppercase fw-semibold mb-2">Messages envoyés</p>
                        <p class="display-6 fw-semibold mb-1">{{ $messagesEnvoyes }}</p>
                        <a href="{{ route('client.messages.index') }}" class="small">Accéder à mes messages</a>
                    </div>
                </article>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <article class="card h-100 shadow-sm">
                    <div class="card-body">
                        <p class="text-secondary small text-uppercase fw-semibold mb-2">Messages avec réponse</p>
                        <p class="display-6 fw-semibold mb-1">{{ $messagesAvecReponse }}</p>
                        <a href="{{ route('client.messages.index') }}" class="small">Voir les réponses reçues</a>
                    </div>
                </article>
            </div>
        </section>

        <section class="dashboard-activity row g-4 align-items-stretch" aria-label="Commandes et actions rapides">
            <div class="col-12 col-lg-7">
                <div class="card h-100 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center gap-3 mb-4">
                            <h2 class="h4 mb-0">Mes commandes récentes</h2>
                            <a href="{{ route('client.commandes.index') }}" class="btn btn-outline-dark btn-sm">Tout voir</a>
                        </div>

                        @if ($commandesRecentes->isEmpty())
                            <div class="text-center py-4">
                                <p class="text-secondary mb-3">Vous n’avez pas encore passé de commande.</p>
                                <a href="{{ route('client.boutique.index') }}" class="btn btn-dark">Découvrir la boutique</a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Commande</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Montant</th>
                                            <th scope="col">Statut</th>
                                            <th scope="col"><span class="visually-hidden">Détails</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($commandesRecentes as $commande)
                                            <tr>
                                                <th scope="row" class="text-nowrap">{{ $commande->numero_commande }}</th>
                                                <td class="text-nowrap">{{ $commande->date_commande->format('d/m/Y') }}</td>
                                                <td class="text-nowrap">{{ number_format((float) $commande->montant_total, 2, ',', ' ') }} FCFA</td>
                                                <td>
                                                    <span class="badge text-bg-light border text-dark">
                                                        {{ [
                                                            'en_attente' => 'En attente',
                                                            'confirmee' => 'Confirmée',
                                                            'en_preparation' => 'En préparation',
                                                            'expediee' => 'Expédiée',
                                                            'livree' => 'Livrée',
                                                            'annulee' => 'Annulée',
                                                        ][$commande->statut] ?? ucfirst(str_replace('_', ' ', $commande->statut)) }}
                                                    </span>
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('client.commandes.show', $commande) }}" class="btn btn-outline-dark btn-sm">Détails</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-5">
                <div class="card h-100 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="h4 mb-3">Raccourcis</h2>
                        <p class="text-secondary mb-4">Accédez rapidement aux services de votre espace client.</p>

                        <div x-data="{ open: false }">
                            <button
                                class="btn btn-dark w-100"
                                type="button"
                                @click="open = !open"
                                :aria-expanded="open.toString()"
                                aria-controls="clientQuickActions"
                            >
                                <span x-text="open ? 'Masquer les actions' : 'Afficher les actions'"></span>
                            </button>
                            <div x-show="open" x-transition id="clientQuickActions" class="d-flex flex-column gap-2 mt-3">
                                <a href="{{ route('client.boutique.index') }}" class="btn btn-outline-dark">Découvrir la boutique</a>
                                <a href="{{ route('client.panier.index') }}" class="btn btn-outline-dark">Voir mon panier</a>
                                <a href="{{ route('client.commandes.index') }}" class="btn btn-outline-dark">Suivre mes commandes</a>
                                <a href="{{ route('client.paiements.index') }}" class="btn btn-outline-dark">Consulter mes paiements</a>
                                <a href="{{ route('client.messages.index') }}" class="btn btn-outline-dark">Mes messages</a>
                                <a href="{{ route('client.temoignages.index') }}" class="btn btn-outline-dark">Mes témoignages</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>