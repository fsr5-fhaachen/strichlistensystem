<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('firstname', 30)->nullable(false);
            $table->string('lastname', 30)->nullable(false);
            $table->string('email', 100)->nullable(false)->unique();
            $table->enum('course', ['ET', 'INF', 'DIB', 'MCD', 'WI'])->nullable(true)->default(null);
            $table->string('img', 100);
            $table->boolean('is_tutor')->nullable(false)->default(false);
            $table->boolean('is_special')->nullable(false)->default(false);
            $table->boolean('is_disabled')->nullable(false)->default(false);
            $table->string('auth_token', 128)->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('persons');
    }
};
