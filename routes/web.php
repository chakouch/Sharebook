<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConnexionController;
use App\Http\Controllers\InscriptionController;

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

Route::get('/', function () {
    return view('index');
});

// Route::group(['namespace' => 'authentification'], function() {
    
    Route::get('connexion', [ConnexionController::class, 'LoginForm']);
    Route::post('connexion', [ConnexionController::class, 'Login']);
    Route::get('inscription', [InscriptionController::class, 'InscriptionForm']);
    Route::post('inscription', [InscriptionController::class, 'Inscription']);
// });

//Route::get('document','App\Http\Controllers\DocumentController@index');

Route::get('document', function () {
    return view('document');
});

Route::get('ouvrage/{id}', function ($id) {
     return view('ouvrage', ['id' => $id ]);
});