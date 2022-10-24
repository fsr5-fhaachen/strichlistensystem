<?php

namespace Database\Seeders;

use App\Models\Person;
use Illuminate\Database\Seeder;

class TutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $importPath = resource_path('Tutorenliste.csv');
        $csvFile = fopen($importPath, 'r');

        while (($data = fgetcsv($csvFile, 2000, ';')) !== False) {
            // if (empty($data[0])) continue;

            Person::create([
                'lastname' => $data[0],
                'firstname' => $data[1],
                'course' => (!empty($data[2]) ? $data[2] : null),
                'email' => $data[3],
                'img' => "",
                'is_tutor' => True,
                'is_special' => !empty($data[4]),
                'is_disabled' => !empty($data[5])
            ]);
        }

        fclose($csvFile);
    }
}
