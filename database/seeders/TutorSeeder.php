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
        $isFirstLine = True;

        while (($data = fgetcsv($csvFile, 2000, ';')) !== False) {
            if ($isFirstLine) {
                $isFirstLine = False;
                continue;
            }

            if (empty($data[0])) continue;

            Person::create([
                'firstname' => $data[1],
                'lastname' => $data[0],
                'email' => $data[1] . '.' . $data[0] . '@alumni.fh-aachen.de',
                'course' => $data[2],
                'img' => $data[1] . $data[0] . '.jpg',
                'is_tutor' => True,
                'is_special' => !empty($data[3]),
                'is_disabled' => !empty($erstiData[4])
            ]);
        }

        fclose($csvFile);
    }
}
