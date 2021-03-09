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

Route::get('index', function () {
    return view('index');
});
    
Route::get('connexion', [ConnexionController::class, 'LoginForm']);
Route::post('connexion', [ConnexionController::class, 'Login']);
Route::get('inscription', [InscriptionController::class, 'InscriptionForm']);
Route::post('inscription', [InscriptionController::class, 'Inscription']);
Route::get('deconnexion', [ConnexionController::class, 'Deconnexion']);

Route::get('contact', function () { return view('contact'); });
Route::post('contact', function () { return view('contact'); });

Route::get('profil', function () { return view('profil'); });
Route::get('editionprofil', function () { return view('editionprofil'); });
Route::get('affich_docs', function () { return view('affich_docs'); });
Route::get('editionprofil', function () { return view('editionprofil'); });
Route::post('editionprofil', function () { return view('editionprofil'); });
Route::get('editionprofiladmin', function () { return view('editionprofiladmin'); });
Route::post('editionprofiladmin', function () { return view('editionprofiladmin'); });
Route::get('modif_utlisateurs_admin', function () { return view('modif_utlisateurs_admin'); });
Route::post('modif_utlisateurs_admin', function () { return view('modif_utlisateurs_admin'); });
Route::get('mydocument', function () { return view('mydocument'); });
Route::get('stat_admin', function () { return view('stat_admin'); });
Route::get('stat_extension', function () { return view('stat_extension'); });
Route::get('stat_public', function () { return view('stat_public'); });
Route::get('supp_account', function () { return view('supp_account'); });
Route::post('supp_account', function () { return view('supp_account'); });
Route::get('utilisateurs_admin', function () { return view('utilisateurs_admin'); });
Route::get('errorAdmin', function () { return view('errorAdmin'); });
Route::get('errorConnexion', function () { return view('errorConnexion'); });
Route::get('docs_non_valide', function () { return view('docs_non_valide'); });
Route::get('ouvrage_validation/{id}', function ($id) { return view('ouvrage_validation', ['id' => $id ]); });
Route::post('ouvrage_validation/{id}', function ($id) { return view('ouvrage_validation', ['id' => $id ]); });
Route::get('create_utilisateurs', function () { return view('create_utilisateurs'); });
Route::post('create_utilisateurs', function () { return view('create_utilisateurs'); });

Route::get('document', function () {
    return view('document');
});

Route::get('ouvrage/{id}', function ($id) {
     return view('ouvrage', ['id' => $id ]);
});


Route::get('/upload', function () { return view('upload'); });

Route::post('/upload', function () { return view('upload'); });


Route::get('/cart', 'App\Http\Controllers\CartController@index')->name('cart.index');
Route::post('/cart/add/{livre}', 'App\Http\Controllers\CartController@store')->name('cart.store');
Route::post('/cart/rent/{livre}', 'App\Http\Controllers\CartController@rent')->name('cart.rent');
Route::patch('/cart', 'App\Http\Controllers\CartController@update')->name('cart.update');

Route::get('/cart/destroy/{livre}', 'App\Http\Controllers\CartController@destroy')->name('cart.destroy');
Route::post('/cart', 'App\Http\Controllers\CartController@clear')->name('cart.clear');
Route::get('/cart/valid', 'App\Http\Controllers\CartController@valid')->name('cart.valid');

Route::get('/book/rented/{filename}','App\Http\Controllers\BookController@stream')->name('book.stream');
Route::get('/book/bought/{filename}','App\Http\Controllers\BookController@read')->name('book.read');
Route::post('/book','App\Http\Controllers\BookController@list')->name('book.list');