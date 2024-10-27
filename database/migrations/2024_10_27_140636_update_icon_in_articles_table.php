<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('icon')->nullable(false)->change();
        });

        DB::statement('ALTER TABLE articles DROP CONSTRAINT IF EXISTS articles_icon_check;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->enum('icon', ['beer', 'lemon', 'wine-bottle', 'faucet'])->nullable(false)->change();
        });
    }
};
