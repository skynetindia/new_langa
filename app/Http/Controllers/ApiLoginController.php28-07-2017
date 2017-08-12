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
			$update = DB::table('users')->where('email', $request->email)->update(array('api_token' => $api_token));
			$userDetails = DB::table('users')->where('email', $request->email)->first();
			$respo = array('result' => $userDetails,'status'=>'success');
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

    /*This is for the entity create of user */
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
		$userdetails = DB::table('users')->where('id', $request->userid)->first();		

		if(isset($request->usertype)){
			$res = DB::table('users')->where('id', $request->userid)->update(array('dipartimento' => $request->usertype));
        }
        $arrCorpwhere = array('email'=>$userdetails->email,'user_id'=>$userdetails->id);
		$entity = DB::table('corporations')->where($arrCorpwhere)->first();		        
		if(count($entity) > 0){
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
		$respo = (count($departmentspack) > 0) ? array('result' => $departmentspack,'status'=>'success') : array('result' => array(),'status'=>'fail');
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
	
	
}
