<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Zahira Nour</title>
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
        <section class="dashboard-hero mb-5">
            <p class="eyebrow mb-3">Espace administration</p>
            <h1 class="hero-title mb-3">Bonjour, <em>{{ auth()->user()->prenom }}</em>.</h1>
            <p class="lead text-secondary mb-0">Votre boutique est prête à être gérée.</p>
        </section>

        <section class="dashboard-summary row g-3 mb-5" aria-label="Statistiques du site">
            <div class="col-12 col-sm-6 col-lg-3">
                <article class="stat-card h-100 p-3">
                    <p class="stat-label mb-2">Produits</p>
                    <p class="stat-value mb-1">{{ $produitsTotal }}</p>
                    <span class="text-success small">Catalogue actif</span>
                </article>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <a class="stat-card h-100 p-3 d-block text-decoration-none" href="{{ route('admin.clients.index') }}">
                    <p class="stat-label mb-2">Clients</p>
                    <p class="stat-value mb-1">{{ $totalClients }}</p>
                    <span class="text-secondary small">Comptes clients à gérer</span>
                </a>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <article class="stat-card h-100 p-3">
                    <p class="stat-label mb-2">Commandes reçues</p>
                    <p class="stat-value mb-1">{{ $commandesEnAttente }}</p>
                    <span class="text-secondary small">À traiter depuis votre espace</span>
                </article>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <article class="stat-card h-100 p-3">
                    <p class="stat-label mb-2">Témoignages</p>
                    <p class="stat-value mb-1">{{ $temoignagesEnAttente }}</p>
                    <span class="text-secondary small">La voix de vos clients</span>
                </article>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <article class="stat-card h-100 p-3">
                    <p class="stat-label mb-2">Messages non lus</p>
                    <p class="stat-value mb-1">{{ $messagesNonLus }}</p>
                    <span class="text-secondary small">À consulter rapidement</span>
                </article>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <article class="stat-card h-100 p-3">
                    <p class="stat-label mb-2">Montant payé</p>
                    <p class="stat-value mb-1">{{ number_format($montantPaye ?? 0, 2, ',', ' ') }} Fcfa</p>
                    <span class="text-secondary small">Encaissements validés</span>
                </article>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <article class="stat-card h-100 p-3">
                    <p class="stat-label mb-2">Produits en rupture</p>
                    <p class="stat-value mb-1">{{ $produitsEnRupture }}</p>
                    <span class="text-secondary small"> à réapprovisionner</span>
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
                    <p class="text-secondary mb-4">Votre espace est prêt. Commencez par enrichir votre boutique ou consultez les dernières commandes.</p>
                    <div x-data="{ open: false }" class="mt-4">
                        <button
                            class="btn btn-coral px-4"
                            type="button"
                            @click="open = !open"
                            :aria-expanded="open.toString()"
                            aria-controls="quickActions"
                        >
                            <span x-text="open ? 'Masquer les actions rapides' : 'Afficher les actions rapides'"></span>
                        </button>
                        <div x-show="open" x-transition id="quickActions" class="mt-4" aria-label="Actions rapides">
                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('admin.clients.index') }}" class="btn btn-outline-dark">Gérer les comptes clients</a>
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-dark">Gérer les catégories</a>
                                <a href="{{ route('admin.produits.index') }}" class="btn btn-outline-dark">Gérer les produits</a>
                                <a href="{{ route('admin.reseaux-sociaux.index') }}" class="btn btn-outline-dark">Gérer les réseaux sociaux</a>
                                <a href="{{ route('admin.commandes.index') }}" class="btn btn-outline-dark">Voir les commandes</a>
                                <a href="{{ route('admin.paiements.index') }}" class="btn btn-outline-dark">Gérer les paiements</a>
                                <a href="{{ route('admin.temoignages.index') }}" class="btn btn-outline-dark">Modérer les témoignages</a>
                                <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-dark">Ouvrir la boîte de réception</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-5">
                <div class="activity-panel h-100 p-4 p-lg-5">
                    <p class="eyebrow mb-3">Activité récente</p>
                    <div class="activity-item d-flex gap-3 py-3">
                        <span class="activity-dot rounded-circle flex-shrink-0 mt-2"></span>
                        <div><strong>Session ouverte</strong><p class="text-secondary small mb-0">Vous êtes connecté en tant qu’administrateur.</p></div>
                    </div>
                    <div class="activity-item d-flex gap-3 py-3">
                        <span class="activity-dot rounded-circle flex-shrink-0 mt-2"></span>
                        <div><strong>Stock à surveiller</strong><p class="text-secondary small mb-0">{{ $produitsEnRupture }} produit(s) en rupture de stock.</p></div>
                    </div>
                    <div class="activity-item d-flex gap-3 py-3">
                        <span class="activity-dot rounded-circle flex-shrink-0 mt-2"></span>
                        <div><strong>Tableau de bord prêt</strong><p class="text-secondary small mb-0">Les données sont synchronisées.</p></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="dashboard-chart-section mt-5" aria-labelledby="dashboard-charts-title">
            <div class="mb-4">
                <p class="eyebrow mb-2">Vue d’ensemble</p>
                <h2 id="dashboard-charts-title" class="h3 mb-0">Statistiques de la boutique</h2>
            </div>

            @php
                $chartValues = [$produitsTotal, $commandesEnAttente, $totalClients];
                $chartLabels = ['Produits', 'Commandes', 'Clients'];
                $chartColors = ['#111111', '#777777', '#c7c7c7'];
                $chartStep = max(1, (int) ceil(max($chartValues) / 4));
                $chartMaximum = $chartStep * 4;
                $chartHasData = array_sum($chartValues) > 0;
                $chartPoints = [];

                foreach ($chartValues as $index => $value) {
                    $x = 100 + ($index * 80);
                    $y = 205 - (($value / $chartMaximum) * 180);
                    $chartPoints[] = "{$x},{$y}";
                }

                $pieTotal = array_sum($chartValues);
                $pieSlices = [];
                $startAngle = -M_PI_2;

                if ($pieTotal > 0) {
                    foreach ($chartValues as $index => $value) {
                        if ($value === 0) {
                            continue;
                        }

                        $sweepAngle = ($value / $pieTotal) * 2 * M_PI;
                        $endAngle = $startAngle + $sweepAngle;
                        $startX = 110 + (85 * cos($startAngle));
                        $startY = 120 + (85 * sin($startAngle));
                        $endX = 110 + (85 * cos($endAngle));
                        $endY = 120 + (85 * sin($endAngle));
                        $largeArc = $sweepAngle > M_PI ? 1 : 0;
                        $path = $value === $pieTotal
                            ? null
                            : sprintf(
                                'M 110 120 L %.2f %.2f A 85 85 0 %d 1 %.2f %.2f Z',
                                $startX,
                                $startY,
                                $largeArc,
                                $endX,
                                $endY,
                            );

                        $pieSlices[] = [
                            'label' => $chartLabels[$index],
                            'value' => $value,
                            'color' => $chartColors[$index],
                            'path' => $path,
                        ];
                        $startAngle = $endAngle;
                    }
                }
            @endphp

            @unless ($chartHasData)
            <p class="alert alert-info" role="status">
                Les graphiques sont prêts, mais les statistiques sont à zéro. Ajoutez des produits, des commandes ou des clients pour voir les données.
            </p>
            @endunless

            <div class="row g-4">
                <div class="col-12 col-xl-4">
                    <article class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h3 class="h5 mb-3">Statistiques en barres</h3>
                            <svg id="commandeChart" viewBox="0 0 360 260" width="100%" height="260" style="display: block; max-width: 100%;" role="img" aria-label="Diagramme en barres des produits, commandes et clients">
                                @for ($tick = 0; $tick <= 4; $tick++)
                                    @php
                                        $y = 25 + ($tick * 45);
                                        $tickValue = $chartMaximum - ($tick * $chartStep);
                                    @endphp
                                    <line x1="48" y1="{{ $y }}" x2="340" y2="{{ $y }}" stroke="#e5e5e5" />
                                    <text x="40" y="{{ $y + 4 }}" text-anchor="end" fill="#666666" font-size="11">{{ $tickValue }}</text>
                                @endfor
                                @foreach ($chartValues as $index => $value)
                                    @php
                                        $barHeight = $value === 0 ? 2 : ($value / $chartMaximum) * 180;
                                        $barY = 205 - $barHeight;
                                        $barX = 76 + ($index * 90);
                                    @endphp
                                    <rect x="{{ $barX }}" y="{{ $barY }}" width="48" height="{{ $barHeight }}" rx="5" fill="{{ $chartColors[$index] }}" />
                                    <text x="{{ $barX + 24 }}" y="{{ max(18, $barY - 7) }}" text-anchor="middle" fill="#222222" font-size="12">{{ $value }}</text>
                                    <text x="{{ $barX + 24 }}" y="232" text-anchor="middle" fill="#666666" font-size="11">{{ $chartLabels[$index] }}</text>
                                @endforeach
                            </svg>
                        </div>
                    </article>
                </div>
                <div class="col-12 col-xl-4">
                    <article class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h3 class="h5 mb-3">Statistiques en courbe</h3>
                            <svg id="commandeLineChart" viewBox="0 0 360 260" width="100%" height="260" style="display: block; max-width: 100%;" role="img" aria-label="Courbe des produits, commandes et clients">
                                @for ($tick = 0; $tick <= 4; $tick++)
                                    @php
                                        $y = 25 + ($tick * 45);
                                        $tickValue = $chartMaximum - ($tick * $chartStep);
                                    @endphp
                                    <line x1="48" y1="{{ $y }}" x2="340" y2="{{ $y }}" stroke="#e5e5e5" />
                                    <text x="40" y="{{ $y + 4 }}" text-anchor="end" fill="#666666" font-size="11">{{ $tickValue }}</text>
                                @endfor
                                <polyline points="{{ implode(' ', $chartPoints) }}" fill="none" stroke="#111111" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                                @foreach ($chartValues as $index => $value)
                                    @php
                                        $pointX = 100 + ($index * 80);
                                        $pointY = 205 - (($value / $chartMaximum) * 180);
                                    @endphp
                                    <circle cx="{{ $pointX }}" cy="{{ $pointY }}" r="6" fill="{{ $chartColors[$index] }}" stroke="#ffffff" stroke-width="2" />
                                    <text x="{{ $pointX }}" y="{{ max(18, $pointY - 12) }}" text-anchor="middle" fill="#222222" font-size="12">{{ $value }}</text>
                                    <text x="{{ $pointX }}" y="232" text-anchor="middle" fill="#666666" font-size="11">{{ $chartLabels[$index] }}</text>
                                @endforeach
                            </svg>
                        </div>
                    </article>
                </div>
                <div class="col-12 col-xl-4">
                    <article class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h3 class="h5 mb-3">Répartition</h3>
                            <svg id="commandePieChart" viewBox="0 0 360 240" width="100%" height="240" style="display: block; max-width: 100%;" role="img" aria-label="Diagramme circulaire des produits, commandes et clients">
                                @if ($pieTotal === 0)
                                    <circle cx="110" cy="120" r="85" fill="#eeeeee" />
                                    <text x="110" y="124" text-anchor="middle" fill="#555555" font-size="13">Aucune donnée</text>
                                @else
                                    @foreach ($pieSlices as $index => $slice)
                                        @if ($slice['path'] === null)
                                            <circle cx="110" cy="120" r="85" fill="{{ $slice['color'] }}" />
                                        @else
                                            <path d="{{ $slice['path'] }}" fill="{{ $slice['color'] }}" stroke="#ffffff" stroke-width="2" />
                                        @endif
                                    @endforeach
                                @endif
                                @foreach ($chartLabels as $index => $label)
                                    <rect x="215" y="{{ 68 + ($index * 32) }}" width="12" height="12" rx="3" fill="{{ $chartColors[$index] }}" />
                                    <text x="234" y="{{ 79 + ($index * 32) }}" fill="#555555" font-size="11">{{ $label }} ({{ $chartValues[$index] }})</text>
                                @endforeach
                            </svg>
                        </div>
                    </article>
                </div>
            </div>

            @php
                $montantsCourbePaiements = array_column($courbePaiements, 'montant');
                $maximumCourbePaiements = max(4, (int) ceil(max($montantsCourbePaiements) / 4) * 4);
                $dernierIndexCourbePaiements = max(1, count($courbePaiements) - 1);
                $pointsCourbePaiements = [];

                foreach ($courbePaiements as $index => $point) {
                    $x = 60 + ($index * (640 / $dernierIndexCourbePaiements));
                    $y = 248 - (($point['montant'] / $maximumCourbePaiements) * 220);
                    $pointsCourbePaiements[] = sprintf('%.2f,%.2f', $x, $y);
                }
            @endphp

            <article class="card shadow-sm mt-4">
                <div class="card-body p-4 p-lg-5">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-start gap-3 mb-4">
                        <div>
                            <p class="eyebrow mb-2">Encaissements</p>
                            <h2 id="payments-chart-title" class="h4 mb-2">Revenus des paiements confirmés</h2>
                            <p class="text-secondary mb-0">
                                {{ $periodePaiements === 'semaine' ? '7 derniers jours' : 'Mois en cours' }}
                                — Total : {{ number_format($totalPaiementsPeriode, 2, ',', ' ') }} FCFA
                            </p>
                        </div>
                        <nav class="d-flex flex-wrap gap-2" aria-label="Période de la courbe des paiements">
                            <a
                                href="{{ route('admin.dashboard', ['periode' => 'semaine']) }}"
                                class="btn {{ $periodePaiements === 'semaine' ? 'btn-dark' : 'btn-outline-dark' }}"
                                @if ($periodePaiements === 'semaine') aria-current="page" @endif
                            >
                                7 derniers jours
                            </a>
                            <a
                                href="{{ route('admin.dashboard', ['periode' => 'mois']) }}"
                                class="btn {{ $periodePaiements === 'mois' ? 'btn-dark' : 'btn-outline-dark' }}"
                                @if ($periodePaiements === 'mois') aria-current="page" @endif
                            >
                                Mois en cours
                            </a>
                        </nav>
                    </div>

                    @if ($errors->has('periode'))
                        <p class="alert alert-danger" role="alert">{{ $errors->first('periode') }}</p>
                    @endif

                    @if ($totalPaiementsPeriode === 0.0)
                        <p class="alert alert-info" role="status">Aucun paiement confirmé sur cette période.</p>
                    @endif

                    <svg
                        id="paiementsRevenueChart"
                        viewBox="0 0 720 300"
                        width="100%"
                        height="300"
                        style="display: block; max-width: 100%;"
                        role="img"
                        aria-labelledby="payments-chart-title"
                    >
                        @for ($tick = 0; $tick <= 4; $tick++)
                            @php
                                $y = 28 + ($tick * 55);
                                $montantTick = $maximumCourbePaiements - ($tick * ($maximumCourbePaiements / 4));
                            @endphp
                            <line x1="60" y1="{{ $y }}" x2="700" y2="{{ $y }}" stroke="#e5e5e5" />
                            <text x="52" y="{{ $y + 4 }}" text-anchor="end" fill="#666666" font-size="11">
                                {{ number_format($montantTick, 0, ',', ' ') }}
                            </text>
                        @endfor

                        <polyline
                            points="{{ implode(' ', $pointsCourbePaiements) }}"
                            fill="none"
                            stroke="#111111"
                            stroke-width="4"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />

                        @foreach ($courbePaiements as $index => $point)
                            @php
                                $x = 60 + ($index * (640 / $dernierIndexCourbePaiements));
                                $y = 248 - (($point['montant'] / $maximumCourbePaiements) * 220);
                                $afficherLabel = $periodePaiements === 'semaine'
                                    || $loop->first
                                    || $loop->last
                                    || $index % 7 === 0;
                            @endphp
                            <circle cx="{{ $x }}" cy="{{ $y }}" r="4" fill="#111111" stroke="#ffffff" stroke-width="2">
                                <title>{{ $point['date'] }} : {{ number_format($point['montant'], 2, ',', ' ') }} FCFA</title>
                            </circle>
                            @if ($afficherLabel)
                                <text x="{{ $x }}" y="276" text-anchor="middle" fill="#666666" font-size="11">
                                    {{ $point['label'] }}
                                </text>
                            @endif
                        @endforeach
                    </svg>
                </div>
            </article>
        </section>
    </main>
</body>
</html>
