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
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('name', 'nom');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('prenom')->nullable();
            $table->string('telephone', 20)->nullable();
            $table->enum('role', ['admin', 'client'])->default('client');
            $table->enum('statut', ['actif', 'inactif', 'bloque'])->default('actif');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['prenom', 'telephone', 'role', 'statut']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('nom', 'name');
        });
    }
};
