<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Validator;
use Redirect;
use Session;

class CommonController extends Controller
{   

	public function __construct(Request $request){ 
        $this->middleware('auth');
    }

    public function downloadcsv(Request $request)
    {
              
        $language = DB::table("language_transalation")->get();
        $url = url('public/csv/keyword.csv');
        
        if(file_exists( $url )){
            
            unlink( $url );
        }

        
        $test = $_SERVER['DOCUMENT_ROOT'].'/easylanganew/public/csv/keyword.csv';
        
        chmod( $test, 0777);
        $fp = fopen( $test, 'w+');
        
        
        $title['language_key']='language_key'; 
        $title['language_label']='language_label';
        $title['language_value']='language_value';
        $title['code']='code';
        $title['date']='date';

        fputcsv($fp, $title);

        foreach ($language as $value) {

            $value = (array) $value;
            $value['language_key']= str_replace('.','',$value['language_key']);
            unset($value['id']);
            
            fputcsv($fp, $value);
        }

        fclose($fp);

        return redirect($url);
    
    }

    public function uploadcsv(Request $request)
    {
  
        $class1="";
        $message='';
        $error=0;
        $target_dir = url('public/');
        
        $target_file = $target_dir . basename($_FILES["file"]["name"]);


        $target_file = $_FILES['file']['name'];
        $fileType = pathinfo($target_file,PATHINFO_EXTENSION);
        if($fileType != "csv")  // here we are checking for the file extension. We are not allowing othre then (.csv) extension .
        {
            $message .= "Sorry, only CSV file is allowed.<br>";
            $error=1;
        }
        else
        {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file))
             {
                DB::table('language_transalation')->truncate(); 

                $message .="File uplaoded successfully.<br>";

                if (($getdata = fopen($target_file, "r")) !== FALSE)
               {
                    $x = 0;

                    while (($data = fgetcsv($getdata, 10000, ",")) !== FALSE) 
                    {
                        ini_set('max_execution_time', 300);
                        if($x > 0) 
                        {                                               
                           DB::table('language_transalation')->insert(array(
                                'language_key' =>$data[0],
                                'language_label' => $data[1],
                                'language_value' => $data[2],
                                'code' => $data[3],
                                'date'=>$data[4]
                            ));                               
                        }
                        $x++;
                    }
                    
                        fclose($getdata);
                    
                }
                    unlink($target_file);
            } 
            else 
            {
                $message .="Sorry, there was an error uploading your file.";
                $error=1;
            }
        }
        
        return redirect()->back();
    
    }

    public function getStateList(Request $request)
    {
        $states = DB::table("stato")
            ->lists("nome_stato","id_stato");

        return response()->json($states);
    }
    
    public function getCityList($id)
    {
        $cities = DB::table("citta")
            ->where("id_stato", $id)
            ->pluck("nome_citta","id_citta");

        return json_encode($cities);
    }

    // store client sign up details
    public function storeclientsignup(Request $request)
    {     

        $validator = Validator::make($request->all(), [
            'nomeazienda' => 'required',
            'nomereferente' => 'required',
            'telefonoprimario' => 'required',
            'emailprimaria' => 'required|email|max:255|unique:corporations',
            'settore' => 'required',
            'telefonosecondario' => '',
            'emailsecondario' => 'email|max:255|unique:corporations',
            'fax' => '',
            'statoemotivo' => '',
            'cf' => '',
            'cartadicredito' => '',
            'iban' => '',
            'swift' => '',
            'sedelegale' => '',
            'indirizzospedizione' => '',
            // 'logo'=>'required|image| max:10000'
        ]);

        if ($validator->fails()) {

            return Redirect::back()
                ->withInput()
                ->withErrors($validator);
        }
        
        DB::table('corporations')->insert(array(
            'nomeazienda' => isset($request->nomeazienda) ? $request->nomeazienda : '',
            'nomereferente' => isset($request->nomereferente) ? $request->nomereferente :'',
            'telefonoprimario' => isset($request->telefonoprimario) ? $request->telefonoprimario : '',
            'emailprimaria' => isset($request->emailprimaria) ? $request->emailprimaria :'',
            'settore' => isset($request->settore) ? $request->settore :'',
            'telefonosecondaria' => isset($request->telefonosecondario) ? $request->telefonosecondario : '',
            'emailsecondaria' => isset($request->emailsecondaria) ? $request->emailsecondaria : '',
            'fax' => isset($request->fax) ? $request->fax : '',
            'statoemotivo' => isset($request->statoemotivo) ? $request->statoemotivo : '',
            'cf' => isset($request->cf) ? $request->cf : '',
            'cartadicredito' => isset($request->cartadicredito) ? $request->cartadicredito : '' ,
            'iban' => isset($request->iban) ? $request->iban : '',
            'swift' => isset($request->swift) ? $request->swift : '',
            'sedelegale' => isset($request->sedelegale) ? $request->sedelegale : '',
            'indirizzospedizione' => isset($request->indirizzospedizione) ? $request->indirizzospedizione : '',
            'logo' => isset($request->logo) ? $request->logo : ''
        ));

        return Redirect::back()
            ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4> Created ..!!! </h4></div>');
    }

    public function storesteptwo(Request $request)
    {        
        $user = DB::table('users')
            ->where('id', $request->user_id)
            ->update( array( 'dipartimento' => $request->role ));
        $user_id = $request->user_id;

        if($user) { 
            $user = DB::table('users')->where('id', $user_id)->first();
            return json_encode($user); 
        }
        return 'true';
    }
	
	public function nextstep()
	{
		
		if (Session::has('reg_user_id')) {
			$reg_user_id = Session::get('reg_user_id');
			$reg_user =  DB::table('users')->where('id', $reg_user_id)->first();
		}
		return  view("auth.register-second",["reg_user"=>$reg_user]);

	}

    public function storestepthree(Request $request)
    {
        $user = DB::table('users')
            ->where('id', $request->user_id_three)
            ->update( array( 
                'id_citta' => $request->city, 
                'id_stato' => $request->state,
            ));

       $user_id = $request->user_id_three;

        if($user) { 
            $user = DB::table('users')->where('id', $user_id)->first();
            return json_encode($user); 
        }
        return 'true';
    }

    public function storestepfour(Request $request)
    {
        $user = DB::table('users')
            ->where('id', $request->user_id_forth)
            ->update( array( 
                'color' => $request->color, 
                'cellulare' => $request->cellphone,
                'logo' => $request->logo,
            ));

       $user_id = $request->user_id_forth;

        if($user) { 
            $user = DB::table('users')->where('id', $user_id)->first();
            return json_encode($user); 
        }
        return 'true';
    }

    // show add alert form
    public function addalert(Request $request)
    {
        /*if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {*/ 
        DB::connection()->enableQueryLog();
        $entity = DB::table('corporations')->where('is_deleted', '=', 0)->get(); 
        $role = DB::table('ruolo_utente')->where('is_delete', '=', 0)->where('ruolo_id', '!=', 0)->get();
		$alerttype = DB::table('alert_tipo')->get();
        
                /*$queries = DB::getQueryLog();
                $last_query = end($queries);
                print_r($last_query);*/

            if($request->user()->id != 0){               
                $arrwhere = array('enti_partecipanti.id_user' => $request->user()->id,'corporations.is_deleted'=> 0);           
                $arrorwhere = array('corporations.user_id' => $request->user()->id,'corporations.is_deleted'=> 0);           
                $entity =   DB::table('corporations')     
                ->leftjoin('enti_partecipanti', 'enti_partecipanti.id_ente', '=', 'corporations.id')
                ->where($arrwhere)
                ->select('corporations.*')
                ->orwhere($arrorwhere)
                ->groupBy('corporations.id')
                ->get();
                /*DB::enableQueryLog();
                $queries = DB::getQueryLog();
                $last_query = end($queries);
                print_r($last_query);*/
                /*select `corporations`.* from `corporations` join `enti_partecipanti` on `enti_partecipanti`.`id_ente` = `corporations`.`id` where (`enti_partecipanti`.`id_user` = 54 and `is_deleted` = 0) or (`corporations`.`user_id` = 54 and `is_deleted` = 0) group by `corporations`.`id`*/
                $querytype = DB::table('ruolo_utente')->where('ruolo_id', $request->user()->dipartimento)->where('ruolo_id', '!=', 0)->first();
                $type = isset($querytype->nome_ruolo) ? $querytype->nome_ruolo : "";
				
				/*$arrwheretype = array();
                if ($type === 'Administration') {                  
					$arrwheretype = array('1','9');//payment and info alert
				}
                elseif($type === 'Commerical' || $type === 'Reseller') { // Commercial 
					$arrwheretype = array('7','9'); // commercial(yello) and info alert
				}
                elseif($type === 'Technician') { // Technician         
					$arrwheretype = array('8','9'); // green and info alert                
				}			

				$alerttype = DB::table('alert_tipo')->whereIn('id_tipo',$arrwheretype)->get();*/
                /*$role = DB::table('ruolo_utente')->where('ruolo_id', $request->user()->dipartimento)->where('ruolo_id', '!=', 0)->get();*/
            }             
            return view('addalertform', [
                'enti' => $entity,
                'ruolo_utente' => $role,
                'alert_tipo' => $alerttype,
            ]);
        /*}*/
    }

    // get alert entity in json format
    public function getalertjson(Request $request)
    {
        $entity = DB::table('inviare_avviso')
                    ->get();  
        foreach($entity as $newkey=>$newval)
        {
            $newval->data_lettura=($newval->data_lettura!='0000-00-00 00:00:00')?date('d-m-Y h:i:s a',strtotime($newval->data_lettura)):'-';
            $allaray[]=$newval;
        }
        return json_encode($allaray);
    }
	
	//store alert details
    public function storeadminalert(Request $request) {
            $validator = Validator::make($request->all(), [
                'nome_alert' => 'required',
                'tipo_alert' => 'required',
                'ente' => 'required',                
                'messaggio' => ''
            ]);
            if ($validator->fails()) {
                return Redirect::back()
                    ->withInput()
                    ->withErrors($validator);
            }            
            
            $entity = implode(",", $request->input('ente'));
            $role = ($request->input('ruolo') && !empty($request->input('ruolo'))) ? implode(",", $request->input('ruolo')) : 'All'; 
            $today = date("Y-m-d");
            $message = strip_tags($request->messaggio);
            DB::table('alert')->insert([
                'nome_alert' => $request->nome_alert,
                'tipo_alert' => $request->tipo_alert,
                'ente' => $entity,
                'ruolo' => $role,
                'messaggio' => $message,
                'is_email'=> isset($request->is_email) ? $request->is_email : '0',
                'is_system_info'=> isset($request->is_system_info) ? $request->is_system_info : '0',
                'created_at' => $today
            ]);
			
			$this->sendalert($request);
            return Redirect::back()
                ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_addsuccessmsg').' </div>');
        }   
		
		// send alert notification to users
    public function sendalert($request)
    {
    	$true = '';
        if($request->user()->id != 0) {            
            return redirect('/unauthorized');

        } else {

            $today = date("Y-m-d");
            $alert = DB::table('alert')
                ->where('created_at', $today)
                ->where('is_sent', '=', 0)
                ->get();

            if($alert->isEmpty()) {
                return "No Alert Remaining...!!";
            }
           	
            foreach ($alert as $value) {
            	$user_entity = $request->user()->id_ente;
            	$corporations = DB::table('corporations')
                    ->where('id', $user_entity)->first();
                   
            	DB::table('inviare_avviso')->insert([
                    'id_ente' => $corporations->id,
                    'user_id' => $request->user()->id,
                    'alert_id' => $value->alert_id,
                    'nome_azienda' => $corporations->nomeazienda,
                    'nome_referente' => $corporations->nomereferente,
                    'settore' => $corporations->settore,
                    'telefono_azienda' => $corporations->telefonoazienda,
                    'email' => $corporations->email,                    
                    'responsible_langa' => $corporations->responsabilelanga,
                    'comment' => '',
                    'conferma' => 'NON LETTO'
                    ]);
            	 
            	DB::table('alert')->where('alert_id', $value->alert_id)
            		->update(array('is_sent' => 1 ));

                $ente = explode(",", $value->ente);
                $ruolo = explode(",", $value->ruolo);

                foreach ($ente as $ente) {
                    $getente = DB::table('enti_partecipanti')->select('id_ente', 'id_user')->where('id_ente', $ente)->get();
                    foreach ($getente as $getente) { 
                        $getrole = DB::table('users')->select('dipartimento')->where('id', $getente->id_user)->where('is_delete', 0)->first(); 
                        if(isset($getrole)) {  
                        	$check = in_array($getrole->dipartimento, $ruolo); 
                        	if($check || $value->ruolo == 'All'){
                        	$corporations = DB::table('corporations')->where('id', $getente->id_ente)->first();  
                            $store = DB::table('inviare_avviso')->insert([
                                'id_ente' => $corporations->id,
                                'user_id' => $getente->id_user,
                                'alert_id' => $value->alert_id,
                                'nome_azienda' => $corporations->nomeazienda,
                                'nome_referente' => $corporations->nomereferente,
                                'settore' => $corporations->settore,
                                'telefono_azienda' => $corporations->telefonoazienda,
                                'email' => $corporations->email,                    
                                'responsible_langa' => $corporations->responsabilelanga,
                                'comment' => '',
                                'conferma' => 'NON LETTO'
                                ]);
	                            if($store) {
	                            	$true = true;     
	                            }
                         	}

	                     	if($value->is_email == '1') {      	
	                     		$emailSubject = "Alert :".$value->nome_alert;
	                     		$toEmail = $corporations->email;
	                    		/*Mail::send('layouts.alertemail', ['content' => $value->messaggio], function ($m) use ($corporations,$emailSubject,$toEmail) {
									$m->from('easy@langa.tv', 'Alert LANGA');
									/*$corporations->email = "developer5@mailinator.com";
									$m->to($corporations->email)->subject($emailSubject);
        						});*/
                    		}
                    	}
                    } 
                }
            }
        }

	    if($true)
	    	return "Send All Alert Successfully";
	    else
	    	return "Somthing Went Wrong";
    } 
    
    public function registerstep2(Request $request) {
        
        /*if (Session::has('reg_user_id')) {
            $reg_user_id = Session::get('reg_user_id');
            $reg_user =  DB::table('users')->where('id', $reg_user_id)->first();
        }*/
        $reg_user = array();
        $departments = DB::table('departments')->get();
        return  view("auth.register-second",["reg_user"=>$reg_user,'departments'=>$departments]);
    }


    public function getdepartmentpackage(Request $request){
        $packagedetails = DB::table('pack')->where('departments_id',$request->departmentid)->get();
        $html = "";
        foreach ($packagedetails as $key => $value) {
            $imageurl = url('public/images/'.$value->icon);
            $html='<div class="wrap-shot">
                            <div class="icon-shot"><img src="'.$imageurl.'" alt="Video Shooting"></div>
                            <div class="video-shot-content">
                                <h3>'.$value->code.'</h3>
                                <p>'.$value->label.'</p>
                                <p>'.nl2br($value->description).'</p>
                            </div>
                        </div>';
        }
        return $html;        
    }
}
