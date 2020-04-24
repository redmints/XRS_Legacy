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

Route::get('/', 'Accueil@getForm');
Route::post('/', 'Accueil@postForm');

Route::get('projet', 'Projet@getForm');
Route::post('projet', 'Projet@postForm');

Route::get('ide', 'Ide@getForm');
Route::post('ide', 'Ide@postForm');

Route::get('login', 'Login@getForm');
Route::post('login', 'Login@postForm');

Route::get('register', 'Register@getForm');
Route::post('register', 'Register@postForm');

Route::get('modificationCompte','Compte@getForm');
Route::post('modificationCompte','Compte@postForm');

Route::get('nouveau-projet', 'NouveauProjet@getForm');
Route::post('nouveau-projet', 'NouveauProjet@postForm');

Route::get('settings', 'Settings@getForm');
Route::post('settings', 'Settings@postForm');

Route::get('getUtilisateurs', 'Utils@getUtilisateurs');
Route::get('getPackages', 'Utils@getPackages');
Route::get('keep_alive', 'Utils@setKeepAlive');
Route::get('shutdown', 'Utils@shutdown');
Route::get('dir2json', 'Utils@dir2json');
