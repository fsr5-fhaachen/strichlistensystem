<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleActionLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_action_logs');
    }
}
