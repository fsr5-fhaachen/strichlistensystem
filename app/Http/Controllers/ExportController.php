<?php

namespace App\Http\Controllers;

use App\Models\ArticleActionLog;
use App\Models\Person;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function validateRequest(string $password){
        return $password == env('CSV_EXPORT_PW');
    }

    public function createCsv(){
        $fileName = 'strichlisten_export.csv';
        $persons = Person::all();

        $headers = array(
            'Content-type' => 'text/csv; charset=UTF-8',
            'Content-Encoding' => 'UTF-8',
            'Content-Disposition' => "attachment; filename=$fileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        );

        $columns = array(
            'Nachname',
            'Vorname',
            'Anz_Bier',
            'Anz_Radler',
            'Anz_Softdrinks',
            'Anz_Wasser'
        );

        $callback = function() use($persons, $columns){
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns, ';');

            foreach ($persons as $person) {
                $row['Nachname'] = $person->lastname;
                $row['Vorname'] = $person->firstname;
                $row['Email'] = $person->email;
                $row['Anz_Bier'] = ArticleActionLog::where([
                    ['person_id', '=', $person->id],
                    ['article_id', '=', 1]
                ])->count();
                $row['Anz_Radler'] = ArticleActionLog::where([
                    ['person_id', '=', $person->id],
                    ['article_id', '=', 2]
                ])->count();
                $row['Anz_Softdrink'] = ArticleActionLog::where([
                    ['person_id', '=', $person->id],
                    ['article_id', '=', 3]
                ])->count();
                $row['Anz_Wasser'] = ArticleActionLog::where([
                    ['person_id', '=', $person->id],
                    ['article_id', '=', 4]
                ])->count();

                fputcsv($file, array($row['Nachname'], $row['Vorname'], $row['Anz_Bier'], $row['Anz_Radler'], $row['Anz_Softdrink'], $row['Anz_Wasser']), ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportCsv(string $password){
        if (!$this->validateRequest($password)) return "Incorrect Password!";

        return $this->createCsv();
    }
}
