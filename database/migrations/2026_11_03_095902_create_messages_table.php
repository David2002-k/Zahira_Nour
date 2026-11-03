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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')
            ->nullable()
            ->constrained('clients')
            ->nullOnDelete();

            $table->string('prenom', 100);
            $table->string('nom', 100);
            $table->string('email', 255);
            $table->string('sujet', 255);
            $table->text('contenu');

            $table->enum('statut', [
                'non_lu',
                'lu',
                'traite'
            ])->default('non_lu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
