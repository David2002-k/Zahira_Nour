<x-app-layout>
    <x-slot name="header">
        @if (auth()->user()->role === 'admin')
            <div class="admin-profile-header">
                <div>
                    <p class="eyebrow mb-2">Espace administration</p>
                    <h2>Modifier mes informations</h2>
                </div>
                <a class="admin-profile-back" href="{{ route('admin.dashboard') }}">
                    <img src="{{ asset('front-end/images/zahira-nour-logo.jpeg') }}" alt="">
                    <span>Retour au tableau de bord</span>
                </a>
            </div>
        @elseif (auth()->user()->role === 'client')
            <div class="client-profile-header flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="eyebrow mb-2">Espace client</p>
                    <h2 class="text-xl font-semibold leading-tight text-gray-900">Modifier mes informations</h2>
                </div>
                <a
                    class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-800 shadow-sm transition hover:border-black hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2"
                    href="{{ route('client.dashboard') }}"
                >
                    <span aria-hidden="true">&larr;</span>
                    <span>Retour au tableau de bord</span>
                </a>
            </div>
        @else
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Profile') }}
            </h2>
            <div class="container py-3">
                <a class="brand-mark navbar-brand" href="{{ route('admin.dashboard') }}">Retour au Tableau de bord</a>
            </div>
        @endif
    </x-slot>

    <div class="admin-profile-page py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="admin-profile-card p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="admin-profile-card p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="admin-profile-card p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
