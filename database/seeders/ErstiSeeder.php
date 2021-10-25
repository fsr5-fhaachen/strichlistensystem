<?php

namespace Database\Seeders;

use App\Models\Person;
use Illuminate\Database\Seeder;
use Illuminate\Filesystem\Filesystem;

class ErstiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $importPath = resource_path('img_import/');
        $exportPath = public_path('images/imported_images.csv');
        $movePath = public_path('images/');

        $fileSys = new Filesystem();
        $files = $fileSys->files($importPath);
        $handle = fopen($exportPath, 'a');

        foreach ($files as $file) {
            $fileName = $file->getFilenameWithoutExtension();
            $erstiData = explode('_', $fileName);

            Person::create([
                'firstname' => $erstiData[0],
                'lastname' => $erstiData[1],
                'email' => $erstiData[0] . '.' . $erstiData[1] . '@alumni.fh-aachen.de',
                'course' => $erstiData[2],
                'img' => '/images/' . $file->getFilename(),
                'is_tutor' => False,
                'is_special' => False
            ]);

            $fileSys->move($file, $movePath . $fileName . '.jpg');

            foreach ($erstiData as $data) {
                fwrite($handle, $data . ';');
            }
            fwrite($handle, PHP_EOL);
        }

        fclose($handle);
    }
}
