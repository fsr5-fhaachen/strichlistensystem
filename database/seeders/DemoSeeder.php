<?php

namespace Database\Seeders;

use App\Models\Person;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run()
    {
        Person::factory()->count(1)->create();
    }
}
