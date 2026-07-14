<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Esta migración es opcional si ya creaste users con estos campos
        // Pero si necesitas actualizar una tabla users existente, descomenta:
        
        /*
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'google_id')) {
                $table->string('google_id')->nullable()->unique()->after('phone');
            }
            if (!Schema::hasColumn('users', 'google_token')) {
                $table->text('google_token')->nullable()->after('google_id');
            }
            if (!Schema::hasColumn('users', 'google_refresh_token')) {
                $table->text('google_refresh_token')->nullable()->after('google_token');
            }
        });
        */
    }

    public function down(): void
    {
        // Schema::table('users', function (Blueprint $table) {
        //     $table->dropColumn(['google_id', 'google_token', 'google_refresh_token']);
        // });
    }
};
