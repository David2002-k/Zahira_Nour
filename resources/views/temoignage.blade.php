@extends('layouts.public')

@section('title', 'Zahira Nour | Témoignages')
@section('meta-description', 'Lisez les témoignages publiés par les clients de Zahira Nour.')

@section('content')
    <main class="container py-5">
        <section aria-labelledby="testimonials-title">
            <div class="mb-4">
                <p class="small text-uppercase fw-semibold text-secondary mb-2">Vos mots comptent</p>
                <h1 id="testimonials-title" class="display-5 fw-semibold mb-2">Témoignages de nos clients</h1>
                <p class="lead text-secondary mb-0">Découvrez les retours partagés par notre clientèle.</p>
            </div>

            @if ($temoignages->isEmpty())
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body p-5">
                        <h2 class="h4 mb-2">Aucun témoignage publié pour le moment</h2>
                        <p class="text-secondary mb-0">Les témoignages approuvés apparaîtront ici.</p>
                    </div>
                </div>
            @else
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    @foreach ($temoignages as $temoignage)
                        <div class="col">
                            <figure class="card h-100 border-0 shadow-sm">
                                <blockquote class="card-body mb-0">
                                    <p class="mb-4">« {{ $temoignage->contenu }} »</p>
                                    <figcaption class="small text-secondary">
                                        <span class="fw-semibold text-dark">
                                            {{ trim(($temoignage->client?->user?->prenom ?? '').' '.($temoignage->client?->user?->nom ?? '')) ?: 'Client Zahira Nour' }}
                                        </span>
                                        @if ($temoignage->date_publication)
                                            <br>
                                            <time datetime="{{ $temoignage->date_publication->toDateString() }}">
                                                Publié le {{ $temoignage->date_publication->format('d/m/Y') }}
                                            </time>
                                        @endif
                                    </figcaption>
                                </blockquote>
                            </figure>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-5">
                    {{ $temoignages->links() }}
                </div>
            @endif
        </section>
    </main>
@endsection
