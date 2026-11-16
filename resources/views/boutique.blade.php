@extends('layouts.public')

@section('title', 'Zahira Nour | Boutique')
@section('meta-description', 'Découvrez les produits disponibles dans la boutique Zahira Nour.')

@section('content')
    <main class="container py-5">
        <section id="catalogue" aria-labelledby="catalogue-title">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4">
                <div>
                    <p class="small text-uppercase fw-semibold text-secondary mb-2">Zahira Nour</p>
                    <h1 id="catalogue-title" class="display-5 fw-semibold mb-2">Notre boutique</h1>
                    <p class="lead text-secondary mb-0">Découvrez notre sélection et trouvez le cadeau idéal.</p>
                </div>
                <p class="text-secondary mb-0">
                    {{ $produits->total() }} {{ $produits->total() === 1 ? 'produit disponible' : 'produits disponibles' }}
                </p>
            </div>

            @if ($produits->isEmpty())
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body p-5">
                        <h2 class="h4 mb-2">La boutique est momentanément vide</h2>
                        <p class="text-secondary mb-0">Les nouveaux produits apparaîtront ici dès qu’ils seront disponibles.</p>
                    </div>
                </div>
            @else
                <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-4">
                    @foreach ($produits as $produit)
                        <article class="col">
                            <div class="card h-100 border-0 shadow-sm">
                                @if ($produit->photo)
                                    <div class="ratio ratio-4x3 bg-white">
                                        <img
                                            src="{{ Storage::url($produit->photo) }}"
                                            class="card-img-top object-fit-cover"
                                            alt="{{ $produit->nom }}"
                                            loading="lazy"
                                        >
                                    </div>
                                @else
                                    <div class="ratio ratio-4x3 bg-body-secondary text-secondary">
                                        <span class="d-flex align-items-center justify-content-center">Photo à venir</span>
                                    </div>
                                @endif

                                <div class="card-body d-flex flex-column">
                                    <p class="small text-uppercase text-secondary mb-2">{{ $produit->categorie?->nom ?? 'Sélection Zahira Nour' }}</p>
                                    <h2 class="h5">{{ $produit->nom }}</h2>
                                    <p class="text-secondary flex-grow-1">
                                        {{ \Illuminate\Support\Str::limit($produit->description ?: 'Découvrez ce produit de notre sélection.', 110) }}
                                    </p>
                                    <p class="h5 fw-semibold mb-1">{{ number_format((float) $produit->prix, 2, ',', ' ') }} FCFA</p>
                                    <p class="small text-secondary mb-0">
                                        {{ $produit->stock }} {{ $produit->stock === 1 ? 'article disponible' : 'articles disponibles' }}
                                    </p>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-5">
                    {{ $produits->links() }}
                </div>
            @endif
        </section>
    </main>
@endsection
