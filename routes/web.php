<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
* Controllers Admin
*/

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategorieController;
use App\Http\Controllers\Admin\ProduitController;
use App\Http\Controllers\Admin\CommandeController as AdminCommandeController;
use App\Http\Controllers\Admin\MessageController as AdminMessageController;
use App\Http\Controllers\Admin\PaiementController as AdminPaiementController;
use App\Http\Controllers\Admin\TemoignageController as AdminTemoignageController;
use App\Http\Controllers\Admin\ReseauSocialController;

/*
* Controllers Client
*/

use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\BoutiqueController;
use App\Http\Controllers\Client\PanierController;
use App\Http\Controllers\Client\CommandeController as ClientCommandeController;
use App\Http\Controllers\Client\MessageController as ClientMessageController;
use App\Http\Controllers\Client\TemoignageController as ClientTemoignageController;
use App\Http\Controllers\Client\PaiementController as ClientPaiementController;

/*
Routes Public
*/
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
Routes administrateur
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // Gestion des catégories
        Route::get('/categories', [CategorieController::class, 'index'])
            ->name('categories.index');

        Route::post('/categories', [CategorieController::class, 'store'])
            ->name('categories.store');

        Route::put('/categories/{categorie}', [CategorieController::class, 'update'])
            ->name('categories.update');

        Route::delete('/categories/{categorie}', [CategorieController::class, 'destroy'])
            ->name('categories.destroy');

        // Gestion des produits
        Route::get('/produits', [ProduitController::class, 'index'])
            ->name('produits.index');

        Route::post('/produits', [ProduitController::class, 'store'])
            ->name('produits.store');

        Route::put('/produits/{produit}', [ProduitController::class, 'update'])
            ->name('produits.update');

        Route::delete('/produits/{produit}', [ProduitController::class, 'destroy'])
            ->name('produits.destroy');

        // Gestion des commandes
        Route::get('/commandes', [AdminCommandeController::class, 'index'])
            ->name('commandes.index');

        Route::get('/commandes/{commande}', [AdminCommandeController::class, 'show'])
            ->name('commandes.show');

        Route::put('/commandes/{commande}', [AdminCommandeController::class, 'update'])
            ->name('commandes.update');

        // Gestion des messages
        Route::get('/messages', [AdminMessageController::class, 'index'])
            ->name('messages.index');

        Route::get('/messages/{message}', [AdminMessageController::class, 'show'])
            ->name('messages.show');

        Route::put('/messages/{message}', [AdminMessageController::class, 'update'])
            ->name('messages.update');

        Route::post('/messages/{message}/reponse', [AdminMessageController::class, 'reply'])
            ->name('messages.reply');

        // Gestion des paiements
        Route::get('/paiements', [AdminPaiementController::class, 'index'])
            ->name('paiements.index');

        Route::get('/paiements/{paiement}', [AdminPaiementController::class, 'show'])
            ->name('paiements.show');

        Route::post('/commandes/{commande}/paiement', [AdminPaiementController::class, 'store'])
            ->name('paiements.store');

        // Gestion des témoignages
        Route::get('/temoignages', [AdminTemoignageController::class, 'index'])
            ->name('temoignages.index');

        Route::put('/temoignages/{temoignage}', [AdminTemoignageController::class, 'update'])
            ->name('temoignages.update');

        // Gestion des réseaux sociaux
        Route::get('/reseaux-sociaux', [ReseauSocialController::class, 'index'])
            ->name('reseaux-sociaux.index');

        Route::post('/reseaux-sociaux', [ReseauSocialController::class, 'store'])
            ->name('reseaux-sociaux.store');

        Route::put('/reseaux-sociaux/{reseauSocial}', [ReseauSocialController::class, 'update'])
            ->name('reseaux-sociaux.update');

        Route::delete('/reseaux-sociaux/{reseauSocial}', [ReseauSocialController::class, 'destroy'])
            ->name('reseaux-sociaux.destroy');
    });



/*
Routes client
*/
Route::middleware(['auth', 'role:client'])
    ->prefix('client')
    ->name('client.')
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [ClientDashboardController::class, 'index'])
            ->name('dashboard');

        // Boutique
        Route::get('/boutique', [BoutiqueController::class, 'index'])
            ->name('boutique.index');

        Route::get('/boutique/{produit}', [BoutiqueController::class, 'show'])
            ->name('boutique.show');

        // Panier
        Route::get('/panier', [PanierController::class, 'index'])
            ->name('panier.index');

        Route::post('/panier/ajouter/{produit}', [PanierController::class, 'store'])
            ->name('panier.add');

        Route::patch('/panier/{produit}', [PanierController::class, 'update'])
            ->name('panier.update');

        Route::delete('/panier/{produit}', [PanierController::class, 'destroy'])
            ->name('panier.remove');

        Route::delete('/panier', [PanierController::class, 'clear'])
            ->name('panier.clear');

        // Commandes
        Route::get('/commandes', [ClientCommandeController::class, 'index'])
            ->name('commandes.index');

        Route::post('/commandes', [ClientCommandeController::class, 'store'])
            ->name('commandes.store');

        Route::get('/commandes/{commande}', [ClientCommandeController::class, 'show'])
            ->name('commandes.show');

        // Messages
        Route::get('/messages', [ClientMessageController::class, 'index'])
            ->name('messages.index');

        Route::get('/messages/creer', [ClientMessageController::class, 'create'])
            ->name('messages.create');

        Route::post('/messages', [ClientMessageController::class, 'store'])
            ->name('messages.store');

        Route::get('/messages/{message}', [ClientMessageController::class, 'show'])
            ->name('messages.show');

        // Témoignages
        Route::get('/temoignages', [ClientTemoignageController::class, 'index'])
            ->name('temoignages.index');

        Route::post('/temoignages', [ClientTemoignageController::class, 'store'])
            ->name('temoignages.store');

        Route::put('/temoignages/{temoignage}', [ClientTemoignageController::class, 'update'])
            ->name('temoignages.update');

        Route::delete('/temoignages/{temoignage}', [ClientTemoignageController::class, 'destroy'])
            ->name('temoignages.destroy');

        // Paiements et reçus
        Route::get('/paiements', [ClientPaiementController::class, 'index'])
            ->name('paiements.index');

        Route::get('/paiements/{paiement}/recu', [ClientPaiementController::class, 'download'])
            ->name('paiements.recu');
    });

require __DIR__.'/auth.php';
