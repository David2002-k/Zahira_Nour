<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Zahira Nour | Espace client</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-stone-900">
        <div class="relative min-h-screen overflow-hidden bg-[#faf7f5]">
            <div class="pointer-events-none absolute -left-32 top-20 h-72 w-72 rounded-full bg-rose-100/70 blur-3xl" aria-hidden="true"></div>
            <div class="pointer-events-none absolute -bottom-32 -right-20 h-80 w-80 rounded-full bg-pink-100/70 blur-3xl" aria-hidden="true"></div>

            <header class="relative z-10 mx-auto flex max-w-7xl items-center justify-between gap-4 px-5 py-5 sm:px-8 lg:px-10">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-3" aria-label="Zahira Nour, accueil">
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#db4566] font-serif text-2xl font-bold text-white shadow-lg shadow-rose-200/70">Z</span>
                    <span class="font-serif text-xl font-bold tracking-wide sm:text-2xl">
                        <span class="text-[#db4566]">Zahira</span>
                        <span class="text-stone-900">Nour</span>
                    </span>
                </a>
                <a href="{{ url('/') }}" class="text-sm font-semibold text-stone-600 transition hover:text-[#c43759]">
                    <span aria-hidden="true">←</span>
                    <span class="hidden sm:inline">Retour à la boutique</span>
                    <span class="sm:hidden">Accueil</span>
                </a>
            </header>

            <main class="relative z-10 mx-auto flex min-h-[calc(100vh-5rem)] max-w-7xl items-center justify-center px-4 pb-8 sm:px-8 lg:px-10">
                <section class="grid w-full max-w-5xl overflow-hidden rounded-[2rem] bg-white shadow-[0_24px_80px_-28px_rgba(74,34,43,0.28)] ring-1 ring-stone-200/70 lg:grid-cols-[0.82fr_1.18fr]">
                    <aside class="relative hidden min-h-[620px] flex-col justify-between overflow-hidden bg-gradient-to-br from-[#351f28] via-[#572735] to-[#a93455] p-10 text-white lg:flex">
                        <div class="pointer-events-none absolute -right-20 -top-20 h-72 w-72 rounded-full border border-white/10" aria-hidden="true"></div>
                        <div class="pointer-events-none absolute -right-10 -top-10 h-52 w-52 rounded-full border border-white/10" aria-hidden="true"></div>
                        <div class="pointer-events-none absolute -bottom-24 -left-24 h-72 w-72 rounded-full bg-[#db4566]/20 blur-2xl" aria-hidden="true"></div>

                        <div class="relative">
                            <span class="inline-flex items-center rounded-full border border-white/20 bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-rose-100">
                                Bienvenue chez Zahira Nour
                            </span>
                            <h2 class="mt-10 font-serif text-4xl font-semibold leading-tight">
                                Une attention délicate,
                                <span class="text-rose-200">un souvenir précieux.</span>
                            </h2>
                            <p class="mt-5 max-w-sm text-sm leading-7 text-rose-50/80">
                                Retrouvez vos commandes et découvrez une sélection de cadeaux pensée pour faire plaisir.
                            </p>
                        </div>

                        <p class="relative text-xs tracking-wide text-rose-100/70">
                            Le plaisir d’offrir, tout simplement.
                        </p>
                    </aside>

                    <div class="px-6 py-9 sm:px-10 sm:py-12 lg:px-14">
                        {{ $slot }}

                        <p class="mt-8 text-center text-xs text-stone-400">
                            © {{ date('Y') }} Zahira Nour. Tous droits réservés.
                        </p>
                    </div>
                </section>
            </main>
        </div>
    </body>
</html>
