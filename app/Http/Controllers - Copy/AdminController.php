<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Storage;
use Redirect;
use Validator;
use Mail;
use File;
use Hash;
use Auth;
use DateTime;


class AdminController extends Controller
{	
	public function __construct(Request $request){ 
        $this->middleware('auth');
    }
	public function index(Request $request) {
        if ($request->user()->id != 0) {
     	      return redirect('/unauthorized');
        }
        else {
        	//unlink('storage/app/images/previewlogo')
        	/*$files = glob('storage/app/images/previewlogo/*'); // get all file names
			foreach($files as $file) { // iterate files
			  if(is_file($file))
		    	unlink($file); // delete file
			}*/
		    return $this->show($request);
        }
    }
    public function show(Request $request) {
		return view('admin', [
			'logo' =>  base64_encode(Storage::get('images/logo.png')),
			'adminsettings'=> DB::table('admin_settings')->select('*')->first(),
            'profilazioni' => DB::table('ruolo_utente')->select('*')->where('is_delete',0)->get(),
		]);
	}
    /*This function is used to store the update the dasboard details */
   	public function storelogotemp(Request $request)	{
        if ($request->user()->id  != 0) {
            return redirect('/unauthorized');
        } 
        else {        
        	/*Storage::put('images/languageicon/' . $request->file('icon')->getClientOriginalName(), file_get_contents($request->file('icon')->getRealPath()));
			$nome = $request->file('icon')->getClientOriginalName();*/
			$validator = Validator::make($request->all(), [					
					'frontlogo'=>'mimes:jpeg,jpg,png,svg|max:1000',
					'adminlogo'=>'mimes:jpeg,jpg,png,svg|max:1000',
					'frontfavicon'=>'mimes:jpeg,jpg,png|max:1000',
					'adminfavicon'=>'mimes:jpeg,jpg,png|max:1000'
				]);
			if ($validator->fails()) {
            	 echo 'fail'; 
            	 exit;
        	}
			if(isset($request->frontlogo)){				
            	$frontlogoname = $request->frontlogo->getClientOriginalName();
            	$frontlogotmp = explode('.', $frontlogoname);
				$fronlogoextensions = end($frontlogotmp);            	
            	Storage::put('images/logopreview/'.$frontlogoname, file_get_contents($request->frontlogo->getRealPath()));
            	echo "<img class='img-responsive' src='".url('storage/app/images/logopreview/'.$frontlogoname)."'  class='preview'>";
            	$arrData= array('frontlogotmp' => $frontlogoname,'user_id'=>$request->user()->id);            	
            }
            if(isset($request->adminlogo)){
            	$adminlogoname = $request->adminlogo->getClientOriginalName();            	
            	$adminlogotmp = explode('.', $adminlogoname);         	
            	$adminlogoextensions = end($adminlogotmp);            	            	
            	Storage::put('images/logopreview/'.$adminlogoname, file_get_contents($request->adminlogo->getRealPath()));
            	echo "<img class='img-responsive' src='".url('storage/app/images/logopreview/'.$adminlogoname)."'  class='preview'>";
            	$arrData= array('adminlogotmp' => $adminlogoname,'user_id'=>$request->user()->id);
            }
            if(isset($request->frontfavicon)){            	
            	$frontfaviconname = $request->frontfavicon->getClientOriginalName();
            	$frontfavicontmp = explode('.', $frontfaviconname);
            	$frontfaviconextensions = end($frontfavicontmp);            	            	
            	Storage::put('images/logopreview/'.$frontfaviconname, file_get_contents($request->frontfavicon->getRealPath()));
            	echo "<img class='img-responsive' src='".url('storage/app/images/logopreview/'.$frontfaviconname)."'  class='preview'>";
            	$arrData= array('frontfavicontmp' => $frontfaviconname,'user_id'=>$request->user()->id);
            }
            if(isset($request->adminfavicon)){            	
            	$adminfaviconname = $request->adminfavicon->getClientOriginalName();
            	$adminfavicontmp = explode('.', $adminfaviconname);
            	$adminfaviconextensions = end($adminfavicontmp);            	            	
            	Storage::put('images/logopreview/'.$adminfaviconname, file_get_contents($request->adminfavicon->getRealPath()));
            	echo "<img class='img-responsive' src='".url('storage/app/images/logopreview/'.$adminfaviconname)."'  class='preview'>";
            	$arrData= array('adminfavicontmp' => $adminfaviconname,'user_id'=>$request->user()->id);
            }

        	$countRec = DB::table('admin_settings')->select('*')->get();
			if(count($countRec) > 0) {			
				DB::table('admin_settings')->where('id', $countRec[0]->id)->update($arrData);				
			}
			else {								
				DB::table('admin_settings')->insert($arrData);
			}
        }
        exit;        
	}

	
	/*This function is used to store the update the dasboard details */
   	public function previewlogo(Request $request)	{
        if ($request->user()->id  != 0) {
            return redirect('/unauthorized');
        } 
        else {
        	$logodetails = DB::table('admin_settings')->select('*')->first();
        	$frontlogo = "";
        	$adminlogo = "";
        	/*$frontlogo = base64_encode(Storage::get('images/logo/'.$logodetails->frontlogo));	*/
        	if(count($logodetails) > 0){
	        	$frontlogo = 'storage/app/images/logo/'.$logodetails->frontlogo;		
	        	$adminlogo = 'storage/app/images/logo/'.$logodetails->adminlogo;		
	        	if (File::exists('storage/app/images/logopreview/'.$logodetails->frontlogotmp)){
	        		$frontlogo = 'storage/app/images/logopreview/'.$logodetails->frontlogotmp;		
	        	}
	        	if ($logodetails->adminlogotmp != "" && File::exists('storage/app/images/logopreview/'.$logodetails->adminlogotmp)){
	        		$adminlogo = 'storage/app/images/logopreview/'.$logodetails->adminlogotmp;		
	        	}
	        }
        	return view('logo_preview', [
			'currenttype'=>$request->type,
			'frontlogo' =>$frontlogo,
			'adminlogo' =>$adminlogo,
			'adminsettings'=> $logodetails,
            'profilazioni' => DB::table('ruolo_utente')->select('*')->where('is_delete',0)->get(),
		]);     
        	exit;
        }
        exit;        
	}

	public function savelogos(Request $request){
		if ($request->user()->id  != 0) {
            return redirect('/unauthorized');
        } 
        else {        	
        	$countRec = DB::table('admin_settings')->select('*')->get();
			if(count($countRec) > 0) {							
				$tempfield = $request->type.'tmp';
				$arrData= array($request->type => $countRec[0]->$tempfield,'user_id'=>$request->user()->id);
				DB::table('admin_settings')->where('id', $countRec[0]->id)->update($arrData);				
				
				$previewfile = 'storage/app/images/logopreview/'.$countRec[0]->$tempfield;
				$orginalfile = 'storage/app/images/logo/'.$countRec[0]->$tempfield;
				copy($previewfile, $orginalfile);
			}
			/*else {								
				DB::table('admin_settings')->insert($arrData);
			}*/	

			$arrMessagetype['adminlogo'] = trans('messages.keyword_admin_logo');
			$arrMessagetype['frontlogo'] = trans('messages.keyword_application_logo');
			$arrMessagetype['frontfavicon'] = trans('messages.keyword_application_favicon');
			$arrMessagetype['adminfavicon'] = trans('messages.keyword_admin_favicon');

			return $arrMessagetype[$request->type].' '.strtolower(trans('messages.keyword_saved_successfully'));			
        }
	}



    public function copyClient(Request $request){

    	if($request->user()->id != 0) {
            return redirect('/unauthorized');
     	} else {

			$true = DB::insert("INSERT INTO users (id_ente, color, name, dipartimento, 
				cellulare, email, password, remember_token, created_at, updated_at)
					SELECT id_ente, color, name, 5, cellulare, email, password, remember_token, created_at, updated_at FROM clienti");

			if($true){
				echo "<h3> Copy Client in user table is completed..!!! </h3>";
			}else {
				echo "<h1> Somthing Went Wroong..!!! </h1>";
			}
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
			/*Insert Into Logs */
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
				/* Store the log details */
				$logs = 'Update Langauge -> (ID:'.$request->languageid.')';
				/*storelogs($request->user()->id,$logs);*/

				return Redirect::back()
								->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Language updated successfully!</div>');
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
								->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Language added successfully!</div>');
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
                            ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Default Language not destroyed!</div>');
				
			}
			else {
            DB::table('languages')
						->where('id', $request->languageid)
						->update(array(
							'is_deleted' =>'1'
				));
            return Redirect::back()
                            ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Language deleted successfully!</div>');
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
		  ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Phase deleted successfully!</div>');
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
			$language_transalation = DB::table('language_transalation')->where('id',$request->id)->first();

			$NextRecord = DB::select(DB::raw("select * from language_transalation where id = (select min(id) from language_transalation where code = '$language_transalation->code' AND id > $request->id)"));
			$PreviouseRecord = DB::select(DB::raw("select * from language_transalation where id = (select max(id) from language_transalation where code ='$language_transalation->code' AND id < $request->id)"));
			
			return view('modify_language_translation', 
			['language_transalation' => $language_transalation,
			'language_selected' => DB::table('languages')->where('code',$language_transalation->code)->first(),
			'language' => DB::table('languages')->where('is_deleted','0')->get(),
			'NextRecord' => $NextRecord,
			'PreviouseRecord' => $PreviouseRecord]);
		}
		else {
			return view('modify_language_translation',
			['language' => DB::table('languages')->where('is_deleted','0')->get(),
			'language_selected' => DB::table('languages')->where('code','en')->first()]);
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
                        ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Language aggiunto correttamente!</div>');
		
	}
	/* this function is used to write the lanague file/dir */
	public function writelanguagefile(){
		$arrLanguages =  DB::table('languages')
                        ->select('*')
                        ->where('id', '!=', 0)                        
                        ->get();		
		$collection = collect($arrLanguages);		
		$arrLanguages = $collection->toArray();		
		/*$numItems = count($arrLanguages);
		$i = 0;*/
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
						"'.$phase->language_key.'" => "'.htmlspecialchars($phase->language_value).'"';
					}
					else {
						$content .= '
						"'.$phase->language_key.'" => "'.htmlspecialchars($phase->language_value).'",';
					}					
				}
				$content .= "]; ?>";
				$fp = fopen($file,"wb");
				fwrite($fp,$content);
				fclose($fp);		
			}			
		}
		/* Write the php file for the js variables  */	
		$jsfile = './resources/views/common/languagesjs.blade.php';
		if(is_file($jsfile)){
			unlink($jsfile);				
		}
		if(!is_file($jsfile)){
			$jscontent = "<script> ";
			$jsphases =  DB::table('language_transalation')->select('*')->groupBy('language_key')->get();		
			$jsnumItems = count($jsphases);			
			foreach($jsphases as $jsphase) {				
				$jskey = preg_replace('/[^A-Za-z0-9\_]/', '', $jsphase->language_key);
				$jscontent .= ' var jslang_'.$jskey.' = "<?php echo trans("messages.'.$jsphase->language_key.'"); ?>";'. PHP_EOL;
			}
			$jscontent .= "</script>";
			$jsfp = fopen($jsfile,"wb");
			fwrite($jsfp,$jscontent);
			fclose($jsfp);		
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
		if($request->hdSaveType != '0' && isset($request->nextrecordid) && $request->nextrecordid != ''){
			$moveRecordid = ($request->hdSaveType == 1) ? $request->nextrecordid : $request->previouserecordid; 
			return redirect('/admin/modify/languagetranslation/'.$moveRecordid)->with('error_code', 5)->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Language updated successfully!</div>');
		}
		else {
			return Redirect::back()
                        ->with('error_code', 5)
                        ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Language updated successfully!</div>');
        }
		
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
			$enti_return= array();
			foreach($data as $data) {				
				$data->action  = "<a class='btn btn-warning' id='approvare' href='".url('/approveenti/'.$data->id)."' onclick='".$approvemsg."'>".trans("messages.keyword_approve")." </a>
    <a class='btn btn-danger' id='rifiutare' href='".url('/rejectenti/'.$data->id)."' onclick='".$rejctemsg."'>".trans("messages.keyword_reject")."</a>";
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
        return Redirect::back()->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_approved_successfully').' </div>');             
		  
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
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_rejected_successfully').' </div>');              
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
            return Redirect::back()->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_addsuccessmsg').' </div>');
        }
    }
	
	/* This function is used to update/delete */
	public function tassonomieUpdate(Request $request) {
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } 
        else {      
        	foreach($request->chktasentitype as $key => $val) {        		
        		$name = isset($request->name[$key]) ? $request->name[$key] : '';
        		$description = isset($request->description[$key]) ? $request->description[$key] : '';
        		$color = isset($request->color[$key]) ? $request->color[$key] : '';
	            if($request->action == 'delete') {
					DB::table('masterdatatypes')->where('id', $key)->delete();							
	            }
	            else {
		            DB::table('masterdatatypes')->where('id', $key)->update(array('name' => $name,'description' => $description,'color' => $color));
	            }          
            }
            $msg = ($request->action == 'delete') ? '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_deletesuccessmsg').' </div>' : '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_editsuccessmsg').' </div>';
            return Redirect::back()->with('msg', $msg);
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
			return Redirect::back()->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_addsuccessmsg').' </div>');
		}
	}
	
	/*This method name is used to update/delete */
	public function actionEmotionalStae(Request $request)
	{
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
        	$chktasentiemotion = isset($request->chktasentiemotion) ? $request->chktasentiemotion : array();
            foreach($chktasentiemotion as $key => $val) {        		        		
        		$name = isset($request->name[$key]) ? $request->name[$key] : '';
        		$description = isset($request->description[$key]) ? $request->description[$key] : '';
        		$color = isset($request->color[$key]) ? $request->color[$key] : '';
        		if($request->action == 'delete') {
					DB::table('statiemotivitipi')->where('id', $key)->delete();							
				}
        		else {
	            	DB::table('statiemotivitipi')->where('id', $key)->update(array('name' => $name,'description' => $description,'color' => $color));
	        	}	            
	        }
            $msg = ($request->action == 'delete') ? '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_deletesuccessmsg').' </div>' : '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_editsuccessmsg').' </div>';
            return Redirect::back()->with('msg', $msg);
        }
    }
	
	/* delete enti type  *
	public function delete(Request $request)
	{
		DB::table('masterdatatypes')
			->where('id', $request->id)
			->delete();
		return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_deletesuccessmsg').' </div>');
	}
	
	public function deleteStatiEmotivi(Request $request)
	{
		DB::table('statiemotivitipi')
			->where('id', $request->id)
			->delete();
                return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_deletesuccessmsg').' </div>');
	}*/
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
        	foreach($request->chktasentitype as $key => $val) {        		
        		$name = isset($request->name[$key]) ? $request->name[$key] : '';
        		$description = isset($request->description[$key]) ? $request->description[$key] : '';
        		$color = isset($request->color[$key]) ? $request->color[$key] : '';
	            if($request->action == 'delete') {
					DB::table('statiemotivipreventivi')->where('id', $key)->delete();							
	            }
	            else {
		            DB::table('statiemotivipreventivi')->where('id', $key)->update(array('name' => $name,'description' => $description,'color' => $color));
	            }          
            }
            $msg = ($request->action == 'delete') ? '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_deletesuccessmsg').' </div>' : '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_editsuccessmsg').' </div>';
            return Redirect::back()->with('msg', $msg);
        }
    }
	
	public function deleteStatiEstimates(Request $request) {
		DB::table('statiemotivipreventivi')
			->where('id', $request->id)
			->delete();
                return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_deletesuccessmsg').' </div>');
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
			return Redirect::back()->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_addsuccessmsg').' </div>');
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
			return Redirect::back()->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_addsuccessmsg').' </div>');
		}
	}

	public function updateStatesProject(Request $request)
	{
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            foreach($request->chktasentitype as $key => $val) {        		
        		$name = isset($request->name[$key]) ? $request->name[$key] : '';
        		$description = isset($request->description[$key]) ? $request->description[$key] : '';
        		$color = isset($request->color[$key]) ? $request->color[$key] : '';
	            if($request->action == 'delete') {
					DB::table('statiemotiviprogetti')->where('id', $key)->delete();							
	            }
	            else {
		            DB::table('statiemotiviprogetti')->where('id', $key)->update(array('name' => $name,'description' => $description,'color' => $color));
	            }          
            }
            $msg = ($request->action == 'delete') ? '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_deletesuccessmsg').' </div>' : '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_editsuccessmsg').' </div>';
            return Redirect::back()->with('msg', $msg);

        }
    }

	public function deleteStatesProject(Request $request) {
		DB::table('statiemotiviprogetti')
			->where('id', $request->id)
			->delete();
       return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_deletesuccessmsg').' </div>');
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
			return Redirect::back()->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_addsuccessmsg').' </div>');
        }
    }
	
	public function deleteProcessing(Request $request) {
		DB::table('lavorazioni')
			->where('id', $request->id)
			->delete();		
		 return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_deletesuccessmsg').' </div>');
	}
	
	public function updateProcessing(Request $request)
	{
            if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {	
        	/*$arrname = $request->name;
        	foreach($arrname as $key => $val){
        		if(isset($request->id[$key])){
        			$description = isset($request->description[$key]) ? $request->description[$key] : '';
        			$color = isset($request->color[$key]) ? $request->color[$key] : '';
		            DB::table('lavorazioni')
		                    ->where('id', $request->id[$key])
		                    ->update(array(
		                        'nome' => $val,
		                        'description' => $description,
		                        'color' => $color,
		            ));
			    }
			}           
			return Redirect::back()->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_editsuccessmsg').'</div>');
			*/

			$arrstate = isset($request->chktasentitype) ? $request->chktasentitype : array();
            foreach($arrstate as $key => $val) {        		
        		$name = isset($request->name[$key]) ? $request->name[$key] : '';
        		$description = isset($request->description[$key]) ? $request->description[$key] : '';
        		$color = isset($request->color[$key]) ? $request->color[$key] : '';
	            if($request->action == 'delete') {
					DB::table('lavorazioni')->where('id', $key)->delete();							
	            }
	            else {
		            DB::table('lavorazioni')->where('id', $key)->update(array('nome' => $name,'description' => $description,'color' => $color));
	            }          
            }
            $msg = ($request->action == 'delete') ? '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_deletesuccessmsg').' </div>' : '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_editsuccessmsg').' </div>';
            return Redirect::back()->with('msg', $msg);


        }
    }
	/* ==================================== Lavorazioni section END ======================================== */
  
	/* ====================================== Payment section ============================================== */
	public function payments(Request $request)	{
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
          return view('tassonomie_payment', ['statepayments' => DB::table('statiemotivipagamenti')->orderBy('id', 'desc')->get()]);
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
			return Redirect::back()->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_addsuccessmsg').' </div>');
		}
	}
	
	public function deleteStatePayment(Request $request) {
		DB::table('statiemotivipagamenti')
			->where('id', $request->id)
			->delete();
                return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_deletesuccessmsg').' </div>');
	}
	
	public function updateStatePayment(Request $request) {
         if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
        	$arrstate = isset($request->chktasentitype) ? $request->chktasentitype : array();
            foreach($arrstate as $key => $val) {        		
        		$name = isset($request->name[$key]) ? $request->name[$key] : '';
        		$description = isset($request->description[$key]) ? $request->description[$key] : '';
        		$color = isset($request->color[$key]) ? $request->color[$key] : '';
	            if($request->action == 'delete') {
					DB::table('statiemotivipagamenti')->where('id', $key)->delete();							
	            }
	            else {
		            DB::table('statiemotivipagamenti')->where('id', $key)->update(array('name' => $name,'description' => $description,'color' => $color));
	            }          
            }
            $msg = ($request->action == 'delete') ? '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_deletesuccessmsg').' </div>' : '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_editsuccessmsg').' </div>';
            return Redirect::back()->with('msg', $msg);

        }
    }

/* ============================================================================================= */
// show user page list
   /* public function utenti(Request $request)
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
    }*/

    // 
  /*  public function getjsonusers(Request $request)
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
    }*/

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

    /*This fucntion is used to delete the user */
    public function destroyutente(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
             DB::table('users')
                    ->where('id', $request->utente)
                    ->delete();
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_user_deleted_successfully').'</div>');
        }
    }

  public function aggiornautente(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');

        } else {

            $user_id = $request->input('user_id');

            $dipartimento = $request->input('dipartimento');

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
            
            if(isset($reading) && isset($writing)){ 				
                $permessi = json_encode(array_merge($reading, $writing));

            } else if(isset($reading)){             	
                $permessi = json_encode($reading);

            } else if(isset($writing)){            	
                $permessi = json_encode($writing);
            } else {  				
                $permessi = json_encode(null);
            }

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

               DB::table('users')
                ->where('id', $request->utente)
                ->update(array(
                'name' => $request->name,
                'email' => $request->email,
                'id_ente' => $idente,
                'id_citta' => $zone,
                'dipartimento' => $request->dipartimento,
                'color' => isset($request->colore) ? $request->colore : '',
                'cellulare' => $request->cellulare,
                'password' => $vecchiapassword,
                'sconto' => (isset($request->sconto))? $request->sconto : 0,
                'sconto_bonus' => (isset($request->sconto_bonus))? $request->sconto_bonus : 0,
                'rendita' => (isset($request->rendita))? $request->rendita : 0,
                'rendita_reseller' => (isset($request->rendita_reseller))? $request->rendita_reseller : 0,
                'is_internal_profile' => (isset($request->is_internal_profile))? $request->is_internal_profile : 0,
                'permessi' => $permessi
               ));
            

            return Redirect::back()
                ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_user_updated_successfully').'</div>');
            
         } else {

            if($request->password!=null)
            {
                $vecchiapassword = bcrypt($request->password);
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
                'color' => isset($request->colore) ? $request->colore : '',
                'cellulare' => $request->cellulare,
                'password' => bcrypt($request->password),
                'sconto' => (isset($request->sconto))? $request->sconto : 0,
                'sconto_bonus' => (isset($request->sconto_bonus))? $request->sconto_bonus : 0,
                'rendita' => (isset($request->rendita))? $request->rendita : 0,
                'rendita_reseller' => (isset($request->rendita_reseller))? $request->rendita_reseller : 0,
                'is_internal_profile' => (isset($request->is_internal_profile))? $request->is_internal_profile : 0,
                'is_approvato' => 1,
                'permessi' => $permessi            
            ));

            if($request->dipartimento == 5) {

            	DB::table('clienti')->insert([
                'name' => $data['name'],
                'cellulare' => isset($data['cellulare']) ? $data['cellulare'] : '',
                'email' => $data['email'],
                'password' => bcrypt($pswd)                
            	]);
            }
            return Redirect::back()->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_user_added_successfully').'</div>');
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
        
           $permessi=json_decode($permessi->permessi,true);
 
            $module = DB::table('modulo')
                    ->where('modulo_sub', null)
                    ->get();
            $i=0;
            $newhtml='';
    
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
                    
                    $newhtml.= "<input type='checkbox' class='reading' id='lettura". $module->modulo.$i."' name='lettura[]' value='".$module->id."|0|lettura' $read ><label for='lettura". $module->modulo.$i."'></label>";

                    $newhtml.= "</td><td>";

                    $newhtml.= "<input type='checkbox' class='writing' id='scrittura". $module->modulo.$i."' name='scrittura[]'  value='$module->id|0|scrittura' $write ><label for='scrittura". $module->modulo.$i."''></label>";

                    $newhtml.= "</td></tr>";

                foreach ($submodule as $submodule) {
                $subread=(in_array("$module->id|$submodule->id|lettura", $permessi))?  'checked':'';
                $subwrite=(in_array("$module->id|$submodule->id|scrittura", $permessi))?  'checked':'';
                  $newhtml.= "<tr>";

                    $newhtml.= "<td>";
                    $newhtml.= $submodule->modulo;
                    $newhtml.= "</td>";

                    $newhtml.= "<td>"; 

                    $newhtml.= "<input type='checkbox' class='lettura".$module->modulo.$i."' id='lettura".$module->modulo.$submodule->modulo.$i."' name='lettura[]' value='$module->id|$submodule->id|lettura' $subread ><label for='lettura".$module->modulo.$submodule->modulo.$i."'></label>";
              
                    $newhtml.= "</td>";

                    $newhtml.= "<td>"; 

                    $newhtml.= "<input type='checkbox' class='scrittura".$module->modulo.$i."' id='lettura".$module->modulo.$submodule->modulo.$i."' name='scrittura[]' value='$module->id|$submodule->id|scrittura'' $subwrite><label for='lettura".$module->modulo.$submodule->modulo.$i."'></label>";
                    $newhtml.= "<input type='hidden' id='hidden' name='checkhidden' value='".$i."'>";
            
                    $newhtml.= "</td>";

                    $newhtml.= "</tr>";
         
                    }
                    $i++;
                }

            } 
            $newhtml.="</table>";  
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
                
            $validator = Validator::make($request->all(), [
                    'new_ruolo' => 'required'
             ]);   
            if ($validator->fails()) {

                    return Redirect::back()
                        ->withInput()
                        ->withErrors($validator);
                }
             $new_ruolo = $request->input('new_ruolo');
            if($nome_ruolo) {
                $ruolo_utente =  DB::table('ruolo_utente')
                    ->where('ruolo_id', $nome_ruolo)
                    ->update(array('permessi' => $permessi,'nome_ruolo'=>$new_ruolo));
 
                return Redirect::back()
                    ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_permission_updated_successfully').'</div>');
            } else {
                
                DB::table('ruolo_utente')->insert(        
                    ['nome_ruolo' => $new_ruolo, 'permessi' => $permessi ]
                    ); 
                return Redirect::back()
                    ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_role_added_successfully').'</div>');
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
            ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_role_deleted_successfully').'</div>');          
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
		$utenti = array();                   
        foreach ($users as $user) {
         $user->azione="<a class='btn btn-warning' id='approvare' href='".url('/approvare/'.$user->id)."' onclick=\"return confirm('".trans('messages.keyword_are_you_sure_you_want_to_approve_this_item?')."');\">".trans('messages.keyword_approve')." </a> 
             <a class='btn btn-danger' id='rifiutare' href='".url('/rifiutare/'.$user->id)."' onclick=\"return confirm('".trans('messages.keyword_are_you_sure_you_want_to_reject_this_item?')."');\">".trans('messages.keyword_reject')."  </a>";
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

            return Redirect::back()->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_approved_successfully').' </div>');


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

			return Redirect::back()->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '. trans('messages.keyword_rejected_successfully').' </div>');
        }
    }

    // Pacchetti list
    public function mostrapacchetti(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
      
            return view('pacchetti', [
                'pack' => DB::table('pack')->orderBy('id', 'desc')->paginate(10),
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
      
        $pack = DB::table('pack')->orderBy('id', 'desc')->get();
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
                'logo'=>'mimes:jpeg,jpg,png|max:1000'
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
                ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '. trans('messages.keyword_addsuccessmsg') .' </div>');
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
                'logo'=>'mimes:jpeg,jpg,png|max:1000'
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
                ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '. trans('messages.keyword_editsuccessmsg') .  ' </div>');
        }
    }

    public function destroypacchettotest(Request $request)
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
                            ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>  '. trans('messages.keyword_deletesuccessmsg') .  '</div>');
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
            return view('modificasconto', [
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
               ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'. trans('messages.keyword_addsuccessmsg') .  '</div>');
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
                            ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '. trans('messages.keyword_editsuccessmsg') .  ' </div>');
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
                            ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '. trans('messages.keyword_deletesuccessmsg') .  ' </div>');
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
            return view('modificascontobonus', [
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
               ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_addsuccessmsg').' </div>');
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
                            ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_editsuccessmsg').' </div>');
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
                ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_deletesuccessmsg').' </div>');
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
						 'logo'=>'image|max:2000',
                        'immagine'=>'image|max:2000'
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
                'description_quize'=>$request->description_quize,
                'escludi_da_quiz'=>isset($request->escludi_da_quiz) ? $request->escludi_da_quiz : '0',
                'is_classic'=>isset($request->classic) ? $request->classic : '0',
                'lavorazione'=>$request->lavorazione,
                'sconto_reseller'=>$request->sconto_reseller,
            ]);
            return Redirect::back()->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_optional_added_correctly').'</div>');
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
        } 
        else {       
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
                        'description_quize'=>$request->description_quize,
                        'escludi_da_quiz'=>isset($request->escludi_da_quiz) ? $request->escludi_da_quiz : '0',
                        'is_classic'=>isset($request->classic) ? $request->classic : '0',
                        'lavorazione'=>$request->lavorazione,
                        'sconto_reseller'=>$request->sconto_reseller,
            		));

            return Redirect::back()
                            ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_optional_modified_correctly').'</div>');
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
                            ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Optional eliminato correttamente!</div>');
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
/* ==================================== Menu section START ======================================== */

    public function menu() {
        return view('menu');
    }

    public function parentmenu(Request $request) {
        $parentmenu = DB::table("modulo")
                ->select('*')
                ->where('modulo_sub', '=', null)
                ->where('type', $request->parent)
                ->get()
                ->toArray();
        // print_r($submenu);die;
        echo json_encode($parentmenu);
    }

    public function menuadd() {
        $parent = DB::table("modulo")->select('*')->where('modulo_sub', null)->get();
        $departments = DB::table("departments")->select('*')->get();
        return view('menuaddmodify', ['parent' => $parent,'departments'=>$departments]);
    }

    public function menumodify(Request $request) {

        $parent = DB::table("modulo")->select('*')->where('modulo_sub', null)->get();

        $menu = DB::table("modulo")->select('*')->where('id', $request->id)->first();

        $departments = DB::table("departments")->select('*')->get();
        //echo "<pre>"; print_r($menu);die;
        //$keyword_key = 'keyword_'.str_replace(" ","_",strtolower($request['keyword_title']));                               
        return view('menuaddmodify', ['menu' => $menu, 'parent' => $parent,'departments'=>$departments]);
    }

    public function menudelete(Request $request) {
        DB::table('modulo')
                ->where('id', $request->id)
                ->delete();
         return Redirect::back()
                        ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Menu deleted successfully!</div>');
    }

    public function storemenu(Request $request) {

        $validator = Validator::make($request->all(), [
                    'manuname' => 'required',
                    'image'=>'mimes:jpeg,jpg,png,svg|max:1000',
                    'menutype' => 'required'
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                            ->withInput()
                            ->withErrors($validator);
        }
        
        $nome = "";
        if ($request->image != null) {
            // Memorizzo l'immagine nella cartella public/imagesavealpha
            Storage::put('images/' . $request->file('image')->getClientOriginalName(), file_get_contents($request->file('image')->getRealPath()));

            $nome = $request->file('image')->getClientOriginalName();
        } 
        else {
            // Imposto l'immagine di default
            $nome = "defaulmenuicon.jpg";
        }


        $status = $this->checkurl($request->menulink);
            $phase_key = 'keyword_'.str_replace(" ","_",strtolower($request->manuname));

            DB::table('modulo')->insert([	
            	'modulo' => $request->manuname,
                'phase_key' => $phase_key,
                'modulo_sub' => (isset($request->submenu) && $request->submenu != "") ? $request->submenu : $request->parentmenu,                        
                'modulo_link' => isset($request->menulink) ? $request->menulink : '',
                'modulo_class' => $request->menuclass,
                'menu_active' => $status,
                'dipartimento' => $request->deparments,
                'image' => $nome,
            	'type' => $request->menutype,
            	'frontpriority' => isset($request->frontpriority) ? $request->frontpriority : '',
            	'backpriority' => isset($request->backpriority) ? $request->backpriority : ''
                ]);


            $arrLanguages =  DB::table('languages')
                        ->select('*')
                        ->where('is_deleted', 0)                        
                        ->get();		

			$collection = collect($arrLanguages);		
			$arrLanguages = $collection->toArray();
			
			foreach($arrLanguages as $key => $val){	

				$language_value = str_replace(" ","_",strtolower($request->manuname));

				DB::table('language_transalation')->insert([
					'language_key' => $phase_key,
					'language_label' =>$language_value,
					'language_value' => $request->manuname,					
					'code' => $val->code
				]);
					
			}
			
			$this->writelanguagefile();


       /* if ($request->submenu != '') {
            $status = $this->checkurl($request->menulink);
            DB::table('modulo')->insert(
                    ['modulo' => $request->manuname,
                        'phase_key' => "keyword_" . $request->manuname,
                        'modulo_sub' => $request->parentmenu,
                        'modulo_subsub' => $request->submenu,
                        'modulo_link' => $request->menulink,
                        'modulo_class' => "",
                        'menu_active' => $status
                    ]
            );
        } elseif ($request->parentmenu != "") {
            $status = $this->checkurl($request->menulink);
            DB::table('modulo')->insert(
                    ['modulo' => $request->manuname,
                        'phase_key' => "keyword_" . $request->manuname,
                        'modulo_sub' => $request->parentmenu,
                        'modulo_link' => $request->menulink,
                        'modulo_class' => "",
                        'menu_active' => $status
                    ]
            );
        } else {
            $status = $this->checkurl($request->menulink);
            DB::table('modulo')->insert(
                    ['modulo' => strtoupper($request->manuname),
                        'phase_key' => "keyword_" . $request->manuname,
                        'modulo_link' => $request->menulink,
                        'modulo_class' => $request->menuclass,
                        'menu_active' => $status
                    ]
            );
        }*/
        return redirect('/admin/menu/')
                        ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_addsuccessmsg').'!</div>');
        //$keyword_key = 'keyword_'.str_replace(" ","_",strtolower($request['keyword_title']));                       
    }

    public function submenu(Request $request) {    	

    	if($request->parent != '0'){  
        	$submenu = DB::table("modulo")
                ->select('*')
                ->where('modulo_sub', $request->parent)                                
                ->get()
                ->toArray(); 

            $submenu1[] = '';
			foreach($submenu as $sub) {	
				$results = DB::table("modulo")
		                ->select('*')
		                ->where('modulo_sub', $sub->id)                                
		                ->get()
		                ->toArray();
				// array_push($submenu, $results);
		        $submenu1 = array_merge($submenu1, $results);				
			}
			$submenu = array_merge($submenu, $submenu1);
        } 
        else {
        	$submenu = DB::table("modulo")
                ->select('*')                
                ->where('modulo_sub','!=', null)            	
                ->get()
                ->toArray();	
        }
        
        echo json_encode($submenu);
    }

    public function checkurl($url) {
        $menuactive = 0;
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
        /* Get the HTML or whatever is linked in $url. */
        $response = curl_exec($handle);
        /* Check for 404 (file not found). */
        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        if ($httpCode == 302 || $httpCode == 200) {
            /* Handle 404 here. */
            $menuactive = 1;
        }
        curl_close($handle);
        return $menuactive;
    }

    public function menujson() {

        $modulo = DB::table("modulo")
                ->select('*')
                ->get()
                ->toArray();

        foreach ($modulo as $key => $val) {
            if ($val->dipartimento != 0) {
                $department = DB::table("ruolo_utente")
                        ->select('*')
                        ->where('ruolo_id', $val->dipartimento)
                        ->first();
                $modulo[$key]->dipartimento = $department->nome_ruolo;
            } else {
                $modulo[$key]->dipartimento = 'All';
            }
            $val->type = ($val->type == '1') ? 'Front' : 'Backend';
            if ($val->menu_active == 0) {
                $modulo[$key]->menu_active = 'Active';
            }
            else {
                $modulo[$key]->menu_active = 'Inactive';
            }
        }
        echo json_encode($modulo);
    }

    public function menuupdate(Request $request) {
        $validator = Validator::make($request->all(), [
                    'manuname' => 'required',
                    'image'=>'mimes:jpeg,jpg,png,svg|max:1000',
                    'menutype' => 'required'
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                            ->withInput()
                            ->withErrors($validator);
        }

    	$nome = "";
    	$oldMenuDetails = DB::table('modulo')->where('id', $request->id)->first();
    	$nome = $oldMenuDetails->image;
        if ($request->image != null) {
            // Memorizzo l'immagine nella cartella public/imagesavealpha
            Storage::put('images/' . $request->file('image')->getClientOriginalName(), file_get_contents($request->file('image')->getRealPath()));
            $nome = $request->file('image')->getClientOriginalName();
        } /*else {
        	
            // Imposto l'immagine di default
            //$nome = "defaulmenuicon.jpg";
        }*/

        //module sub sub menu
        if ($request->submenu != '') {
            $status = $this->checkurl($request->menulink);
            DB::table('modulo')->where('id', $request->id)->
                    update(array(
                        'modulo' => $request->manuname,                        
                        'modulo_sub' => $request->parentmenu,
                        'modulo_subsub' => $request->submenu,
                        'modulo_link' => isset($request->menulink) ? $request->menulink : '',
                        'modulo_class' => "",
                        'menu_active' => $status,
                        'image' => $nome,
	                	'type' => $request->menutype,
	                	'frontpriority' => isset($request->frontpriority) ? $request->frontpriority : '',
	                	'backpriority' => isset($request->backpriority) ? $request->backpriority : ''
            ));
        } elseif ($request->parentmenu != "") {
            //module sub menu
            $status = $this->checkurl($request->menulink);
            DB::table('modulo')
                    ->where('id', $request->id)
                    ->update(array(
                        'modulo' => $request->manuname,                       
                        'modulo_sub' => $request->parentmenu,
                        'modulo_subsub' => 0,
                        'modulo_link' => isset($request->menulink) ? $request->menulink : '',
                        'modulo_class' => "",
                        'menu_active' => $status,
                        'image' => $nome,
	                	'type' => $request->menutype,
	                	'frontpriority' => isset($request->frontpriority) ? $request->frontpriority : '',
	                	'backpriority' => isset($request->backpriority) ? $request->backpriority : ''
            ));
        } 
        else {
            //module parent menu
            $status = $this->checkurl($request->menulink);
            DB::table('modulo')
                    ->where('id', $request->id)
                    ->update(array(
                        'modulo' => $request->manuname,                        
                        'modulo_sub' => $request->parentmenu,
                        'modulo_link' => isset($request->menulink) ? $request->menulink : '',
                        'modulo_class' => $request->menuclass,
                        'menu_active' => $status,
                        'image' => $nome,
	                	'type' => $request->menutype,
	                	'frontpriority' => isset($request->frontpriority) ? $request->frontpriority : '',
	                	'backpriority' => isset($request->backpriority) ? $request->backpriority : ''
                	));
        }
        return Redirect::back()
        	->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_editsuccessmsg').'</div>');
    }
    /* ==================================== Menu section END ======================================== */  


// ===================================================================================    
//    							Alert Functions
// ===================================================================================

	// show add alert form
    public function addadminalert(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            
            return view('addalertform', [
                'enti' => DB::table('corporations')
                    ->get(),
                'ruolo_utente' => DB::table('ruolo_utente')
                    ->where('is_delete', '=', 0)
                    ->get(),
                'alert_tipo' => DB::table('alert_tipo')
            		->get(),
            ]);
        }
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

    // store alert details
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
            
            $entity = implode(",", $request->input('ente'));
            $role = implode(",", $request->input('ruolo'));  

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


            return Redirect::back()
                ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_addsuccessmsg').' </div>');
        }
    }

    // show and modify alert type
    public function alertTipo()
    {
        return view('alerttipo', [
            'alert_tipo' => DB::table('alert_tipo')
                ->get()
        ]);
    }

    // add alert type
    public function newalertTipo(Request $request)
    {
            if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {

        	$validator = Validator::make($request->all(), [
                'nome_tipo' => 'required'
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                    ->withInput()
                    ->withErrors($validator);
            }
           
            DB::table('alert_tipo')->insert([
                'nome_tipo' => $request->nome_tipo,
                'desc_tipo' => isset($request->desc_tipo) ? $request->desc_tipo :'',
                'color' => isset($request->color) ? $request->color :'' 
            ]);

            return Redirect::back()->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_addsuccessmsg').' </div>');;
        }
    }

    // update type color
    public function alerttipoUpdate(Request $request)
    {
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {

        	$validator = Validator::make($request->all(), [
                'nome_tipo' => 'required'
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                    ->withInput()
                    ->withErrors($validator);
            }		

         	$arrstate = isset($request->chktasentitype) ? $request->chktasentitype : array();
            foreach($arrstate as $key => $val) {        		
        		$name = isset($request->nome_tipo[$key]) ? $request->nome_tipo[$key] : '';
        		$description = isset($request->desc_tipo[$key]) ? $request->desc_tipo[$key] : '';
        		$color = isset($request->color[$key]) ? $request->color[$key] : '';
	            if($request->action == 'delete') {
					DB::table('alert_tipo')->where('id_tipo', $key)->delete();							
	            }
	            else {
		            DB::table('alert_tipo')->where('id_tipo', $key)->update(array('nome_tipo' => $name,'desc_tipo' => $description,'color' => $color));
	            }          
            }
            $msg = ($request->action == 'delete') ? '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_deletesuccessmsg').' </div>' : '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_editsuccessmsg').' </div>';
            return Redirect::back()->with('msg', $msg);


        }
    }

    // delete alert type
    public function alerttipodelete(Request $request)
    {
        DB::table('alert_tipo')
            ->where('id_tipo', $request->id_tipo)
            ->delete();

        return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_deletesuccessmsg').' </div>');;
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
                ->where('is_sent', '=', 0)
                ->get();


            if($alert->isEmpty()) {
                return "NO Alert Remaining ..!!";
            }
           	
           	
            foreach ($alert as $value) {

                $ente = explode(",", $value->ente);
                $ruolo = explode(",", $value->ruolo);

                foreach ($ente as $ente) {

                    $getente = DB::table('enti_partecipanti')
                        ->select('id_ente', 'id_user')
                        ->where('id_ente', $ente)
                        ->get();
                                   
                    foreach ($getente as $getente) {
 
                        $getrole = DB::table('users')
                            ->select('dipartimento')
                            ->where('id', $getente->id_user)
                            ->where('is_delete', 0)
                            ->first();                       	
                       	
                        if(isset($getrole)) {  

                        	$check = in_array($getrole->dipartimento, $ruolo);   

                        	if($check){
                        	$corporations = DB::table('corporations')
                                ->where('id', $getente->id_ente)
                                ->first();                              
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

	                 		DB::table('alert')      
	                            ->where('alert_id', $value->alert_id)       
	                            ->update(array(     
	                            'is_sent' => 1      
	                    	));
	                     	if($value->is_email == '1') {      	
	                     		$emailSubject = "Alert :".$value->nome_alert;
	                     		$toEmail = $corporations->email;
	                    		Mail::send('layouts.alertemail', ['content' => $value->messaggio], function ($m) use ($corporations,$emailSubject,$toEmail) {
									$m->from('easy@langa.tv', 'Alert LANGA');
									/*$corporations->email = "developer5@mailinator.com";*/
									$m->to($corporations->email)->subject($emailSubject);
        						});
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
    }
 /* ==================================== Taxation section START ======================================== */

    public function deletetaxation(Request $request) {
        if ($request->user()->id != 0) {

            return redirect('/unauthorized');
        } else {

            DB::table('tassazione')
                    ->where('tassazione_id', $request->id)
                    ->delete();

            return Redirect::back()
                            ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_taxation_deleted_successfully').'</div>');
        }
    }

    public function storetaxation(Request $request) {

        if ($request->user()->id != 0) {
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

            if ($tassazione_id) {

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
                                ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_taxation_updated_successfully').'</div>');
            } else {

                DB::table('tassazione')->insert([
                    'tassazione_nome' => $request->tassazione_nome,
                    'tassazione_percentuale' => $request->tassazione_percentuale
                ]);

                return Redirect::back()
                                ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_taxation_inserted_successfully').'</div>');
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
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {

            if ($request->id) {

                $taxation = DB::table('tassazione')
                        ->where('tassazione_id', $request->id)
                        ->first();

                return view('aggiungitaxation')->with('taxation', $taxation);
            } else {
                return view('aggiungitaxation');
            }
        }
    }

    // show taxation
    public function showtaxation(Request $request) {
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            return view('taxation');
        }
    }
/* ==================================== Taxation section END ======================================== */

/* ====================================  Department section START ======================================== */

    public function dipartimenti(Request $request) {
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            return $this->mostraDipartimenti();
        }
    }

    public function mostraDipartimenti() {
       return view('tassonomie_dipartimenti');
    }

    public function nuovo() {
        return view('aggiungidipartimento', [
            'utenti' => DB::table('users')
                    ->get(),
        ]);
    }

    public function add(Request $request) {
        return redirect('admin/tassonomie/dipartimenti/add');
    }

    public function salvadipartimento(Request $request) {
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
                            ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans("messages.keyword_department_added_successfully").'</div>');
        }
    }

    public function modificadipartimento(Request $request) {
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

    public function destroydipartimento(Request $request) {
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            DB::table('departments')
                    ->where('id', $request->department)
                    ->delete();
            return Redirect::back()
                            ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans("messages.keyword_department_deleted_properly").'</div>');
        }
    }

    public function aggiornadipartimento(Request $request) {
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            $validator = Validator::make($request->all(), [
                        'nomedipartimento' => 'required|max:35',
                        'nomereferente' => 'required|max:35',
                        'settore' => 'max:50',
                        'piva' => 'max:11',
                        'cf' => 'max:16',
                        //'telefonodipartimento' => 'required|max:20',
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
                            ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans("messages.keyword_modify_department").'</div>');
        }
    }
	public function dipartimentijson()
	{ //echo "hello";
		
            $dipartimenti = DB::table('departments')
                    ->orderBy('id')
                    ->limit(50)
                    ->get();
			foreach($dipartimenti as $key=>$val)
			{
				$val->logo="<img src='".url('storage/app/images/'.$val->logo)."' style='max-width:100px; max-height:100px'></img>";
				$department[]=$val;
			}
			return json_encode($department);
      
	}

    /* ====================================  Department section END ======================================== */
	/* ==================================== Quiz Demo section START  ======================================== */

    public function quizdemo() {
        /* tassonomie_lavorazioni */
        return view('quiz_demo', [
            'departments' => DB::table('departments')->get(),
            'quizdemodettagli' => DB::table('quizdemodettagli')->orderBy('id', 'desc')->get(),
                /* 'lavorazioni' => DB::table('departments')
                  ->leftJoin('lavorazioni', 'departments.id', '=', 'lavorazioni.departments_id')
                  ->select('departments.id as departmentsID','departments.nomedipartimento','lavorazioni.*')
                  ->get(), */
        ]);
    }

    public function nuovoquizdemo(Request $request) {
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        }
        $validator = Validator::make($request->all(), [
                    'name' => 'required|max:255|unique:quizdemodettagli,nome',                         
                    'url' => 'required',
                    'immagine' => 'mimes:jpeg,jpg,png|max:1000'
        ]);
        if ($validator->fails()) {
            return Redirect::back()
                            ->withInput()
                            ->withErrors($validator);
        }
        $averageRate = '3';
        $totalRate = '5';
        $today = date("Y-m-d h:i:s");
        $immaginenome = "";
        if ($request->immagine != null) {
            // Memorizzo l'immagine nella cartella public/imagesavealpha
            Storage::put('images/quizdemo/' . $request->file('immagine')->getClientOriginalName(), file_get_contents($request->file('immagine')->getRealPath()));
            $immaginenome = $request->file('immagine')->getClientOriginalName();
        }
        // Creo il nuovo tipo e lo memorizzo nel DB masterdatatypes
        DB::table('quizdemodettagli')->insert([
            'nome' => $request->name,
            'url' => $request->url,
            'immagine' => $immaginenome,
            'tassomedio' => $averageRate,
            'tassototale' => $totalRate,
            'created_date' => $today,
            'updated_date' => $today,
        ]);
        return Redirect::back()->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' . trans('messages.keyword_quiz_added') . '</div>');
    }

    public function quizdemodelete(Request $request) {
        DB::table('quizdemodettagli')
                ->where('id', $request->id)
                ->delete();
        return Redirect::back()
                        ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' . trans('messages.keyword_quiz_deleted') . '</div>');
    }

    public function quizdemoUpdate(Request $request) {
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } 
        else {
            /*$validator = Validator::make($request->all(), [
                        'name' => 'required',
                        'name' => 'required|max:255|unique:quizdemodettagli,nome,'.$request->id.',id',
                        'url' => 'required',
                        'immagine.*' => 'mimes:jpeg,jpg,png|max:1000'
            ]);
            if ($validator->fails()) {
                return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }*/
			/*$rules = array();
			$arrname = $request->name;
            foreach($arrname as $key => $val) {
            	 $rules['name.'.$key] = 'required|max:255';
            }
            $validator = Validator::make($request->all(),$rules);
            if ($validator->fails()) {
               	return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }*/
            $arrImages=array();			
            $arrstate = isset($request->chktasentitype) ? $request->chktasentitype : array();            
            foreach($arrstate as $key => $val) {        		
        		$name = isset($request->name[$key]) ? $request->name[$key] : '';
        		//$description = isset($request->description[$key]) ? $request->description[$key] : '';
        		//$color = isset($request->color[$key]) ? $request->color[$key] : '';
        		$url = isset($request->url[$key]) ? $request->url[$key] : '';
        		 $averageRate = '3';
		            $totalRate = '5';
		            $today = date("Y-m-d h:i:s");
		            $immagine = DB::table('quizdemodettagli')
		                    ->select('immagine')
		                    ->where('id', $key)
		                    ->first();

            		$arr = json_decode(json_encode($immagine), true);
					$immaginenome = $arr['immagine'];   
            		$arrfiles = $request->file('immagine');  					

		            if (isset($arrfiles[$key]) && $arrfiles[$key] != null) {
		                // Memorizzo l'immagine nella cartella public/imagesavealpha
		                Storage::put('images/quizdemo/' . $arrfiles[$key]->getClientOriginalName(), file_get_contents($arrfiles[$key]->getRealPath()));
		                $immaginenome = $arrfiles[$key]->getClientOriginalName();
		            }
	            if($request->action == 'delete') {
					DB::table('quizdemodettagli')->where('id', $key)->delete();							
	            }
	            else {
		            DB::table('quizdemodettagli')->where('id', $key)->update(array('nome' => $name,'url' => $url,'immagine' => $immaginenome,'updated_date'=>$today));
	            }          
            }
            $msg = ($request->action == 'delete') ? '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_deletesuccessmsg').' </div>' : '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_editsuccessmsg').' </div>';
            return Redirect::back()->with('msg', $msg);
        }
    }

    /* ==================================== Quiz Demo section END ======================================== */
	
	/* ==================================== Life Cost Indices section START======================================== */
    // show list of provinces
    public function showprovincie(Request $request) {
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            $provincie = DB::table('citta')
                    ->get();
            $stato = DB::table('stato')
                    ->get();
            return view('provincie')->with('provincie', $provincie)->with('stato', $stato);
        }
    }

// add new provincie 

    public function addprovincie(Request $request) {
        if ($request->user()->id != 0) {
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

                if ($check_citta->nome_citta == $citta && $check_citta->id_stato == $stato) {

                    return '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> can not add same city in same state.! </div>';
                }
            }

            DB::table('citta')->insert(
                    ['id_stato' => $stato, 'nome_citta' => $citta,
                        'provincie' => $provincie]
            );

            return '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> Provincie added succesfully..!! </div>';
        }
    }

    // store provincie 
    public function storeprovincie(Request $request) {
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {

            $citta = $request->input('citta');
            $provincie = $request->input('provincie');
            $id_citta = $request->input('id_citta');

            foreach ($citta as $index => $nome_citta) {

                foreach ($id_citta as $key => $value) {

                    if ($index == $key) {

                        DB::table('citta')
                                ->where('id_citta', $value)
                                ->update(['nome_citta' => $nome_citta]);
                    }
                }
            }

            foreach ($provincie as $index => $provincie) {

                foreach ($id_citta as $key => $value) {

                    if ($index == $key) {

                        DB::table('citta')
                                ->where('id_citta', $value)
                                ->update(['provincie' => $provincie]);
                    }
                }
            }

            return Redirect::back()
                            ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> provincie updated succesfully..!</div>');
        }
    }

    /* ==================================== Life Cost Indices section END ======================================== */
	
	/* ==================================== Login activity section START ======================================== */

// show user page list
    public function utenti(Request $request) {
        if ($request->user()->id != 0) {
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

    public function getjsonusers(Request $request) {
        $users = DB::table('users')
                ->join('ruolo_utente', 'users.dipartimento', '=', 'ruolo_utente.ruolo_id')
                ->leftjoin('stato', 'users.id_stato', '=', 'stato.id_stato')
                ->select('*')
                ->where('id', '!=', 0)
                ->where('users.is_delete', '=', 0)
                ->where('is_approvato', '=', 1)
                ->where('dipartimento', '!=', 5)
                ->where('ruolo_utente.is_delete', '=', 0)
                ->get()
                ->toArray();
        foreach ($users as $key => $usr) {
            $users[$key]->button = '<button id="access" class="access btn btn-warning" onclick="access(' . $usr->id . ')" type="submit">'.ucwords(trans('messages.keyword_access')).'</button>';
        }
        return json_encode($users);
    }

    public function clients(Request $request) {

        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            return view('clients');
        }
    }

    public function getjsonclients(Request $request) {

        $clients = DB::table('users')
               ->join('ruolo_utente', 'users.dipartimento', '=', 'ruolo_utente.ruolo_id')
               ->leftjoin('stato', 'users.id_stato', '=', 'stato.id_stato')
               ->select('*')               
               ->where('users.is_delete', '=', 0)
               ->where('is_approvato', '=', 1)
               ->where('dipartimento', '=', 5)              
               ->get()
               ->toArray();

        foreach ($clients as $key => $usr) {
            $clients[$key]->button = '<button id="access" class="access btn btn-warning" onclick="access(' . $usr->id . ')" type="submit">Access</button>';
        }

        return json_encode($clients);
    }

    protected function access(Request $request) {
        
        $user = DB::table('users')
                ->where('id', $request->userid)
                ->first();

        $request->session()->put('isAdmin', 1);
        $request->session()->put('adminID', Auth::id());
        
        if (Auth::loginUsingId($user->id)) {
            return redirect('/');
        }
    }

    /* ==================================== Login activity section END ======================================== */
	
    /* ============================ Quiz Package section Start ========================  */
    /* Package sesction listing : Paras */
     public function quizpackage(Request $request) {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            return view('quizpackage', [
                'pacchetto' => DB::table('pacchetto')
                                ->select('*')
                                ->where('id', '!=', 0)
                                ->where('is_deleted', '=', 0)
                                ->paginate(10),
            ]);
        }
    }
    // Language details
    public function getjsonquizpackage(Request $request) {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } 
		else { 
			$data = DB::table('pacchetto')
                        ->select('*')
                        ->where('id', '!=', 0)
                        ->where('is_deleted', '=', 0)
                        ->get();            
			foreach($data as $data) {								
				$ente_return[] = $data;	
			}
			return json_encode($ente_return);
        }
    }
	
    public function modifyquizpackage(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } 
        else {
            if($request->pacchetto){
                return view('modifyquizpackage', [                   
                    'action'=>'edit',
                    'pacchetto_data' => DB::table('pacchetto')
                                ->select('*')
                                ->where('id', $request->pacchetto)
                                ->get()               
                ]);
            } 
            else {
                return view('modifyquizpackage', ['action'=>'add']);
            }
        }
    }
     
    public function savequizpackage(Request $request) {

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
            return Redirect::back()->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_quiz_package_updated_successfully').'</div>');
            
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
           ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_quiz_package_added_successfully').'</div>');

        }        
        }            
    }
    
     public function destroyquizpackage(Request $request)
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
                            ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Pacchetto eliminato correttamente!</div>');
        }
    }
    /* ============================ Package section ========================  */
	// user read alert 
    public function userreadalert(Request $request)
    {

        $today = date("Y-m-d h:i:s");

        $alert_id = $request->input('alert_id');
        $user_id = $request->input('user_id');
      
         DB::table('inviare_avviso')
            ->where('alert_id', $alert_id)
            ->where('user_id', $user_id)
            ->update(array(
	            'data_lettura' => $today,
	            'conferma' => 'LETTO'
            ));
                
        return Redirect::back();
        
    }

    // make comment alert
    public function alertmakecomment(Request $request)
    {
        $messaggio = $request->input('messaggio');
        $alert_id = $request->input('alert_id');
        $user_id = $request->input('user_id');
        
        DB::table('inviare_avviso')
            ->where('alert_id', $alert_id)
            ->where('user_id', $user_id)
            ->update(array(
                'comment' => $messaggio
        	));
                
        return Redirect::back();    
    }   
	
    /* ==================================== Alert end======================================== */
	
	/* ====================================Notification start ======================================== */	
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
                ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_notification_deleted_successfully').'</div>');
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
			$notifica = array();
			$action = 'add';
            if($request->id){
            	$notifica = DB::table('notifica')
                        ->where('id', "=", $request->id)
                        ->first();
                $action = 'edit';
            } 
            return view('addadminnotification', [
            		'action'=>$action,
                    'notifica' => $notifica,
                    'enti' => DB::table('corporations')->get(),
                    'modulo' => DB::table('modulo')->where('modulo_sub', '=', null)->get(),
                    'ruolo_utente' => DB::table('ruolo_utente')->where('is_delete',0)->get()                
                ]);
            
        }
    }

  // detail notification json
    public function detailnotificationjson(Request $request)
    {
        if($request->id) {

            $notifica = DB::table('invia_notifica')
                ->where('notification_id', "=", $request->id)
                ->get();   
               
        } else {

            $notifica = DB::table('invia_notifica')
                ->get();               
        }

        return json_encode($notifica);

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

          	    $ente = $request->input('ente');
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
                    ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_notification_updated_successfully').'</div>');

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
				$ente = $request->input('ente');
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
                    ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_notification_added_successfully').'</div>');
            }    
        }
    }

    // send alert notification to users
  

      // send notification to users
    public function sendnotification(Request $request)
    {
        if($request->user()->id != 0) {
            
            return redirect('/unauthorized');

        } else {

            $today = date("Y-m-d");

            $notifica = DB::table('notifica')
                ->where('created_at', $today)
                ->where('is_sent', '=', 0)
                ->get();

            if($notifica->isEmpty()) {
                return "Notification not set ..!!";
            }

            foreach ($notifica as $value) {
                
                $ente = explode(",", $value->id_ente);
                $ruolo = explode(",", $value->ruolo);

                if($ente[0] != null){
                	
                	foreach ($ente as $ente) {

                		$getente = DB::table('enti_partecipanti')
	                        ->select('id_ente', 'id_user')
	                        ->where('id_ente', $ente)
	                        ->distinct()
	                        ->get();

	                    $store = false;

                        foreach ($getente as $getente) {                        

                            $getrole = DB::table('users')
	                            ->select('dipartimento')
	                            ->where('id', $getente->id_user)
	                            ->where('is_delete', 0)
	                            ->first(); 
             	
	                        if(isset($getrole)) {  

                        	$check = in_array($getrole->dipartimento, $ruolo);  

                        	if($check){

	                        	$corporations = DB::table('corporations')
	                                ->where('id', $getente->id_ente)
	                                ->first();

	                            $store = DB::table('invia_notifica')->insert([
	                            	'id_ente' => $corporations->id,
	                                'user_id' => $getente->id_user,
	                                'notification_id' => $value->id,
	                                'nome_azienda' => $corporations->nomeazienda,
	                                'nome_referente' => $corporations->nomereferente,
	                                'settore' => $corporations->settore,
	                                'telefono_azienda' => $corporations->telefonoazienda,
	                                'email' => $corporations->email,
	                                'data_lettura' => '',
	                                'conferma' => 'NON LETTO'
	                            ]);	       

	                            DB::table('notifica')
                                ->where('id', $value->id)
                                ->update(array( 'is_sent' => 1 ));   

                                $true = true;                  

                    			}
                        	} 
                        } 
                	}

                } else {
                	
                	foreach ($ruolo as $role) {

                        $getdept = DB::table('users')
                        	->select('id', 'dipartimento')
                            ->where('dipartimento', $role)
                            ->where('is_delete', 0)
                            ->get();                       	

                        foreach ($getdept as $getdept) {

	                        $store = DB::table('invia_notifica')->insert([
	                            'ruolo' => $role,
	                            'user_id' => $getdept->id,
	                            'notification_id' => $value->id,
	                            'nome_azienda' => '',
	                            'nome_referente' => '',
	                            'settore' => '',
	                            'telefono_azienda' => '',
	                            'email' => '',
	                            'data_lettura' => '',
	                            'conferma' => 'NON LETTO'
	                        ]);

                            if($store) {
                            	$true = true;     
                            }	
                        }

                        DB::table('notifica')
                        ->where('id', $value->id)
                        ->update(array( 'is_sent' => 1 ));
                    } 
                }
            }	

            if($true){
               return "Send all notifications successfully.!!";
            } else {
               return "Somthing Went Wrong";
            }                       
        }
    }

// user read notification
    public function userreadnotification(Request $request)
    {
        $today = date("Y-m-d h:i:s");

        $notification_id = $request->input('notification_id');
        $user_id = $request->input('user_id');

        DB::table('invia_notifica')
            ->where('notification_id', $notification_id)
            ->where('user_id', $user_id)
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
        $notification_id = $request->input('notification_id');
        $user_id = $request->input('user_id');
        
        DB::table('invia_notifica')
            ->where('notification_id', $notification_id)
            ->where('user_id', $user_id)
            ->update(array(
                'comment' => $messaggio
        	));
                
        return Redirect::back();  
    }   

    // notification delete
    public function userdeletenotification(Request $request)
    {    	
        $notification_id = $request->input('notification_id');
        $user_id = $request->input('user_id');
        
        DB::table('invia_notifica')
            ->where('notification_id', $notification_id)
            ->where('user_id', $user_id)
            ->update(array(
                'is_deleted' => 1
        	));
                
        return Redirect::back();  
    }

    // alert delete
    public function userdeletealert(Request $request)
    {    	
        $alert_id = $request->input('alert_id');
        $user_id = $request->input('user_id');
        
        DB::table('inviare_avviso')
            ->where('alert_id', $alert_id)
            ->where('user_id', $user_id)
            ->update(array(
                'is_deleted' => 1
        	));
                
        return Redirect::back();  
    }   
   

    public function getnotificationjson(Request $request)
    {
        $notifica = DB::table('notifica')
                    ->get();  

        $role_values = DB::table('ruolo_utente')->where('is_delete',0)
                ->get();

        $notification = [];

        foreach ($notifica as $notifica) {

            $ruolo = explode(",", $notifica->ruolo);

            $r = '';
            foreach($role_values as $role) {

                 if(in_array($role->ruolo_id, $ruolo)){
					$r .= '<div class="round-checkbox manual_radio">';
					$r .= '<input name="ruolo" disabled="disabled" checked id="ruolo_'.$role->ruolo_id.'_id_M" value="'.$role->ruolo_id.'" type="checkbox">';
					$r .= '<label for="ruolo_'.$role->ruolo_id.'_id_M">'.$role->nome_ruolo.'</label>';
					$r .= '<div class="check"><div class="inside"></div></div></div>';
                    /*$r .= "<input type='checkbox' name='ruolo' id='ruolo' value='$role->ruolo_id' disabled='disabled' checked /> $role->nome_ruolo ";*/
                } else {
					$r .= '<div class="round-checkbox manual_radio">';
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

    /* ==================================== Activity Logs section START ======================================== */
	// show user page list
    public function activitylogs(Request $request) {    	
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } 
        else {        	
        	$request->mastertype = isset($request->mastertype) ? $request->mastertype : 'user';        	
        	$request->type = isset($request->type) ? $request->type : '0';
            return view('member_activity_log',
            	['departments'=> DB::table('ruolo_utente')->where('is_delete','0')->where('ruolo_id','!=','1')->get(),
            	'usertype'=>$request->type,
            	'mastertype'=>$request->mastertype]);
        }
    }

    public function getjsonactivitylogs(Request $request) {    	
    	$request->type = isset($request->type) ? $request->type : '0';    	
    	//$request->type = $request->type == 'admin'
    	$query=	DB::table('member_activity_log')
			->join('users', 'users.id', '=', 'member_activity_log.user_id')
			->join('ruolo_utente', 'ruolo_utente.ruolo_id', '=', 'users.dipartimento')
			->select('users.name as username','users.dipartimento','ruolo_utente.nome_ruolo','member_activity_log.*')
			->orderBy('member_activity_log.id', 'desc');
	    	if($request->mastertype == 'admin'){			
				$query->where("users.dipartimento",'1');			
	    	}
	    	else {
	    		($request->type == '0') ? $query->where("users.dipartimento","!=","1")	: $query->where("users.dipartimento",$request->type);					
	    	}    	
			$users = $query->get()->toArray();		
        	return json_encode($users);
    }

    /* This function is used to delete activity logs */
	public function deleteActivitylogs(Request $request) {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } 
		else {
			 DB::table('member_activity_log')
            ->where('id', $request->id)
            ->delete();			               
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_activity_deleted_successfully').'</div>');			
        }
    }
	/*================================= Frequency sections ============================================= */
	public function frequency(Request $request) {
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } 
		else {
          return view('frequency', [
			'frequency' => DB::table('frequenze')->orderBy('id', 'desc')->get(),
			]);
        }
    }   
	
	public function updatefrequency(Request $request) {
            if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
        	$arrname = $request->name;
        	foreach($arrname as $key => $val){
        		if(isset($request->id[$key])){
        			$description = isset($request->description[$key]) ? $request->description[$key] : '';
        			$rinnovo = isset($request->rinnovo[$key]) ? $request->rinnovo[$key] : '';
		            DB::table('frequenze')
		                    ->where('id', $request->id[$key])
		                    ->update(array(
		                        'nome' => $val,
		                        'descrizione' => $description,
		                        'rinnovo' => $rinnovo,
		            ));
		        }
		    }
            return Redirect::back()->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_editsuccessmsg').'</div>');
        }
    }
	
	public function deletefrequency(Request $request) {
		DB::table('frequenze')
			->where('id', $request->id)
			->delete();
                return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_deletesuccessmsg').' </div>');
	}
	
	public function addfrequency(Request $request)
	{
		if($request->user()->id != 0)
			return redirect('/unauthorized');
		else {
			DB::table('frequenze')->insert([
				'nome' => $request->name,
				'descrizione' => $request->description,
				'rinnovo' => $request->rinnovo,
			]);
			return Redirect::back()->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_addsuccessmsg').' </div>');
		}
	}

	/*================================= Notification sections ============================================= */
	/* get filter notification in json format  */
	 public function notificationjson(Request $request) {
       
      $userId = Auth::id();

		$notifications = DB::table('invia_notifica')
       ->leftjoin('notifica', 'invia_notifica.notification_id', '=', 'notifica.id')
       ->select(DB::raw('invia_notifica.*, notifica.id as noti_id, notifica.notification_type, notifica.notification_desc'))
       ->where('user_id', $userId)
       ->where('is_enabled', 0)
       ->Where('notification_type', 'like', '%' .$request->find. '%')
       ->orderBy('data_lettura', 'asc')	         
       ->get()->toArray();

      // $html = '';
      $noti = [];

      if($notifications){

      	foreach($notifications as $notification){
				$date = $notification->created_at; $date = date_format(new DateTime($date), 'D-m-Y H:i:s'); 

		  		$html = "<div id='replace-noti'><div class='chkbox-blk'> <div class='chkbox'> <input type='checkbox' id='notifi2'> <label for='notifi2'> notifi2 </label> </div> <div class='info'> <a href='" .url('/notifiche/delete') .'/' .$notification->id. "' onclick='return confirm('".trans('messages.keyword_sure_to_disable_notification')."?')'> <span>" .$notification->notification_type;
				$html .="</span> <span class='time'>" .$date;
				$html .= "</span> <div class='message'>" .$notification->notification_desc;
				$html .= "</div> </a> </div> </div> </div> ";
		      $noti = $html;
   		}	

      } else {
      	$html = "<div class='chkbox-blk'> <div class='chkbox'> </div> <div class='info'> <a href=''> <span> No matches Found";				
			$html .= "</span> </div> </a> </div> </div> ";
			$noti = $html;
      }
   	
      return $noti;
    }

    public function notificationdisabled(Request $request) 
    {
        if($request->user()->id != 0) {        	
            return redirect('/unauthorized');
        } else {
        		$id = $request->arr_id;
        		foreach ($id as $value){
        			DB::table('invia_notifica')
                 ->where('id', $value)
                 ->update(array(
                     'is_enabled' => 1
               ));
        		}
        }
    }

}
