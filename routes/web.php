<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/unauthorized', function () {
    return view('errors.403');
});

Route::get('/onworking', function () {
    return view('errors.503');
});

Route::auth();

Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/admin', 'AdminController@index');
/*===================================== Language section routes =============================== */
// Lanauge
Route::get('/admin/language', 'AdminController@language');
Route::get('/admin/language/json', 'AdminController@getjsonlanguage');
Route::get('/admin/modify/language/{languageid?}', 'AdminController@modifylanguage');
Route::post('/admin/update/language/{languageid?}', 'AdminController@saveLanguage');
Route::get('/admin/destroy/language/{languageid}', 'AdminController@destroylanguage');

// Language Translations
Route::get('/admin/languagetranslation/{code?}', 'AdminController@translation');
Route::get('/admin/languagetranslation/json/{code?}', 'AdminController@getjsontranslation');
Route::get('/admin/languagetranslation/delete/{id}', 'AdminController@destroytranslation');
Route::get('/admin/writelanguage', 'AdminController@writelanguagefile');

Route::any('/admin/add/languagetranslation', 'AdminController@addtranslation');
Route::get('/admin/modify/languagetranslation/{id}', 'AdminController@addtranslation');
Route::post('admin/languagetranslation/store', 'AdminController@savetranslation');
Route::post('admin/languagetranslation/update/{key}', 'AdminController@updatetranslation');

Route::get('/language-chooser', 'LanguageController@changeLanguage');
Route::get('/language/', array('before'=> 'csrf','as'=>'language-chooser','uses'=>'LanguageController@changeLanguage'));

/*===================================== Entiity section routes =============================== */
//Company(Entities) sections
Route::get('admin/taxonomies/enti', 'AdminController@enti');

// for getting new enti list
Route::get('/newenti', 'AdminController@newregisteredenti');
//Route::get('/admin/language', 'AdminController@language');
Route::get('/newenti/json', 'AdminController@getjsonregisteredenti');

// approve enti
Route::get('/approveenti/{id}', 'AdminController@approveenti');
// reject enti
Route::get('/rejectenti/{id}', 'AdminController@rejectedenti');

/*===================================== Estimates (Preventi) section routes =============================== */
// Preventivi -> Stato emotivo
Route::get('/admin/taxonomies/estimates', 'AdminController@estimates'); //fatto
Route::get('/admin/taxonomies/statiestimate/delete/id/{id}', 'AdminController@deleteStatiEstimates'); //fatto
Route::post('/admin/taxonomies/updateestimates', 'AdminController@updateStatiEstimates'); //fatto(?)
Route::post('/admin/taxonomies/addestimates', 'AdminController@addStatiEstimates');

/*===================================== Project (Progetti) section routes =============================== */
//Progetti -> Stato emotivo
Route::get('/admin/taxonomies/project', 'AdminController@project');
Route::get('/admin/taxonomies/statesproject/delete/id/{id}', 'AdminController@deleteStatesProject');
Route::post('/admin/taxonomies/updatestatesproject', 'AdminController@updateStatesProject');
Route::post('/admin/taxonomies/addstatesproject', 'AdminController@addStatesProject');

//Project -> Processing (lavorazioni) 
Route::get('/admin/taxonomies/processing', 'AdminController@processing');
Route::post('/admin/taxonomies/addprocessing', 'AdminController@addProcessing');
Route::post('/admin/taxonomies/updateprocessing', 'AdminController@updateProcessing');
Route::get('/admin/taxonomies/deleteprocessing/id/{id}', 'AdminController@deleteProcessing');

/*===================================== Payments (Pagamenti) section =============================== */
// Pagamenti -> Stato emotivo
Route::get('/admin/taxonomies/payments', 'AdminController@payments');
Route::post('/admin/taxonomies/addstatepayment', 'AdminController@addstatepayment');
Route::get('/admin/taxonomies/statepayment/delete/id/{id}', 'AdminController@deleteStatePayment');
Route::post('/admin/tassonomie/updatestatepayment', 'AdminController@updateStatePayment');


/* ========================================= Entity Section ============================================ */
Route::get('/enti/myenti', 'CorporationController@myenti');
Route::get('enti/myenti/json', 'CorporationController@getJsonMyenti');
Route::get('/enti', 'CorporationController@index');
Route::get('enti/json', 'CorporationController@getjson');
Route::get('/enti/delete/corporation/{corporation}', 'CorporationController@destroy');
Route::get('/enti/modify/corporation/{corporation}', 'CorporationController@modify');
Route::post('/enti/update/corporation/{corporation}', 'CorporationController@update');
Route::get('/enti/duplicate/corporation/{corporation}', 'CorporationController@duplicate');
Route::get('/enti/nuovocliente/corporation/{corporation}', 'CorporationController@nuovocliente');
Route::post('/enti/add/', 'CorporationController@add');
Route::get('/enti/add/', 'CorporationController@add');
Route::post('/enti/store/', 'CorporationController@store');


/*==================================================================================================================== */
// show list of users
Route::get('/admin/utenti', 'AdminController@utenti');
// get users list json
Route::get('users/json', 'AdminController@getjsonusers');
// add/edit user form view
Route::get('/admin/modify/utente/{utente?}', 'AdminController@modificautente');
// store user details
Route::post('/admin/update/utente/{utente?}', 'AdminController@aggiornautente');
// get role permission
Route::get('/admin/role/permission/{ruolo_id?}', 'AdminController@rolepermission');

// show role view
Route::get('/utente-permessi', 'AdminController@permessiutente');
// get role permission json
Route::get('/utente-permessi/json', 'AdminController@rolepermessijson');
// add/edit view for role permission
Route::get('/role-permessi/{ruolo_id?}', 'AdminController@permessirole');
// store role permissions
Route::post('/store-permessi', 'AdminController@storepermessi');
// delete role
Route::get('/admin/destroy/ruolo/{ruolo_id}', 'AdminController@deleterole');

// get new user list
Route::get('/newutente', 'AdminController@newregistratoutente');
// new user json
Route::get('/newutente/json', 'AdminController@newutentejson');
// approve user
Route::get('/approvare/{id}', 'AdminController@approvareutente');
// reject user
Route::get('/rifiutare/{id}', 'AdminController@rifiutareutente');


// show package list 
Route::get('/admin/tassonomie/pacchetti', 'AdminController@mostrapacchetti');
// get package json
Route::get('/admin/tassonomie/pacchetti/json', 'AdminController@mostrapacchettijson');
// add package form
Route::get('/admin/tassonomie/pacchetti/add', 'AdminController@aggiungipacchetto');
// store add package details
Route::post('/admin/tassonomie/pacchetti/store', 'AdminController@salvapacchetto');
// edit package form
Route::get('/admin/tassonomie/modify/pacchetto/{pacchetto}', 'AdminController@modifypacchetto');
// store edit package details
Route::post('/admin/tassonomie/update/pacchetto/{pacchetto}', 'AdminController@aggiornapacchetto');
// delete package detail
Route::get('/admin/tassonomie/delete/pacchetto/{pacchetto}', 'AdminController@destroypacchetto');


// discount view
Route::get('/admin/tassonomie/sconti', 'AdminController@mostrasconti');
// get discount json
Route::get('/admin/sconti/json', 'AdminController@scontijson');
// add discount form
Route::get('/admin/tassonomie/sconti/add', 'AdminController@aggiungisconto');
// store add discount
Route::post('/admin/tassonomie/sconti/store', 'AdminController@salvasconto');
// edit discount form
Route::get('/admin/tassonomie/modify/sconto/{sconto}', 'AdminController@modifysconto');
// store edit discount
Route::post('/admin/tassonomie/update/sconto/{sc}', 'AdminController@aggiornasconto');
// delete discount
Route::get('/admin/tassonomie/delete/sconto/{sconto}', 'AdminController@destroysconto');

// discount bonus view
Route::get('/admin/tassonomie/scontibonus', 'AdminController@mostrascontibonus');
// get discount json
Route::get('/admin/scontibonus/json', 'AdminController@scontibonusjson');
// add bonus discount form
Route::get('/admin/tassonomie/scontibonus/add', 'AdminController@aggiungiscontobonus');
// store bonus discount form
Route::post('/admin/tassonomie/scontibonus/store', 'AdminController@salvascontobonus');
// edit bonus discount form
Route::get('/admin/tassonomie/modify/scontobonus/{sconto}', 'AdminController@modifyscontobonus');
// store bonus discount form
Route::post('/admin/tassonomie/update/scontobonus/{sc}', 'AdminController@aggiornascontobonus');
// delete bonus discount 
Route::get('/admin/tassonomie/delete/scontobonus/{sconto}', 'AdminController@destroyscontobonus');

Route::get('admin/tassonomie/vendita', 'AdminController@vendita');
Route::get('/admin/taxonomies/optional/', 'AdminController@mostraoptional');
Route::any('/admin/taxonomies/optional/add', 'AdminController@aggiungioptional');
Route::any('/admin/taxonomies/optional/store', 'AdminController@salvaoptional');
Route::get('/admin/taxonomies/modify/optional/{optional}', 'AdminController@modificaoptional');
Route::post('/admin/taxonomies/update/optional/{optional}', 'AdminController@saveoptionalchanges');
Route::get('/admin/taxonomies/delete/optional/{optional}', 'AdminController@destroyoptional');
Route::get('/admin/taxonomies/json', 'AdminController@getjson');


//Dynamic Menu
Route::get('/admin/menu', 'AdminController@menu');
Route::any('/menu/add', 'AdminController@menuadd');
Route::get('/menu/submenu/{parent}', 'AdminController@submenu');
Route::post('/menu/store', 'AdminController@storemenu');
Route::get('/menu/json', 'AdminController@menujson');
Route::get('/menu/modify/{id}', 'AdminController@menumodify');
Route::post('/menu/update/{id}', 'AdminController@menuupdate');
Route::get('/menu/delete/{id}', 'AdminController@menudelete');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

