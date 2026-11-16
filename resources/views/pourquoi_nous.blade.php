@extends('layouts.public')

@section('title', 'Zahira Nour | Pourquoi nous')
@section('meta-description', 'Découvrez l’attention portée à la sélection Zahira Nour.')

@section('content')
    <main class="container py-5">
        <section aria-labelledby="why-title">
            <div class="mx-auto text-center mb-5" style="max-width: 760px">
                <p class="small text-uppercase fw-semibold text-secondary mb-2">Notre engagement</p>
                <h1 id="why-title" class="display-5 fw-semibold mb-3">Pourquoi choisir Zahira Nour ?</h1>
                <p class="lead text-secondary mb-0">Nous souhaitons vous aider à trouver une attention qui fera plaisir aux personnes qui comptent.</p>
            </div>

            <div class="row row-cols-1 row-cols-md-3 g-4">
                <div class="col">
                    <article class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h2 class="h4">Une sélection inspirante</h2>
                            <p class="text-secondary mb-0">Parcourez des idées cadeaux et des accessoires pour différentes occasions.</p>
                        </div>
                    </article>
                </div>
                <div class="col">
                    <article class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h2 class="h4">Le plaisir d’offrir</h2>
                            <p class="text-secondary mb-0">Chaque attention est une façon de célébrer un moment ou une personne importante.</p>
                        </div>
                    </article>
                </div>
                <div class="col">
                    <article class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h2 class="h4">À votre écoute</h2>
                            <p class="text-secondary mb-0">Une question sur la boutique ? Écrivez-nous depuis notre page de contact.</p>
                        </div>
                    </article>
                </div>
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('public.boutique') }}" class="btn btn-dark">Découvrir la boutique</a>
            </div>
        </section>
    </main>
@endsection
