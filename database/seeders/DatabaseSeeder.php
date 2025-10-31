<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $seeders = [
            ArticleSeeder::class,
            DemoSeeder::class,
            ErstiSeeder::class
        ];

        $this->call($seeders);
    }
}
