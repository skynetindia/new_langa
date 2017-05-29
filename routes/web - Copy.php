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


/// Lanauge
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

// for getting new enti list
Route::get('/newenti', 'AdminController@newregisteredenti');
//Route::get('/admin/language', 'AdminController@language');
Route::get('/newenti/json', 'AdminController@getjsonregisteredenti');

// approve enti
Route::get('/approveenti/{id}', 'AdminController@approveenti');
// reject enti
Route::get('/rejectenti/{id}', 'AdminController@rejectedenti');




// for getting new user list
Route::get('/newutente', 'AdminController@newregistratoutente');
// approve user
Route::get('/approvare/{id}', 'AdminController@approvareutente');
// reject user
Route::get('/rifiutare/{id}', 'AdminController@rifiutareutente');


// user permessi
Route::get('/utente-permessi', 'AdminController@permessiutente');
// role permessi
Route::get('/role-permessi/{ruolo_id?}', 'AdminController@permessirole');
// role delete
Route::get('/admin/destroy/ruolo/{ruolo_id}', 
	'AdminController@deleterole');
// store permessi
Route::post('/store-permessi', 'AdminController@storepermessi');

// show all provinces
Route::get('/show-provincie', 'AdminController@showprovincie');
// store provinces
Route::post('/store-provincie', 'AdminController@storeprovincie');
// add new provinces
Route::post('/addprovincie', 'AdminController@addprovincie');

// add admin alert
Route::get('/admin/alert', 'AdminController@addadminalert');
// store admin alert
Route::post('/admin/alert/store', 'AdminController@storeadminalert');
// send alert
Route::get('/send-alert', 'AdminController@sendalert');
// get alert ente json
Route::get('/alert/enti/json', 'AdminController@getalertjson');
// make comment in alert notification
Route::get('/alert/make-comment', 'AdminController@alertmakecomment');
// user read alert notification
Route::get('/alert/user-read', 'AdminController@userreadalert');
// send alert
Route::get('/send-notification', 'AdminController@sendnotification');

// alert type
Route::get('/admin/alert/tipo', 'AdminController@alertTipo');
// add alert type
Route::post('/alert/add/tipo', 'AdminController@nuovoalertTipo');
// update alert type
Route::post('/admin/update/tipo', 'AdminController@alerttipoUpdate');
// delete alert type
Route::get('/admin/delete/tipo/{id_tipo}', 'AdminController@alerttipodelete');

// show notification
Route::get('/admin/shownotification', 
	'AdminController@showadminnotification');
// get notification json
Route::get('/notification/json', 'AdminController@getnotificationjson');

// get enti notification json
Route::get('/notification/enti/json', 
	'AdminController@getentinotificationjson');

// add notification
Route::get('/admin/notification/{id?}', 
	'AdminController@addadminnotification');

Route::get('/notification/delete/{id}', 'AdminController@deletenotification');

// store notification
Route::post('/admin/notification/store/{id?}', 'AdminController@storeadminnotification');

// detail notification
Route::get('/notification/detail/{id?}', 'AdminController@detailadminnotification');

// make comment in notification
Route::get('/notification/make-comment', 'AdminController@notificationmakecomment');

// user read notification
Route::get('/notification/user-read', 'AdminController@userreadnotification');


// make comment in role wised notification
Route::get('/note_role/make-comment', 'AdminController@notemakecomment');
// role wised read notification
Route::get('/note_role/user-read', 'AdminController@userreadnote');

// show taxation 
Route::get('/taxation', 'AdminController@showtaxation');
// add taxation

Route::get('/taxation/add/{id?}', 'AdminController@addtaxation');
// store taxation
Route::post('/taxation/store', 'AdminController@storetaxation');
// delete taxation
Route::get('/taxation/delete/{id}', 'AdminController@deletetaxation');
// get taxation
Route::get('taxation/json', 'AdminController@getjsontaxation');


// add new provinces
// Route::get('/admin/add/utente', 'AdminController@addutente');



Route::get('/cestino/json', 'HomeController@getjsoncestino');
Route::get('/cestino/ripristina/{tipo}/{id}', 'HomeController@ripristina');
Route::get('/cestino/delete/{tipo}/{id}', 'HomeController@eliminadefinitivamente');
Route::get('/cestino', 'HomeController@mostracestino');
Route::get('/newsletter', 'HomeController@newsletter');
Route::get('/newsletter/add', 'AdminController@elencotemplatenewsletter');
Route::post('/newsletter/add', 'AdminController@aggiunginewsletter');
Route::get('newsletter/json', 'HomeController@getjsonnewsletter');
Route::get('/newsletter/delete/{id}', 'AdminController@deletenewsletter');
Route::get('/newsletter/modify/{id}', 'AdminController@modifynewsletter');
Route::post('/newsletter/store', 'AdminController@storenewsletter');
Route::post('/newsletter/update/{id}', 'AdminController@aggiornanewsletter');
Route::post('/newsletter/send', 'HomeController@invianewsletter');

Route::get('/notifiche', 'HomeController@mostranotifiche');
Route::get('/notifiche/disdisci/{id}', 'HomeController@disdiscinotifica');
Route::get('/notifiche/delete/{id}', 'HomeController@cancellanotifica');
Route::get('/notifiche/json', 'HomeController@getjsonnotifiche');

Route::get('/faq', 'HomeController@mostrafaq');

Route::get('/changelog', 'HomeController@mostrachangelog');

Route::get('/valutaci', function () {
    return view('layouts.valutaci');
});
Route::post('/valutaci/store', 'HomeController@segnalazionerrore');

Route::get('/contatti', 'HomeController@mostracontatti');

Route::get('/nuovoutente', 'HomeController@nuovoutente');
Route::get('/conferma', 'HomeController@confermautente');

Route::get('/calendario/{tipo}', 'CalendarioController@index');
Route::get('/calendario/show/{tipo}/day/{day}/month/{month}/year/{year}', 'CalendarioController@show');
Route::post('/calendario/add', 'CalendarioController@store');
Route::get('/calendario/delete/event/{event}', 'CalendarioController@destroy');
Route::get('/calendario/edit/event/{event}', 'CalendarioController@edit');
Route::post('/calendario/update/event/{event}', 'CalendarioController@update');


// Preventivi
Route::get('/preventivi', 'QuoteController@index');
Route::get('/preventivi/miei', 'QuoteController@miei');
Route::post('/preventivi/add', 'QuoteController@nuovo');
Route::get('/preventivi/add', 'QuoteController@aggiungi');
Route::post('/preventivi/store', 'QuoteController@store');
Route::get('/preventivi/modify/quote/{quote}', 'QuoteController@modify');
Route::post('/preventivi/modify/quote/{quote}', 'QuoteController@modifica');
Route::get('/preventivi/delete/quote/{quote}', 'QuoteController@elimina');
Route::get('/preventivi/duplicate/quote/{quote}', 'QuoteController@duplica');
Route::get('/preventivi/pdf/quote/{quote}', 'QuoteController@pdf');
Route::get('/preventivi/noprezzi/pdf/quote/{quote}', 'QuoteController@pdfnoprezzi');
Route::get('/preventivi/optional/{quote}', 'QuoteController@eliminaoptional');
Route::post('/preventivo/optional/aggiorna/{id}', 'QuoteController@aggiornaoptional');
Route::get('/preventivi/optional/elimina/{id}', 'QuoteController@eliminaoptionaldalprev');
Route::get('preventivi/json', 'QuoteController@getjson');
Route::get('preventivi/miei/json', 'QuoteController@getJsonMiei');
Route::get('/preventivi/files/{id}', 'QuoteController@filepreventivo');
Route::post('/preventivi/modify/quote/uploadfiles/{code}', 'QuoteController@fileupload');
Route::get('/preventivi/modify/quote/getfiles/{code}', 'QuoteController@fileget');
Route::get('/preventivi/modify/quote/deletefiles/{id}', 'QuoteController@filedelete');
Route::get('/preventivi/modify/quote/updatefiletype/{typeid}/{id}', 'QuoteController@filetypeupdate');
Route::get('/preventivi/modify/quote/getdefaultfiles/{quote_id}', 'QuoteController@fileget');




// Progetti
// Aggiungi nuovo progetto
Route::get('/progetti', 'ProjectController@index');
Route::get('/progetti/miei', 'ProjectController@miei');
Route::get('/progetti/add', 'ProjectController@aggiungi');
// Salva il nuovo progetto
Route::post('/progetti/store', 'ProjectController@store');
Route::get('/progetti/delete/project/{project}', 'ProjectController@destroy');
Route::get('/progetti/duplicate/project/{project}', 'ProjectController@duplicate');
Route::get('/progetti/modify/project/{project}', 'ProjectController@modify');
Route::post('/progetti/modify/project/{project}', 'ProjectController@update');
Route::get('/progetti/files/{project}', 'ProjectController@vedifiles');
Route::get('/progetti/files/elimina/{project}', 'ProjectController@eliminafile');
Route::get('/progetti/add/{id}', 'ProjectController@creadapreventivo');
Route::get('progetti/miei/json', 'ProjectController@getJsonMiei');
Route::get('progetti/json', 'ProjectController@getjson');
// Enti
Route::get('/enti', 'CorporationController@index');
Route::get('/enti/delete/corporation/{corporation}', 'CorporationController@destroy');
Route::get('/enti/modify/corporation/{corporation}', 'CorporationController@modify');
Route::post('/enti/update/corporation/{corporation}', 'CorporationController@update');
Route::get('/enti/duplicate/corporation/{corporation}', 'CorporationController@duplicate');
Route::get('/enti/nuovocliente/corporation/{corporation}', 'CorporationController@nuovocliente');
Route::post('/enti/add/', 'CorporationController@add');
Route::get('/enti/add/', 'CorporationController@nuovo');
Route::post('/enti/store/', 'CorporationController@store');
Route::get('/enti/miei', 'CorporationController@miei');
Route::get('enti/json', 'CorporationController@getjson');




Route::get('enti/miei/json', 'CorporationController@getJsonMiei');

Route::get('/admin', 'AdminController@index');
/// Impostazioni globali
// Logo
Route::post('/admin/globali/store', 'AdminController@store');
// Profilazioni
Route::post('/admin/profilazione/add', 'AdminController@nuovaprofilazione');
/// Utenti
Route::get('/admin/utenti', 'AdminController@utenti');
Route::get('/admin/utenti/attiva/id/{id}/password/{password}/email/{email}', 'AdminController@attivapassword');
Route::get('/admin/modify/utente/{utente?}', 'AdminController@modificautente');
Route::post('/admin/update/utente/{utente?}', 'AdminController@aggiornautente');
Route::get('/admin/destroy/utente/{utente}', 'AdminController@destroyutente');
//// Tassonomie
/// Enti

/// Pacchetto (Package)
Route::get('/admin/pacchetto', 'AdminController@pacchetto');
//Route::get('/admin/pacchetto/attiva/id/{id}/password/{password}/email/{email}', 'AdminController@attivapassword');
Route::get('/admin/modify/pacchetto/{pacchetto?}', 'AdminController@modificapacchetto');
Route::post('/admin/update/pacchetto/{pacchetto?}', 'AdminController@aggiornapacchettoquiz');
Route::get('/admin/destroy/pacchetto/{pacchetto}', 'AdminController@destroypacchettoquiz');

// Tipi enti
Route::post('/admin/tassonomie/new', 'AdminController@nuovoTipo');
Route::post('/admin/tassonomie/update', 'AdminController@tassonomieUpdate');
Route::get('/admin/tassonomie/delete/id/{id}', 'AdminController@delete');
// Stati emotivi enti
Route::post('/admin/tassonomie/nuovostatoemotivo', 'AdminController@nuovoStatoEmotivo');
Route::post('/admin/tassonomie/nuovostatoprogetto', 'AdminController@nuovoStatoEmotivoProgetto');
Route::post('/admin/tassonomie/nuovostatopagamento', 'AdminController@nuovoStatoEmotivoPagamento');
Route::post('/admin/tassonomie/nuovostatopreventivo', 'AdminController@nuovoStatoEmotivoPreventivo');
Route::post('/admin/tassonomie/aggiornastatiemotivi', 'AdminController@aggiornaStatiEmotivi');
Route::get('/admin/tassonomie/statiemotivi/delete/id/{id}', 'AdminController@deleteStatiEmotivi');

//Company(Entities) sections
Route::get('admin/taxonomies/enti', 'AdminController@enti');
// Progetti -> Stato emotivo
Route::get('/admin/tassonomie/progetti', 'AdminController@progetti');
Route::get('/admin/tassonomie/statiprogetti/delete/id/{id}', 'AdminController@deleteStatiProgetti');
Route::post('/admin/tassonomie/aggiornastatiprogetti', 'AdminController@aggiornaStatiProgetti');
// Preventivi -> Stato emotivo
Route::get('/admin/tassonomie/preventivi', 'AdminController@preventivi'); //fatto
Route::get('/admin/tassonomie/statipreventivi/delete/id/{id}', 'AdminController@deleteStatiPreventivi'); //fatto
Route::post('/admin/tassonomie/aggiornastatipreventivi', 'AdminController@aggiornaStatiPreventivi'); //fatto(?)
// Pagamenti -> Stato emotivo
Route::get('/admin/tassonomie/pagamenti', 'AdminController@pagamenti');
Route::get('/admin/tassonomie/statipagamenti/delete/id/{id}', 'AdminController@deleteStatiPagamenti');
Route::post('/admin/tassonomie/aggiornastatipagamenti', 'AdminController@aggiornaStatiPagamenti');

// Progetti -> Lavorazioni
Route::get('/admin/tassonomie/lavorazioni', 'AdminController@lavorazioni');
Route::post('/admin/tassonomie/lavorazioninew', 'AdminController@nuovolavorazioni');
Route::post('/admin/tassonomie/lavorazioniupdate', 'AdminController@lavorazioniUpdate');
Route::get('/admin/tassonomie/lavorazionidelete/id/{id}', 'AdminController@lavorazionidelete');

/*Route::get('/admin/tassonomie/statilavorazioni/delete/id/{id}', 'AdminController@deleteStatiLavorazioni');
Route::post('/admin/tassonomie/aggiornastatilavorazioni', 'AdminController@aggiornaStatiLavorazioni');*/

// route is repeat again 
// Route::get('/admin/tassonomie/statiprogetti/delete/id/{id}', 'AdminController@deleteStatiPagamenti');

/// Dipartimenti
Route::get('admin/tassonomie/dipartimenti', 'AdminController@dipartimenti');
Route::post('/admin/tassonomie/dipartimenti/add', 'AdminController@add');
Route::get('/admin/tassonomie/dipartimenti/add', 'AdminController@nuovo');
Route::post('/admin/tassonomie/dipartimenti/store', 'AdminController@salvadipartimento');
Route::get('/admin/tassonomie/dipartimenti/modify/department/{department}', 'AdminController@modificadipartimento');
Route::get('/admin/tassonomie/dipartimenti/delete/department/{department}', 'AdminController@destroydipartimento');
Route::post('/admin/tassonomie/dipartimenti/update/department/{department}', 'AdminController@aggiornadipartimento');

/// Vendita
// Optional
Route::get('admin/tassonomie/vendita', 'AdminController@vendita');
Route::get('/admin/tassonomie/optional', 'AdminController@mostraoptional');
Route::get('/admin/tassonomie/optional/add', 'AdminController@aggiungioptional');
Route::post('/admin/tassonomie/optional/store', 'AdminController@salvaoptional');
Route::get('/admin/tassonomie/modify/optional/{optional}', 'AdminController@modificaoptional');
Route::post('/admin/tassonomie/update/optional/{optional}', 'AdminController@salvamodificheoptional');
Route::get('/admin/tassonomie/delete/optional/{optional}', 'AdminController@destroyoptional');
// Pacchetti
Route::get('/admin/tassonomie/pacchetti/add', 'AdminController@mostrapacchetti');
Route::post('/admin/tassonomie/pacchetti/add', 'AdminController@aggiungipacchetto');
Route::post('/admin/tassonomie/pacchetti/store', 'AdminController@salvapacchetto');
Route::get('/admin/tassonomie/delete/pacchetto/{pacchetto}', 'AdminController@destroypacchetto');
Route::get('/admin/tassonomie/modify/pacchetto/{pacchetto}', 'AdminController@modifypacchetto');
Route::post('/admin/tassonomie/update/pacchetto/{pacchetto}', 'AdminController@aggiornapacchetto');
// Sconti
Route::get('/admin/tassonomie/sconti/add', 'AdminController@mostrasconti');
Route::post('/admin/tassonomie/sconti/add', 'AdminController@aggiungisconto');
Route::post('/admin/tassonomie/sconti/store', 'AdminController@salvasconto');
Route::get('/admin/tassonomie/delete/sconto/{sconto}', 'AdminController@destroysconto');
Route::get('/admin/tassonomie/modify/sconto/{sconto}', 'AdminController@modifysconto');
Route::post('/admin/tassonomie/update/sconto/{sc}', 'AdminController@aggiornasconto');
// Bonus sconti
Route::get('/admin/tassonomie/scontibonus/add', 'AdminController@mostrascontibonus');
Route::post('/admin/tassonomie/scontibonus/add', 'AdminController@aggiungiscontobonus');
Route::post('/admin/tassonomie/scontibonus/store', 'AdminController@salvascontobonus');
Route::get('/admin/tassonomie/delete/scontobonus/{sconto}', 'AdminController@destroyscontobonus');
Route::get('/admin/tassonomie/modify/scontobonus/{sconto}', 'AdminController@modifyscontobonus');
Route::post('/admin/tassonomie/update/scontobonus/{sc}', 'AdminController@aggiornascontobonus');

/// Pagamenti
Route::get('/pagamenti', 'AccountingController@index');
Route::post('/pagamenti/store', 'AccountingController@creadisposizione');
Route::get('/pagamenti/delete/accounting/{accounting}', 'AccountingController@destroydisposizione');
Route::get('/pagamenti/duplicate/accounting/{accounting}', 'AccountingController@duplicadisposizione');
Route::post('/pagamenti/modifica/accounting/{accounting}', 'AccountingController@modificadisposizione');
Route::get('/pagamenti/json', 'AccountingController@getjson');
Route::get('/pagamenti/mostra/accounting/{accounting}', 'AccountingController@mostradisposizione');
Route::get('/pagamenti/tranche/add/{id}', 'AccountingController@aggiungitranche');
Route::get('/pagamenti/tranche/json/id/{id}', 'AccountingController@getjsontranche');
Route::get('/pagamenti/tranche/delete/{id}', 'AccountingController@eliminatranche');
Route::get('/pagamenti/tranche/duplicate/{id}', 'AccountingController@duplicatranche');
Route::get('/pagamenti/tranche/modifica/{id}', 'AccountingController@modificatranche');
Route::post('/pagamenti/tranche/store', 'AccountingController@salvatranche');
Route::post('/pagamenti/tranche/update/{id}', 'AccountingController@aggiornatranche');
Route::get('/pagamenti/tranche/corpofattura/{id}', 'AccountingController@vedicorpofattura');
Route::get('pagamenti/tranche/corpofattura/delete/{id}', 'AccountingController@eliminacorpofattura');
Route::post('/pagamenti/tranche/corpofattura/update/{id}', 'AccountingController@aggiornacorpofattura');
Route::get('/pagamenti/tranche/pdf/{id}', 'AccountingController@generapdftranche');
Route::get('/pagamenti/tranche/elenco', 'AccountingController@elencotranche');
Route::get('/pagamenti/tranche/json', 'AccountingController@getjsontuttetranche');
Route::get('/pagamenti/coordinate', 'AccountingController@mostracoordinate');

// Statistiche
Route::get('/statistiche/economiche', 'AccountingController@mostrastatistiche');
Route::get('/statistiche/economiche/{tipo}/{anno}', 'AccountingController@statisticheeconomiche');
Route::get('costi/json', 'AccountingController@getjsoncosti');
Route::get('/costo/delete/{id}', 'AccountingController@destroycosto');
Route::get('/costi/modify/{id}', 'AccountingController@modificacosto');
Route::post('/costo/aggiorna/{id}', 'AccountingController@aggiornacosto');

// Profilo utente
Route::get('/profilo', 'HomeController@mostraprofilo');
Route::post('/profilo/aggiornaimmagine/{id}', 'HomeController@aggiornaimmagine');
Route::get('/profilo/link/elimina/{id}', 'HomeController@eliminalink');
Route::post('/profilo/aggiungilink', 'HomeController@aggiungilink');

//Quiz section that we need to move on reseller sections
Route::get('/quiz', 'QuizController@index');
Route::get('/quiz/inserisci', 'QuizController@quizStep_1');
Route::post('/storeStep_1', 'QuizController@storequizStep_1');
Route::get('/quiz/valuta/{id}', 'QuizController@quizStep_2');
Route::get('quiz/getDetails', 'QuizController@getQuizDetails');
Route::post('quiz/saveDetails', 'QuizController@saveRatDetails');


Route::get('/admin/quiz', 'AdminController@quizdemo');
Route::post('/admin/quizdemonew', 'AdminController@nuovoquizdemo');
Route::get('/admin/quizdemodelete/id/{id}', 'AdminController@quizdemodelete');
Route::post('/admin/quizdemoupdate', 'AdminController@quizdemoUpdate');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
