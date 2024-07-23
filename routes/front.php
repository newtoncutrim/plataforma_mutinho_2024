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

use App\Http\Controllers\Front\HomeController;

Route::group([
  'middleware' => ['frontAuth', 'api'],
  'prefix' => '/'
], function () {
  //COLOQUE AQUI AS ROTAS PARA QUE POSSA TER OS DADOS DO USUÁRIO LOGADO
});

Route::get('/', [HomeController::class, 'index'])->name('home');
