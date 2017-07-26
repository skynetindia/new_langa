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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/* Login and Register API */
Route::post('login', 'ApiLoginController@login');
Route::post('registerstepone', 'ApiLoginController@registerstepone');
Route::post('registersteptwo', 'ApiLoginController@registersteptwo');
Route::post('getusertype', 'ApiLoginController@getusertype');
Route::post('getdepartments', 'ApiLoginController@getdepartments');
Route::post('getsectors', 'ApiLoginController@getsectors');
Route::post('getdepartmentspackage', 'ApiLoginController@getdepartmentspackage');



/* All the login required api call here */
Route::group(['middleware' => 'auth:api'], function() {	    
    /*$arr = Auth::guard('api')->user();
    if(empty($arr) || $arr == "" || $arr == null) {
        $arrCustomResponse = array('result' => 'Session expired.Please login again.','status'=>'fail');        
        exit(json_encode($arrCustomResponse));
        /*echo response()->json(['result' => 'Session expired.Please login again.','status'=>'fail']);                        
        exit;*
    }*/       
	Route::post('getlanguages',"ApiController@getlanguagelist");
    Route::post('getmenulist',"ApiController@getmenulist");
    Route::post('getnotification',"ApiController@getnotification");
    Route::post('getalertnotification',"ApiController@getalertnotification");
    Route::post('notificationclose',"ApiController@notificationclose");
    Route::post('alertclose',"ApiController@alertclose");
    Route::post('readalert',"ApiController@readalert");
    Route::post('alertcomment',"ApiController@alertcomment");
    Route::post('userprofileupdate',"ApiController@userprofileupdate");
    Route::post('getDashboardModules', 'ApiController@getDashboardModules');
});

/*Route::group(['middleware' => 'auth:api'], function(){
	//Route::post('apilogin', 'ApiController@login');
    Route::post('getmenulist',"ApiController@getmenulist");
    /*Route::post('send-fax', [
        'uses'=>'api\ApiController@sendFax',
        'as'=>'send-fax'
    ]);
    Route::post('user/change-password', [
        'uses'=>'api\ApiController@changePassword',
        'as'=>'user/change-password'
    ]);*
});

Route::group(['middleware' => ['auth:api']], function () {
        Route::get('/test', function (Request $request) {
             return response()->json(['name' => 'test']);
        });
    });
*/