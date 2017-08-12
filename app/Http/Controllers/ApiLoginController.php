<?php

namespace App\Http\Controllers;

use App\User;
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

/*class Cestino {

    public $id;
    public $tipo;
    public $nome;

}*/

class ApiLoginController extends Controller {

    /**
     * Create a new controller instance.
     *
     *
     */
    
    private $monthnames = array(null, "Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre");
    protected $events;
    public $api_token = "";
    public $request_param = "";
    public $responde_param = "";
    public $responde_url = "";
    public $responde_ip = "";
    public $device_id = "";
    public $device_type = "";
    public function __construct(Request $request) { 
    	$this->api_token = isset($request->api_token) ? $request->api_token : "";
    	$this->responde_url = $request->url();
    	$this->responde_ip = $request->ip();
    	$this->device_id = isset($request->device_id) ? $request->device_id : "";
    	$this->device_type = isset($request->device_type) ? $request->device_type : "";    	     
    }
    /*public function __construct(EventRepository $events,CorporationRepository $corporations) {      		
		//$this->middleware('auth');		
		/*$table->string('api_token', 60)->unique();
		echo str_random(60);
		exit;*
		$arr = Auth::guard('api')->user();		
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

     public function login(Request $request) {
    	$input = $request->all();		
    	$this->request_param = json_encode($request->all());
		if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_delete' => 0, 'is_active'=>0])) {
			$api_token = str_random(60);
			$update = DB::table('users')->where('email', $request->email)->update(array('api_token' => $api_token,'language_id'=>$request->language_id));
			$userDetails = DB::table('users')->where('email', $request->email)->first();
			$respo = array('result' => $userDetails,'status'=>'success');
            $logs = $userDetails->name.' login successfully from App (UserID: '.$userDetails->id.' )';
            storelogs($userDetails->id, $logs);     

			$this->responde_param = json_encode($respo);
			$this->storerequestresponse();
			return response()->json($respo);
		}
		else {
			$respo = array('result' => 'These credentials do not match our records.','status'=>'fail');
			$this->responde_param = json_encode($respo);
			$this->storerequestresponse();
		    return response()->json(['result' => 'These credentials do not match our records.','status'=>'fail']);
		}    	
    }

    public function sociallogin(Request $request) {
        $input = $request->all();       
        $this->request_param = json_encode($request->all());
        $userDetails = DB::table('users')->where(['email'=>$request->email,'social_id'=>$request->social_id])->first();
        if(count($userDetails) > 0) {
            $respo = array('result' => $userDetails,'status'=>'success','isnew'=>'0');
            $logs = $userDetails->name.' login successfully from App Social (UserID: '.$userDetails->id.' )';
            storelogs($userDetails->id, $logs);     
        }
        else {
            $userDetails =  User::create([
            'name' => isset($request->name) ? $request->name : '',
            'email' => isset($request->email) ? $request->email : '',
            'social_id' => $request->social_id,
            'social_type'=> $request->social_type            
            ]);           
            $userDetails = DB::table('users')->where(['email'=>$userDetails->email,'social_id'=>$userDetails->social_id])->first();
            $respo = array('result' => $userDetails,'status'=>'success','isnew'=>'1');
            $logs = $userDetails->name.' Register successfully from App Social (UserID: '.$userDetails->id.')';
            storelogs($userDetails->id, $logs);     

        }

        if (Auth::loginUsingId($userDetails->id)) {
            $api_token = str_random(60);
            $update = DB::table('users')->where('email', $request->email)->update(array('api_token' => $api_token,'language_id'=>$request->language_id));            
            $this->responde_param = json_encode($respo);
            $this->storerequestresponse();
            return response()->json($respo);
        }
        else {
            $respo = array('result' => 'These credentials do not match our records.','status'=>'fail');
            $this->responde_param = json_encode($respo);
            $this->storerequestresponse();
            return response()->json(['result' => 'These credentials do not match our records.','status'=>'fail']);
        }       
    }
        
    /* After Login must call web this for create as session in webview  */
    public function makesessionwebview(Request $request){
        $user = DB::table('users')->where('id', $request->userid)->first();
        $request->session()->put('isAdmin', 1);
        //$request->session()->put('adminID', Auth::id());
                
        if (Auth::loginUsingId($user->id)) {
            return redirect('api/dashboard/entity/'.$user->id);
        }
	}
	
    public function registerstepone(Request $request){
    	/*if(isset($reg_user_id)){
            return Validator::make($data, [
                'email' => 'required|string|email|max:255|unique:users,email,'.$reg_user_id,
                'password' => 'required|string|min:6'
            ]);
        } 
        else {
            return Validator::make($data, [
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6'
            ]);
        }*/
        $this->request_param = json_encode($request->all());
        $validator = Validator::make($request->all(), [
                    'name' => 'required|max:20',                                        
                    'email' => 'required|string|email|max:255|unique:users',
               		'password' => 'required|string|min:6|max:64'                         
                ]);   
        if ($validator->fails()) {
        	//print_r($validator->getMessageBag());                        
            $respo = array('message'=>json_encode($validator->errors()),'status'=>'fail');
			$this->responde_param = json_encode($respo);
			$this->storerequestresponse();
            return response()->json($respo);
        }
         $user =  User::create([
            'name' => isset($request->name) ? $request->name : '',
            'email' => isset($request->email) ? $request->email : '',
            'password' => bcrypt($request->password),            
            ]);
         	
         	$respo = array('result' => $user,'status'=>'success');
			$this->responde_param = json_encode($respo);
			$this->storerequestresponse();
         	return response()->json($respo);
		
    	/*if(isset($reg_user_id)) {
            $user = DB::table('users')->where('id', $reg_user_id)->update(array(
                'name' => isset($name) ? $name : '',
                'email' => isset($data['email']) ? $data['email'] : '',
                'password' => bcrypt($data['password'])
            ));
            return $user;            
        } 
        else {
            $user =  User::create([
            'name' => isset($name) ? $name : '',
            'email' => isset($data['email']) ? $data['email'] : '',
            'password' => bcrypt($data['password'])
            ]);
            // $email = $data['email'];
            // $pswd = bcrypt($data['password']);

            // Mail::send('layouts.nuovaregistrazione', ['user' => $user, 'pswd' => $pswd, 'emailutente' => $email], function ($m) use ($user, $email) {
            //     $m->from('easy@langa.tv', 'Easy LANGA');            
            //     $m->to($email)->subject('RICHIESTA CONFERMA REGISTRAZIONE UTENTE_Easy LANGA');
            // });
            Session::put('reg_user_id', $user->id);    
            return json_encode($user);
        }*/
    }

    /*This is for the entity create of user that store the user type(ie. in next step) like Clients, Resellers.... */
    public function registersteptwo(Request $request){
 		$validator = Validator::make($request->all(), [
                    'phone' => 'required|max:25',                                        
                    'location' => 'required|max:1000',
                    'userid'=>'required'
               		
                ]);   
 		$this->request_param = json_encode($request->all());            
        if ($validator->fails()) {
        	//print_r($validator->getMessageBag());                        
            $respo = array('message'=>json_encode($validator->errors()),'status'=>'fail');
			$this->responde_param = json_encode($respo);
			$this->storerequestresponse();
            return response()->json($respo);
        }				

		if(isset($request->usertype)) {
			$res = DB::table('users')->where('id', $request->userid)->update(array('dipartimento' => $request->usertype));
        }
        $userdetails = DB::table('users')->where('id', $request->userid)->first();      

        $arrCorpwhere = array('email'=>$userdetails->email,'user_id'=>$userdetails->id);
		$entity = DB::table('corporations')->where($arrCorpwhere)->first();		        
		if(count($entity) > 0) {
			DB::table('corporations')->where('id', $entity->id)->update(
				array('nomeazienda' => isset($request->companyname) ? $request->companyname : $userdetails->name,            
	            'settore' => isset($request->sector) ? $request->sector : '',            
	            'telefonoazienda' => isset($request->phone) ? $request->phone : '',            
				'indirizzo' => $request->location)
				);
		}
		else {
			$corp =  DB::table('corporations')->insertGetId([ 
	            'nomeazienda' => isset($request->companyname) ? $request->companyname : $userdetails->name,            
	            'settore' => isset($request->sector) ? $request->sector : '',            
	            'telefonoazienda' => isset($request->phone) ? $request->phone : '',            
				'indirizzo' => $request->location,
				'email' => $userdetails->email,
				'user_id'=>$userdetails->id,							
                /*
				'cellulareazienda' => isset($request->cellulareazienda) ? $request->cellulareazienda : '',
				'emailsecondaria' => $request->emailsecondaria,
				'sedelegale' => $request->sedelegale,
				'indirizzospedizione' => $request->indirizzospedizione,			
	            'fax' => isset($request->fax) ? $request->fax : '',            
				'logo' => $nome,
	            'iban' => isset($request->iban) ? $request->iban : '',
				'swift'=> isset($request->swift) ? $request->swift : '',
				'responsabilelanga' => $request->responsabilelanga,
				'telefonoresponsabile' => isset($request->telefonoresponsabile) ? $request->telefonoresponsabile : '',
				'responsiblelang_id' => $request->responsabilelangaid,			
				'skype_id'=> isset($request->skype_id) ? $request->skype_id : '',*/			
	        ]);
		}
        
        $respo = array('result' => $userdetails,'status'=>'success');
        $this->responde_param = json_encode($respo);
		$this->storerequestresponse();
 		return response()->json($respo);
    }

    public function getsectors(Request $request){
    	$this->request_param = json_encode($request->all());            
		$arrSector = json_decode(file_get_contents(asset('public/json/settori.json')));		

		$respo = (count($arrSector) > 0) ? array('result' => $arrSector,'status'=>'success') : array('result' => array(),'status'=>'fail');
        $this->responde_param = json_encode($respo);
		$this->storerequestresponse();
 		return response()->json($respo);
    }

    /* get the type like clint, Adminstrator, Reseller, Technicain */
    public function getusertype(Request $request){
    	$this->request_param = json_encode($request->all());            
		$usertype = DB::table('ruolo_utente')->where('ruolo_id', '!=','0')->get()->toArray();
		$respo = (count($usertype) > 0) ? array('result' => $usertype,'status'=>'success') : array('result' => array(),'status'=>'fail');
        $this->responde_param = json_encode($respo);
		$this->storerequestresponse();
 		return response()->json($respo);
    }

    public function getdepartments(Request $request){
    	$this->request_param = json_encode($request->all());            
    	$departments = DB::table('departments')->get()->toArray();
		$respo = (count($departments) > 0) ? array('result' => $departments,'status'=>'success') : array('result' => array(),'status'=>'fail');
        $this->responde_param = json_encode($respo);
		$this->storerequestresponse();
 		return response()->json($respo);
    }

    public function getdepartmentspackage(Request $request) {
    	$this->request_param = json_encode($request->all());            
    	$departmentspack = DB::table('pack')->where(['departments_id'=>$request->department_id])->get()->toArray();
        $arrPackages = array();
        foreach ($departmentspack as $module) {            
            $module->icon = url('storage/app/images/'.$module->icon);
            $arrPackages[] = $module;
        }
		$respo = (count($arrPackages) > 0) ? array('result' => $arrPackages,'status'=>'success') : array('result' => array(),'status'=>'fail');
        $this->responde_param = json_encode($respo);
		$this->storerequestresponse();
 		return response()->json($respo);
    }


    public function updateclientpackage(Request $request){
        $validator = Validator::make($request->all(), [
                    'package_department' => 'required',                                        
                    'package_id' => 'required',
                    'userid'=>'required'                    
                ]);   
        $this->request_param = json_encode($request->all());            
        if ($validator->fails()) {
            //print_r($validator->getMessageBag());                        
            $respo = array('message'=>json_encode($validator->errors()),'status'=>'fail');
            $this->responde_param = json_encode($respo);
            $this->storerequestresponse();
            return response()->json($respo);
        }               
        $arrupdate = array('department' => $request->package_department,'package'=>$request->package_id);
        $res = DB::table('users')->where('id', $request->userid)->update($arrupdate);
        $userdetails = DB::table('users')->where('id', $request->userid)->first(); 
        
        $respo = array('result' => $userdetails,'status'=>'success');
        $this->responde_param = json_encode($respo);
        $this->storerequestresponse();
        return response()->json($respo);
    }

     public function registermediaupdate(Request $request){
        $validator = Validator::make($request->all(), [
                    'area_interest' => 'required',                                        
                    'description' => 'required',
                    'file' => 'required',
                    'userid'=>'required'                    
                ]);   
        $this->request_param = json_encode($request->all());            
        if ($validator->fails()) {
            //print_r($validator->getMessageBag());                        
            $respo = array('message'=>json_encode($validator->errors()),'status'=>'fail');
            $this->responde_param = json_encode($respo);
            $this->storerequestresponse();
            return response()->json($respo);
        }
        $nome = time().uniqid().'-usermedia_'.$request->file('file')->getClientOriginalName(); 
        Storage::put('images/usermedia/' . $nome, file_get_contents($request->file('file')->getRealPath()));               
        
        $arrupdate = array('description' => $request->description,'media'=>$nome,'location'=>$request->area_interest);
        $res = DB::table('users')->where('id', $request->userid)->update($arrupdate);
        $userdetails = DB::table('users')->where('id', $request->userid)->first(); 
        
        $respo = array('result' => $userdetails,'status'=>'success');
        $this->responde_param = json_encode($respo);
        $this->storerequestresponse();
        return response()->json($respo);
    }

    /*public function register(Request $request) {        
    	$input = $request->all();
    	$input['password'] = Hash::make($input['password']);
    	User::create($input);
        return response()->json(['result'=>true]);
    }*/
    
   
	/* This api is used for the logout */
	public function logout(){
		Auth::logout();
	}
	
	
	 /* This used to get all the languages with icon and details : 25-Jul-2017 */
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

    /* This used to get languages keyword base on the language code : 08-Aug-2017 */
    public function getlanguagekeywords(Request $request) {
        /*$langcode = isset($request->langcode) ? $request->langcode : 'en';
        App::setLocale($langcode);*/ 
        /*$arrlanguages = array();        
        foreach ($languages as $languageskey => $languagesval) {
            $languagesval->icon = url('storage/app/images/languageicon/'.$languagesval->icon);
            $arrlanguages[] = $languagesval;
        }*/        
        $languages = DB::table('language_transalation')->where(['code'=>$request->code,'is_cmspage'=>'0'])->orderBy('id')->get()->toArray();                    
        $arrResponse = array('result'=>array(),'status'=>'fail');
        if((count($languages) > 0)){
           App::setLocale($request->code);
           $arrResponse = array('result'=>$languages,'status'=>'success');
        }
        

        $this->request_param = json_encode($request->all());
        $this->responde_param = json_encode($arrResponse);
        $this->storerequestresponse();
        return response()->json($arrResponse);
    }		
}
