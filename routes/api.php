<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'UserController@login');
    Route::post('signup', 'UserController@signup');
    Route::get('logout', 'UserController@logout');
    Route::get('user', 'UserController@user');

});

Route::group([
    'prefix' =>'area'
  ], function() {
      Route::post('insertar', 'AreaController@insertar');
      Route::post('actualizar', 'AreaController@actualizar');
      Route::delete('eliminar', 'AreaController@eliminar');
      Route::get('mostrar', 'AreaController@mostrar');
      Route::get('listar', 'AreaController@listar');
  });

  Route::group([
    'prefix' =>'aula'
  ], function() {
      Route::post('insertar', 'AulaController@insertar');
      Route::post('actualizar', 'AulaController@actualizar');
      Route::delete('eliminar', 'AulaController@eliminar');
      Route::get('mostrar', 'AulaController@mostrar');
      Route::get('listar', 'AulaController@listar');
  });

  Route::group([
    'prefix' =>'campus'
  ], function() {
      Route::post('insertar', 'CampusController@insertar');
      Route::post('actualizar', 'CampusController@actualizar');
      Route::delete('eliminar', 'CampusController@eliminar');
      Route::get('mostrar', 'CampusController@mostrar');
      Route::get('listar', 'CampusController@listar');
  });

  Route::group([
    'prefix' =>'comentario'
  ], function() {
      Route::post('insertar', 'ComentarioController@insertar');
      Route::post('actualizar', 'ComentarioController@actualizar');
      Route::delete('eliminar', 'ComentarioController@eliminar');
      Route::get('mostrar', 'ComentarioController@mostrar');
      Route::get('listar', 'ComentarioController@listar');
      Route::get('comentarios-profesor', 'ComentarioController@obtenerComentariosPorProfesor');
  });

  Route::group([
    'prefix' =>'edificio'
  ], function() {
      Route::post('insertar', 'EdificioController@insertar');
      Route::post('actualizar', 'EdificioController@actualizar');
      Route::delete('eliminar', 'EdificioController@eliminar');
      Route::get('mostrar', 'EdificioController@mostrar');
      Route::get('listar', 'EdificioController@listar');
  });

  Route::group([
    'prefix' =>'evaluacion'
  ], function() {
      Route::post('insertar', 'EvaluacionController@insertar');
      Route::post('actualizar', 'EvaluacionController@actualizar');
      Route::delete('eliminar', 'EvaluacionController@eliminar');
      Route::get('mostrar', 'EvaluacionController@mostrar');
      Route::get('listar', 'EvaluacionController@listar');
      Route::get('por-usuario','EvaluacionController@porUsuario');
      Route::get('promedio-profesor', 'EvaluacionController@promedioProfesor');
      Route::get('promedio-profesores', 'EvaluacionController@promedioProfesores');
  });

  Route::group([
    'prefix' =>'profesor'
  ], function() {
      Route::post('insertar', 'ProfesorController@insertar');
      Route::post('actualizar', 'ProfesorController@actualizar');
      Route::delete('eliminar', 'ProfesorController@eliminar');
      Route::get('mostrar', 'ProfesorController@mostrar');
      Route::get('listar', 'ProfesorController@listar');
  });

  Route::group([
    'prefix' =>'curso'
  ], function() {
      Route::post('insertar', 'CursoController@insertar');
      Route::post('actualizar', 'CursoController@actualizar');
      Route::delete('eliminar', 'CursoController@eliminar');
      Route::get('mostrar', 'CursoController@mostrar');
      Route::get('listar', 'CursoController@listar');
  });

  Route::group([
    'prefix' =>'materia'
  ], function() {
      Route::post('insertar', 'MateriaController@insertar');
      Route::post('actualizar', 'MateriaController@actualizar');
      Route::delete('eliminar', 'MateriaController@eliminar');
      Route::get('mostrar', 'MateriaController@mostrar');
      Route::get('listar', 'MateriaController@listar');
  });

  Route::group([
    'prefix' =>'pregunta'
  ], function() {
      Route::post('insertar', 'PreguntaController@insertar');
      Route::post('actualizar', 'PreguntaController@actualizar');
      Route::delete('eliminar', 'PreguntaController@eliminar');
      Route::get('mostrar', 'PreguntaController@mostrar');
      Route::get('listar', 'PreguntaController@listar');
  });

  Route::group([
    'prefix' =>'respuesta'
  ], function() {
      Route::post('insertar', 'RespuestaController@insertar');
      Route::post('actualizar', 'RespuestaController@actualizar');
      Route::delete('eliminar', 'RespuestaController@eliminar');
      Route::get('mostrar', 'RespuestaController@mostrar');
      Route::get('listar', 'RespuestaController@listar');
  });

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
