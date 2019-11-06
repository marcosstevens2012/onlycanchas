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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//AUDITORIA
Route::resource('turno/auditoria','AuditoriaController');  

//CLIENTES 
Route::resource('cliente/cliente', 'ClienteController');
Route::get('/buscarProvincia','ClienteController@buscarProvincia');
Route::get('/buscarCiudad','ClienteController@buscarCiudad');


//CANCHAS
Route::resource('cancha','CanchaController');

//COMPLEJOS
Route::resource('complejo','ComplejoController');

//USUARIOS
Route::resource('users','UsuarioController');

//CLIENTE
Route::resource('cliente','ClienteController');

//TURNO FUTBOL
Route::resource('turnofutbol','TurnoFutbolController');
Route::post('/actualizar','TurnoFutbolController@actualizar')->name('turnofutbol.actualizar');
Route::get('/buscarFecha','TurnoFutbolController@buscarFecha');
Route::get('/buscarHorarioFutbol','TurnoFutbolController@buscarHorarioFutbol');
Route::resource('turnofutbol/grilla/index', 'GrillaFutbolController');


//TTURNO PADLE
Route::resource('turno','TurnoPadleController');
Route::get('/buscarHorario','TurnoController@buscarHorario');
Route::get('/cancelar','TurnoController@cancelar');
Route::get('/buscarHorario2','TurnoController@buscarHorario2');
Route::get('/buscarFecha2','TurnoController@buscarFecha2');




Route::get('usuario/{id}','UsuarioController@update');


Route::get('error', function(){ 
    abort(500);
});

Auth::routes();

Route::get('logout', 'Auth\LoginController@logout', function () {
    return abort(404);
});

Route::get('/home', 'HomeController@index')->name('home');
