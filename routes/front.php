<?php

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

use App\Http\Controllers\Front\CustomerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\HomeController;
use Illuminate\Support\Facades\Auth;

Route::group([
  'middleware' => ['frontAuth', 'api'],
  'prefix' => 'front'
], function () {
  //COLOQUE AQUI AS ROTAS PARA QUE POSSA TER OS DADOS DO USUÁRIO LOGADO
});


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');

/* Route::post('front/login', 'Front\Auth\LoginController@login')->name('front.login'); */
/* Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/', 'Front\Auth\LoginController@showLoginForm')->name('login');
Route::post('front/login', 'Front\Auth\LoginController@login')->name('front.login'); */