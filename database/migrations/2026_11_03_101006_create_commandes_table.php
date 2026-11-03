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
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')
            ->constrained('clients')
            ->restrictOnDelete();

            $table->string('numero_commande', 50)->unique();

            $table->decimal('montant_total', 10, 2)->default(0);

            $table->enum('statut', [
                'en_attente',
                'confirmee',
                'en_preparation',
                'expediee',
                'livree',
                'annulee'
            ])->default('en_attente');

            $table->text('adresse_livraison');
            $table->string('telephone_livraison', 20);

            $table->timestamp('date_commande')->useCurrent();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
