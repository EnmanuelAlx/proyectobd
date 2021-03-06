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
Route::get('/', 'Auth\LoginController@showLoginForm')->name('/');

Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('showRegister', 'Auth\RegisterController@showRegister')->name('showRegister');
Route::post('registrar', 'Auth\RegisterController@registrar')->name('registrar');
Route::get('dashboard', 'DashboardController@index')->name('dashboard');



Route::group(['prefix' => 'admin'], function(){

    //////////////////////Cargos////////////////////
    Route::group(['prefix' => 'cargos'], function(){
        Route::get('/', 'CargoController@index')->name('cargos.index');
        Route::post('/buscar','CargoController@store');
        Route::post('/add_new', 'CargoController@create');
        Route::get('/get_item', 'CargoController@show');
        Route::get('/delete_item', 'CargoController@destroy');
        Route::post('/edit', 'CargoController@update');
    });
    ////////////////////////////////////////////////

    /////////////////////Proceso de elccion//////////
    Route::group(['prefix' => 'ProcesoEleccion'], function(){
        Route::get('/', 'ProcesoEleccionController@index')->name('eleccion.index');
        Route::post('/buscar','ProcesoEleccionController@store');
        Route::post('/add_new', 'ProcesoEleccionController@create');
        Route::get('/get_item', 'ProcesoEleccionController@show');
        Route::get('/delete_item', 'ProcesoEleccionController@destroy');
        Route::post('/edit', 'ProcesoEleccionController@update');
    });
    ////////////////////////////////////////////////

    /////////////////////Cargos por eleccion//////////
    Route::group(['prefix' => 'CargoEleccion'], function(){
        Route::get('/', 'CargoEleccionController@index')->name('cargo_x_eleccion.index');
        Route::post('/buscar','CargoEleccionController@store');
        Route::post('/add_new', 'CargoEleccionController@create');
        Route::get('/get_item', 'CargoEleccionController@show');
        Route::get('/delete_item', 'CargoEleccionController@destroy');
        Route::post('/edit', 'CargoEleccionController@update');
    });
    ////////////////////////////////////////////////

    /////////////////////Facultades//////////
    Route::group(['prefix' => 'facultades'], function(){
        Route::get('/', 'FacultadesController@index')->name('facultades.index');
        Route::post('/buscar','FacultadesController@store');
        Route::post('/add_new', 'FacultadesController@create');
        Route::get('/get_item', 'FacultadesController@show');
        Route::get('/delete_item', 'FacultadesController@destroy');
        Route::post('/edit', 'FacultadesController@update');
    });
    ////////////////////////////////////////////////

    /////////////////////Extensiones//////////
    Route::group(['prefix' => 'extensiones'], function(){
        Route::get('/', 'ExtensionesController@index')->name('extensiones.index');
        Route::post('/buscar','ExtensionesController@store');
        Route::post('/add_new', 'ExtensionesController@create');
        Route::get('/get_item', 'ExtensionesController@show');
        Route::get('/delete_item', 'ExtensionesController@destroy');
        Route::post('/edit', 'ExtensionesController@update');
    });
    ////////////////////////////////////////////////

    /////////////////////Escuelas//////////
    Route::group(['prefix' => 'escuelas'], function(){
        Route::get('/', 'EscuelasController@index')->name('escuelas.index');
        Route::post('/buscar','EscuelasController@store');
        Route::post('/add_new', 'EscuelasController@create');
        Route::get('/get_item', 'EscuelasController@show');
        Route::get('/delete_item', 'EscuelasController@destroy');
        Route::post('/edit', 'EscuelasController@update');
    });
    ////////////////////////////////////////////////

    /////////////////////Profesores_votantes//////////
    Route::group(['prefix' => 'ProfesoresVotantes'], function(){
        Route::get('/', 'ProfesoresVotantesController@index')->name('profesores_votantes.index');
        Route::post('/buscar','ProfesoresVotantesController@store');
        Route::post('/add_new', 'ProfesoresVotantesController@create');
        Route::get('/get_item', 'ProfesoresVotantesController@show');
        Route::get('/delete_item', 'ProfesoresVotantesController@destroy');
        Route::post('/edit', 'ProfesoresVotantesController@update');
    });
    ////////////////////////////////////////////////

    /////////////////////Egresados_votantes//////////
    Route::group(['prefix' => 'EgresadosVotantes'], function(){
        Route::get('/', 'EgresadosVotantesController@index')->name('egresados_votantes.index');
        Route::post('/buscar','EgresadosVotantesController@store');
        Route::post('/add_new', 'EgresadosVotantesController@create');
        Route::get('/get_item', 'EgresadosVotantesController@show');
        Route::get('/delete_item', 'EgresadosVotantesController@destroy');
        Route::post('/edit', 'EgresadosVotantesController@update');
    });
    ////////////////////////////////////////////////

    /////////////////////Postulaciones//////////
    Route::group(['prefix' => 'Postulaciones'], function(){
        Route::get('/', 'PostulacionesController@index')->name('postularse.index');
        Route::post('/buscar','PostulacionesController@store');
        Route::post('/add_new', 'PostulacionesController@create');
        Route::get('/get_item', 'PostulacionesController@show');
        Route::get('/delete_item', 'PostulacionesController@destroy');
        Route::post('/edit', 'PostulacionesController@update');
        Route::post('/getCargos', 'PostulacionesController@getCargos');
    });
    ////////////////////////////////////////////////

    /////////////////////////////votacion////////////////////////////
    Route::group(['prefix' => 'votaciones'], function(){
        Route::get('index', 'votacionController@index')->name('votaciones.index');
        Route::get('getPostulados', 'votacionController@getPostulados')->name('votaciones.getP');
        Route::get('getVoto', 'votacionController@getVoto')->name('votaciones.getVoto');
    });
    /////////////////////////////////////////////////////////////////////////////////////

    /////////////////////Comision Electoral//////////
    Route::group(['prefix' => 'ComisionElectoral'], function(){
        Route::get('/', 'ComisionElectoralController@index')->name('comisionElectoral.index');
        Route::post('/buscar','ComisionElectoralController@store');
        Route::post('/add_new', 'ComisionElectoralController@create');
        Route::get('/get_item', 'ComisionElectoralController@show');
        Route::get('/delete_item', 'ComisionElectoralController@destroy');
        Route::post('/edit', 'ComisionElectoralController@update');
    });
    ////////////////////////////////////////////////

    /////////////////////Dashboard//////////
    Route::group(['prefix' => 'Dashboard'], function(){
        Route::get('get', 'DashboardController@getGraficas')->name('GetGraficas');

    });
    ////////////////////////////////////////////////
    ///////////////////reportes///////////////////////////////////
    Route::group(['prefix' => 'reportes'], function(){
        Route::get('/', 'ComisionElectoralController@index')->name('reportes.index');

        Route::get('/total_post_prof', 'reportesController@getVotosProfesores')->name('total_post_prof.index');
        Route::get('/electget', 'reportesController@votoProf')->name('total_post_prof.get');

        Route::get('/total_post_egre', 'reportesController@getVotosEgresados')->name('total_post_egre.index');
        Route::get('elecctget', 'reportesController@eleccttget')->name('total_post_egre.get');

        Route::get('/cargos_eleccion', 'reportesController@reporteCargosEleccion')->name('cargos_eleccion.index');
        Route::get('/eleccionget', 'reportesController@electget')->name('elecciones.get');

        Route::get('/post_prof_1mas_cargos', 'reportesController@getpostmas1')->name('post_prof_1mas_cargos.index');
        Route::get('/eleget', 'reportesController@eleget1')->name('post_prof_1mas_cargos.get');

        Route::get('/post_egre_1mas_cargos', 'reportesController@getpostmas1egre')->name('post_egre_1mas_cargos.index');
        Route::get('/elget', 'reportesController@elget1')->name('post_egre_1mas_cargos.get');


        Route::get('PDFCargosEleccion', 'reportesController@printPdfCargos_eleccion')->name('frm_get');
        Route::get('PDFegreunomascargos', 'reportesController@printPdfEgresadosUnoMasCargos')->name('frm_get2');
        Route::get('PDFtotal_post_prof', 'reportesController@printPdftotal_post_prof')->name('frm_get3');
        Route::get('PDFtotal_post_egre', 'reportesController@printPdftotal_post_egre')->name('frm_get4');


    });
    

});

