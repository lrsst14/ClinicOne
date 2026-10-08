<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class EnsureSessionsTableExistsTest extends TestCase
{
    public function test_migration_creates_the_missing_sessions_table(): void
    {
        Schema::dropIfExists('sessions');

        $migration = require database_path('migrations/2026_10_08_104045_ensure_sessions_table_exists.php');
        $migration->up();

        $this->assertTrue(Schema::hasTable('sessions'));
        $this->assertTrue(Schema::hasColumns('sessions', [
            'id',
            'user_id',
            'ip_address',
            'user_agent',
            'payload',
            'last_activity',
        ]));
    }

    public function test_migration_preserves_an_existing_sessions_table(): void
    {
        Schema::dropIfExists('sessions');
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
        });

        $migration = require database_path('migrations/2026_10_08_104045_ensure_sessions_table_exists.php');
        $migration->up();

        $this->assertTrue(Schema::hasTable('sessions'));
        $this->assertFalse(Schema::hasColumn('sessions', 'payload'));
    }
}
