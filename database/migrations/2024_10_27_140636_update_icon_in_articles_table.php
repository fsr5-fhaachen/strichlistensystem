<?php

use App\Models\Article;
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
        $driver = DB::getConfig('driver');

        // sqlite doesn't support the 'alter table drop constraint' command
        // the workaround needs to be used if sqlite is selected as database driver
        if ($driver != 'sqlite') {
            Schema::table('articles', function (Blueprint $table) {
                $table->string('icon')->nullable(false)->change();
            });
            DB::statement('ALTER TABLE articles DROP CONSTRAINT IF EXISTS articles_icon_check;');
        } else {
            Schema::create('articles2', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('name', 50)->nullable(false);
                $table->string('icon')->nullable(false);
                $table->integer('show_order')->nullable(false);
                $table->integer('max_order_amount')->nullable(false)->default(1);
            });

            foreach (Article::all() as $article) {
                DB::table('articles2')->insert(array(
                    'id' => $article->id,
                    'created_at' => $article->created_at,
                    'updated_at' => $article->updated_at,
                    'name' => $article->name,
                    'show_order' => $article->show_order,
                    'max_order_amount' => $article->max_order_amount
                ));
            }

            Schema::dropIfExists('articles');

            Schema::rename('articles2', 'articles');
        }
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
