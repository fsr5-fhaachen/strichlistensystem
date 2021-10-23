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
            $table->string('image_url', 100);
            $table->boolean('is_tutor')->nullable(False);
            $table->boolean('is_special')->nullable(False);
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
