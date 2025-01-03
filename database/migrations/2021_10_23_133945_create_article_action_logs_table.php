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
        Schema::create('article_action_logs', function (Blueprint $table) {
            $table->id();
            $table->softDeletes();
            $table->timestamps();
            $table->foreignId('person_id')->nullable(false)->constrained('persons')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('article_id')->nullable(false)->constrained('articles')->onUpdate('cascade')->onDelete('cascade');
            $table->text('ip')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_action_logs');
    }
};
