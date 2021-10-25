<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('firstname', 30)->nullable(False);
            $table->string('lastname', 30)->nullable(False);
            $table->string('email', 100)->nullable(False)->unique();
            $table->enum('course', ['ET', 'INF', 'MCD', 'WI'])->nullable(False);
            $table->string('img', 100);
            $table->boolean('is_tutor')->nullable(False)->default(False);
            $table->boolean('is_special')->nullable(False)->default(False);
            $table->boolean('is_disabled')->nullable(False)->default(False);
            $table->string('auth_token', 128)->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persons');
    }
}
