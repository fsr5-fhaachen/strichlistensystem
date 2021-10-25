<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * articles
     *
     * @var array
     */
    private static $articles = [
        [
            'name' => 'Bier',
            'icon' => 'beer',
            'show_order' => 1,
        ],
        [
            'name' => 'Radler',
            'icon' => 'lemon',
            'show_order' => 2,
        ],
        [
            'name' => 'Softdrinks',
            'icon' => 'wine-bottle',
            'show_order' => 3,
        ],
        [
            'name' => 'Wasser',
            'icon' => 'faucet',
            'show_order' => 4,
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::$articles as $article) {
            Article::create($article);
        }
    }
}
