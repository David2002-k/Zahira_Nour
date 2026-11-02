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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categorie_id')->constrained('categories')->restrictOnDelete();
            $table->string('photo')->nullable();
            $table->string('nom', 255);
            $table->string('slug', 120)->unique();
            $table->text('description')->nullable();
            $table->decimal('prix', 10, 2);
            $table->integer('stock')->default(0);
            $table->enum('statut', [
                'disponible',
                'indisponible',
                'en_rupture'
            ])->default('disponible');
            $table->timestamp('date_publication')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
