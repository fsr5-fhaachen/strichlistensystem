<?php

namespace App\Http\Controllers;

use App\Models\ArticleActionLog;
use App\Models\Person;
use App\Models\Article;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public function validateRequest(string $password)
    {
        return $password == env('CSV_EXPORT_PW');
    }

    public function createCsv(): StreamedResponse
    {
        $fileName = 'strichlisten_export.csv';
        $persons = Person::all();

        $headers = [
            'Content-type' => 'text/csv; charset=UTF-8',
            'Content-Encoding' => 'UTF-8',
            'Content-Disposition' => "attachment; filename=$fileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $columns = [
            'Nachname',
            'Vorname',
        ];

        $articles = Article::all();
        foreach ($articles as $article) {
            $columns[] = 'Anz_' . $article->name;
        }

        $callback = function () use ($persons, $columns, $articles) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns, ';');

            foreach ($persons as $person) {
                $row['Nachname'] = $person->lastname;
                $row['Vorname'] = $person->firstname;

                foreach ($articles as $article) {
                    $row['Anz_' . $article->name] = ArticleActionLog::where([
                        ['person_id', '=', $person->id],
                        ['article_id', '=', $article->id],
                    ])->count();
                }

                $array = array_map('utf8_decode', array_values($row));
                fputcsv($file, $array, ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportCsv(string $password)
    {
        if (! $this->validateRequest($password)) {
            return 'Incorrect Password!';
        }

        return $this->createCsv();
    }
}
