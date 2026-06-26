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
        Schema::table('watchlists', function (Blueprint $table) {
            // Menambahkan kolom 'type' setelah 'tmdb_movie_id'
            // Defaultnya kita set 'movie' biar data lama tidak error
            $table->string('type')->default('movie')->after('tmdb_movie_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('watchlists', function (Blueprint $table) {
            // Menghapus kolom 'type' jika rollback
            $table->dropColumn('type');
        });
    }
};