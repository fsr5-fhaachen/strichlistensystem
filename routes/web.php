<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AppController::class, 'index'])->middleware('vpn');
Route::post('/person/{id}/generate-auth-link', [PersonController::class, 'generateAuthLink'])->middleware('vpn');
Route::get('/person/{id}/auth/{token}', [PersonController::class, 'authWithToken'])->where('id', '[0-9]+')->where('token', '[a-f0-9]+')->middleware('throttle:3,30')->name('person.authWithToken');
Route::get('/logout', [AppController::class, 'logout']);
Route::get('/error', [AppController::class, 'error'])->name('error');

Route::group([
    'prefix' => 'person',
    'middleware' => ['vpn.or.person']
], function () {
    Route::get('/{id}', [PersonController::class, 'show'])->name('person.show');
    Route::post('/{id}/buy/{articleId}', [PersonController::class, 'buy'])->where('id', '[0-9]+')->where('articleId', '[0-9]+')->name('person.buy.article');
    Route::post('/{id}/cancel/{articleActionLogId}', [PersonController::class, 'cancel'])->where('id', '[0-9]+')->where('articleActionLogId', '[0-9]+')->name('person.cancel.article');
});

Route::get('/exportcsv/{password}', [ExportController::class, 'exportCsv']);
