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
        Schema::create('temoignages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')
            ->constrained('clients')
            ->cascadeOnDelete();
            $table->text('contenu');
            $table->enum('statut', [
                'en_attente', 
                'approuve', 
                'rejete'
            ])
            ->default('en_attente');
            $table->timestamp('date_publication')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temoignages');
    }
};
