<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class UserNameMigrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_legacy_name_values_are_moved_to_nom_and_name_is_removed(): void
    {
        $legacyUser = User::factory()->create(['nom' => '']);
        $userWithNom = User::factory()->create(['nom' => 'Current Nom']);

        Schema::table('users', function (Blueprint $table): void {
            $table->string('name')->nullable();
        });

        DB::table('users')->where('id', $legacyUser->id)->update(['name' => 'Legacy Name']);
        DB::table('users')->where('id', $userWithNom->id)->update(['name' => 'Old Duplicate']);

        $migration = require database_path('migrations/2026_11_02_153615_remove_legacy_name_from_users_table.php');
        $migration->up();

        $this->assertDatabaseHas('users', [
            'id' => $legacyUser->id,
            'nom' => 'Legacy Name',
        ]);
        $this->assertDatabaseHas('users', [
            'id' => $userWithNom->id,
            'nom' => 'Current Nom',
        ]);
        $this->assertFalse(Schema::hasColumn('users', 'name'));
    }
}
