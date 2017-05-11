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
	public function index(Request $request)
	{
        if ($request->user()->id != 0) {
     	      return redirect('/unauthorized');
        } else {
		     return $this->show($request);
        }
    }

	
	// Language details
    public function language(Request $request) {
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
	public function show(Request $request) {
		return view('admin', [
			'logo' =>  base64_encode(Storage::get('images/logo.png')),
                        'profilazioni' => DB::table('ruolo_utente')
                                            ->select('*')
											->where('is_delete',0)
                                            ->get(),
		]);
	}
	
	// Language details
    public function getjsonlanguage(Request $request) {
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

    public function modifylanguage(Request $request) {    
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
	public function saveLanguage(Request $request) {
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
		$re = DB::table('languages')->where('id',$request->code)->first();
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
		$this->writelanguagefile();
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
						$content .= '
						"'.$phase->language_key.'" => "'.$phase->language_value.'"';
					}
					else {
						$content .= '
						"'.$phase->language_key.'" => "'.$phase->language_value.'",';
					}					
				}
				$content .= "]; ?>";
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
	
    // getting list of enti : 11-05-2017
    public function newregisteredenti(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } 
		else {
            return view('new_registar_enti', [
                'corporations' => DB::table('corporations')
                                ->select('*')
                                ->where('is_approvato', '=', 0)
                                ->paginate(10),
            ]);
        }
    }
	
	// Language details : 11-05-2017
    public function getjsonregisteredenti(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } 
		else { 
			$data =   DB::table('corporations')
                                ->select('*')
                                ->where('is_approvato', '=', 0)
                                ->get();
			$approvemsg = 'return confirm("'.trans("messages.keyword_are_you_sure_you_want_to_approve_this_item?").'");';
			$rejctemsg = 'return confirm("'.trans("messages.keyword_are_you_sure_you_want_to_reject_this_item?").'");';
			foreach($data as $data) {				
				$data->action  = "<a class='btn btn-default' id='approvare' href='".url('/approveenti/'.$data->id)."' onclick='".$approvemsg."'>".trans("messages.keyword_approve")." </a>
    <a class='btn btn-default' id='rifiutare' class='btn btn-default' href='".url('/rifiutareenti/'.$data->id)."' onclick='".$rejctemsg."'>".trans("messages.keyword_reject")."</a>";
				$enti_return[] = $data;	
			}
			return json_encode($enti_return);
        }
    }

    // approve enti : 11-05-2017
    public function approveenti(Request $request)
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
        
		  return Redirect::back()->with('success', trans('messages.keyword_approved_successfully'));
        }
    }

    // rejct enti : 11-05-2017
    public function rejectedenti(Request $request)
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
                
            return Redirect::back()->with('success', trans('messages.keyword_rejected_successfully'));
        }
    }

    
	
	public function enti(Request $request)
	{
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } 
		else {
			return view('tassonomie_enti', [
				'type' => DB::table('masterdatatypes')->orderBy('id', 'desc')->get(),
				'emotional_states_types' => DB::table('statiemotivitipi')->orderBy('id', 'desc')->get(),
			]);
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
	
	/* delete enti type  */
	public function delete(Request $request)
	{
		DB::table('masterdatatypes')
			->where('id', $request->id)
			->delete();
		return Redirect::back();
	}
	
	public function deleteStatiEmotivi(Request $request)
	{
		DB::table('statiemotivitipi')
			->where('id', $request->id)
			->delete();
                return Redirect::back();
	}
/*================================= Estimates sections ============================================= */
	public function estimates(Request $request) {
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } 
		else {
          return view('tassonomie_preventivi', [
			'estimates_stats' => DB::table('statiemotivipreventivi')->orderBy('id', 'desc')->get(),
			]);
        }
    }
	
	public function updateStatiEstimates(Request $request) {
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
	
	public function deleteStatiEstimates(Request $request) {
		DB::table('statiemotivipreventivi')
			->where('id', $request->id)
			->delete();
                return Redirect::back();
	}
	
	public function addStatiEstimates(Request $request)
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
	
/*====================================== Project sections ================================================== */
	public function project(Request $request) {
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
			 return view('tassonomie_project', ['statesproject' => DB::table('statiemotiviprogetti')->orderBy('id', 'desc')->get(),]);
        }
    }
	
	public function addStatesProject(Request $request) {
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

	public function updateStatesProject(Request $request)
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

	public function deleteStatesProject(Request $request) {
		DB::table('statiemotiviprogetti')
			->where('id', $request->id)
			->delete();
       return Redirect::back();
	}

	/* ==================================== Processing(Lavorazioni) section START Paras ======================================== */
	public function processing() {
		/* tassonomie_enti */		
		return view('tassonomie_processing', [
			'departments' => DB::table('departments')->get(),
			'lavorazioni' => DB::table('departments')
			->leftJoin('lavorazioni', 'departments.id', '=', 'lavorazioni.departments_id')
			->select('departments.id as departmentsID','departments.nomedipartimento','lavorazioni.*')
			->orderBy('lavorazioni.id', 'desc')
			->get(),
		]);
	}
	
	public function addProcessing(Request $request) {
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } 
		else {			           
            DB::table('lavorazioni')->insert([
                'nome' => $request->name,
                'description' => $request->description,
				'color' => $request->color,
                'departments_id' => $request->departments_id
            ]);
			return Redirect::back()->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>'.trans('messages.keyword_processing_added_successfully').'</h4></div>');
        }
    }
	
	public function deleteProcessing(Request $request) {
		DB::table('lavorazioni')
			->where('id', $request->id)
			->delete();
		  return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>'.trans('messages.keyword_processing_deleted_successfully').'</h4></div>');
	}
	
	public function updateProcessing(Request $request)
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
			return Redirect::back()->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>'.trans('messages.keyword_processing_updated_successfully').'</h4></div>');
        }
    }
	/* ==================================== Lavorazioni section END ======================================== */
  
	/* ====================================== Payment section ============================================== */
	public function payments(Request $request)	{
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
          return view('tassonomie_payment', ['statepayments' => DB::table('statiemotivipagamenti')->get()]);
        }
    }
	
	public function addstatepayment(Request $request)
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
	
	public function deleteStatePayment(Request $request) {
		DB::table('statiemotivipagamenti')
			->where('id', $request->id)
			->delete();
                return Redirect::back();
	}
	
	public function updateStatePayment(Request $request) {
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

/* ============================================================================================= */
// show user page list
    public function utenti(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
                return view('utenti', [
                    // 'utenti' => DB::table('users')
                    //     ->join('ruolo_utente', 'users.dipartimento', '=', 'ruolo_utente.ruolo_id')
                    //     ->select('*')
                    //     ->where('id', '!=', 0)
                    //     ->where('is_approvato', '=', 1)
                    //     ->where('ruolo_utente.is_delete', '=', 0)
                    //     ->paginate(10),
            ]);
        }
    }

    // 
    public function getjsonusers(Request $request)
    {   
        $users = DB::table('users')
            ->join('ruolo_utente', 'users.dipartimento', '=', 'ruolo_utente.ruolo_id')
            ->select('*')
            ->where('id', '!=', 0)
            ->where('users.is_delete', '=', 0)
            ->where('is_approvato', '=', 1)
            ->where('ruolo_utente.is_delete', '=', 0)
            ->get();
                    
        return json_encode($users);
    }

    public function modificautente(Request $request)
    {
    
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {

            $module = DB::table('modulo')
                        ->where('modulo_sub', null)
                        ->get();

            $enti = DB::table('corporations')
                        ->select('id', 'nomereferente')
                        ->whereNotNull('nomereferente')
                        ->where('nomereferente','!=',"")
                        ->orderBy('nomeazienda')
                        ->get();

            $citta = DB::table('citta')
                        ->select('*')
                        ->where('nome_citta','!=',"")
                        ->get();

            $ruolo = DB::table('ruolo_utente')
                        ->where('is_delete',0)
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
                
                return view('modificautente')->with(array('module'=>$module, 'utente' => $utente, 'permessi' => $permessi, 'enti'=> $enti, 'citta'=> $citta, 
                    'ruolo'=> $ruolo));

            } else {

                return view('modificautente')->with(array('module'=>$module, 'enti'=>$enti, 'citta'=> $citta, 'ruolo'=> $ruolo));
            }
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
            
            if(isset($reading) || isset($writing)){
                
                $permessi = json_encode(array_merge($reading, $writing));
            } else {

                $permessi = json_encode(null);
            }
 
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
                'sconto' => (isset($request->sconto))? $request->sconto : 0,
                'sconto_bonus' => (isset($request->sconto_bonus))? $request->sconto_bonus : 0,
                'rendita' => (isset($request->rendita))? $request->rendita : 0,
                'rendita_reseller' => (isset($request->rendita_reseller))? $request->rendita_reseller : 0,
                'permessi' => $permessi
               ));
            

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
                'utente_commerciale' => 0,
                'id_stato' => 0,
                'id_citta' => $zone,
                'dipartimento' => $request->dipartimento,
                'color' => $request->colore,
                'cellulare' => $request->cellulare,
                'password' => bcrypt($request->password),
                'sconto' => (isset($request->sconto))? $request->sconto : 0,
                'sconto_bonus' => (isset($request->sconto_bonus))? $request->sconto_bonus : 0,
                'rendita' => (isset($request->rendita))? $request->rendita : 0,
                'rendita_reseller' => (isset($request->rendita_reseller))? $request->rendita_reseller : 0,
                'is_approvato' => 1,
                'permessi' => $permessi->{'permessi'}
            
            ));
            
            return Redirect::back()
            ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Utente Add correttamente!</h4></div>');

            }
        
        }
            
    }

    public function rolepermission(Request $request)
    {
        
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
               
            $permessi = DB::table('ruolo_utente')
                    ->select('permessi')
                    ->where('ruolo_id', '=', $request->ruolo_id)
                    ->first();           
            //$collection = collect($arrLanguages);
        //$arrLanguages = $collection->toArray();

          // print_r($permessi);
         // $replaceable=['[',']','"'];
         
           //$permessi=explode(',',str_replace($replaceable,'',$permessi->permessi));
           $permessi=json_decode($permessi->permessi,true);
         // dd($permessi);
            $module = DB::table('modulo')
                    ->where('modulo_sub', null)
                    ->get();
            $i=0;
            $newhtml='';
            //echo "<pre>";print_r($permessi);
            $newhtml.= "<table class='table table-striped table-bordered'><tr><th>". trans('messages.keyword_module')."</th> <th> ".trans('messages.keyword_reading')."</th> <th>  ".trans('messages.keyword_writing')."</th> </tr>";
            foreach ($module as $module) {

                $submodule = DB::table('modulo')
                    ->where('modulo_sub', $module->id)
                    ->get();
            

                if($submodule) {
                    
                    $read=(in_array("$module->id|0|lettura", $permessi))? 'checked':'';
                    $write=(in_array("$module->id|0|scrittura", $permessi))?  'checked':'';
                    $newhtml.= "<tr>";
                    $newhtml.= "<td><b>";
                    $newhtml.= $module->modulo;
                    $newhtml.= "</td></b> <td>";
                    
                    $newhtml.= "<input type='checkbox' class='reading' id='lettura$i' name='lettura[]' value='".$module->id."|0|lettura' $read >";

                    $newhtml.= "</td><td>";

                    $newhtml.= "<input type='checkbox' class='writing' id='scrittura$i' name='scrittura[]'  value='$module->id|0|scrittura' $write >";

                    $newhtml.= "</td></tr>";

                foreach ($submodule as $submodule) {
                $subread=(in_array("$module->id|$submodule->id|lettura", $permessi))?  'checked':'';
                $subwrite=(in_array("$module->id|$submodule->id|scrittura", $permessi))?  'checked':'';
                  $newhtml.= "<tr>";

                    $newhtml.= "<td>";
                    $newhtml.= $submodule->modulo;
                    $newhtml.= "</td>";

                    $newhtml.= "<td>"; 

                    $newhtml.= "<input type='checkbox' class='lettura".$i."' id='lettura' name='lettura[]' value='$module->id|$submodule->id.'|lettura' $subread >";
              
                    $newhtml.= "</td>";

                    $newhtml.= "<td>"; 

                    $newhtml.= "<input type='checkbox' class='scrittura'".$i."' id='scrittura' name='scrittura[]' value='$module->id|$submodule->id|scrittura'' $subwrite>";
                    $newhtml.= "<input type='hidden' id='hidden' name='checkhidden' value=' $i'>";
            
                    $newhtml.= "</td>";

                    $newhtml.= "</tr>";
         
                    }

                }

            } 
            $newhtml.="</table>";      // return json_encode($ruolo_utente);
        }
        return $newhtml;
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

    public function rolepermessijson(Request $request)
    {   
        $ruolo_utente = DB::table('ruolo_utente')
            ->where('is_delete', '=', 0)
            ->get();
                    
        return json_encode($ruolo_utente);
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


                return view('modify_permission')->with('module', $module)->with('ruolo_utente', $ruolo_utente)->with('permessi', $permessi)->with('ruolo_id',$request->ruolo_id);

            } else {

                return view('modify_permission')->with('module', $module);

            }
                      
        }
    }

    // store permessi 
    public function storepermessi(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {                    
          
            $reading = $request->input('lettura');

            $writing = $request->input('scrittura');

            $nome_ruolo = $request->input('nome_ruolo');
            
            if(isset($reading) && isset($writing)){
 
                $permessi = json_encode(array_merge($reading, $writing));

            } else if(isset($reading)){
             
                $permessi = json_encode($reading);

            } else if(isset($writing)){

                $permessi = json_encode($writing);

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

    // delete role  
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

        return Redirect::back()
            ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4> Ruolo deleted succesfully..!</h4></div>');
          
        }
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

    public function newutentejson(Request $request)
    {   
        $users = DB::table('users')
                    ->select('*')
                    ->where('is_approvato', '=', 0)
                    ->get();
        // dd($users);
        foreach ($users as $user) {

         $user->azione="<a class='btn btn-default' id='approvare' href='".url('/approvare/'.$user->id)."' onclick=\"return confirm('Are you sure you want to approve this item?');\"> Approve </a> 
             <a class='btn btn-default' id='rifiutare' class='btn btn-default' href='".url('/rifiutare/'.$user->id)."' onclick=\"return confirm('Are you sure you want to reject this item?');\"> Reject </a>";

          $utenti[] = $user;

        }

        return json_encode($utenti);
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

            return Redirect::back()->with('success', 'Reject Successfully..!!');;

        }
    }

    // Pacchetti list
    public function mostrapacchetti(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
      
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

    // get package json 
    public function mostrapacchettijson(Request $request)
    {
      
        $pack = DB::table('pack')->get();
        $optionalpack = DB::table('optional_pack')->get();
        $optional = DB::table('optional')->get();        

        foreach ($pack as $pacchetto) {

        $pacchetto->icon="<img src='".url('storage/app/images')."/".$pacchetto->icon."' width='80' height='80'>";

        $option_label = [];
            
            foreach($optionalpack as $opt) {

                if($pacchetto->id == $opt->pack_id){

                    foreach($optional as $opzionale) {

                        if($opzionale->id == $opt->optional_id) { 

                            $option_label[] = $opzionale->label;

                            break;
                        }  
                    }
                }
            }

        $pacchetto->optional = implode(", ", $option_label);
        $package[] = $pacchetto;

        }
        
        return json_encode($package);
        
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

    public function salvapacchetto(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {

            $validator = Validator::make($request->all(), [
                'code' => 'required|unique:pack|max:35',
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
                ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4> '. trans('messages.keyword_addsuccessmsg') .' </h4></div>');
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
                ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4> '. trans('messages.keyword_editsuccessmsg') .  ' </h4></div>');
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
                            ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>  '. trans('messages.keyword_deletesuccessmsg') .  '</h4></div>');
        }
    }

    public function mostrasconti(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            return view('sconti', [
                // 'sconti' => DB::table('sconti')
                //     ->paginate(10),
                // // 'entisconti' = legame tra lo id_sconto e id_tipo ente,
                // 'entisconti' => DB::table('entisconti')
                //     ->get(),
                // // 'tipienti' = Elenco dei tipi enti (POTENZIALE, CLIENTE, ... con ->color)
                // 'tipienti' => DB::table('masterdatatypes')
                //     ->get(),
            ]);  
        }
    }

    // get discount json 
    public function scontijson(Request $request)
    {
 
        $discount = DB::table('sconti')->get();
        $entisconti = DB::table('entisconti')->get();
        $tipienti = DB::table('masterdatatypes')->get();        

        $discount = DB::table('sconti')
            ->leftjoin('entisconti', 'sconti.id','=', 'entisconti.id_sconto')
            ->leftjoin('masterdatatypes', 'entisconti.id_tipo','=', 'masterdatatypes.id')
            ->select(DB::raw('sconti.*, masterdatatypes.id as mdid, masterdatatypes.label, masterdatatypes.color'))
            ->get();

        
        foreach($discount as $disc) {

            $disc->text = "<p style='padding-left:5px; color:#ffffff;background-color:".$disc->color.";'> ".$disc->label." </p>";  
            unset($disc->color);
            unset($disc->label);
            $discounts[] = $disc;
        }

        return json_encode($discounts);
        
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
                'descrizione' => isset($request->descrizione) ? $request->descrizione : '' ,
            ]);
            
            
            $tipo = DB::table('masterdatatypes')
                         ->where('id', $request->tipoente)
                         ->first();

                    DB::table('entisconti')->insert([
                        'id_sconto' => $scontoid,
                        'id_tipo' => $tipo->id,
                ]);
                    
            return Redirect::back()
               ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>'. trans('messages.keyword_addsuccessmsg') .  '</h4></div>');
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
                        'descrizione' => isset($request->descrizione) ? $request->descrizione : '',
            ));
            
           
            DB::table('entisconti')->where('id_sconto', $request->sc)
            ->update(array('id_tipo' => $request->tipoente));
            
            return Redirect::back()
                            ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4> '. trans('messages.keyword_editsuccessmsg') .  ' </h4></div>');
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
                            ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4> '. trans('messages.keyword_deletesuccessmsg') .  ' </h4></div>');
        }
    }

    public function mostrascontibonus(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else { 
            return view('scontibonus', [
                // 'sconti' => DB::table('scontibonus')
                //     ->paginate(10),
                // // 'entisconti' = legame tra lo id_sconto e id_tipo ente,
                // 'entisconti' => DB::table('entiscontibonus')
                //     ->get(),
                // // 'tipienti' = Elenco dei tipi enti (POTENZIALE, CLIENTE, ... con ->color)
                // 'tipienti' => DB::table('users')
                //     ->get(),
            ]);  
        }
    }

    // get bonus discount json 
    public function scontibonusjson(Request $request)
    {

        $discount = DB::table('scontibonus')
            ->leftjoin('entiscontibonus','scontibonus.id','=','entiscontibonus.id_sconto')
            ->leftjoin('users', 'entiscontibonus.id_tipo','=', 'users.id')
            ->select(DB::raw('scontibonus.*, users.name as uname'))
            ->get();

        foreach($discount as $disc) {

            $disc->name = "<p style='padding-left:5px;'> ".$disc->name." </p>";  

            $discounts[] = $disc;
        }

        return json_encode($discounts);
        
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
                'descrizione' => isset($request->descrizione) ? $request->descrizione:'',
            ]);
            
            
            $tipo = DB::table('users')
                         ->where('id', $request->tipoente)
                         ->first();
            DB::table('entiscontibonus')->insert([
                'id_sconto' => $scontoid,
                'id_tipo' => $tipo->id,
            ]);
                    
            return Redirect::back()
               ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4> '.trans('messages.keyword_addsuccessmsg').' </h4></div>');
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
                            ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4> '.trans('messages.keyword_editsuccessmsg').' </h4></div>');
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
                ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4> '.trans('messages.keyword_deletesuccessmsg').' </h4></div>');
        }
    }

/* ==================================== Optional section STRAT ======================================== */

   public function mostraoptional(Request $request) {
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            // Elenco di tutti gli optional
            return view('optional', ['optional' => DB::table('optional')->paginate(10)]);
        }
    }

    public function aggiungioptional(Request $request) {
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            return view('aggiungioptional', [
                'dipartimenti' => DB::table('departments')
                        ->get(),
                'frequenze' => DB::table('frequenze')
                        ->get(),
                'lavorazioni' => DB::table('lavorazioni')->get()
            ]);
        }
    }

    public function salvaoptional(Request $request) {
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            $validator = Validator::make($request->all(), [
                        'code' => 'required|max:35',
                        //'label' => 'required|max:35',
                        'description' => 'max:255',
                        'price' => 'max:16',
                        'frequenza' => 'required',
                        //'dipartimento' => 'required'
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

            DB::table('optional')->insert([
                'code' => $request->code,
                'icon' => $nome,
                'label' => $request->label,
                'description' => $request->description,
                'price' => $request->price,
                'frequenza' => $request->frequenza,
                'dipartimento' => $request->dipartimento,
            ]);

            return Redirect::back()->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Dipartimento aggiunto correttamente!</h4></div>');
        }
    }

    public function modificaoptional(Request $request) {
        if ($request->user()->id != 0)
            return redirect('/unauthorized');
        else {
            return view('modificaoptional', [
                'optional' => DB::table('optional')
                        ->where('id', $request->optional)
                        ->first(),
                'dipartimenti' => DB::table('departments')
                        ->get(),
                'frequenze' => DB::table('frequenze')
                        ->get()
                ,
                'lavorazioni' => DB::table('lavorazioni')->get()
            ]);
        }
    }

    public function saveoptionalchanges(Request $request) {
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
       
            $validator = Validator::make($request->all(), [
                        'code' => 'required|max:35',
//                        /'label' => 'required|max:35',
                        'description' => 'max:255',
                        'price' => 'max:16',
                        'frequenza' => 'required',
                        'dipartimento' => 'required'
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }
            $logo = DB::table('optional')
                    ->select('icon')
                    ->where('id', $request->optional)
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

            DB::table('optional')
                    ->where('id', $request->optional)
                    ->update(array(
                        'code' => $request->code,
                        'icon' => $nome,
                        'label' => $request->label,
                        'description' => $request->description,
                        'price' => $request->price,
                        'frequenza' => $request->frequenza,
                        'dipartimento' => $request->dipartimento,
            ));

            return Redirect::back()
                            ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Optional modificato correttamente!</h4></div>');
        }
    }

    public function destroyoptional(Request $request) {
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

    public function getjson() {
        $optional = DB::table('optional') ->get()
                ->toArray();
       
        foreach($optional as $key=>$val){
          $optional[$key]->icon='<img src="' . url('storage/app/images/') . '/' . $val->icon . '" height="100px" width="100px">';
        }
//        echo "<pre>";
//        print_r($optional);die;
//      
       echo json_encode($optional);
    }

    /* ==================================== Optional section END ======================================== */






}
