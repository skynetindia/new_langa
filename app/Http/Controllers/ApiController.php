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

    /*This function is used to store the reponse/request details in all call - 25-Jul-2017 */
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
	
  /* This is used to get the menu list as per given language code
    Also set the language as per given language od site
   : 25-Jul-2017 */
	public function getmenulist(Request $request) {
    $langcode = isset($request->langcode) ? $request->langcode : 'en';
    App::setLocale($langcode);
    
    $user = DB::table('users')->where('api_token','!=', null)->where('api_token', $this->api_token)->first();

    $user_permission = $user->permessi;
    $permission = json_decode($user_permission);    

		
		$finalMenu = array();	 
		$module = DB::table('modulo')->where('modulo_sub', null)->where('type', 1)->orderBy('frontpriority')->orderBy('id')->get();
        foreach ($module as $module) {
		      $mainMenu = array();
          $modulo = ucfirst(strtolower($module->modulo));
          $submodule = DB::table('modulo')->where('modulo_sub', $module->id)->get();
          /* Check user permissions */
          if($user_permission == "null" || $permission == null || !in_array($module->id.'|0|lettura', $permission)) {
            continue;
          }
          /*if($submodule->isEmpty() && !checkpermission($module->id, 0, 'lettura')) {
            continue;
          }*/
		      if($submodule->isEmpty()) {  
			     $mainMenu = array('name'=>trans('messages.'.$module->phase_key), 'link'=>url($module->modulo_link),'menu_icon'=>asset('storage/app/images/'.$module->image),'submunelist'=>array());
          } 
		      else {
			$submenulist = array();		  	
		   	if ($submodule) {
				foreach ($submodule as $submodule) {
				  $subsubmodule = DB::table('modulo')->where('modulo_sub', $submodule->id)->get();              
				  $childmodule = array();
          if($user_permission == "null" || $permission == null || !in_array($module->id.'|'.$submodule->id.'|lettura', $permission)) {
            continue;
          }
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

  /* This used to get all the languages with icon and details : 25-Jul-2017 */
/*	public function getlanguagelist(Request $request) {
		/*$langcode = isset($request->langcode) ? $request->langcode : 'en';
		App::setLocale($langcode);*
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
    }*/

    /*This function is used for the notification that display in top box : 25-Jul-2017 */
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

	/*This api is used for the notification belt display of today notification : 25-Jul-2017 */
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

    /* Close notification is parmente hide from the top bars : 25-Jul-2017 */
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
    /* Close the alert from top belt display */
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

    /* Comment on the alert top display in belt : 25-Jul-2017 */
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

   /* Make the alert readable on click : 25-Jul-2017 */
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

   /* This is used for the update of user profile : 25-Jul-2017 */
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

    /* This function is give the dasboard modules for login user type  */
   public function getDashboardModules(Request $request) {        
      $user = DB::table('users')->where('api_token','!=', null)->where('api_token', $this->api_token)->first();     
      $this->request_param = json_encode($request->all());
      $day = date('j');
      $month = date('n');
      $year = date('Y');
      $arrModules = array();
      $arrMenurls['1'] = url('api/dashboard/entity/'.$user->id);
      $arrMenurls['2'] = url('api/dashboard/calendor/'.$user->id);
      $arrMenurls['3'] = url('api/dashboard/quote/'.$user->id);
      $arrMenurls['4'] = url('api/dashboard/project/'.$user->id);
      $arrMenurls['21'] = url('api/dashboard/invoice/'.$user->id);

        if($user) {
          $arrModules = DB::select(DB::raw("select * from modulo where id IN (select module_id from dashboard_widgets where user_type = ".$user->dipartimento.")"));
          $finalmodule = array();
          foreach($arrModules as $key => $val) {
            //$menuvewviewurl = $val
            $menuurl = isset($arrMenurls[$val->id]) ? $arrMenurls[$val->id] : "";
            $finalmodule[] = array('module_id'=>$val->id,'name'=>trans('messages.'.$val->phase_key),'url'=>$menuurl);          
          }

        /* Menu for the Left side fixed module */        
        $Querytype = DB::table('ruolo_utente')->where('ruolo_id', $user->dipartimento)->first();
        $type = isset($Querytype->nome_ruolo) ? $Querytype->nome_ruolo : "";         

        if ($user->id === 0 || $type === 'Administration') {
            $arrchildmodule = array(
              array('module_id'=>'1','name'=>trans('messages.keyword_statistics'),'url'=>url('api/dashboard/statistics/').'/'.$user->id.'/'.$year),
              array('module_id'=>'2','name'=>trans('messages.keyword_tax_deadlines'),'url'=>url('api/dashboard/taxdeadline/').'/'.$user->id));
        }
        elseif($type === 'Commercial') {  /*Commercial*/
         $arrchildmodule = array(                        
              array('module_id'=>'1','name'=>trans('messages.keyword_statistics'),'url'=>url('api/dashboard/statistics/').'/'.$user->id.'/'.$year),
              array('module_id'=>'2','name'=>trans('messages.keyword_pending_confirmation'),'url'=>url('api/dashboard/pendingquote/').'/'.$user->id),
              array('module_id'=>'3','name'=>trans('messages.keyword_login_reseller'),'url'=>url('api/dashboard/resellerlogin/').'/'.$user->id.'/'.$year));   
        }
        elseif($type === 'Technician') { /* Technician */
         $arrchildmodule = array(              
              array('module_id'=>'1','name'=>trans('messages.keyword_statistics'),'url'=>url('api/dashboard/statistics/').'/'.$user->id.'/'.$year),
              array('module_id'=>'2','name'=>trans('messages.keyword_quotes').' '.trans('messages.keyword_confirmed'),'url'=>url('api/dashboard/confirmquote/').'/'.$user->id ));
        }
        elseif($type === 'Reseller') { /* Reseller */        
         $arrchildmodule = array(          
              array('module_id'=>'1','name'=>trans('messages.keyword_your_responsible_langa'),'url'=>url('api/dashboard/projectReseller/').'/'.$user->id.'/'.$year),
              array('module_id'=>'2','name'=>trans('messages.keyword_statistics'),'url'=>url('api/dashboard/statistics/').'/'.$user->id.'/'.$year),
              array('module_id'=>'3','name'=>trans('messages.keyword_projects'),'url'=>url('api/dashboard/projectReseller/').'/'.$user->id.'/'.$year),              
              array('module_id'=>'4','name'=>trans('messages.keyword_statistics'),'url'=>url('api/dashboard/statistics/').'/'.$user->id.'/'.$year),
              array('module_id'=>'5','name'=>trans('messages.keyword_pending_confirmation'),'url'=>url('api/dashboard/pendingquote/').'/'.$user->id));   
        }
        elseif($type === 'Client' || $type === 'Customer') { /* Client- Customer */                    
            $arrchildmodule = array(
              array('module_id'=>'1','name'=>trans('messages.keyword_your_responsible_langa'),'url'=>url('api/dashboard/projectsCustomer/').'/'.$user->id.'/'.$year),
              array('module_id'=>'2','name'=>trans('messages.keyword_projects'),'url'=>url('api/dashboard/projectsCustomer/').'/'.$user->id.'/'.$year));
        }
        else { /* Other User Dashboard */
          $arrchildmodule = array (
              array('module_id'=>'1','name'=>trans('messages.keyword_statistics')),
              array('module_id'=>'2','name'=>trans('messages.keyword_tax_deadlines'))
              ); 
        }
        
         $result = array('widgetmodules'=>$finalmodule,'fixedmodules'=>$arrchildmodule);
         $respo = array('result'=>$result,'status'=>'success');
         $this->responde_param = json_encode($respo);
         $this->storerequestresponse();
         return response()->json($respo);            
      }      
  }

  /* Dashboard All Webview section display from here */
  public function dashboardview(Request $request) {
    $userid = $request->id;
    $viewtype = $request->type;
    $userdetail = DB::table('users')->where('id',$userid)->first();
    $Querytype = DB::table('ruolo_utente')->where('ruolo_id', $userdetail->dipartimento)->first();
    $userprofiletype = isset($Querytype->nome_ruolo) ? $Querytype->nome_ruolo : "";         
    $statistics = array();
    $projectsCustomer = array();
    $responsabilelanga = array();
    $projectReseller = array();
    $resellerdetails =  array();
    $arrchartdetails = array();

    $day = date('j');
    $month = date('n');
    /*$year = date('Y');*/
    $year = isset($request->year) ? $request->year : date('Y');
    $monthName = array(
                  ''.trans("messages.keyword_january").'',
                  ''.trans("messages.keyword_february").'',
                  ''.trans("messages.keyword_march").'',
                  ''.trans("messages.keyword_april").'',
                  ''.trans("messages.keyword_may").'',
                  ''.trans("messages.keyword_june").'',
                  ''.trans("messages.keyword_july").'',
                  ''.trans("messages.keyword_august").'',
                  ''.trans("messages.keyword_september").'',
                  ''.trans("messages.keyword_october").'',
                  ''.trans("messages.keyword_november").'',
                  ''.trans("messages.keyword_december").'');
    /* ============================== Calendor sections  ==================================== */
    $calendortype = 0;
    $this->calendorDetails($eventi,$estimates,$projects,$invoices,$month,$day,$year,$calendortype,$userid);

    if ($userid === 0 || $userprofiletype === 'Administration') { 
        /* =============================== Statisctics sections =================================== */
        $guadagno = []; $revenues = []; $expenses = [];
        $this->compexpense($expenses, $year);
        $this->compRevenue($revenues, $year);
        $this->calcolaGuadagno($guadagno, $revenues, $expenses);          
        $statistics = array('month' => $monthName, 'revenue' => $revenues, 'expense' => $expenses, 'earn' => $guadagno);
    }
    elseif($userprofiletype === 'Commercial') {
        /* =============== Statistics sections ============== */            
        $notconfirm = []; $pendingconfirm = []; $confirm = [];                    
        $this->confirm($confirm, $year,'0','0',$userdetail);                    
        $this->pendingConfirm($pendingconfirm, $year,'0','0',$userdetail);                    
        $this->notConfirm($notconfirm, $pendingconfirm, $confirm,$year,'0','0',$userdetail);                       
        $statistics = array('month' => $monthName, 'pendingconfirm' => $pendingconfirm, 'confirm' => $confirm, 'notconfirm' => $notconfirm);

        /* ============================ Reseller Login Details ===================== */
        $usertype = DB::table('ruolo_utente')->where('nome_ruolo', 'Reseller')->orwhere('nome_ruolo', 'Reseller')->first();
        $resellerdetails  = DB::table('users')->where(['dipartimento'=>$usertype->ruolo_id,'is_delete'=>0])->get();        
    }
    elseif($userprofiletype === 'Reseller') {
        /* =============== Statistics sections ============== */            
        $notconfirm = []; $pendingconfirm = []; $confirm = [];                    
        $this->confirm($confirm, $year,'0','0',$userdetail);                    
        $this->pendingConfirm($pendingconfirm, $year,'0','0',$userdetail);                    
        $this->notConfirm($notconfirm, $pendingconfirm, $confirm,$year,'0','0',$userdetail);                       
        $statistics = array('month' => $monthName, 'pendingconfirm' => $pendingconfirm, 'confirm' => $confirm, 'notconfirm' => $notconfirm);        

        /* ================== Responsible Langa =================== */
        $whereid = explode(',',Auth::user()->id_ente);
        $responsabilelangaEntity = DB::table('corporations')->whereIn('id', $whereid)->get();

        //exit;
        $arrresponsibleid = array();
        foreach($responsabilelangaEntity as $rkey => $rval){
            if($rval->responsiblelang_id != ""){
             array_push($arrresponsibleid, $rval->responsiblelang_id);               
            }            
        }
        $arrresponsibleid = implode(',',$arrresponsibleid);
        $arrresponsibleid = explode(',',$arrresponsibleid);
        $responsabilelanga = DB::table('users')->whereIn('id', $arrresponsibleid)->get();                            
        
        /* ================= Project Chart Details ================ */
        $partecipanti = DB::table('progetti_partecipanti')->select('id_progetto')->where('id_user', $userid)->get();
        $projectReseller = DB::table('projects')
                ->join('users', 'projects.user_id', '=', 'users.id')
                ->select('projects.*')
                ->whereIn('projects.id', json_decode(json_encode($partecipanti), true))
                ->orWhere('projects.user_id', $userid)
                ->where('users.is_delete', '=', 0)
                ->where('projects.statoemotivo','!=','12')->where('projects.progresso','!=','100')->where('projects.statoemotivo','!=','FINE PROGETTO')->paginate(2);
        
        $arrchartdetails = array();
        $arrProjectdetails = array();
        foreach($projectReseller as $keyp => $valp) {            
            $quote = DB::table('quotes')->where('id', $valp->id_preventivo)->first();
            $dipartimento= (isset($quote->dipartimento) && !empty($quote->dipartimento)) ? $quote->dipartimento : '1';
           
           $arrchartdetails[$valp->id] = DB::select("select `lavorazioni`.*, AVG(`progetti_lavorazioni`.`completamento`) as `completedPercentage` from `lavorazioni` left join `progetti_lavorazioni` on `lavorazioni`.`id` = `progetti_lavorazioni`.`completato` AND `progetti_lavorazioni`.`id_progetto` = $valp->id WHERE `lavorazioni`.`departments_id`=$dipartimento GROUP BY id ORDER BY completedPercentage DESC");
        }
    }
    elseif($userprofiletype === 'Technician') {
        /* Project Chart Details */
        $arrWhere = array('user_id'=>$userid,'is_deleted'=>0);
        $project = DB::table('projects')->where($arrWhere)->where('statoemotivo','!=','12')->where('progresso','!=','100')->where('statoemotivo','!=','FINE PROGETTO')->orWhere('statoemotivo',null)->get();    
         $arrchartdetails = array();
        if(!$project->isEmpty()) {
            foreach($project as $keyp => $valp){
            $quote = DB::table('quotes')->where('id', $valp->id_preventivo)->first();
            $dipartimento= (isset($quote->dipartimento) && !empty($quote->dipartimento)) ? $quote->dipartimento : '1';
            // DB::connection()->enableQueryLog();
            //$processing = DB::table('lavorazioni')->where('departments_id', $dipartimento)->get();
            $arrchartdetails[] = DB::select("select `lavorazioni`.*, AVG(`progetti_lavorazioni`.`completamento`) as `completedPercentage` from `lavorazioni` left join `progetti_lavorazioni` on `lavorazioni`.`id` = `progetti_lavorazioni`.`completato` AND `progetti_lavorazioni`.`id_progetto` = $valp->id WHERE `lavorazioni`.`departments_id`=$dipartimento GROUP BY id ORDER BY completedPercentage DESC");
            /*$arrchartdetails[] = DB::select("select `oggettostato`.*, `progetti_lavorazioni`.`completamento` as `completedPercentage` from `oggettostato` left join `progetti_lavorazioni` on `oggettostato`.`id` = `progetti_lavorazioni`.`completato` AND `progetti_lavorazioni`.`id_progetto` = $valp->id");*/
            }
        } 
        else {
            $dept = $userdetail->dipartimento;
            $processing = DB::table('lavorazioni')->where('departments_id', $dept)->get();
            foreach ($processing as $value) {
                $value->completedPercentage = 0;
                $arrchartdetails[] = $value;
            }
            $arrchartdetails = array($arrchartdetails);
        }
    }
    elseif($userprofiletype === 'Client' || $userprofiletype === 'Customer') { 
        $partecipanti = DB::table('progetti_partecipanti')->select('id_progetto')->where('id_user', $userid)->get();
        $projectsCustomer = DB::table('projects')
            ->join('users', 'projects.user_id', '=', 'users.id')
            ->select('projects.*')
            ->whereIn('projects.id', json_decode(json_encode($partecipanti), true))
            ->orWhere('projects.user_id', $userid)
            ->where('users.is_delete', '=', 0)
            ->where('projects.statoemotivo','!=','12')
            ->where('projects.progresso','!=','100')
            ->where('projects.statoemotivo','!=','FINE PROGETTO')
            ->paginate(2);        
        /*$arrWhere = array('user_id'=>Auth::user()->id,'is_deleted'=>0);        
        $projects = DB::table('projects')->where($arrWhere)->where('statoemotivo','!=','12')->where('progresso','!=','100')->where('statoemotivo','!=','FINE PROGETTO')->paginate(2);*/
        
        $arrchartdetails = array();
        $arrProjectdetails = array();
        foreach($projectsCustomer as $keyp => $valp) {            
           $quote = DB::table('quotes')->where('id', $valp->id_preventivo)->first();
           $dipartimento= (isset($quote->dipartimento) && !empty($quote->dipartimento)) ? $quote->dipartimento : '1';
           $arrchartdetails[$valp->id] = DB::select("select `lavorazioni`.*, AVG(`progetti_lavorazioni`.`completamento`) as `completedPercentage` from `lavorazioni` left join `progetti_lavorazioni` on `lavorazioni`.`id` = `progetti_lavorazioni`.`completato` AND `progetti_lavorazioni`.`id_progetto` = $valp->id WHERE `lavorazioni`.`departments_id`=$dipartimento GROUP BY id ORDER BY completedPercentage DESC");
        }     

        $whereid = explode(',',$userdetail->id_ente);
        $responsabilelangaEntity = DB::table('corporations')->whereIn('id', $whereid)->get();
        $arrresponsibleid = array();
        foreach($responsabilelangaEntity as $rkey => $rval){
            if($rval->responsiblelang_id != ""){
             array_push($arrresponsibleid, $rval->responsiblelang_id);               
            }            
        }
        $arrresponsibleid = implode(',',$arrresponsibleid);
        $arrresponsibleid = explode(',',$arrresponsibleid);        
        $responsabilelanga = DB::table('users')->whereIn('id', $arrresponsibleid)->get();                    
       
    }
    else { 
        /* =============================== Statisctics sections =================================== */
        $guadagno = []; $revenues = []; $expenses = [];
        $this->compexpense($expenses, $year);
        $this->compRevenue($revenues, $year);
        $this->calcolaGuadagno($guadagno, $revenues, $expenses);          
        $statistics = array('month' => $monthName, 'revenue' => $revenues, 'expense' => $expenses, 'earn' => $guadagno); 
    }

     return view('webview.dashboard_view', [
            'userid'=>$userid,
            'type'=>$viewtype,
            'statistics' =>$statistics,
            'year' => $year,
            'day' => $day,
            'month' => $month,
            /*'forecastday'=>$forecastday,
            'location'=>$arrCurrentLocation['city'].', '.$arrCurrentLocation['country'],*/
            'giorniMese' => date('t', mktime(0, 0, 0, $month, $day, $year)),
            'nomiMesi' => $monthName,
            'events' => $eventi,
            'enti' => $this->getEntity($userdetail),
            'utenti' => DB::table('users')->get(),
            'tipo' => $calendortype,            
            'estimates' => $estimates,
            'projects' => $projects,
            'invoices' => $invoices,
            'userprofiletype'=>$userprofiletype,
            'chartdetails' =>$arrchartdetails,
            'projectsCustomer'=>$projectsCustomer,
            'responsabilelanga'=>$responsabilelanga,
            'projectReseller'=>$projectReseller,
            'resellerdetails'=>$resellerdetails
        ]); 
  }

    public function calendorDetails(&$eventi,&$estimates,&$projects,&$invoices,$month,$day,$year,$type,$userid){
    
        if($month == date('n') && $day == 0 && $year == date('Y'))
            $day = date('j');

        if($userid==0 || $type==1)
            $eventi=DB::table('events')->orderBy('mese', 'asc')->get();
        else if($type==0)
            $eventi=DB::table('events')->where('user_id', $userid)->orderBy('mese', 'asc')->get();
        
        
        $estimates = array();
        $projects = array();
        $invoices = array();
        /* === Estimates Details === */
        if($userid == 0 && $type==2) {
            $estimates = DB::table('quotes')
            ->leftJoin('users', 'users.id', '=', 'quotes.user_id')
            ->select('users.color as color','users.name','quotes.*')
            ->where('quotes.is_deleted', 0)->where('users.is_delete',0)->get();                                           
        }
        else if($type==2) {            
            $userid = $userid;
            $arrwhere['quotes.is_deleted'] = 0;
            $arrwhere['statiemotivipreventivi.id'] = '8';                        
            $estimates = DB::table('quotes')
            ->Join('statipreventivi', 'statipreventivi.id_preventivo', '=', 'quotes.id')
            ->Join('statiemotivipreventivi', 'statiemotivipreventivi.id', '=', 'statipreventivi.id_tipo')
            ->leftJoin('users', 'users.id', '=', 'quotes.user_id')
            ->where($arrwhere)
            ->where(function ($query) use ($userid)  {                
                $query->where('quotes.user_id', $userid)
                      ->orWhere('quotes.idutente', $userid);
            })
            ->select('users.color as color','users.name','quotes.*')->get();                
        }

        /* === Project Details === */
        if($type==2){
            $projectwhere['is_deleted'] = 0;
            $projectwhere['users.is_delete'] = 0;
            if($userid != 0) {
                $projectwhere['projects.user_id'] = $userid;
            }
            $projects = DB::table('projects')
                ->join('users', 'projects.user_id', '=', 'users.id')
                ->select(DB::raw('projects.*, users.id as uid, users.is_delete, users.color'))
                ->where('datafine','!=','')                
                ->where($projectwhere)
                ->orderBy('projects.id', 'asc')
                ->get();

            /* Invoice Details */
            $invoicewhere['users.is_delete'] = 0;
            if(Auth::user()->id != 0) {
                $invoicewhere['tranche.user_id']=$userid;            
            }
            $invoices = DB::table('tranche')
                    ->join('users', 'tranche.user_id','=','users.id')
                    ->select(DB::raw('tranche.*, users.id as uid, users.is_delete, users.color'))                
                    ->where($invoicewhere)
                    ->get();  
        }    
    }

    public function getEntity($user)
    {   
      if($user->id == 0 || $user->dipartimento == 0) {
      /*$data = Corporation::where('is_deleted', 0)->orderBy('id', 'asc')->get();*/     
        $data = DB::table('corporations')
        ->join('users', 'corporations.user_id', '=', 'users.id')
        ->select('corporations.*')
        ->where('is_deleted','0')
        ->where('users.is_delete', '=', 0)
        ->where('corporations.is_approvato', 1)
        ->orderBy('corporations.id', 'asc')
        ->get();

      foreach($data as $data) {       
        if($data->statoemotivo != ""){
          $statiemotivitipi = DB::table('statiemotivitipi')->where('id',$data->statoemotivo)->orderBy('id', 'asc')->first();
          if(isset($statiemotivitipi->language_key)){
            $data->statoemotivo = (!empty($statiemotivitipi->language_key)) ? trans('messages.'.$statiemotivitipi->language_key) : $statiemotivitipi->name;
          }
          if(isset($statiemotivitipi->color)){
           $data->statoemotivo = '<span style="color:'.$statiemotivitipi->color.'">'.ucwords(strtolower($data->statoemotivo)).'</span>';
          }
        }
        $data->nomeazienda = ucwords(strtolower($data->nomeazienda));
        $data->nomereferente = ucwords(strtolower($data->nomereferente));
        $data->settore = ucwords(strtolower($data->settore));
        $data->responsabilelanga = ucwords(strtolower($data->responsabilelanga));       
        $ente_return[] = $data; 
      } 
      return $ente_return;
    } 
    else {      
      $partecipanti = DB::table('enti_partecipanti')
        ->select('id_ente')
        ->where('id_user', $user->id)
        ->orderBy('id', 'asc')
        ->get();
      $ente_return = [];
      $enti = DB::table('corporations')          
          ->select('corporations.*')
          ->where('privato', 0)
          ->whereIn('id', json_decode(json_encode($partecipanti), true))
          ->orWhere('user_id', $user->id)
          ->orWhere('responsabilelanga', $user->name)
          ->orderBy('id', 'asc')
          ->get();
      
      foreach($enti as $ente) {      
        if($ente->is_deleted == 0){
          if($ente->statoemotivo != ""){
            $statiemotivitipi = DB::table('statiemotivitipi')->where('id',$ente->statoemotivo)->orderBy('id', 'asc')->first();
            if(isset($statiemotivitipi->language_key)){
              $ente->statoemotivo = (!empty($statiemotivitipi->language_key)) ? trans('messages.'.$statiemotivitipi->language_key) : $statiemotivitipi->name;           
            }
            if(isset($statiemotivitipi->color)){
              $ente->statoemotivo = '<span style="color:'.$statiemotivitipi->color.'">'.ucwords(strtolower($ente->statoemotivo)).'</span>';
            }
          }

          $ente->nomeazienda = ucwords(strtolower($ente->nomeazienda));
          $ente->nomereferente = ucwords(strtolower($ente->nomereferente));
          $ente->settore = ucwords(strtolower($ente->settore));
          $ente->responsabilelanga = ucwords(strtolower($ente->responsabilelanga));
          $ente_return[] = $ente;          
        }
      }
      return $ente_return;
    }
    }


    /*=============== Adminstrator Dashboard Statistics sections Start ============== */
    public function compexpense(&$expenses, $year) {
        for($i = 1; $i <= 12; $i++) {
            if($i < 10)
                $i = '0' . $i;
            $timestamp=strtotime('1-'.$i.'-'.$year);;
            $expense = DB::table('costi')
            ->selectRaw("sum(costo) as cost")
            ->whereBetween('datainserimento',[date('Y-m-01',$timestamp),date('Y-m-t',$timestamp)])
            ->first();      
            $expenses[] =  ($expense->cost!=null)?$expense->cost:0;
        }
    }
    public function compRevenue(&$revenues, $year)
    {
        DB::connection()->enableQueryLog();
        for($i = 1; $i <= 12; $i++) {
            if($i < 10)
                $i = '0' . $i;
        $timestamp = strtotime('1-'.$i.'-'.$year);
        $revenue = DB::table('tranche')
        ->Join('users', 'users.id', '=', 'tranche.user_id')
        ->selectRaw("sum(imponibile) as cost,dipartimento ")
        ->where('privato', 0)
        /*->where('dipartimento', 2)*/
        ->whereBetween('datainserimento',[date('Y-m-01',$timestamp),date('Y-m-t',$timestamp)])
        ->groupBy('dipartimento')
        ->get();
        $totrevn=0; 
        foreach($revenue as $revkey=>$revval){
            if($revval->dipartimento==2)
            $totrevn-=$revval->cost;
            else
            $totrevn+=$revval->cost;
        }
        $revenues[] =  $totrevn;            
        }
    }
    public function calcolaGuadagno(&$guadagno, $revenues, $expenses) {       
        foreach($revenues as $key=>$val) {
            $guadagno[] = $val + $expenses[$key];
        }   
    }
    /*=============== Adminstrator Dashboard Statistics sections End ============== */

    /*=============== Commercial Dashboard Sections Start ============== */
    public function confirm(&$confirm, $year, $startDate = '0', $endDate ='0',$userdetails="") {        
        $startMonth =  1;
        $endMonth = 12;        
        if($year == '0' && $startDate != '0' && $endDate !='0') {            
            $startMonth = date("m",strtotime($startDate));
            $endMonth = date("m",strtotime($endDate));                       
            $startYear = date("Y",strtotime($startDate));
            $endYear = date("Y",strtotime($endDate));
            $totalmonth = (($endYear - $startYear) * 12) + ($endMonth - $startMonth);
            /*$endMonth = ($totalmonth > 12) ? $totalmonth : 12;
            $startMonth = ($totalmonth > 12) ? $startMonth : 1;*/
        }
        else {
             $startYear = $year;
             $endYear = $year;
        }
        $totalYear = ($endYear - $startYear);
        for($y = $startYear; $y <= $endYear; $y++) {
            $endmonth = ($y == $endYear) ? $endMonth : 12;
            $startmonth = ($y == $startYear) ? $startMonth : 01;
            /* Get the Year wise data */
            if($totalYear > 2){                           
                    $arrbetween = array(date('Y-01-01',strtotime('1-1-'.$y)),date('Y-12-31',strtotime('1-1-'.$y))); 
                    DB::connection()->enableQueryLog();
                    $preventivi = DB::table('quotes')
                    ->selectRaw("sum(quotes.totale) as confirmamount")
                    ->join('statipreventivi', 'quotes.id', '=', 'statipreventivi.id_preventivo')
                    ->join('statiemotivipreventivi', 'statiemotivipreventivi.id', '=', 'statipreventivi.id_tipo')
                    ->where(function($query) use($userdetails) {
                        $query->where('quotes.user_id', '=', $userdetails->id)
                            ->orWhere('quotes.idutente', '=', $userdetails->id);
                    })->where('statiemotivipreventivi.id', '6')
                    ->whereBetween('statipreventivi.created_at',$arrbetween)
                    ->where('quotes.is_deleted', 0)->first();                                      
                   /* $queries = DB::getQueryLog();
                    $last_query = end($queries);
                    print_r($last_query);                
                    exit;*/
                    $confirm[] =  ($preventivi->confirmamount!=null)?$preventivi->confirmamount:0;               
            }
            else {
                for($i = $startmonth; $i <= $endmonth; $i++) {
                    /*if($i < 10)
                        $i = '0' . $i;*/                
                    $timestamp = ($year != 0) ? strtotime('1-'.$i.'-'.$year) : strtotime('1-'.$i.'-'.$y);            
                    $arrbetween = array(date('Y-m-01',$timestamp),date('Y-m-t',$timestamp)); 

                    DB::connection()->enableQueryLog();
                    $preventivi = DB::table('quotes')
                    ->selectRaw("sum(quotes.totale) as confirmamount")
                    ->join('statipreventivi', 'quotes.id', '=', 'statipreventivi.id_preventivo')
                    ->join('statiemotivipreventivi', 'statiemotivipreventivi.id', '=', 'statipreventivi.id_tipo')
                    ->where(function($query) use($userdetails){
                        $query->where('quotes.user_id', '=', $userdetails->id)
                            ->orWhere('quotes.idutente', '=', $userdetails->id);
                    })->where('statiemotivipreventivi.id', '6')
                    ->whereBetween('statipreventivi.created_at',$arrbetween)
                    ->where('quotes.is_deleted', 0)->first();          
                    // $query = DB::getQueryLog();
                    // $lastQuery = end($query);
        
                    // dd($preventivi);
                   /* $queries = DB::getQueryLog();
                    $last_query = end($queries);
                    print_r($last_query);                
                    exit;*/
                    $confirm[] =  ($preventivi->confirmamount!=null)?$preventivi->confirmamount:0;
                }
            }
        }
    }
    public function pendingConfirm(&$pendingconfirm, $year, $startDate = '0', $endDate ='0',$userdetails="")
    {
        $startMonth =  1;
        $endMonth = 12;
        if($year == '0' && $startDate != '0' && $endDate !='0') {
              $startMonth = date("m",strtotime($startDate));
              $endMonth = date("m",strtotime($endDate));
              $startYear = date("Y",strtotime($startDate));
              $endYear = date("Y",strtotime($endDate));
              $totalmonth = (($endYear - $startYear) * 12) + ($endMonth - $startMonth);
              /*$endMonth = ($totalmonth > 12) ? $totalmonth : 12;
              $startMonth = ($totalmonth > 12) ? $startMonth : 1;*/
        } 
        else {
             $startYear = $year;
             $endYear = $year;
        }  
        $totalYear = ($endYear - $startYear);  

        for($y = $startYear; $y <= $endYear; $y++) {
            $endmonth = ($y == $endYear) ? $endMonth : 12;                         
            $startmonth = ($y == $startYear) ? $startMonth : 01;  
            if($totalYear > 2){                                                                  
                    $arrbetween = array(date('Y-01-01',strtotime('1-1-'.$y)),date('Y-12-31',strtotime('1-1-'.$y))); 

                    DB::connection()->enableQueryLog();
                    $preventivi = DB::table('quotes')
                    ->selectRaw("sum(quotes.totale) as confirmamount")
                    ->join('statipreventivi', 'quotes.id', '=', 'statipreventivi.id_preventivo')
                    ->join('statiemotivipreventivi', 'statiemotivipreventivi.id', '=', 'statipreventivi.id_tipo')
                    ->where(function($query) use($userdetails) {
                        $query->where('quotes.user_id', '=', $userdetails->id)
                            ->orWhere('quotes.idutente', '=', $userdetails->id);
                    })->where('statiemotivipreventivi.id', '9')
                    ->whereBetween('statipreventivi.created_at',$arrbetween)
                    ->where('quotes.is_deleted', 0)->first();                  
                     /*$queries = DB::getQueryLog();
                        $last_query = end($queries);
                        print_r($last_query);                
                        exit;*/
                    $pendingconfirm[] =  ($preventivi->confirmamount!=null)?$preventivi->confirmamount:0;                
            }
            else {
                for($i = $startmonth; $i <= $endmonth; $i++) {
                    /*if($i < 10)
                        $i = '0' . $i;
                    $timestamp=strtotime('1-'.$i.'-'.$year);
                     $arrbetween = ($year != 0) ? array(date('Y-m-01',$timestamp),date('Y-m-t',$timestamp)) : array(date('Y-m-d',strtotime($startDate)),date('Y-m-d',strtotime($endDate)));   */
                    $timestamp = ($year != 0) ? strtotime('1-'.$i.'-'.$year) : strtotime('1-'.$i.'-'.$y);            
                    $arrbetween = array(date('Y-m-01',$timestamp),date('Y-m-t',$timestamp)); 

                    DB::connection()->enableQueryLog();
                    $preventivi = DB::table('quotes')
                    ->selectRaw("sum(quotes.totale) as confirmamount")
                    ->join('statipreventivi', 'quotes.id', '=', 'statipreventivi.id_preventivo')
                    ->join('statiemotivipreventivi', 'statiemotivipreventivi.id', '=', 'statipreventivi.id_tipo')
                    ->where(function($query) use($userdetails) {
                        $query->where('quotes.user_id', '=', $userdetails->id)
                            ->orWhere('quotes.idutente', '=', $userdetails->id);
                    })->where('statiemotivipreventivi.id', '9')
                    ->whereBetween('statipreventivi.created_at',$arrbetween)
                    ->where('quotes.is_deleted', 0)->first();                  
                     /*$queries = DB::getQueryLog();
                        $last_query = end($queries);
                        print_r($last_query);                
                        exit;*/
                    $pendingconfirm[] =  ($preventivi->confirmamount!=null)?$preventivi->confirmamount:0;
                }
            } 
        }       
    }

    public function notConfirm(&$notconfirm, $pendingconfirm, $confirm,$year, $startDate = '0', $endDate ='0',$userdetails="") {               
        DB::connection()->enableQueryLog();
        $startMonth =  1;
        $endMonth = 12;
        if($year == '0' && $startDate != '0' && $endDate !='0') {
              $startMonth = date("m",strtotime($startDate));
              $endMonth = date("m",strtotime($endDate));
              $startYear = date("Y",strtotime($startDate));
              $endYear = date("Y",strtotime($endDate));
              $totalmonth = (($endYear - $startYear) * 12) + ($endMonth - $startMonth);
              /*$endMonth = ($totalmonth > 12) ? $totalmonth : 12;
              $startMonth = ($totalmonth > 12) ? $startMonth : 1;*/
        }  
        else {
             $startYear = $year;
             $endYear = $year;
        }    
        $totalYear = ($endYear - $startYear);  
         for($y = $startYear; $y <= $endYear; $y++) {
            $endmonth = ($y == $endYear) ? $endMonth : 12;                         
            $startmonth = ($y == $startYear) ? $startMonth : 01;                        
             if($totalYear > 2){                                                 
                $arrbetween = array(date('Y-01-01',strtotime('1-1-'.$y)),date('Y-12-31',strtotime('1-1-'.$y)));            
                DB::connection()->enableQueryLog();
                $preventivi = DB::table('quotes')
                ->selectRaw("sum(quotes.totale) as confirmamount")
                ->join('statipreventivi', 'quotes.id', '=', 'statipreventivi.id_preventivo')
                ->join('statiemotivipreventivi', 'statiemotivipreventivi.id', '=', 'statipreventivi.id_tipo')
                ->where(function($query) use($userdetails){
                    $query->where('quotes.user_id', '=', $userdetails->id)
                        ->orWhere('quotes.idutente', '=', $userdetails->id);
                })->where('statiemotivipreventivi.id', '8')
                ->whereBetween('statipreventivi.created_at',$arrbetween)
                ->where('quotes.is_deleted', 0)->first();                  
                 /*$queries = DB::getQueryLog();
                    $last_query = end($queries);
                    print_r($last_query);                
                    exit;*/
                $notconfirm[] =  ($preventivi->confirmamount!=null)?$preventivi->confirmamount:0;              
          }
          else {
            for($i = $startmonth; $i <= $endmonth; $i++) {
            /*if($i < 10)
                $i = '0' . $i;
            $timestamp=strtotime('1-'.$i.'-'.$year);
             $arrbetween = ($year != 0) ? array(date('Y-m-01',$timestamp),date('Y-m-t',$timestamp)) : array(date('Y-m-d',strtotime($startDate)),date('Y-m-d',strtotime($endDate))); */
            $timestamp = ($year != 0) ? strtotime('1-'.$i.'-'.$year) : strtotime('1-'.$i.'-'.$y);            
            $arrbetween = array(date('Y-m-01',$timestamp),date('Y-m-t',$timestamp)); 
           
            DB::connection()->enableQueryLog();
            $preventivi = DB::table('quotes')
            ->selectRaw("sum(quotes.totale) as confirmamount")
            ->join('statipreventivi', 'quotes.id', '=', 'statipreventivi.id_preventivo')
            ->join('statiemotivipreventivi', 'statiemotivipreventivi.id', '=', 'statipreventivi.id_tipo')
            ->where(function($query) use($userdetails) {
                $query->where('quotes.user_id', '=', $userdetails->id)
                    ->orWhere('quotes.idutente', '=', $userdetails->id);
            })->where('statiemotivipreventivi.id', '8')
            ->whereBetween('statipreventivi.created_at',$arrbetween)
            ->where('quotes.is_deleted', 0)->first();                  
             /*$queries = DB::getQueryLog();
                $last_query = end($queries);
                print_r($last_query);                
                exit;*/
            $notconfirm[] =  ($preventivi->confirmamount!=null)?$preventivi->confirmamount:0;
          }
          }
        }        
    }
    /*=============== Commercial Dashboard sections End ============== */

    /* Confirm Quotes By signature */    
    public function confirmQuotesSignature(Request $request) {       
      $user = DB::table('users')->where('api_token','!=', null)->where('api_token', $this->api_token)->first();     
      if($user) {
        $validator = Validator::make($request->all(), ['signature' => 'required','quoteid'=>'required|numeric']);      
        if ($validator->fails()) {
            /*return Redirect::back()->withInput()->withErrors($validator);*/
            $this->request_param = json_encode($request->all());
            $respo = array('message'=>json_encode($validator->errors()),'status'=>'fail');
            $this->responde_param = json_encode($respo);
            $this->storerequestresponse();
            return response()->json($respo);
        }  
        $response = DB::table('quotes')->where('id', $request->quoteid)->update(array('signature' => $request->signature));      
        $quoteDetails = DB::table('quotes')->where('id',$request->quoteid)->where('signature',$request->signature)->get();        
        if($quoteDetails) {
          // Get confirm state id
          $tipo = DB::table('statiemotivipreventivi')->where('id', '6')->first();
          DB::table('statipreventivi')->where('id_preventivo', $request->quoteid)->delete();
          DB::table('statipreventivi')->insert([
              'id_tipo' => $tipo->id,
              'id_preventivo' => $request->quoteid,
              'created_at'=>date('Y-m-d H:i:s')
            ]);          
          $respo = array('result'=>$quoteDetails,'status'=>'success');
          $this->responde_param = json_encode($respo);
          $this->storerequestresponse();
          return response()->json($respo);            
        }
        $respo = array('result'=>array(),'status'=>'fail');
        $this->responde_param = json_encode($respo);
        $this->storerequestresponse();
        return response()->json($respo);            
      }
    }

    /*Media File Upload for in qoutes,project,invoice */
    public function mediafileupload(Request $request) {   
      $user = DB::table('users')->where('api_token','!=', null)->where('api_token', $this->api_token)->first();     
      if($user) {
        $webviewurl = $request->webviewurl;
        $c = explode('/',$webviewurl);
        $last = explode('/', end($c));          
        $last = $last[0];

        if (strpos($webviewurl,'estimates/add') !== false) {
          $master_type = 0;            
        }
        elseif(strpos($webviewurl,'estimates/modify/quote/') !== false){
          $master_type = 0;   
          $master_id =  $last;         
        }
        elseif(strpos($webviewurl,'progetti/add') !== false) {
          $master_type = 1;             
        }
        elseif(strpos($webviewurl,'progetti/modify/project') !== false){
          $master_type = 1;   
          $master_id =  $last;         
        }
        elseif(strpos($webviewurl,'pagamenti/tranche/add') !== false){
          $master_type = 3;             
        }
        elseif(strpos($webviewurl,'pagamenti/tranche/modifica') !== false){
          $master_type = 3;   
          $master_id =  $last;         
        }                
        /* 0:Quote,1:Proeject,3:Invoice */
        if(isset($master_type)) {
          $arrfolder[0]='quote';
          $arrfolder[1]='projects';
          $arrfolder[3]='invoice';        
          Storage::put('images/'.$arrfolder[$master_type].'/'.$request->file('file')->getClientOriginalName(), file_get_contents($request->file('file')->getRealPath()));          
          $nome = $request->file('file')->getClientOriginalName();  
          $lastinserid = DB::table('media_files')->insertGetId([
            'name' => $nome,
            'code' => "",
            'title'=> isset($request->title) ? $request->title : "",
            'description'=> isset($request->description) ? $request->description : "",
            'master_type' => $master_type,
            'type'=>$user->dipartimento,
            'master_id' => isset($master_id) ? $master_id : 0,
            'date_time'=>time()
          ]);         
          $uploadeDetail = DB::table('media_files')->where('id',$lastinserid)->get();
          $respo = array('result'=>$uploadeDetail,'status'=>'success');
          $this->responde_param = json_encode($respo);
          $this->storerequestresponse();
          return response()->json($respo);            
        }
      }
       $uploadeDetail = DB::table('media_files')->where('id',$lastinserid)->get();
       $respo = array('result'=>'Some Data are missing','status'=>'fail');
       $this->responde_param = json_encode($respo);
       $this->storerequestresponse();
       return response()->json($respo);            
    }
}
