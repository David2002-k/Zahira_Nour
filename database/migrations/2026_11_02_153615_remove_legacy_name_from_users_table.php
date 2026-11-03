<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'name')) {
            return;
        }

        if (! Schema::hasColumn('users', 'nom')) {
            Schema::table('users', function (Blueprint $table): void {
                $table->renameColumn('name', 'nom');
            });

            return;
        }

        DB::table('users')
            ->where(function (QueryBuilder $query): void {
                $query->whereNull('nom')->orWhere('nom', '');
            })
            ->update(['nom' => DB::raw('name')]);

        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // The removed name column duplicated nom and must not be reintroduced.
    }
};
