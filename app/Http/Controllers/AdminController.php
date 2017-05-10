<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Storage;
use Redirect;
use Validator;
use Mail;
use File;

class AdminController extends Controller
{
    public function __construct(Request $request){ 
        $this->middleware('auth');	
    }
	
	// Language details
    public function language(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } 
		else {
			    return view('language', [
                    'language' => DB::table('languages')
                        ->select('*')
                        ->where('id', '!=', 0)
                        ->where('is_deleted', '=', 0)
                        ->paginate(10),
            ]);
        }
    }
	
	// Language details
    public function getjsonlanguage(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } 
		else { 
			$data = DB::table('languages')
                        ->select('*')
                        ->where('id', '!=', 0)
                        ->where('is_deleted', '=', 0)
                        ->get();            
			foreach($data as $data) {				
				if($data->icon != ""){
					
					$data->icon = '<img src="'.url('storage/app/images/languageicon').'/'.$data->icon.'" height="100px" width="100px">';					
				}
				$ente_return[] = $data;	
			}
			return json_encode($ente_return);
        }
    }


    public function modifylanguage(Request $request)
    {    
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } 
		else {
			$language = array();
            if($request->languageid){
                $language = DB::table('languages')
                        ->select('*')
                        ->where('id', $request->languageid)
                        ->first();
			}  
			$permessi = array();
			if(isset($utente->permessi) && !empty($utente->permessi)){
			   $permessi = json_decode($utente->permessi);
			}
			return view('modifylanguage', ['language' => $language]);
        }
    }
	/* Save the lanuage*/
	public function saveLanguage(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } 
		else {
			if(isset($request->languageid) && !empty($request->languageid)){
				$validator = Validator::make($request->all(), [
					'code' => 'required|max:3|min:2|unique:languages,code,'.$request->languageid.',id',
					'name' => 'required|max:50',
					'icon'=>'mimes:jpeg,jpg,png|max:1000'
				]);
			}
			else {
				$validator = Validator::make($request->all(), [
					'code' => 'required|max:3|min:2|unique:languages,code',
					'name' => 'required|max:50',
					'icon'=>'mimes:jpeg,jpg,png|max:1000'
				]);
			}

            if ($validator->fails()) {
                return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }
			/* Update Case */
			if(isset($request->languageid) && !empty($request->languageid)){
				$logo = DB::table('languages')
						->select('icon')
						->where('id', $request->languageid)
						->first();
				
				$arr = json_decode(json_encode($logo), true);
				$nome = $arr['icon'];
				
				if ($request->icon != null) {
					// Memorizzo l'immagine nella cartella public/imagesavealpha
					Storage::put(
							'images/languageicon/' . $request->file('icon')->getClientOriginalName(), file_get_contents($request->file('icon')->getRealPath())
					);
					$nome = $request->file('icon')->getClientOriginalName();
				}
				DB::table('languages')
						->where('id', $request->languageid)
						->update(array(
							'code' => $request->code,
							'icon' => $nome,
							'name' => $request->name,
							'original_name' => $request->original_name,
							'is_default'=>isset($request->is_default) ? $request->is_default : '0'
				));
				if(isset($request->is_default) && $request->is_default == '1'){
					DB::table('languages')
						->where('id', '!=', $request->languageid)
						->update(array('is_default'=>'0'));
				}
				return Redirect::back()
								->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Language updated successfully!</h4></div>');
			}
			else {
				$nome = "";
				if ($request->icon != null) {
					// Memorizzo l'immagine nella cartella public/imagesavealpha
					Storage::put(
							'images/languageicon/' . $request->file('icon')->getClientOriginalName(), file_get_contents($request->file('icon')->getRealPath())
					);
					$nome = $request->file('icon')->getClientOriginalName();
				}				
				if(isset($request->is_default) && $request->is_default == '1'){
					DB::table('languages')
						->where('id', '!=', 0)
						->update(array('is_default'=>'0'));
				}

				DB::table('languages')->insert(array(
							'code' => $request->code,
							'icon' => $nome,
							'name' => $request->name,
							'original_name' => $request->original_name,
							'is_default'=>isset($request->is_default) ? $request->is_default : '0'
				));
				return Redirect::back()
								->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Language added successfully!</h4></div>');
			}
        }
    }
	
	/* This function is used to delete languages */
	public function destroylanguage(Request $request) {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } 
		else {
			    $countRec = DB::table('languages')
                        ->select('*')
                        ->where('id', $request->languageid)
						->where('is_default','1')
                        ->count();
			if($countRec > 0){
				return Redirect::back()
                            ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Default Language not destroyed!</h4></div>');
				
			}
			else {
            DB::table('languages')
						->where('id', $request->languageid)
						->update(array(
							'is_deleted' =>'1'
				));
            return Redirect::back()
                            ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Language deleted successfully!</h4></div>');
			}
        }
    }
	
	
	public function translation(Request $request){
		$re = DB::table('language_transalation')->where('id',$request->code)->first();
		return view('language_translation', [
            'language_transalation' => DB::table('language_transalation')->where('code',$re->code)->get(),
            'language' => DB::table('languages')->where('is_deleted','0')->where('code',$re->code)->first(),
			'code' => $re->code,
        ]);		
	}
	
	
	public function destroytranslation(Request $request) {
		  DB::table('language_transalation')
            ->where('id', $request->id)
            ->delete();
			
			return Redirect::back()
		  ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Phase deleted successfully!</h4></div>');
	}
	public function getjsontranslation(Request $request)
	{
		
		$data = DB::table('language_transalation')				
				->select('*')
				->where('code',$request->code)				
				->get();
			
			$data_return= array();
			/*foreach($data as $data) {				
				$data_return[] = $data->language_label;					
			}*/
		return json_encode($data);
	}
	
	public function addtranslation(Request $request){
		if(isset($request->id)){
			return view('modify_language_translation', 
			['language_transalation' => DB::table('language_transalation')->where('id',$request->id)->first(),
			'language' => DB::table('languages')->where('is_deleted','0')->get()]);
		}
		else {
			return view('modify_language_translation',
			['language' => DB::table('languages')->where('is_deleted','0')->get()]);
		}
	}

	public function savetranslation(Request $request){
			$validator = Validator::make($request->all(), [
				'keyword_title' => 'required'
			]);			

            if($validator->fails()) {
                return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }
		$arrLanguages =  DB::table('languages')
                        ->select('*')
                        ->where('id', '!=', 0)                        
                        ->get();		
		$collection = collect($arrLanguages);
		$arrLanguages = $collection->toArray();
		foreach($arrLanguages as $key => $val){			
			if(isset($request[$val->code.'_keyword_desc'])){
				$language_value = $request[$val->code.'_keyword_desc'];
				$keyword_key = 'keyword_'.str_replace(" ","_",strtolower($request['keyword_title']));
					DB::table('language_transalation')->insert([
						'language_key' => $keyword_key,
						'language_label' =>$request['keyword_title'],
						'language_value' => $language_value,					
						'code' => $val->code
					]);
			}		
		}
		
		return Redirect::back()
                        ->with('error_code', 5)
                        ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Language aggiunto correttamente!</h4></div>');
		
	}
	/* this function is used to write the lanague file/dir */
	public function writelanguagefile(){
		$arrLanguages =  DB::table('languages')
                        ->select('*')
                        ->where('id', '!=', 0)                        
                        ->get();		
		$collection = collect($arrLanguages);
		$arrLanguages = $collection->toArray();
		foreach($arrLanguages as $key => $val){
			$path = './resources/lang/'.$val->code;
			if(!is_dir($path)) {
				mkdir($path, 0775, true);				
			}
			$file = $path.'/messages.php';
			if(is_file($file)){
				unlink($file);				
			}
			if(!is_file($file)){
				$content = "<?php return [";
				$phases =  DB::table('language_transalation')
                        ->select('*')
                        ->where('code', $val->code)                        
                        ->get();		
				$numItems = count($phases);
				$i = 0;
				foreach($phases as $phase){
					if(++$i === $numItems) {
						$content .= "
						'".$phase->language_key."' => '".$phase->language_value."'";
					}
					else {
						$content .= "
						'".$phase->language_key."' => '".$phase->language_value."',";
					}					
				}
				$content .= ']; ?>';
				$fp = fopen($file,"wb");
				fwrite($fp,$content);
				fclose($fp);		
			}
		}
	}
	public function updatetranslation(Request $request){
		$validator = Validator::make($request->all(), [
				'keyword_title' => 'required'
			]);			

            if($validator->fails()) {
                return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }
		$arrLanguages =  DB::table('languages')
                        ->select('*')
                        ->where('id', '!=', 0)                        
                        ->get();		
		$collection = collect($arrLanguages);
		$arrLanguages = $collection->toArray();
		
		foreach($arrLanguages as $key => $val){
			if(isset($request[$val->code.'_keyword_desc'])){
				$language_value = $request[$val->code.'_keyword_desc'];
				$keyword_key = 'keyword_'.str_replace(" ","_",strtolower($request['keyword_title']));
					DB::table('language_transalation')
						->where('language_key', $request->key)
						->where('code', $val->code)
						->update([
						'language_label' =>$request['keyword_title'],
						'language_value' => $language_value
					]);
			}		
		}
		$this->writelanguagefile();
		return Redirect::back()
                        ->with('error_code', 5)
                        ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Language updated successfully!</h4></div>');
		
	}
	

	 // delete alert type
    public function alerttipodelete(Request $request)
    {
        DB::table('alert_tipo')
            ->where('id_tipo', $request->id_tipo)
            ->delete();
        return Redirect::back();
    }

    // update type color
    public function alerttipoUpdate(Request $request)
    {
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {

            DB::table('alert_tipo')
                    ->where('id_tipo', $request->id_tipo)
                    ->update(array(
                        'nome_tipo' => $request->nome_tipo,
                        'desc_tipo' => $request->desc_tipo,
                        'color' => $request->color,
            ));

            return Redirect::back();
        }
    }

    // add alert type
    public function nuovoalertTipo(Request $request)
    {
            if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
           
            DB::table('alert_tipo')->insert([
                'nome_tipo' => $request->nome_tipo,
                'desc_tipo' => $request->desc_tipo,
                'color' => $request->color,
            ]);

            return Redirect::back();
        }
    }

	
    // alert types
    public function alertTipo()
    {
        return view('alerttipo', [
            'alert_tipo' => DB::table('alert_tipo')
                ->get()
        ]);
    }
    public function deletetaxation(Request $request) {
        if($request->user()->id != 0) {

            return redirect('/unauthorized');

        } else {

            DB::table('tassazione')
                ->where('tassazione_id', $request->id)
                ->delete();

            return Redirect::back()
                ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Taxation eliminata correttamente!</h4></div>');
        }
    }


    public function storetaxation(Request $request) {

        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {

            
            $validator = Validator::make($request->all(), [
                'tassazione_nome' => 'required',
                'tassazione_percentuale' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                    ->withInput()
                    ->withErrors($validator);
            }
            
            $tassazione_id = $request->input('tassazione_id');

            if($tassazione_id){

            $tassazione_nome = $request->input('tassazione_nome');
            $tassazione_percentuale = $request->input('tassazione_percentuale');

                DB::table('tassazione')
                    ->where('tassazione_id', $tassazione_id)
                    ->update(array(
                        'tassazione_nome' => $tassazione_nome,
                        'tassazione_percentuale' => 
                        $tassazione_percentuale
                    ));

               return Redirect::back()
                    ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Tassazione update correttamente!</h4></div>');

            } else {

               DB::table('tassazione')->insert([
                'tassazione_nome' => $request->tassazione_nome,
                'tassazione_percentuale' => $request->tassazione_percentuale
                ]);

                return Redirect::back()
                    ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Tassazione aggiunta correttamente!</h4></div>');

            }
        }
    }

    public function getjsontaxation(Request $request) {

        $tassazione = DB::table('tassazione')
          ->get();
        return json_encode($tassazione);
    }

    // show taxation form
    public function addtaxation(Request $request) {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {

            if($request->id){

                $taxation = DB::table('tassazione')
                    ->where('tassazione_id', $request->id)
                    -> first();

                return view('aggiungitaxation')->with('taxation',                    $taxation);                

            } else {
                return view('aggiungitaxation');
            }
            
        }
    }

    // show taxation
    public function showtaxation(Request $request) {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            return view('taxation');
        }
    }


    // role wised read notification
    public function userreadnote(Request $request)
    {

        $today = date("Y-m-d h:i:s");
        $id = $request->input('id');
      
         DB::table('invia_notifica')
                ->where('id', $id)
                ->update(array(
                    'data_lettura' => $today,
                    'conferma' => 'LETTO'
                    ));
                
        return Redirect::back();
        
    }

    // make comment in role wised notification
    public function notemakecomment(Request $request)
    {
        $messaggio = $request->input('messaggio');
        $id = $request->input('id');
        
         DB::table('invia_notifica')
                ->where('id', $id)
                ->update(array(
                    'comment' => $messaggio,
                    'conferma' => 'LETTO'
                    ));
                
        return Redirect::back();
        
    }    

    // user read notification
    public function userreadnotification(Request $request)
    {

        $today = date("Y-m-d h:i:s");
        $id = $request->input('id');
      
         DB::table('invia_notifica')
                ->where('id', $id)
                ->update(array(
                    'data_lettura' => $today,
                    'conferma' => 'LETTO'
                    ));
                
        return Redirect::back();
        
    }

    // make comment in notification
    public function notificationmakecomment(Request $request)
    {
        $messaggio = $request->input('messaggio');
        $id = $request->input('id');
        
         DB::table('invia_notifica')
                ->where('id', $id)
                ->update(array(
                    'comment' => $messaggio,
                    'conferma' => 'LETTO'
                    ));
                
        return Redirect::back();
        
    }    

    // user read alert notification
    public function userreadalert(Request $request)
    {

        $today = date("Y-m-d h:i:s");
        $alert_id = $request->input('alert_id');
      
         DB::table('inviare_avviso')
                ->where('alert_id', $alert_id)
                ->update(array(
                    'data_lettura' => $today,
                    'conferma' => 'LETTO'
                    ));
                
        return Redirect::back();
        
    }

    // make comment in alert notification
    public function alertmakecomment(Request $request)
    {
        $messaggio = $request->input('messaggio');
        $alert_id = $request->input('alert_id');
        
         DB::table('inviare_avviso')
                ->where('alert_id', $alert_id)
                ->update(array(
                    'comment' => $messaggio,
                    'conferma' => 'LETTO'
                    ));
                
        return Redirect::back();
        
    }    

    // add admin alert
    public function addadminalert(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } 
		else {            
            return view('addalertform', [
                'enti' => DB::table('corporations')
                    ->get(),
                'ruolo_utente' => DB::table('ruolo_utente')
                    ->get()                
            ]);
        }
    }

    // show notification
    public function showadminnotification(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            
            return view('elenconotifiche', [
                'elenconotifiche' => DB::table('notifica')
                    ->get()            
            ]);
        }
    }

    public function deletenotification(Request $request) {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {

            DB::table('notifica')
                ->where('id', $request->id)
                ->delete();

            return Redirect::back()
                ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>notification eliminata correttamente!</h4></div>');
        }
    }

    // detail notification
    public function detailadminnotification(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {

            if($request->id) {
                return view('notifichedetails', [
                    'detail_notifica' => DB::table('invia_notifica')
                    ->where('notification_id', "=", $request->id)
                    ->get()      
                ]);
            } else {
                 return view('notifichedetails', [
                    'detail_notifica' => DB::table('invia_notifica')
                    ->get()      
                ]);
            }
           
        }
    }


    // add notification
    public function addadminnotification(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {

            if($request->id){

                return view('addadminnotification', [
                    'notifica' => DB::table('notifica')
                        ->where('id', "=", $request->id)
                        ->first(),
                    'enti' => DB::table('corporations')
                        ->get(),
                    'modulo' => DB::table('modulo')
                        ->where('modulo_sub', '=', null)
                        ->get(),
                    'ruolo_utente' => DB::table('ruolo_utente')
                        ->get()                
                ]);

            } else {

                return view('addadminnotification', [
                    'enti' => DB::table('corporations')
                        ->get(),
                    'modulo' => DB::table('modulo')
                        ->where('modulo_sub', '=', null)
                        ->get(),
                    'ruolo_utente' => DB::table('ruolo_utente')
                        ->get()                
                ]);
            }
            
        }
    }

    // store admin alert
    public function storeadminalert(Request $request)
    {
        if($request->user()->id != 0) {
            
            return redirect('/unauthorized');

        } else {

            $validator = Validator::make($request->all(), [
                'nome_alert' => 'required',
                'tipo_alert' => 'required',
                'ente' => 'required',
                'ruolo' => 'required',
                'messaggio' => ''
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                    ->withInput()
                    ->withErrors($validator);
            }
            
            $ente = implode(",", $request->input('ente'));
            $ruolo = implode(",", $request->input('ruolo'));  

            $today = date("Y-m-d");

            $messaggio = strip_tags($request->messaggio);

            DB::table('alert')->insert([
                'nome_alert' => $request->nome_alert,
                'tipo_alert' => $request->tipo_alert,
                'ente' => $ente,
                'ruolo' => $ruolo,
                'messaggio' => $messaggio,
                'created_at' => $today
            ]);

            return Redirect::back()
                ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Alert add correttamente!</h4></div>');
        }
    }

     // store admin notification
    public function storeadminnotification(Request $request)
    {
        if($request->user()->id != 0) {
            
            return redirect('/unauthorized');

        } else {

            $id = $request->input('id');

            if($id){

                $validator = Validator::make($request->all(), [
                    'type' => 'required',
                    'modulo' => 'required',
                    'tempo_avviso' => 'required',
                    'ruolo' => 'required'
                ]);

                if ($validator->fails()) {
                    return Redirect::back()
                        ->withInput()
                        ->withErrors($validator);
                }

            
                if(isset($request->ente)){
                    $ente = implode(",", $request->input('ente'));
                } else {
                    $ente = null;
                }

                $ruolo = implode(",", $request->input('ruolo'));  

                $today = date("Y-m-d");

                $description = strip_tags($request->description);

                    DB::table('notifica')
                    ->where('id', $id)
                    ->update(array(
                        'notification_type' => $request->type,
                        'modulo' => $request->modulo,
                        'tempo_avviso' => $request->tempo_avviso,
                        'id_ente' => $ente,
                        'ruolo' => $ruolo,
                        'notification_desc' => $description,
                        'created_at' => $today
                    ));

                    return Redirect::back()
                    ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Notification update correttamente!</h4></div>');

            } else {

                $validator = Validator::make($request->all(), [
                'type' => 'required',
                'modulo' => 'required',
                'tempo_avviso' => 'required',
                'ruolo' => 'required'
                ]);

                if ($validator->fails()) {
                    return Redirect::back()
                        ->withInput()
                        ->withErrors($validator);
                }

                if(isset($ente)){
                    $ente = implode(",", $request->input('ente'));
                } else {
                    $ente = null;
                }
                
                $ruolo = implode(",", $request->input('ruolo'));  

                $today = date("Y-m-d");

                $description = strip_tags($request->description);

                 DB::table('notifica')->insert([
                    'notification_type' => $request->type,
                    'modulo' => $request->modulo,
                    'tempo_avviso' => $request->tempo_avviso,
                    'id_ente' => $ente,
                    'ruolo' => $ruolo,
                    'notification_desc' => $description,
                    'created_at' => $today
                ]);

                return Redirect::back()
                    ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Notification add correttamente!</h4></div>');
            }    
        }
    }

    // send alert notification to users
    public function sendalert(Request $request)
    {
        if($request->user()->id != 0) {
            
            return redirect('/unauthorized');

        } else {

            $today = date("Y-m-d");

            $alert = DB::table('alert')
                ->where('created_at', $today)
                ->get();

            if(empty($alert)) {

                return "Alert not set for today.!!";
            }
           
            foreach ($alert as $value) {
                
                $ente = explode(",", $value->ente);
                $ruolo = explode(",", $value->ruolo);
                
                foreach ($ente as $ente) {

                    $getente = DB::table('enti_partecipanti')
                        ->select('id_user')
                        ->where('id_ente', $ente)
                        ->get();

                    foreach ($getente as $getente) {
 
                        $getrole = DB::table('users')
                            ->select('dipartimento')
                            ->where('id', $getente->id_user)
                            ->get();

                        if($getrole) {
                        
                            $corporations = DB::table('corporations')
                                ->where('id', $value->ente)
                                ->first();

                             $true = DB::table('inviare_avviso')->insert([
                                    'id_ente' => $corporations->id,
                                    'alert_id' => $value->alert_id,
                                    'nome_azienda' => $corporations->nomeazienda,
                                    'nome_referente' => $corporations->nomereferente,
                                    'settore' => $corporations->settore,
                                    'telefono_azienda' => $corporations->telefonoazienda,
                                    'email' => $corporations->email,
                                    'data_lettura' => '',
                                    'responsible_langa' => $corporations->responsabilelanga,
                                    'conferma' => 'NON LETTO'
                                ]);

                            if($true){

                                return "alert send succesfully.!";

                            } else {

                                return false;
                            }

                        } 
                    }
                }
            }
        }
    }

    // send notification to users
    public function sendnotification(Request $request)
    {
        if($request->user()->id != 0) {
            
            return redirect('/unauthorized');

        } else {


            $today = date("Y-m-d");

            $notifica = DB::table('notifica')
                ->where('created_at', $today)
                ->get();

            if(empty($notifica)) {

                return "Notification not set for today.!!";
            }

            foreach ($notifica as $value) {
                
                $ente = explode(",", $value->id_ente);
                $ruolo = explode(",", $value->ruolo);

                if($ente[0] != null){
                      
                  foreach ($ente as $ente) {

                    $getente = DB::table('enti_partecipanti')
                        ->select('id_user')
                        ->where('id_ente', $ente)
                        ->get();

                    foreach ($getente as $getente) {

                        foreach ($ruolo as $role) {

                            $getrole = DB::table('users')
                                ->select('*')
                                ->where('id', $getente->id_user)
                                ->where('dipartimento', '=',  $role)
                                ->first();

                            if($getrole) {

                                $corporations = DB::table('corporations')
                                    ->where('id', $value->id_ente)
                                ->first();
                            
                             $true = DB::table('invia_notifica')->insert([
                                    'id_ente' => $corporations->id,
                                    'ruolo' => $role,
                                    'user_id' => $getrole->id,
                                    'notification_id' => $value->id,
                                    'nome_azienda' => $corporations->nomeazienda,
                                    'nome_referente' => $corporations->nomereferente,
                                    'settore' => $corporations->settore,
                                    'telefono_azienda' => $corporations->telefonoazienda,
                                    'email' => $corporations->email,
                                    'data_lettura' => '',
                                    'conferma' => 'NON LETTO'
                                ]);

                      
                                if($true){
                                    return "notification send succesfully.!";

                                } else {

                                    return false;
                                }

                            }
                        } 
                    }
                }

                } // end if 
                else {

                    foreach ($ruolo as $role) {

                        $getdept = DB::table('users')
                            ->where('dipartimento', $role)
                            ->get();
                      
                        foreach ($getdept as $getdept) {

                            $corporations = DB::table('corporations')
                            ->where('id', $getdept->id)
                            ->first();
   
                            $true = DB::table('invia_notifica')->insert([
                            'ruolo' => $role,
                            'user_id' => $getdept->id,
                            'notification_id' => $value->id,
                            'nome_azienda' => $corporations->nomeazienda,
                            'nome_referente' => $corporations->nomereferente,
                            'settore' => $corporations->settore,
                            'telefono_azienda' => $corporations->telefonoazienda,
                            'email' => $corporations->email,
                            'data_lettura' => '',
                            'conferma' => 'NON LETTO'
                            ]);

                        }
                    }

                    if($true){

                        return "notification send succesfully.!";

                    } else {

                        return false;
                    }
                             
                }
            }
        }
    }

    public function getalertjson(Request $request)
    {
        $ente = DB::table('inviare_avviso')
                    ->get();  

        return json_encode($ente);
    }

    public function getnotificationjson(Request $request)
    {
        $notifica = DB::table('notifica')
                    ->get();  

        $role_values = DB::table('ruolo_utente')
                ->get();

        $notification = [];

        foreach ($notifica as $notifica) {

            $ruolo = explode(",", $notifica->ruolo);

            $r = '';
            foreach($role_values as $role) {

                if(in_array($role->ruolo_id, $ruolo)){
					$r .= '<div class="round-checkbox">';
					$r .= '<input name="ruolo" disabled="disabled" checked id="ruolo_'.$role->ruolo_id.'_id_M" value="'.$role->ruolo_id.'" type="checkbox">';
					$r .= '<label for="ruolo_'.$role->ruolo_id.'_id_M">'.$role->nome_ruolo.'</label>';
					$r .= '<div class="check"><div class="inside"></div></div></div>';
                    /*$r .= "<input type='checkbox' name='ruolo' id='ruolo' value='$role->ruolo_id' disabled='disabled' checked /> $role->nome_ruolo ";*/
                } else {
					$r .= '<div class="round-checkbox">';
					$r .= '<input name="ruolo" disabled="disabled" id="ruolo_'.$role->ruolo_id.'_id_M" value="'.$role->ruolo_id.'" type="checkbox">';
					$r .= '<label for="ruolo_'.$role->ruolo_id.'_id_M">'.$role->nome_ruolo.'</label>';
					$r .= '<div class="check"><div class="inside"></div></div></div>';
                    /*$r .= "<input type='checkbox' name='ruolo' id='ruolo' disabled='disabled' value='$role->ruolo_id' /> $role->nome_ruolo ";*/
                }

            }
            
            $notifica->ruolo = $r;

            array_push($notification, $notifica);
            
        }

        return json_encode($notification);
    }

    public function getentinotificationjson(Request $request)
    {
        $invia_notifica = DB::table('invia_notifica')
                    ->get();  

        return json_encode($invia_notifica);
    }


    // getting list of users
    public function newregistratoutente(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            return view('newregistratoutente', [
                'utenti' => DB::table('users')
                                ->select('*')
                                ->where('is_approvato', '=', 0)
                                ->paginate(10),
            ]);
        }
    }

    // getting list of enti
    public function newregistratoenti(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            return view('newregistratoenti', [
                'corporations' => DB::table('corporations')
                                ->select('*')
                                ->where('is_approvato', '=', 0)
                                ->paginate(10),
            ]);
        }
    }

    // approve user
    public function approvareutente(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            
            DB::table('users')
                ->where('id', $request->id)
                ->update(array(
                    'is_approvato' => 1));

             // DB::table('rivenditore')
             //    ->where('id', $request->id)
             //    ->update(array(
             //        'is_approvato' => 1));
        
            return Redirect::back()->with('success', 'Approve Successfully..!!');;

        }
    }

    // rejct user
    public function rifiutareutente(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            
            DB::table('users')
                ->where('id', $request->id)
                ->update(array(
                    'is_approvato' => 2));
            
            // DB::table('rivenditore')
            //     ->where('id', $request->id)
            //     ->update(array(
            //         'is_approvato' => 2));
                
            return Redirect::back()->with('success', 'Reject Successfully..!!');;

        }
    }

    // approve enti
    public function approvareenti(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            
            DB::table('corporations')
                ->where('id', $request->id)
                ->update(array(
                    'is_approvato' => 1));

             // DB::table('rivenditore')
             //    ->where('id', $request->id)
             //    ->update(array(
             //        'is_approvato' => 1));
        

            return redirect()->back()->with('success', 'Approve Successfully..!!');   

        }
    }

    // rejct enti
    public function rifiutareenti(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            
            DB::table('corporations')
                ->where('id', $request->id)
                ->update(array(
                    'is_approvato' => 2));
            
            // DB::table('rivenditore')
            //     ->where('id', $request->id)
            //     ->update(array(
            //         'is_approvato' => 2));
                
            return Redirect::back()->with('success', 'Reject Successfully..!!');   

        }
    }

    // view user role page 
    public function permessiutente(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {

        $ruolo_utente = DB::table('ruolo_utente')
            ->where('is_delete', '=', 0)
            ->get();

        return view('role_permessi')->with('ruolo_utente', $ruolo_utente);
          
        }
    }

    // view permessi page 
    public function permessirole(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } 
        else {

              $module = DB::table('modulo')
                    ->where('modulo_sub', null)
                    ->get();    


            if($request->ruolo_id){

                $ruolo_utente = DB::table('ruolo_utente')
                    ->where('ruolo_id', '=', $request->ruolo_id)
                    ->get();

                $permessi = array();

                if(isset($ruolo_utente[0]->permessi) && !empty($ruolo_utente[0]->permessi)){
                    $permessi = json_decode($ruolo_utente[0]->permessi);
                }


                return view('permessi')->with('module', $module)->with('ruolo_utente', $ruolo_utente)->with('permessi', $permessi)->with('ruolo_id',$request->ruolo_id);

            } else {

                return view('permessi')->with('module', $module);

            }
                      
        }
    }
    
    // store permessi 
    public function storepermessi(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
                    
            // $reading = $request->has('lettura') ? $request->input('lettura') : null;

            // $writing = $request->has('scrittura') ? $request->input('lettura') : null;

            // $nome_ruolo = $request->input('nome_ruolo');
            
            // $permessi = json_encode(array_merge($reading, $writing));

            $reading = $request->input('lettura');

            $writing = $request->input('lettura');

            $nome_ruolo = $request->input('nome_ruolo');
            

            if(isset($reading) || isset($writing)){
                $permessi = json_encode(array_merge($reading, $writing));
            } else {
                $permessi = json_encode(null);
            }
                   
            if($nome_ruolo) {

                $ruolo_utente =  DB::table('ruolo_utente')
                    ->where('ruolo_id', $nome_ruolo)
                    ->update(array('permessi' => $permessi));
 
                return Redirect::back()
                    ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4> permessi updated succesfully..!</h4></div>');
            } else {

                $validator = Validator::make($request->all(), [
                    'new_ruolo' => 'required'
                ]);

                if ($validator->fails()) {

                    return Redirect::back()
                        ->withInput()
                        ->withErrors($validator);
                }


                $new_ruolo = $request->input('new_ruolo');

                    DB::table('ruolo_utente')->insert(        
                        ['nome_ruolo' => $new_ruolo, 'permessi' => $permessi ]
                        );
 
                return Redirect::back()
                    ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4> Role Add succesfully..!</h4></div>');
            }
        }
    }

    // delete ruolo  
    public function deleterole(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {

        $ruolo_utente = DB::table('ruolo_utente')
                ->where('ruolo_id', $request->ruolo_id)
                ->update(array(
                    'is_delete' => 1
                ));

        // $ruolo_utente = DB::table('ruolo_utente')
        //     ->where('ruolo_id', '=', $request->ruolo_id)
        //     ->delete();

        return Redirect::back()
                ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4> Ruolo deleted succesfully..!</h4></div>');
          
        }
    }
    
    // show list of provinces
    public function showprovincie(Request $request) {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            $provincie = DB::table('citta')
                        ->get();
            $stato = DB::table('stato')
                        ->get();

            return view('provincie')->with('provincie', $provincie)->with('stato', $stato);
        }
    }

    // store provincie 
    public function storeprovincie(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            
        $citta = $request->input('citta');
        $provincie = $request->input('provincie');
        $id_citta = $request->input('id_citta');
        
        foreach ($citta as $index => $nome_citta) {

            foreach ($id_citta as $key => $value) {

                if($index == $key){

                    DB::table('citta')
                        ->where('id_citta', $value)
                        ->update(['nome_citta' => $nome_citta]);
                }
            }
        }

        foreach ($provincie as $index => $provincie) {

            foreach ($id_citta as $key => $value) {

                if($index == $key){

                    DB::table('citta')
                        ->where('id_citta', $value)
                        ->update(['provincie' => $provincie]);
                }
            }
        }

       return Redirect::back()
                ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4> provincie updated succesfully..!</h4></div>');
          
        }
    }

    // add new provincie 
    public function addprovincie(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
        
        $validator = Validator::make($request->all(), [
                'stato' => 'required',
                'citta' => 'required',
                'provincie' => 'required|numeric'
        ]);

        if ($validator->fails()) {

            // return Redirect::back()
            //     ->withInput()
            //     ->withErrors($validator);
        }

        $stato = $request->input('stato');
        $citta = $request->input('citta');
        $provincie = $request->input('provincie');

        $check_citta = DB::table('citta')->get();

        foreach ($check_citta as $check_citta) {
     
            if($check_citta->nome_citta == $citta && $check_citta->id_stato == $stato)
            {

                return '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4> can not add same city in same state.! </h4></div>';
            } 

        }

        DB::table('citta')->insert(        
                ['id_stato' => $stato, 'nome_citta' => $citta, 
                'provincie' => $provincie]
            );

        return '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4> Provincie added succesfully..!! </h4></div>';
      
        }
   
    }


    public function addutente(Request $request)
    {
        
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {

            $module = DB::table('modulo')
                            ->where('modulo_sub', null)
                            ->get();

            return view('modificautente', [
                'enti' => DB::table('corporations')
                            ->select('id', 'nomereferente')
                            ->orderBy('nomeazienda')
                            ->get(),
                'citta' => DB::table('citta')
                            ->select('*')
                            ->get(),
                
            ])->with(array('module'=>$module));
        }
    }
    
    public function aggiornanewsletter(Request $request) {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:35',
                'dipartimento' => 'required',
                'contenuto' => 'max:5000'
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                    ->withInput()
                    ->withErrors($validator);
            }

            DB::table('newsletter')
                ->where('id', $request->id)
                ->update(array(
                    'name' => $request->name,
                    'dipartimento' => $request->dipartimento,
                    'contenuto' => $request->contenuto,
            ));

            return Redirect::back()
                ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Newsletter modificata correttamente!</h4></div>');
        }
    }

    public function storenewsletter(Request $request) {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:35',
                'dipartimento' => 'required',
                'contenuto' => 'max:5000'
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                    ->withInput()
                    ->withErrors($validator);
            }
            
            DB::table('newsletter')->insert([
                'name' => $request->name,
                'dipartimento' => $request->dipartimento,
                'contenuto' => $request->contenuto,
            ]);

            return Redirect::back()
                ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Newsletter aggiunta correttamente!</h4></div>');
        }
    }

    public function modifynewsletter(Request $request) {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            $newsletter = DB::table('newsletter')
                ->where('id', $request->id)
                ->first();
            return view('modificanewsletter', ['newsletter' => $newsletter]);
        }
    }
    
    public function deletenewsletter(Request $request) {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            DB::table('newsletter')
                ->where('id', $request->id)
                ->delete();

            return Redirect::back()
                ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Newsletter eliminata correttamente!</h4></div>');
        }
    }

    public function aggiunginewsletter(Request $request) {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            return view('aggiunginewsletter');
        }
    }

    public function elencotemplatenewsletter(Request $request) {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            return view('elenconewsletter');
        }
    }
    // Sconti
    // Elenco valore sconto legato al tipo ente (target_id) tramite DB (masterdatatypes)
        // 'quotationdiscount'
        // Elenco dei tipi enti
        // 'corporations'
    
    public function destroyutente(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
             DB::table('users')
                    ->where('id', $request->utente)
                    ->delete();
            return Redirect::back()
                            ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Utente eliminato correttamente!</h4></div>');
        }
    }
    
    public function aggiornautente(Request $request)
    {

        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {

            $user_id = $request->input('user_id');

            $dipartimento = $request->input('dipartimento');

            if($request->utente){

            $validator = Validator::make($request->all(), [
                'name' => 'required|max:20',
                'email' => 'required|email|max:255|unique:users,email,'.$user_id.',id',
                'idente' => 'required|max:35',
                'dipartimento' => 'required|max:64',
                'colore' => 'max:30',
                'sconto' => 'required|numeric',
                'sconto_bonus' => 'required|numeric',
                'rendita' => 'required|numeric',
                'rendita_reseller' => 'required|numeric',
                'password' => 'max:64',
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }

            $vecchiapassword = DB::table('users')
                                ->where('id', $request->utente)
                                ->first();
            $vecchiapassword = (String)$vecchiapassword->password;
            
            if($request->password!=null)
            {
                $vecchiapassword = bcrypt($request->password);
            }


            $idente = $request->input('idente');

            if(isset($idente)){
                $idente = implode(",", $idente);
             } else {
                $idente = '';
             }

            $zone = $request->input('zone');
            
            if(isset($zone)){
                $zone = implode(",", $zone);
             } else {
                $zone = '';
             }            
        

            $reading = $request->input('lettura');
            $writing = $request->input('scrittura');
            

            // $permessi = json_encode(array_merge($reading, $writing));

            if(isset($reading) || isset($writing)){
                
                $permessi = json_encode(array_merge($reading, $writing));
            } else {

                $permessi = json_encode(null);
            }
 
            if($dipartimento == 1 || $dipartimento == 3) {

                DB::table('users')
                ->where('id', $request->utente)
                ->update(array(
                'name' => $request->name,
                'email' => $request->email,
                'id_ente' => $idente,
                'dipartimento' => $request->dipartimento,
                'color' => $request->colore,
                'cellulare' => $request->cellulare,
                'password' =>  bcrypt($request->password),
                'permessi' => $permessi
            ));

            } else if($dipartimento == 4 ) {

                DB::table('users')
                ->where('id', $request->utente)
                ->update(array(
                'name' => $request->name,
                'email' => $request->email,
                'id_ente' => $idente,
                'id_citta' => $zone,
                'dipartimento' => $request->dipartimento,
                'color' => $request->colore,
                'cellulare' => $request->cellulare,
                'password' => bcrypt($request->password),
                'sconto' => $request->sconto,
                'sconto_bonus' => $request->sconto_bonus,
                'rendita_reseller' => $request->rendita_reseller,
                'permessi' => $permessi
            ));

            } else {
                
               DB::table('users')
                ->where('id', $request->utente)
                ->update(array(
                'name' => $request->name,
                'email' => $request->email,
                'id_ente' => $idente,
                'id_citta' => $zone,
                'dipartimento' => $request->dipartimento,
                'color' => $request->colore,
                'cellulare' => $request->cellulare,
                'password' => bcrypt($request->password),
                'sconto' => $request->sconto,
				'is_approvato' => '1',
                'sconto_bonus' => $request->sconto_bonus,
                'rendita' => $request->rendita,
                'rendita_reseller' => $request->rendita_reseller,
                'permessi' => $permessi
                ));
            }

            return Redirect::back()
                ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Utente modificato correttamente!</h4></div>');
            
         } else {

            $permessi = DB::table('ruolo_utente')
                        ->select('permessi')
                        ->where('ruolo_id', $request->dipartimento)
                        ->first();

            if($request->password!=null)
            {
                $vecchiapassword = bcrypt($request->password);
            }

            $idente = $request->input('idente');

            if(isset($idente)){
                $idente = implode(",", $idente);
             } else {
                $idente = '';
             }

            $zone = $request->input('zone');
            
            if(isset($zone)){
                $zone = implode(",", $zone);
             } else {
                $zone = '';
             }            

            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:users',
                'email' => 'required|email|max:255|unique:users'
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                    ->withInput()
                    ->withErrors($validator);
            }


            DB::table('users')->insert(array(
                'name' => $request->name,
                'email' => $request->email,
                'id_ente' => $idente,
                'id_citta' => $zone,
                'dipartimento' => $request->dipartimento,
                'color' => $request->colore,
                'cellulare' => $request->cellulare,
                'password' => bcrypt($request->password),
                'sconto' => $request->sconto,
                'sconto_bonus' => $request->sconto_bonus,
                'rendita' => $request->rendita,
                'rendita_reseller' => $request->rendita_reseller,
                'permessi' => $permessi->{'permessi'}
            
            ));
            
            return Redirect::back()
            ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Utente Add correttamente!</h4></div>');

            }
        
        }
            
    }

    public function modificautente(Request $request)
    {
    
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            $module = DB::table('modulo')
                            ->where('modulo_sub', null)
                            ->get();

            if($request->utente){
                $utente = DB::table('users')
                        ->select('*')
                        ->where('id', $request->utente)
                        ->first();

                $permessi = array();

                if(isset($utente->permessi) && !empty($utente->permessi)){
                    $permessi = json_decode($utente->permessi);
                }
                
                return view('modificautente', [
                    'enti' => DB::table('corporations')
                                ->select('id', 'nomereferente')
								->whereNotNull('nomereferente')
								->where('nomereferente','!=',"")
                                ->orderBy('nomeazienda')
                                ->get(),
                    'citta' => DB::table('citta')
                                ->select('*')
								->where('nome_citta','!=',"")
                                ->get(),
					'ruolo' => DB::table('ruolo_utente')
								->where('is_delete',0)
       							->get(),
                
                ])->with(array('module'=>$module, 'utente' => $utente, 'permessi' => $permessi));

            } else {

                    return view('modificautente', [
                    'enti' => DB::table('corporations')
                                ->select('id', 'nomereferente')
								->whereNotNull('nomereferente')
								->where('nomereferente','!=',"")
                                ->orderBy('nomeazienda')
                                ->get(),
                    'citta' => DB::table('citta')
                                ->select('*')
								->where('nome_citta','!=',"")								
                                ->get(),
					'ruolo' => DB::table('ruolo_utente')
								->where('is_delete',0)
       							->get(),
                
                ])->with(array('module'=>$module));
            }
        }
    }
    
    public function attivapassword(Request $request)
    {
        $emailutente = preg_replace("/%40/", '@', $request->email);
            DB::table('users')->where('id', $request->id)
                    ->update(array(
                'password' => bcrypt($request->password),
                'email' => $emailutente,
            ));
           
        $nuovoutente = DB::table('users')
                            ->select('*')
                            ->where('id', $request->id)
                            ->first();
                            
            
        Mail::send('confermautente', ['user' => $nuovoutente->name, 'pswd' => $request->password, 'emailutente' => $nuovoutente->email], function ($m) use ($nuovoutente) {
            $m->from("amministrazione@langa.tv", 'Easy LANGA');
            $m->to($nuovoutente->email)->subject('Account Easy LANGA attivo');
        });
        
        return redirect("/conferma");
    }
    
    public function utenti(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
                return view('utenti', [
                    'utenti' => DB::table('users')
                        ->join('ruolo_utente', 'users.dipartimento', '=', 'ruolo_utente.ruolo_id')
                        ->select('*')
                        ->where('id', '!=', 0)
                        ->where('is_approvato', '=', 1)
                        ->where('ruolo_utente.is_delete', '=', 0)
                        ->paginate(10),
            ]);
        }
    }
    /* ============================ Package section ========================  */
    /* Package sesction listing : Paras */
     public function pacchetto(Request $request) {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            return view('pacchetto', [
                'pacchetto' => DB::table('pacchetto')
                                ->select('*')
                                ->where('id', '!=', 0)
                                ->where('is_deleted', '=', 0)
                                ->paginate(10),
            ]);
        }
    }
    
    public function modificapacchetto(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } 
        else {
            if($request->pacchetto){
                return view('modificapacchettoquiz', [                   
                    'action'=>'edit',
                    'pacchetto_data' => DB::table('pacchetto')
                                ->select('*')
                                ->where('id', $request->pacchetto)
                                ->get()               
                ]);
            } 
            else {
                return view('modificapacchettoquiz', ['action'=>'add']);
            }
        }
    }
     
    public function aggiornapacchettoquiz(Request $request) {

        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } 
        else {
            $validator = Validator::make($request->all(), [
                'nome_pacchetto' => 'required|max:35',
                'pagine_totali' => 'required',
                'prezzo_pacchetto' => 'required|max:10',
                'per_pagina_prezzo' => 'required|max:10',
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }
            
         if($request->pacchetto){
            DB::table('pacchetto')
                ->where('id', $request->pacchetto)
                ->update(array(
                'nome_pacchetto' => $request->nome_pacchetto,
                'pagine_totali' => $request->pagine_totali,
                'prezzo_pacchetto' => $request->prezzo_pacchetto,
                'per_pagina_prezzo' => $request->per_pagina_prezzo,
                'updated_date'=> date('Y-m-d H:i:s')
            ));            
            return Redirect::back()
                ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Pacchetto modificato correttamente!</h4></div>');
            
         } 
         else {
            DB::table('pacchetto')->insert(array(
                'nome_pacchetto' => $request->nome_pacchetto,
                'pagine_totali' => $request->pagine_totali,
                'prezzo_pacchetto' => $request->prezzo_pacchetto,
                'per_pagina_prezzo' => $request->per_pagina_prezzo,
                'created_date' => date('Y-m-d H:i:s')
            ));
            return Redirect::back()
           ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Pacchetto Add correttamente!</h4></div>');

        }        
        }            
    }
    
     public function destroypacchettoquiz(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
             DB::table('pacchetto')
                ->where('id', $request->pacchetto)
                ->update(array(
                'is_deleted' => '1',
                'updated_date'=> date('Y-m-d H:i:s')
            ));   
            return Redirect::back()
                            ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Pacchetto eliminato correttamente!</h4></div>');
        }
    }
    /* ============================ Package section ========================  */
    
    public function aggiornascontobonus(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:35',
                'tipoente' => 'required|max:35',
                'sconto' => 'required|max:3',
                'descrizione' => 'max:255',
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }

            DB::table('scontibonus')
                    ->where('id', $request->sc)
                    ->update(array(
                        'name' => $request->name,
                        'sconto' => $request->sconto,
                        'descrizione' => $request->descrizione,
            ));
            
           
            DB::table('entiscontibonus')->where('id_sconto', $request->sc)
			->update(array('id_tipo' => $request->tipoente));
            
            return Redirect::back()
                            ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Sconto modificato correttamente!</h4></div>');
        }
    }
    
    public function modifyscontobonus(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            return view('modificascontobonus', [
                'sconto' => DB::table('scontibonus')
                                ->where('id', $request->sconto)
                                ->first(),
                'entisconti' => DB::table('entiscontibonus')
                                ->where('id_sconto', $request->sconto)
                                ->get(),
                // 'tipienti' = Elenco dei tipi enti (POTENZIALE, CLIENTE, ... con ->color)
                'tipienti' => DB::table('users')
                    ->get(),
            ]);
        }
    }
    
    public function destroyscontobonus(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            DB::table('scontibonus')
                    ->where('id', $request->sconto)
                    ->delete();
            DB::table('entiscontibonus')
                    ->where('id_sconto', $request->sconto)
                    ->delete();
            return Redirect::back()
                            ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Sconto eliminato correttamente!</h4></div>');
        }
    }
    
    public function salvascontobonus(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:35',
                'tipoente' => 'required|max:35',
                'sconto' => 'required|max:3',
                'descrizione' => 'max:255',
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }
            
            // Salvo il pacchetto
            $scontoid = DB::table('scontibonus')->insertGetId([
                'name' => $request->name,
                'sconto' => $request->sconto,
                'descrizione' => $request->descrizione,
            ]);
            
            
            $tipo = DB::table('users')
                         ->where('id', $request->tipoente)
                         ->first();
            DB::table('entiscontibonus')->insert([
                'id_sconto' => $scontoid,
                'id_tipo' => $tipo->id,
            ]);
                    
            return Redirect::back()
                           ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Sconto aggiunto correttamente!</h4></div>');
	}
    }
    
    public function aggiungiscontobonus(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            return view('aggiungiscontobonus', [
                'tipienti' => DB::table('users')
                                ->get(),
            ]);
        }
    }
    
    public function mostrascontibonus(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            return view('scontibonus', [
                'sconti' => DB::table('scontibonus')
                    ->paginate(10),
                // 'entisconti' = legame tra lo id_sconto e id_tipo ente,
                'entisconti' => DB::table('entiscontibonus')
                    ->get(),
                // 'tipienti' = Elenco dei tipi enti (POTENZIALE, CLIENTE, ... con ->color)
                'tipienti' => DB::table('users')
                    ->get(),
            ]);  
        }
    }
    // FINE SCONTI BONUS
    
    public function aggiornasconto(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:35',
                'tipoente' => 'required|max:35',
                'sconto' => 'required|max:3',
                'descrizione' => 'max:255',
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }

            DB::table('sconti')
                    ->where('id', $request->sc)
                    ->update(array(
                        'name' => $request->name,
                        'sconto' => $request->sconto,
                        'descrizione' => $request->descrizione,
            ));
            
           
            DB::table('entisconti')->where('id_sconto', $request->sc)
			->update(array('id_tipo' => $request->tipoente));
            
            return Redirect::back()
                            ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Sconto modificato correttamente!</h4></div>');
        }
    }
    
    public function modifysconto(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            return view('modificasconto', [
                'sconto' => DB::table('sconti')
                                ->where('id', $request->sconto)
                                ->first(),
                'entisconti' => DB::table('entisconti')
                                ->where('id_sconto', $request->sconto)
                                ->get(),
                // 'tipienti' = Elenco dei tipi enti (POTENZIALE, CLIENTE, ... con ->color)
                'tipienti' => DB::table('masterdatatypes')
                    ->get(),
            ]);
        }
    }
    
    public function destroysconto(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            DB::table('sconti')
                    ->where('id', $request->sconto)
                    ->delete();
            DB::table('entisconti')
                    ->where('id_sconto', $request->sconto)
                    ->delete();
            return Redirect::back()
                            ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Sconto eliminato correttamente!</h4></div>');
        }
    }
    
    public function salvasconto(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:35',
                'tipoente' => 'required|max:35',
                'sconto' => 'required|max:3',
                'descrizione' => 'max:255',
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }
            
            // Salvo il pacchetto
            $scontoid = DB::table('sconti')->insertGetId([
                'name' => $request->name,
                'sconto' => $request->sconto,
                'descrizione' => $request->descrizione,
            ]);
            
            
            $tipo = DB::table('masterdatatypes')
                         ->where('id', $request->tipoente)
                         ->first();
            DB::table('entisconti')->insert([
                'id_sconto' => $scontoid,
                'id_tipo' => $tipo->id,
            ]);
                    
            return Redirect::back()
                           ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Sconto aggiunto correttamente!</h4></div>');
	}
    }
    
    public function aggiungisconto(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            return view('aggiungisconto', [
                'tipienti' => DB::table('masterdatatypes')
                                ->get(),
            ]);
        }
    }
    
    public function mostrasconti(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            return view('sconti', [
                'sconti' => DB::table('sconti')
                    ->paginate(10),
                // 'entisconti' = legame tra lo id_sconto e id_tipo ente,
                'entisconti' => DB::table('entisconti')
                    ->get(),
                // 'tipienti' = Elenco dei tipi enti (POTENZIALE, CLIENTE, ... con ->color)
                'tipienti' => DB::table('masterdatatypes')
                    ->get(),
            ]);  
        }
    }
    
    // FINE SCONTI
    
    public function aggiornapacchetto(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            $validator = Validator::make($request->all(), [
                'code' => 'required|max:35',
                'label' => 'required|max:35',
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }
            $logo = DB::table('pack')
                    ->select('icon')
                    ->where('id', $request->pacchetto)
                    ->first();
            
            $arr = json_decode(json_encode($logo), true);
            $nome = $arr['icon'];
            
            if ($request->logo != null) {
                // Memorizzo l'immagine nella cartella public/imagesavealpha
                Storage::put(
                        'images/' . $request->file('logo')->getClientOriginalName(), file_get_contents($request->file('logo')->getRealPath())
                );
                $nome = $request->file('logo')->getClientOriginalName();
            }

            DB::table('pack')
                    ->where('id', $request->pacchetto)
                    ->update(array(
                        'code' => $request->code,
                        'icon' => $nome,
                        'label' => $request->label,
            ));
            
           
            DB::table('optional_pack')->where('pack_id', $request->pacchetto)
			->delete();
            
            // Aggiorno i tipi
            if(isset($request->optional)) {
		$options = $request->optional;
		for($i = 0; $i < count($options); $i++) {
                    $tipo = DB::table('optional')
                                ->where('id', $options[$i])
				->first();
                    DB::table('optional_pack')->insert([
                    	'optional_id' => $tipo->id,
                    	'pack_id' => $request->pacchetto,
                    ]);
		}
            }

            return Redirect::back()
                            ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Pacchetto modificato correttamente!</h4></div>');
        }
    }
    
    public function modifypacchetto(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            return view('modificapacchetto', [
                'optional' => DB::table('optional')
                                ->get(),
                'optionalselezionati' => DB::table('optional_pack')
                                            ->where('pack_id', $request->pacchetto)
                                            ->get(),
                'pacchetto' => DB::table('pack')
                                  ->where('id', $request->pacchetto)
                                  ->first(),
            ]);
        }
    }
    
    public function destroypacchetto(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            DB::table('optional_pack')
                    ->where('pack_id', $request->pacchetto)
                    ->delete();
            DB::table('pack')
                    ->where('id', $request->pacchetto)
                    ->delete();
            return Redirect::back()
                            ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Pacchetto eliminato correttamente!</h4></div>');
        }
    }
    
    public function salvapacchetto(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            $validator = Validator::make($request->all(), [
                'code' => 'required|max:35',
                'label' => 'required|max:35',
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }
            $nome = "";
            if ($request->logo != null) {
                // Memorizzo l'immagine nella cartella public/imagesavealpha
                Storage::put(
                        'images/' . $request->file('logo')->getClientOriginalName(), file_get_contents($request->file('logo')->getRealPath())
                );
                $nome = $request->file('logo')->getClientOriginalName();
            } else {
                // Imposto l'immagine di default
                $nome = "mancalogo.jpg";
            }
            
            // Salvo il pacchetto
            $packid = DB::table('pack')->insertGetId([
                'code' => $request->code,
                'icon' => $nome,
                'label' => $request->label,
            ]);
            
            // Salvo gli optional che compongono il pacchetto
            if(isset($request->optional)) {
                $opt = $request->optional;
		for($i = 0; $i < count($opt); $i++) {
                    $tipo = DB::table('optional')
                        ->where('id', $opt[$i])
			->first();
                    DB::table('optional_pack')->insert([
			'optional_id' => $tipo->id,
			'pack_id' => $packid,
                    ]);
		}
            }
            
            return Redirect::back()
                            ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Pacchetto aggiunto correttamente!</h4></div>');
        }
    }
    
    // Mostra la pagina per creare un nuovo pacchetto
    public function aggiungipacchetto(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            return view('aggiungipacchetto', [
                'optional' => DB::table('optional')
                                ->get(),
            ]);
        }
    }
    
    // Pacchetti
    public function mostrapacchetti(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
        // Elenco in cui ogni optional è legato ad un id di un pacchetto
        // optional_id => id dell'optional
        // pack_id => id del pacchetto
        // 'optionalpack'

        // Elenco di tutti i pacchetti, che saranno popolati tramite id
        // dall' optional pack
        // 'pack'
            return view('pacchetti', [
                'pack' => DB::table('pack')
                    ->paginate(10),
                'optionalpack' => DB::table('optional_pack')
                        ->get(),
                'optional' => DB::table('optional')
                                ->get(),
            ]);    
        }
    }
    
    // Optional
    public function destroyoptional(Request $request)
    {
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {

            DB::table('optional')
                    ->where('id', $request->optional)
                    ->delete();
            return Redirect::back()
                            ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Optional eliminato correttamente!</h4></div>');
        }
    }
    
    /* Optional section save : Paras */
    public function salvamodificheoptional(Request $request) {
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } 
		else {
            $validator = Validator::make($request->all(), [
                        'code' => 'required|max:35',
                        /*'label' => 'required|max:35',*/
                        'description' => 'max:255',
						'description_quize' => 'max:255',
                        'price' => 'max:16',
						'sconto_reseller' => 'max:16',
                        'frequenza' => 'required',
                        'dipartimento' => 'required',
						'logo'=>'mimes:jpeg,jpg,png | max:1000',
						'immagine'=>'mimes:jpeg,jpg,png | max:1000'
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }
            $logo = DB::table('optional')
                    ->select('icon','immagine')
                    ->where('id', $request->optional)
                    ->first();
            $arr = json_decode(json_encode($logo), true);
            $nome = $arr['icon'];
			$immagine = $arr['immagine'];
            if ($request->logo != null) {
                // Memorizzo l'immagine nella cartella public/imagesavealpha
                Storage::put(
                        'images/' . $request->file('logo')->getClientOriginalName(), file_get_contents($request->file('logo')->getRealPath())
                );
                $nome = $request->file('logo')->getClientOriginalName();
            }
			
			if ($request->immagine != null) {
                // Memorizzo l'immagine nella cartella public/imagesavealpha
                Storage::put(
                        'images/' . $request->file('immagine')->getClientOriginalName(), file_get_contents($request->file('immagine')->getRealPath())
                );
                $immagine = $request->file('immagine')->getClientOriginalName();
            }
			$escludi_da_quiz = isset($request->escludi_da_quiz) ? $request->escludi_da_quiz : '0';
            DB::table('optional')
                    ->where('id', $request->optional)
                    ->update(array(
                        'code' => $request->code,
						'escludi_da_quiz' => $escludi_da_quiz,
                        'icon' => $nome,
						'immagine'=>$immagine,
                        /*'label' => $request->label,*/
                        'description' => $request->description,
						'description_quize'=>$request->description_quize,
                        'price' => $request->price,
						'sconto_reseller'=>$request->sconto_reseller,
						'lavorazione'=>$request->lavorazione,
                        'frequenza' => $request->frequenza,
                        'dipartimento' => $request->dipartimento,
            ));

            return Redirect::back()
                            ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Optional modificato correttamente!</h4></div>');
        }
    }
	
    /* Modification : paras */
    public function modificaoptional(Request $request)
    {
        if($request->user()->id != 0)
            return redirect('/unauthorized');
	else {
            return view('modificaoptional', ['optional' => DB::table('optional')->where('id', $request->optional)->first(),
											'dipartimenti' => DB::table('departments')->get(),
											'lavorazioni' => DB::table('lavorazioni')->get(),
											'frequenze' => DB::table('frequenze')->get(),
            ]);
        }
    }
    
    public function salvaoptional(Request $request)
    {
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            $validator = Validator::make($request->all(), [
                        'code' => 'required|max:35',
                       /*'label' => 'required|max:35',*/
                        'description' => 'max:255',
						'description_quize' => 'max:255',
                        'price' => 'max:16',
						'sconto_reseller' => 'max:16',
                        'frequenza' => 'required',
                        'dipartimento' => 'required',
						'logo'=>'mimes:jpeg,jpg,png|max:1000',
						'immagine'=>'mimes:jpeg,jpg,png|max:1000'
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }
            $nome = "";
			$immagine = "";
			 if ($request->logo != null) {
                // Memorizzo l'immagine nella cartella public/imagesavealpha
                Storage::put(
                        'images/' . $request->file('logo')->getClientOriginalName(), file_get_contents($request->file('logo')->getRealPath())
                );
                $nome = $request->file('logo')->getClientOriginalName();
            }
			else {
                // Imposto l'immagine di default
                $nome = "mancalogo.jpg";
            }
			
			if ($request->immagine != null) {
                // Memorizzo l'immagine nella cartella public/imagesavealpha
                Storage::put(
                        'images/' . $request->file('immagine')->getClientOriginalName(), file_get_contents($request->file('immagine')->getRealPath())
                );
                $immagine = $request->file('immagine')->getClientOriginalName();
            }else {
                // Imposto l'immagine di default
                $immagine = "mancalogo.jpg";
            }
			$escludi_da_quiz = isset($request->escludi_da_quiz) ? $request->escludi_da_quiz : '0';
			
            DB::table('optional')->insert([
        	    	    'code' => $request->code,
						'escludi_da_quiz' => $escludi_da_quiz,
                        'icon' => $nome,
						'immagine'=>$immagine,
                        /*'label' => $request->label,*/
                        'description' => $request->description,
						'description_quize'=>$request->description_quize,
                        'price' => $request->price,
						'sconto_reseller'=>$request->sconto_reseller,
						'lavorazione'=>$request->lavorazione,
                        'frequenza' => $request->frequenza,
                        'dipartimento' => $request->dipartimento,
            ]);

            return Redirect::back()
                            ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Optional aggiunto correttamente!</h4></div>');
        }
    }
    
	/*Add the optional : Paras */
    public function aggiungioptional(Request $request)
    {
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } 
		else {
            return view('aggiungioptional', ['dipartimenti' => DB::table('departments')->get(),
			'frequenze' => DB::table('frequenze')->get(),
			'lavorazioni' => DB::table('lavorazioni')->get()
            ]);
        }
    }
    
    public function mostraoptional(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
                // Elenco di tutti gli optional
            return view('optional', ['optional' => DB::table('optional')->paginate(10)]);    
        }
    }
    
    // INIZIO VENDITA
    public function vendita(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            return view('vendita');
        }
    }
    
    // FINE VENDITA
    
    public function destroydipartimento(Request $request)
	{
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            DB::table('departments')
                    ->where('id', $request->department)
                    ->delete();
            return Redirect::back()
                            ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Dipartimento eliminato correttamente!</h4></div>');
        }
    }
    
    public function aggiornadipartimento(Request $request)
    {
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            $validator = Validator::make($request->all(), [
                        'nomedipartimento' => 'required|max:35',
                        'nomereferente' => 'required|max:35',
                        'settore' => 'max:50',
                        'piva' => 'max:11',
                        'cf' => 'max:16',
                        'telefonodipartimento' => 'required|max:20',
                        'cellularedipartimento' => 'max:20',
                        'email' => 'required|max:64',
                        'emailsecondaria' => 'max:64',
                        'fax' => 'max:64',
                        'indirizzo' => 'required',
                        'noteenti' => 'max:255',
                        'iban' => 'max:64',
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }
            $logo = DB::table('departments')
                    ->select('logo')
                    ->where('id', $request->department)
                    ->first();
            $arr = json_decode(json_encode($logo), true);
            $nome = $arr['logo'];
            if ($request->logo != null) {
                // Memorizzo l'immagine nella cartella public/imagesavealpha
                Storage::put(
                        'images/' . $request->file('logo')->getClientOriginalName(), file_get_contents($request->file('logo')->getRealPath())
                );
                $nome = $request->file('logo')->getClientOriginalName();
            }

            DB::table('departments')
                    ->where('id', $request->department)
                    ->update(array(
                        'nomedipartimento' => $request->nomedipartimento,
                        'nomereferente' => $request->nomereferente,
                        'settore' => $request->settore,
                        'piva' => $request->piva,
                        'cf' => $request->cf,
                        'logo' => $nome,
                        'telefonodipartimento' => $request->telefonodipartimento,
                        'cellularedipartimento' => $request->cellularedipartimento,
                        'email' => $request->email,
                        'emailsecondaria' => $request->emailsecondaria,
                        'fax' => $request->fax,
                        'indirizzo' => $request->indirizzo,
                        'noteenti' => $request->noteenti,
                        'iban' => $request->iban
            ));

            return Redirect::back()
                            ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Dipartimento modificato correttamente!</h4></div>');
        }
    }
    
    public function modificadipartimento(Request $request)
    {
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            return view('modificadipartimento', [
                'utenti' => DB::table('users')
                        ->get(),
                'dipartimento' => DB::table('departments')
                        ->where('id', $request->department)
                        ->first(),
            ]);
        }
    }
    
    public function salvadipartimento(Request $request)
    {
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            $validator = Validator::make($request->all(), [
                        'nomedipartimento' => 'required|max:35',
                        'nomereferente' => 'required|max:35',
                        'settore' => 'max:50',
                        'piva' => 'max:11',
                        'cf' => 'max:16',
                        'telefonodipartimento' => 'required|max:20',
                        'cellularedipartimento' => 'max:20',
                        'email' => 'required|max:64',
                        'emailsecondaria' => 'max:64',
                        'fax' => 'max:64',
                        'indirizzo' => 'required',
                        'noteenti' => 'max:255',
                        'iban' => 'max:64',
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }
            $nome = "";
            if ($request->logo != null) {
                // Memorizzo l'immagine nella cartella public/imagesavealpha
                Storage::put(
                        'images/' . $request->file('logo')->getClientOriginalName(), file_get_contents($request->file('logo')->getRealPath())
                );
                $nome = $request->file('logo')->getClientOriginalName();
            } else {
                // Imposto l'immagine di default
                $nome = "mancalogo.jpg";
            }

            DB::table('departments')->insert([
                'nomedipartimento' => $request->nomedipartimento,
                'nomereferente' => $request->nomereferente,
                'settore' => $request->settore,
                'piva' => $request->piva,
                'cf' => $request->cf,
                'telefonodipartimento' => $request->telefonodipartimento,
                'cellularedipartimento' => $request->cellularedipartimento,
                'email' => $request->email,
                'logo' => $nome,
                'emailsecondaria' => $request->emailsecondaria,
                'fax' => $request->fax,
                'indirizzo' => $request->indirizzo,
                'noteenti' => $request->noteenti,
                'iban' => $request->iban
            ]);

            return Redirect::back()
                            ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Dipartimento aggiunto correttamente!</h4></div>');
        }
    }
    
    public function nuovo()
	{
		return view('aggiungidipartimento', [
			'utenti' => DB::table('users')
                            ->get(),
		]);
	}
    
    public function add(Request $request)
	{
		return redirect('admin/tassonomie/dipartimenti/add');
	}
	
	public function show(Request $request)
	{
		return view('admin', [
			'logo' =>  base64_encode(Storage::get('images/logo.png')),
                        'profilazioni' => DB::table('ruolo_utente')
                                            ->select('*')
											->where('is_delete',0)
                                            ->get(),
		]);
	}
	
	public function deleteStatiEmotivi(Request $request)
	{
		DB::table('statiemotivitipi')
			->where('id', $request->id)
			->delete();
                return Redirect::back();
	}
	
	public function deleteStatiProgetti(Request $request)
	{
		DB::table('statiemotiviprogetti')
			->where('id', $request->id)
			->delete();
                return Redirect::back();
	}
	
	public function deleteStatiPreventivi(Request $request)
	{
		DB::table('statiemotivipreventivi')
			->where('id', $request->id)
			->delete();
                return Redirect::back();
	}
	
	public function deleteStatiPagamenti(Request $request)
	{
		DB::table('statiemotivipagamenti')
			->where('id', $request->id)
			->delete();
                return Redirect::back();
	}

	public function delete(Request $request)
	{
		DB::table('masterdatatypes')
			->where('id', $request->id)
			->delete();
		return Redirect::back();
	}
	
	public function tassonomieUpdate(Request $request)
	{
            if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            DB::table('masterdatatypes')
                    ->where('id', $request->id)
                    ->update(array(
                        'name' => $request->name,
                        'description' => $request->description,
                        'color' => $request->color,
            ));
            return Redirect::back();
        }
    }
	
	public function aggiornaStatiEmotivi(Request $request)
	{
            if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            DB::table('statiemotivitipi')
                    ->where('id', $request->id)
                    ->update(array(
                        'name' => $request->name,
                        'description' => $request->description,
                        'color' => $request->color,
            ));
            return Redirect::back();
        }
    }
	
	public function aggiornaStatiProgetti(Request $request)
	{
            if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            DB::table('statiemotiviprogetti')
                    ->where('id', $request->id)
                    ->update(array(
                        'name' => $request->name,
                        'description' => $request->description,
                        'color' => $request->color,
            ));
            return Redirect::back();
        }
    }
	
	public function aggiornaStatiPreventivi(Request $request)
	{
            if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            DB::table('statiemotivipreventivi')
                    ->where('id', $request->id)
                    ->update(array(
                        'name' => $request->name,
                        'description' => $request->description,
                        'color' => $request->color,
            ));
            return Redirect::back();
        }
    }
	
	public function aggiornaStatiPagamenti(Request $request)
	{
            if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            DB::table('statiemotivipagamenti')
                    ->where('id', $request->id)
                    ->update(array(
                        'name' => $request->name,
                        'description' => $request->description,
                        'color' => $request->color,
            ));
            return Redirect::back();
        }
    }

	public function nuovoStatoEmotivo(Request $request)
	{
		if($request->user()->id != 0)
			return redirect('/unauthorized');
		else {
			// Creo il nuovo tipo e lo memorizzo nel DB masterdatatypes
			DB::table('statiemotivitipi')->insert([
				'name' => $request->name,
				'description' => $request->description,
				'color' => $request->color,
			]);
			return Redirect::back();
		}
	}
	
	public function nuovoStatoEmotivoProgetto(Request $request)
	{
		if($request->user()->id != 0)
			return redirect('/unauthorized');
		else {
			DB::table('statiemotiviprogetti')->insert([
				'name' => $request->name,
				'description' => $request->description,
				'color' => $request->color,
			]);
			return Redirect::back();
		}
	}
	
	public function nuovoStatoEmotivoPreventivo(Request $request)
	{
		if($request->user()->id != 0)
			return redirect('/unauthorized');
		else {
			DB::table('statiemotivipreventivi')->insert([
				'name' => $request->name,
				'description' => $request->description,
				'color' => $request->color,
			]);
			return Redirect::back();
		}
	}
	
	public function nuovoStatoEmotivoPagamento(Request $request)
	{
		if($request->user()->id != 0)
			return redirect('/unauthorized');
		else {
			DB::table('statiemotivipagamenti')->insert([
				'name' => $request->name,
				'description' => $request->description,
				'color' => $request->color,
			]);
			return Redirect::back();
		}
	}

	public function nuovoTipo(Request $request)
	{
            if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            // Creo il nuovo tipo e lo memorizzo nel DB masterdatatypes
            DB::table('masterdatatypes')->insert([
                'name' => $request->name,
                'description' => $request->description,
                'color' => $request->color,
            ]);
            return Redirect::back();
        }
    }
	
	public function mostraTassonomie()
	{
		return view('tassonomie_enti', [
			'tipi' => DB::table('masterdatatypes')
				->get(),
			'statiemotivitipi' => DB::table('statiemotivitipi')
				->get(),
		]);
	}
        
        public function mostraDipartimenti()
	{
		return view('tassonomie_dipartimenti', [
			'dipartimenti' => DB::table('departments')
                            ->orderBy('id')
                            ->limit(50)
                            ->get(),
		]);
	}
	
	public function enti(Request $request)
	{
            if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            return $this->mostraTassonomie();
        }
    }
	
	public function mostraTassonomieProgetti()
	{
		return view('tassonomie_progetti', [
			'statiemotiviprogetti' => DB::table('statiemotiviprogetti')
				->get(),
		]);
	}
	
	public function mostraTassonomiePreventivi()
	{
		return view('tassonomie_preventivi', [
			'statiemotiviprogetti' => DB::table('statiemotivipreventivi')
				->get(),
		]);
	}
	
	public function mostraTassonomiePagamenti()
	{
		return view('tassonomie_pagamenti', [
			'statiemotivipagamenti' => DB::table('statiemotivipagamenti')
				->get(),
		]);
	}
	
	public function progetti(Request $request)
	{
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            return $this->mostraTassonomieProgetti();
        }
    }
	
	public function preventivi(Request $request)
	{
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            return $this->mostraTassonomiePreventivi();
        }
    }
	
	public function pagamenti(Request $request)
	{
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            return $this->mostraTassonomiePagamenti();
        }
    }
        
        public function dipartimenti(Request $request)
	{
            if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            return $this->mostraDipartimenti();
        }
    }
	
	public function store(Request $request)
	{
            if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            // Salvo le impostazioni
            $fileName = $request->logo;
			//dd($fileName);
            Storage::put(
                    'images/logo.png', file_get_contents($request->logo->getRealPath())
            );
        }
        return $this->show($request);
	}
	
	public function index(Request $request)
	{
        if ($request->user()->id != 0) {
     	      return redirect('/unauthorized');
        } else {
		     return $this->show($request);
        }
    }
/* ==================================== Lavorazioni section START Paras ======================================== */
	public function lavorazioni() {
		/*tassonomie_enti */		
		return view('tassonomie_lavorazioni', [
			'departments' => DB::table('departments')->get(),
			'lavorazioni' => DB::table('departments')
			->leftJoin('lavorazioni', 'departments.id', '=', 'lavorazioni.departments_id')
			->select('departments.id as departmentsID','departments.nomedipartimento','lavorazioni.*')
			->get(),
		]);
	}
	
	public function nuovolavorazioni(Request $request)
	{
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } 
		else {
            // Creo il nuovo tipo e lo memorizzo nel DB masterdatatypes
            DB::table('lavorazioni')->insert([
                'nome' => $request->name,
                'description' => $request->description,
				'color' => $request->color,
                'departments_id' => $request->departments_id,
            ]);
			return Redirect::back()->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Lavorazioni aggiunto correttamente!</h4></div>');
        }
    }
	
	public function lavorazionidelete(Request $request)
	{
		DB::table('lavorazioni')
			->where('id', $request->id)
			->delete();
		  return Redirect::back()
                            ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Lavorazioni eliminato correttamente!</h4></div>');
	}
	
	public function lavorazioniUpdate(Request $request)
	{
            if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            DB::table('lavorazioni')
                    ->where('id', $request->id)
                    ->update(array(
                        'nome' => $request->name,
                        'description' => $request->description,
                        'color' => $request->color,
            ));
			return Redirect::back()->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Lavorazioni aggiunto correttamente!</h4></div>');
        }
    }
	/* ==================================== Lavorazioni section END ======================================== */
  


}
