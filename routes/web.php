<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComprobantesController;
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
    return view('welcome');
});

Route::get('comprobantes', [ComprobantesController::class, 'index']);


//use App\Http\Controllers\readxmlcontroller;
//Route::get("read-xml", [readXmlController::class, "index"]);


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@exportExcel')->name('comprobante.excel');
Route::post('/home', 'HomeController@exportExcel')->name('comprobante.excel');

