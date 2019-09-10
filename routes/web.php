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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::resource('medecins', 'MedecinController');
Route::post('addFormation/{id}', 'MedecinController@addFormations')->name('medecins.addformation');
Route::post('addExperties/{id}', 'MedecinController@addExperties')->name('medecins.addexperties');
Route::get('activer/{id}', 'MedecinController@activateMedecin')->name('medecins.active');
Route::post('packEdit/{id}', 'MedecinController@packEdit')->name('medecins.pack.edit');

Route::resource('patients','PatientController');

Route::get('calendrier', 'RendezVousController@index')->name('calendrier');
Route::get('getListRendezVous', 'RendezVousController@listRendezVous')->name('list_rendez_vous');
Route::get('tableRendezVous', 'RendezVousController@listTableRendezvous')->name('table_rendez_vous');
Route::delete('rendezvous/{id}/delete','RendezVousController@destroy')->name('rendezvous.destroy');
Route::get('traiteRendezVous/{id}', 'RendezVousController@rendezvousVisite')->name('traite_rendez_vous');
Route::post('rendezvous/store', 'RendezVousController@store')->name('rendezvous.store');
Route::get('getRendezVous', 'RendezVousController@getRendezVous')->name('rendezvous.get');
Route::post('editRendezVous', 'RendezVousController@editRendezVous')->name('rendezvous.edit');
Route::get('editRendezVousOnDrop', 'RendezVousController@editRendezVousOnDrop')->name('rendezvous.edit.ondrop');
Route::get('checkDispo','RendezVousController@checkDispo')->name('rendezvous.checkDispo');
Route::get('to_confirm','RendezVousController@indexToConfirm')->name('rendezvous.to_confirm');

Route::get('planning', 'PlanningController@index')->name('planning');
Route::post('planningstore', 'PlanningController@store')->name('planning.store');

Route::get('empechement','RendezVousEmpechementController@index')->name('empechement');
Route::post('empechement/store','RendezVousEmpechementController@store')->name('empechement.store');
Route::post('empechement/update','RendezVousEmpechementController@update')->name('empechement.update');
Route::get('empechement/get','RendezVousEmpechementController@getEmpechement')->name('empechement.get');
Route::delete('empechement/{id}/delete','RendezVousEmpechementController@destroy')->name('empechement.destroy');
Route::get('empechement/checkPossibility','RendezVousEmpechementController@checkReposPossibility')->name('empechement.checkReposPossible');

Route::get('users','UserController@index')->name('users.index');
Route::post('users/store','UserController@store')->name('users.store');
Route::post('users/update','UserController@update')->name('users.update');
Route::delete('users/{id}/delete','UserController@destroy')->name('users.destroy');
Route::get('users/get','UserController@getUser')->name('users.get');
Route::get('users/{id}/active','UserController@userActiver')->name('users.active');

Route::get('maladies','MaladieController@index')->name('maladies.index');
Route::post('maladies/store','MaladieController@store')->name('maladies.store');
Route::delete('maladies/{id}/delete','MaladieController@destroy')->name('maladies.destroy');
Route::get('maladies/get','MaladieController@getMaladie')->name('maladies.get');

Route::post('visite/{id}/store','VisiteController@store')->name('visites.store');
Route::post('visite/{id}/update','VisiteController@update')->name('visites.update');
Route::delete('visite/{idp}/{idv}/delete','VisiteController@destroy')->name('visites.destroy');
Route::get('visite/get','VisiteController@getVisite')->name('visites.get');

Route::get('search','FrontController@index')->name('search');
Route::get('searchDoc','FrontController@searchDoc')->name('searchDoc');
Route::get('disponibiliteMedecin','FrontController@disponibiliteMedecin')->name('disponibiliteMedecin');
Route::post('prendre_rendez_vous','FrontController@store')->name('prendre_rendez_vous');
Route::get('session_rendervous','FrontController@authentifierAndPrendreRv')->name('session_rendervous');
Route::get('complete_doc','FrontController@medecinComplete')->name('complete.doc');
Route::get('medecin/{id}/{specialite}/{ville}/{nom}-{prenom}','FrontController@medecinProfil')->name('profil_med');


Route::post('store_patient_front','PatientController@storeFromFront')->name('store.patient.front');

Route::get('/add_comment','CommentairesController@store')->name('commentaire.store');
Route::get('/delete_comment','CommentairesController@destroy')->name('commentaire.delete');