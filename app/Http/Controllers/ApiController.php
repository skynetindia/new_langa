<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Repositories\CorporationRepository;
use App\Repositories\EventRepository;
use Redirect;
use Validator;
use DB;
use Storage;
use Auth;
use App\Event;
use App;


class ApiController extends Controller {

    /**
     * Create a new controller instance.
     *
     *
     */    
    protected $events;
    private $api_token = "";
    public $request_param = "";
    public $responde_param = "";
    public $responde_url = "";
    public $responde_ip = "";
    public $device_id = "";
    public $device_type = "";
    public function __construct(EventRepository $events,CorporationRepository $corporations,Request $request) {      		
    	$this->api_token = $request->api_token;
    	$this->responde_url = $request->url();
    	$this->responde_ip = $request->ip();
    	$this->device_id = $request->device_id;
    	$this->device_type = $request->device_type;    	
    	
		//$this->middleware('auth');		
		/*$table->string('api_token', 60)->unique();
		echo str_random(60);
		exit;*/
		/*$arr = Auth::guard('api')->user();				
		
		if(empty($arr) || $arr == "" || $arr == null) {
			 return response()->json([
                'message' => 'Record not found',
            ], 404);
			//echo response()->json(['result' => 'User not exist','status'=>'fail']);
 			/*return response()->json(['result' => 'User not exist','status'=>'fail']);*
 			exit;
		}
		exit;*/		
    }

    /*public function checkuser(){
    	$arr = Auth::guard('api')->user();
    	//$user = DB::table('users')->where('api_token','!=', null)->where('api_token', $this->api_token)->first();
		if(empty($arr) || $arr == "" || $arr == null) {
			 return response()->json(['message' => 'Session expired.Please login again.','status'=>'fail']);			 			
		}		
    }*/

    public function storerequestresponse(){
    	$data_time=date("Y-m-d H:i:s");    	
		$this->request_param = str_replace("'","|_|",$this->request_param);
		$this->responde_param = str_replace("'","|_|",$this->responde_param);			    	
    	 DB::table('api_call_details')->insert(array(
                                'request_url' =>$this->responde_url,
                                'request_details' => $this->request_param,
                                'response_details' => $this->responde_param,
                                'device_id' => $this->device_id,
                                'device_type'=>$this->device_type,
                                'date_time'=>$data_time,
                                'ip'=>$this->responde_ip
                            ));    
    }
	
	public function getmenulist(Request $request) {
		$langcode = isset($request->langcode) ? $request->langcode : 'en';
		App::setLocale($langcode);
		$finalMenu = array();	 
		$module = DB::table('modulo')->where('modulo_sub', null)->where('type', 1)->orderBy('frontpriority')->orderBy('id')->get();
        foreach ($module as $module) {
		  $mainMenu = array();
          $modulo = ucfirst(strtolower($module->modulo));
          $submodule = DB::table('modulo')->where('modulo_sub', $module->id)->get();
		  if($submodule->isEmpty()){  
			$mainMenu = array('name'=>trans('messages.'.$module->phase_key), 'link'=>url($module->modulo_link),'menu_icon'=>asset('storage/app/images/'.$module->image),'submunelist'=>array());
          } 
		  else {
			$submenulist = array();		  	
		   	if ($submodule) {
				foreach ($submodule as $submodule) {
				  $subsubmodule = DB::table('modulo')->where('modulo_sub', $submodule->id)->get();              
				  $childmodule = array();
				  if($subsubmodule->isEmpty()) { 
					$submenulist[] = array('name'=>trans('messages.'.$submodule->phase_key), 'link'=>url($submodule->modulo_link),'menu_icon'=>"",'submunelist'=>$childmodule);
				  }
				  else {		
					  $childmodule = array();
					   foreach ($subsubmodule as $subsubmodule1) {
							$childmodule[] = array('name'=>trans('messages.'.$subsubmodule1->phase_key), 'link'=>url($subsubmodule1->modulo_link),'menu_icon'=>"",'submunelist'=>array());
					   }
					  $submenulist[] = array('name'=>trans('messages.'.$submodule->phase_key), 'link'=>url($submodule->modulo_link),'menu_icon'=>"",'submunelist'=>$childmodule);
					}
				}            
			}   
			$mainMenu = array('name'=>trans('messages.'.$module->phase_key), 'link'=>url($module->modulo_link),'menu_icon'=>asset('storage/app/images/'.$module->image),'submunelist'=>$submenulist);     
		}
		$finalMenu[] = $mainMenu;
      }
      $this->request_param = json_encode($request->all());
      $this->responde_param = json_encode(['result' => $finalMenu,'status'=>'success']);
      $this->storerequestresponse();
	  return response()->json(['result' => $finalMenu,'status'=>'success']);
	}

	public function getlanguagelist(Request $request) {
		/*$langcode = isset($request->langcode) ? $request->langcode : 'en';
		App::setLocale($langcode);*/		
		$languages = DB::table('languages')->where('is_deleted', 0)->orderBy('id')->get();		
		$arrResponse = array('result'=>array(),'status'=>'fail');
		$arrlanguages = array();
		foreach ($languages as $languageskey => $languagesval) {
			$languagesval->icon = url('storage/app/images/languageicon/'.$languagesval->icon);
			$arrlanguages[] = $languagesval;
		}		
		$arrResponse = array('result'=>$arrlanguages,'status'=>'success');

		$this->request_param = json_encode($request->all());
      	$this->responde_param = json_encode($arrResponse);
      	$this->storerequestresponse();

		return response()->json($arrResponse);
    }

    /*This function is used for the notification that display in top box */
    public function getnotification(Request $request) {
    	$user = DB::table('users')->where('api_token','!=', null)->where('api_token', $this->api_token)->first();
    	$notifications = DB::table('invia_notifica')
	          ->leftjoin('notifica', 'invia_notifica.notification_id', '=', 'notifica.id')
	          ->select(DB::raw('invia_notifica.*, notifica.id as noti_id, notifica.notification_type, notifica.notification_desc'))
	          ->where('user_id', $user->id)
	          ->where('is_enabled', 0)
	          ->where('is_deleted', 0)
	          ->orderBy('data_lettura', 'asc')	         
	          ->get();

	    $arrnotifications = array();
		foreach($notifications as $notificationkey =>$notificationval) {
			$date = $notificationval->created_at; 
			$notificationval->created_at = dateFormate($date, 'D-m-Y H:i:s'); 
			$arrnotifications[] = $notificationval;
		}
        $alerts = DB::table('inviare_avviso')
          ->leftjoin('alert', 'inviare_avviso.alert_id', '=', 'alert.alert_id')
          ->select(DB::raw('inviare_avviso.*, alert.alert_id as alrt_id, alert.nome_alert, alert.messaggio'))
          ->where('user_id', $user->id)
          ->where('is_enabled', 0)
          ->where('is_deleted', 0)
          ->where('alert.is_system_info', '1')
          ->orderBy('data_lettura', 'asc')	         
          ->get(); 
        $arralert = array();
		foreach($alerts as $alertskey =>$alertsval) {
			$date = $alertsval->created_at; 
			$alertsval->created_at = dateFormate($date, 'D-m-Y H:i:s');
			$arralert[] = $alertsval;
		}
		$arrResult['notifications'] = $arrnotifications;
		$arrResult['alert'] = $arralert;
		$arrResult['totalnotifications'] = count($arrnotifications);
		$arrResult['totalalert'] = count($arralert);

		$this->request_param = json_encode($request->all());
      	$this->responde_param = json_encode(array('result'=>$arrResult,'status'=>'success'));
      	$this->storerequestresponse();

		return response()->json(array('result'=>$arrResult,'status'=>'success'));
	}

	/*This api is used for the notification belt display of today notification */
	public function getalertnotification(Request $request) {		
    	$user = DB::table('users')->where('api_token','!=', null)->where('api_token', $this->api_token)->first();
    	if($user){
    	$today = date("Y-m-d");
        $alert = DB::table('inviare_avviso')
          ->join('alert', 'inviare_avviso.alert_id', '=', 'alert.alert_id')
          ->leftjoin('alert_tipo', 'alert.tipo_alert', '=', 'alert_tipo.id_tipo')
          ->select('inviare_avviso.*','alert.*','alert_tipo.color')
          ->where('user_id', $user->id)->where('is_deleted', 0)
          ->where('alert.created_at', '=', $today)->groupBy('alert.alert_id')
          ->where('alert.is_system_info', '1')
          ->get();
         $arralert = array();
		foreach($alert as $alertskey =>$alertsval) {
			$date = $alertsval->created_at; 
			$alertsval->created_at = dateFormate($date, 'D-m-Y H:i:s');
			$arralert[] = $alertsval;
		} 
		$notifications = DB::table('invia_notifica')
          ->leftjoin('notifica', 'invia_notifica.notification_id', '=', 'notifica.id')
          ->select(DB::raw('invia_notifica.*, notifica.id as noti_id, notifica.notification_type, notifica.notification_desc, notifica.created_at'))
          ->where('user_id', $user->id)->where('is_deleted', 0)
          ->where('notifica.created_at', '=', $today)
          ->groupBy('notification_id')    
          ->get(); 
        $arrnotifications = array();
		foreach($notifications as $notificationkey =>$notificationval) {
			$date = $notificationval->created_at; 
			$notificationval->created_at = dateFormate($date, 'D-m-Y H:i:s'); 
			$arrnotifications[] = $notificationval;
		}

		$arrResult['notifications'] = $arrnotifications;
		$arrResult['alert'] = $arralert;
		$arrResult['totalnotifications'] = count($arrnotifications);
		$arrResult['totalalert'] = count($arralert);
		
		$this->request_param = json_encode($request->all());
      	$this->responde_param = json_encode(array('result'=>$arrResult,'status'=>'success'));
      	$this->storerequestresponse();

		return response()->json(array('result'=>$arrResult,'status'=>'success'));
		}
		

    }

    /*Close notification is parmente hide */
    public function notificationclose(Request $request) {		
    	$user = DB::table('users')->where('api_token','!=', null)->where('api_token', $this->api_token)->first();
    	if($user) {
    		 $res = DB::table('invia_notifica')
            ->where('notification_id', $request->notification_id)
            ->where('user_id', $user->id)
            ->update(array('is_deleted' => 1));
        	$response = ($res) ? array('status'=>'success') : array('status'=>'fail');

        	$this->request_param = json_encode($request->all());
      		$this->responde_param = json_encode($response);
      		$this->storerequestresponse();
        	return response()->json($response);		
    	}
    }
    public function alertclose(Request $request) {		
    	$user = DB::table('users')->where('api_token','!=', null)->where('api_token', $this->api_token)->first();
    	if($user) {
    		 $res = DB::table('inviare_avviso')
            ->where('alert_id', $request->alert_id)
            ->where('user_id', $user->id)
            ->update(array('is_deleted' => 1));
        	$response = ($res) ? array('status'=>'success') : array('status'=>'fail');

        	$this->request_param = json_encode($request->all());
      		$this->responde_param = json_encode($response);
      		$this->storerequestresponse();
        	return response()->json($response);		
    	}
    }

  	public function alertcomment(Request $request) {		
  		$user = DB::table('users')->where('api_token','!=', null)->where('api_token', $this->api_token)->first();
  		if($user) {
	    	$message = $request->input('message');
	        $alert_id = $request->input('alert_id');
	        $user_id = $user->id;
	        /*$user_alert_id = $request->input('user_alert_id');*/	        
	        $res = DB::table('inviare_avviso')->where('alert_id', $alert_id)->where('user_id', $user_id)->update(array('comment' => $message));
	        $response = ($res) ? array('status'=>'success') : array('status'=>'fail');

	        $this->request_param = json_encode($request->all());
      		$this->responde_param = json_encode($response);
      		$this->storerequestresponse();
        	return response()->json($response);		
        }
   }
   public function readalert(Request $request) {		
  		$user = DB::table('users')->where('api_token','!=', null)->where('api_token', $this->api_token)->first();
  		if($user) {
  			$today = date("Y-m-d h:i:s");
        	$alert_id = $request->alert_id;
         	$res = DB::table('inviare_avviso')
            ->where('alert_id', $alert_id)
            ->where('user_id', $user->id)
            ->update(array(
	            'data_lettura' => $today,
	            'conferma' => 'LETTO'
            ));
			$response = ($res) ? array('status'=>'success') : array('status'=>'fail');

			$this->request_param = json_encode($request->all());
      		$this->responde_param = json_encode($response);
      		$this->storerequestresponse();
        	return response()->json($response);		
        }
   }

   /* */
   public function userprofileupdate(Request $request) {		   	
  		$user = DB::table('users')->where('api_token','!=', null)->where('api_token', $this->api_token)->first();  		
  		if($user) {
      	    $validator = Validator::make($request->all(), [
                    'name' => 'required|max:20',                                        
                    'email' => 'required|max:255|unique:users,email,'.$user->id.',id',                    
                    'email' => 'required|max:255',                    
                    'discount' => 'numeric',
                    'discount_bonus' => 'numeric',
                    'revenue' => 'numeric',
                    'revenue_reseller' => 'numeric',
                    'password' => 'max:64',
                    /*'logo' => 'image|max:2000'*/
                ]);              
                if ($validator->fails()) {
                    /*return Redirect::back()->withInput()->withErrors($validator);*/
                    $this->request_param = json_encode($request->all());
                    $respo = array('message'=>json_encode($validator->errors()),'status'=>'fail');
      				      $this->responde_param = json_encode($respo);
      				      $this->storerequestresponse();
                    return response()->json($respo);
                }                

                $CheckemailExistt = DB::table('users')->where('email',$request->email)->where('id','!=',$user->id)->count();
                if($CheckemailExistt > 0) {
                	$this->request_param = json_encode($request->all());
                    $respo = array('message'=>'Email already exist!','status'=>'fail');
      				$this->responde_param = json_encode($respo);
      				$this->storerequestresponse();
      				return response()->json($respo);
                }


                //$oldDetails = DB::table('users')->where('id',$request->login_user_id)->first();
                /*$queries = DB::getQueryLog();
                $last_query = end($queries);
                print_r($last_query);
                print_r($oldDetails);
                exit;*/
                $nome = $user->logo;
                if ($request->logo != null) {
                    $nome = time() . uniqid() . '-' . '-ente';
                    Storage::put('images/' . $nome, file_get_contents($request->file('logo')->getRealPath()));
                }

                $vecchiapassword = (String)$user->password;                
                if($request->password!=null) {
                    $vecchiapassword = bcrypt($request->password);
                }


               DB::table('users')
                ->where('id', $user->id)
                ->update(array(
                'name' => $request->name,
                'email' => $request->email,                
                'password' => $vecchiapassword,
                'sconto' => (isset($request->discount))? $request->discount : $user->sconto,
                'sconto_bonus' => (isset($request->discount_bonus))? $request->discount_bonus : $user->sconto_bonus,
                'rendita' => (isset($request->revenue))? $request->revenue : $user->rendita,
                'rendita_reseller' => (isset($request->revenue_reseller))? $request->revenue_reseller : $user->rendita_reseller,
                'is_internal_profile' => (isset($request->is_internal_profile))? $request->is_internal_profile : $user->is_internal_profile,                
                'logo' => $nome
               ));  
               $this->request_param = json_encode($request->all());
               $respo = array('message'=>trans('messages.keyword_profile_updated_successfully'),'status'=>'success');
      			$this->responde_param = json_encode($respo);
      			$this->storerequestresponse();
      			return response()->json($respo);            
    	}        
   }

    /* This function is give the dasboard modules for login user type */
   public function getDashboardModules(Request $request) {        
      $user = DB::table('users')->where('api_token','!=', null)->where('api_token', $this->api_token)->first();     
      $arrModules = array();
      if($user) {
        $arrModules = DB::select(DB::raw("select * from modulo where id IN (select module_id from dashboard_widgets where user_type = ".$user->dipartimento.")"));
        $finalmodule = array();
        foreach($arrModules as $key => $val) {
          $finalmodule[] = array('module_id'=>$val,'name'=>trans('messages.'.$val->phase_key));          
        }                                 
        /*$arrWidgets = DB::table('dashboard_widgets')->where('user_type',$user->dipartimento)->get();
        $arrModuleIds= array();
        foreach ($arrWidgets as $key => $value) {
          $arrModuleIds[] = $value->module_id;
        }
        return $arrModuleIds;*/
        
         $this->request_param = json_encode($request->all());
         $respo = array('result'=>$finalmodule,'status'=>'success');
         $this->responde_param = json_encode($respo);
         $this->storerequestresponse();
         return response()->json($respo);            
      }      
  }
}
