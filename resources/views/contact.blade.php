@extends('layouts.public')

@section('title', 'Zahira Nour | Contact')
@section('meta-description', 'Contactez l’équipe Zahira Nour.')

@section('content')
    <main class="container py-5">
        <section class="mx-auto" style="max-width: 760px" aria-labelledby="contact-title">
            <p class="small text-uppercase fw-semibold text-secondary mb-2">Nous sommes à votre écoute</p>
            <h1 id="contact-title" class="display-5 fw-semibold mb-3">Contactez-nous</h1>
            <p class="lead text-secondary mb-4">Une question ? Envoyez-nous un message et nous vous répondrons dès que possible.</p>

            @if (session('success'))
                <div class="alert alert-success" role="status">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('public.contact.store') }}" class="card border-0 shadow-sm">
                @csrf
                <div class="card-body p-4 p-md-5">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input id="prenom" name="prenom" type="text" value="{{ old('prenom') }}" maxlength="100" class="form-control @error('prenom') is-invalid @enderror" required>
                            @error('prenom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="nom" class="form-label">Nom</label>
                            <input id="nom" name="nom" type="text" value="{{ old('nom') }}" maxlength="100" class="form-control @error('nom') is-invalid @enderror" required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="email" class="form-label">Adresse e-mail</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" maxlength="255" class="form-control @error('email') is-invalid @enderror" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="sujet" class="form-label">Sujet</label>
                            <input id="sujet" name="sujet" type="text" value="{{ old('sujet') }}" maxlength="255" class="form-control @error('sujet') is-invalid @enderror" required>
                            @error('sujet')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="contenu" class="form-label">Votre message</label>
                            <textarea id="contenu" name="contenu" rows="6" maxlength="10000" class="form-control @error('contenu') is-invalid @enderror" required>{{ old('contenu') }}</textarea>
                            @error('contenu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-dark">Envoyer le message</button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </main>
@endsection
