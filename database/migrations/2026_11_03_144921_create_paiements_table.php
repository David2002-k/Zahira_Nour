<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();

            // Administrateur ayant validé le paiement
            $table->foreignId('admin_id')
            ->nullable()
            ->constrained('admins')
            ->nullOnDelete();

            // Commande concernée
            $table->foreignId('commande_id')
            ->constrained('commandes')
            ->restrictOnDelete();

            // Référence unique du paiement
            $table->string('reference_paiement', 50)->unique();

            // Montant réellement payé
            $table->decimal('montant_paye', 10, 2);

            // Mode de paiement utilisé
            $table->enum('mode_paiement', [
                'especes',
                'orange_money',
                'moov_money',
                'wave',
                'autre'
            ]);

            // Date effective du paiement
            $table->timestamp('date_paiement');

            // État du paiement
            $table->enum('statut', [
                'en_attente',
                'confirme',
                'rejete'
            ])->default('en_attente');

            $table->string('fichier_recu')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
