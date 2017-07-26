<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ProjectRepository;
use DB;
use Validator;
use Redirect;
use Storage;
use App\Http\Requests;
use App\Project;
use App\Classes\PdfWrapper as PDF;

class ProjectController extends Controller
{
    protected $progetti;
	protected $logmainsection;

	protected $module;
	protected $sub_id;

    public function __construct(ProjectRepository $projects) {

        $this->middleware('auth');
        $this->progetti = $projects;
        $this->logmainsection = 'Project';

        $request = parse_url($_SERVER['REQUEST_URI']);
		$path = ($_SERVER['HTTP_HOST'] == 'localhost') ? rtrim(str_replace('/easylangaw/', '', $request["path"]), '/') : $request["path"];		
		$result = rtrim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $path), '/');
		$current_module = DB::select('select * from modulo where TRIM(BOTH "/" FROM modulo_link) = :link', ['link' => $result]);  

        $this->module = (isset($current_module[0]->modulo_sub)) ? $current_module[0]->modulo_sub : 4;
        $this->sub_id = (isset($current_module[0]->id)) ? $current_module[0]->id : 18;
    }

	//updatemediaComment
    /* File uploader : paras */
	public function fileupload(Request $request){
			/*$validator = Validator::make($request->all(), [
                        'code' => 'required',
						'file'=>'mimes:jpeg,jpg,png|max:1000',	
            ]);
            if ($validator->fails()) {
                return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }*/	
			Storage::put(
					'images/projects/' . $request->file('file')->getClientOriginalName(), file_get_contents($request->file('file')->getRealPath())
			);
			$nome = $request->file('file')->getClientOriginalName();			
				DB::table('media_files')->insert([
				'name' => $nome,
				'code' => $request->code,
				'type'=>$request->user()->dipartimento,
				'master_type'=>'1',
				'date_time'=>time()
			]);					
	}

	
	public function fileget(Request $request) {
			/*$validator = Validator::make($request->all(), [
                        'code' => 'required',			
            ]);
            if ($validator->fails()) {
			    return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }*/
			
			if(isset($request->quote_id)) {
				$updateData = DB::table('media_files')->where('master_id', $request->quote_id)->get();										
			}
			else {
				$updateData = DB::table('media_files')->where('code', $request->code)->get();				
			}
						
			foreach($updateData as $prev) {
				$imagPath = url('/storage/app/images/projects/'.$prev->name);
				$downloadlink = url('/storage/app/images/projects/'.$prev->name);
				$filename = $prev->name;			
				$arrcurrentextension = explode(".", $filename);
				$extention = end($arrcurrentextension);
							
				$arrextension['docx'] = 'docx-file.jpg';
				$arrextension['pdf'] = 'pdf-file.jpg';
				$arrextension['xlsx'] = 'excel.jpg';
				if(isset($arrextension[$extention])){
					$imagPath = url('/storage/app/images/default/'.$arrextension[$extention]);			
				}

				$titleDescriptions = (!empty($prev->title)) ? '<hr><strong>'.$prev->title.'</strong><p>'.$prev->description.'</p>' : "";			
				$html = '<tr class="quoteFile_'.$prev->id.'"><td><img src="'.$imagPath.'" height="100" width="100"><a href="'.$downloadlink.'" class="btn btn-info pull-right"  download><i class="fa fa-download"></i></a><a class="btn btn-success pull-right"  onclick="sociallinks('.$prev->id.')"><i class="fa fa-share-alt"></i></a><a class="btn btn-danger pull-right" style="text-decoration: none; color:#fff" onclick="deleteQuoteFile('.$prev->id.')"><i class="fa fa-trash"></i></a>'.$titleDescriptions.'</p></td></tr>';

				$html .='<tr class="quoteFile_'.$prev->id.'"><td>';
				$utente_file = DB::table('ruolo_utente')->select('*')->where('is_delete', 0)->get();							
				foreach($utente_file as $key => $val){
					if($request->user()->dipartimento == $val->ruolo_id){
						$response = DB::table('media_files')->where('id', $prev->id)->update(array('type' => $val->ruolo_id));	    
						/*$html .=' <div class="cust-radio"><input type="radio" checked="checked" name="rdUtente_'.$prev->id.'" id="'.$val->nome_ruolo.'_'.$val->ruolo_id.'" onchange="updateType('.$val->ruolo_id.','.$prev->id.');" value="'.$val->ruolo_id.'" /><label for="'.$val->nome_ruolo.'_'.$val->ruolo_id.'"> '.$val->nome_ruolo.'</label><div class="check"><div class="inside"></div></div></div>';*/
						
						$specailcharcters = array("'", "`");
                    	$rolname = str_replace($specailcharcters, "", $val->nome_ruolo);
                    	$html .=' <div class="cust-checkbox"><input type="checkbox" checked="checked" name="rdUtente_'.$prev->id.'" id="'.$rolname.'_'.$prev->id.'" onchange="updateType('.$val->ruolo_id.','.$prev->id.',this.id);"  value="'.$val->ruolo_id.'" /><label for="'.$rolname.'_'.$prev->id.'"> '.$val->nome_ruolo.'</label><div class="check"><div class="inside"></div></div></div>';
					}
					else {
						/*$html .=' <div class="cust-radio"><input type="radio" name="rdUtente_'.$prev->id.'" id="'.$val->nome_ruolo.'_'.$val->ruolo_id.'" onchange="updateType('.$val->ruolo_id.','.$prev->id.');"  value="'.$val->ruolo_id.'" /><label for="'.$val->nome_ruolo.'_'.$val->ruolo_id.'"> '.$val->nome_ruolo.'</label><div class="check"><div class="inside"></div></div></div>';*/
						$specailcharcters = array("'", "`");
                    	$rolname = str_replace($specailcharcters, "", $val->nome_ruolo);
                    	$html .=' <div class="cust-checkbox"><input type="checkbox" name="rdUtente_'.$prev->id.'" id="'.$rolname.'_'.$prev->id.'" onchange="updateType('.$val->ruolo_id.','.$prev->id.',this.id);"  value="'.$val->ruolo_id.'" /><label for="'.$rolname.'_'.$prev->id.'"> '.$val->nome_ruolo.'</label><div class="check"><div class="inside"></div></div></div>';
					}
				}
				echo $html .='</td></tr>';
			}
			exit;			
		}

		
	public function filedelete(Request $request){
		/*$validator = Validator::make($request->all(), ['code' => 'required']);
		if ($validator->fails()) {
			return Redirect::back()
							->withInput()
							->withErrors($validator);
		}*/
	    $response = DB::table('media_files')->where('id', $request->id)->delete();
	    echo ($response) ? 'success' :'fail';   				
		exit;
	}
	public function filetypeupdate(Request $request){		 
		$request->ids = isset($request->ids) ? implode(",",$request->ids) : "";
		$response = DB::table('media_files')->where('id', $request->id)->update(array('type' => $request->ids));
		echo ($response) ? 'success' :'fail';   			    		
		exit;
	}
	public function updatemediaComment(Request $request){		 		
		$updateData = DB::table('media_files')->where('code', $request->code)->orderBy('id', 'desc')->first();										
		$title = $request->title;
		$descriptions = $request->descriptions;
		
		$response = DB::table('media_files')->where('date_time', $updateData->date_time)->update(array('description' => $descriptions,'title'=>$title));
		echo ($response) ? 'success' :'fail';   			    		
		exit;
	}
		

    public function index(Request $request)
    {
    	if(!checkpermission($this->module, $this->sub_id, 'lettura')){
    		return redirect('/unauthorized');
    	}

        return $this->show($request);
    }
    
	public function completaCodice(&$progetti)
	{
		if($progetti != ''){
			foreach($progetti as $prog) {
				$anno = substr($prog->datainizio, -2);
				if($prog->id_ente != null)
					$prog->ente = DB::table('corporations')
						->where('id', $prog->id_ente)
						->first()->nomeazienda;
				$prog->codice = '::' . $prog->id . '/' . $anno;
			}
		}
		
	}
	
	public function getJsonMiei(Request $request)
	{
		$progetti = $this->progetti->forUser2($request->user());	
		$this->completaCodice($progetti);
		return json_encode($progetti);
	}
	
	public function getjson(Request $request)
	{

		$progetti = $this->progetti->forUser($request->user());
		$this->completaCodice($progetti);
		return json_encode($progetti);
	}

	public function pdf(Request $request)
	{		
		/*$request->id;
		$quote*/
		$project = DB::table('projects')->where('id', $request->id)->first();

		$progetti_lavorazioni = DB::table('progetti_lavorazioni')->where('id_progetto', $request->id)->get();
		
		$preventivo = DB::table('quotes')->where('id', $project->id_preventivo)->first();		
		
		
		$ente = DB::table('corporations')->where('id', $preventivo->idente)->first();
		$utente = DB::table('users')->where('id', $preventivo->user_id)->first();
		$responsabile = DB::table('users')->where('name', $ente->responsabilelanga)->first();
		$ente_DA = array();
		if(isset($utente->id_ente)){
			$ente_DA = DB::table('corporations')->where('id', $utente->id_ente)->first();
		}
		$ownerDepartments = DB::table('departments')->where('id', $preventivo->dipartimento)->first();
		$optional_preventivi = DB::table('optional_preventivi')->where('id_preventivo', $preventivo->id)->get();
			
		$pdf = new PDF('utf-8');
		$pdf->mirrorMargins(1);
						
		$header = \View::make('pdf.project_header')->render();		
		$footer = \View::make('pdf.project_footer')->render();
		
		$pdf->SetHTMLHeader($header, 'O');
		$pdf->SetHTMLHeader($header, 'E');
		$pdf->SetHTMLFooter($footer, 'O');
		$pdf->SetHTMLFooter($footer, 'E');
		
		/*$pdf->AddPage('Portrait', margin-left, margin-right, margin-top, margin-bottom, margin-header, margin-footer, 'A4');*/
		$pdf->AddPage('P', 10, 10, 38, 20, 8, 2, 'A4');
		/*return view('pdf.quotation', [
			'preventivo' =>$preventivo,										
			'ente' => $ente,
			'utente' => $utente,
			'ente_DA' => $ente_DA,
			'owner'=>$ownerDepartments,
			'responsabile'=>$responsabile,
			'optional_preventivi'=>$optional_preventivi]);
		exit;*/

		$pdf->loadView('pdf.project', [
			'project'=>$project,
			'progetti_lavorazioni'=>$progetti_lavorazioni,
			'preventivo' =>$preventivo,										
			'ente' => $ente,
			'utente' => $utente,
			'ente_DA' => $ente_DA,
			'owner'=>$ownerDepartments,
			'responsabile'=>$responsabile,
			'optional_preventivi'=>$optional_preventivi]);
		
		$logs = $this->logmainsection.' -> Generate pdf for project Quote ( Quote ID: '. $project->id_preventivo .')';
		storelogs($request->user()->id, $logs);
		
		/*$pdf->download('test.pdf');*/
		$pdf->stream('project_quote.pdf');				
	
	}
	
	public function miei(Request $request)
    {
    	if(!checkpermission($this->module, $this->sub_id, 'lettura')){
    		return redirect('/unauthorized');
    	}

		$buffer = DB::table('buffer')
					->where([
						'id_user' => $request->user()->id,
					])
					->first();
		if($buffer) {
			DB::table('projects')
				->where('id', $buffer->id_progetto)
				->delete();
			DB::table('buffer')
				  ->where('id', $buffer->id)
				  ->delete();
		}
        return view('progetti.main', [
			'miei' => 1
		]);
    }
	
    public function show(Request $request)
    {
        return view('progetti.main');
    }
    
    public function aggiungi(Request $request)
    {
		
    	if(!checkpermission($this->module, $this->sub_id, 'scrittura')){
    		return redirect('/unauthorized');
    	}
    	/*Get the Processing of web */
    	$processing = DB::table('lavorazioni')->where('departments_id', '1')->get();

		$arrwhere['quotes.is_deleted'] = 0;
        $arrwhere['statiemotivipreventivi.id'] = '6';                        
        $quotes = DB::table('quotes')
        ->Join('statipreventivi', 'statipreventivi.id_preventivo', '=', 'quotes.id')
        ->Join('statiemotivipreventivi', 'statiemotivipreventivi.id', '=', 'statipreventivi.id_tipo')            
        ->where($arrwhere)            
        ->select('quotes.*')->get();                

        /*DB::table('quotes')->where('legameprogetto', 1)->get() */
        return view('progetti.aggiungi', [
            'utenti' => DB::table('users')->get(),
            'confirmQuote' => $quotes,
			'statiemotivi' => DB::table('statiemotiviprogetti')->get(),
			'oggettostato' => $processing,
        ]);
    }
    
    public function store(Request $request)
    {
		
        $validator = Validator::make($request->all(), [
            'nomeprogetto' => 'required|max:50',
            'notetecniche' => 'max:1000',
        ]);        
        
        if($validator->fails()) {
            return Redirect::back()
                ->withInput()
                ->with('error_code', 6)
                ->withErrors($validator);
        }

        $progetto = DB::table('projects')->insertGetId([
                        'user_id' => $request->user()->id,
                        'nomeprogetto' => $request->nomeprogetto,
                        'notetecniche' => $request->notetecniche,
                        'noteprivate' => $request->noteprivate,
                        'datainizio' => isset($request->datainizio) ? $request->datainizio : '',
                        'datafine' => isset($request->datafine) ? $request->datafine : '',
                        'progresso' => isset($request->progresso) ? $request->progresso : '0',
						'statoemotivo' => $request->statoemotivo,
						'emotion_stat_id' => isset($request->statoemotivo) ? $request->statoemotivo : 0
                      ]);

        $logs = $this->logmainsection.' -> Add New Project (ID: '. $progetto . ')';
		storelogs($request->user()->id, $logs);

		/* DB::table('projects')->where('id', $project->id)
        ->update(array(
                        'nomeprogetto' => $request->nomeprogetto,
                        'notetecniche' => $request->notetecniche,
                        'noteprivate' => $request->noteprivate,
                        'datainizio' => $request->datainizio,
                        'datafine' => $request->datafine,
                        'progresso' => $request->progresso,
						'statoemotivo' => $request->statoemotivo,
						'emotion_stat_id' => $request->statoemotivo
                      ));*/
		/*if($request->statoemotivo!=null) {
			// Memorizzo lo stato emotivo
			$tipo = DB::table('statiemotiviprogetti')
				->where('name', $request->statoemotivo)
				->first();
			DB::table('statiprogetti')->insert([
				'id_progetto' => $progetto,
				'id_tipo' => $tipo->id,
			]);
		}*/
		
		// Memorizza i file
		if(isset($request->file)) {
			$options = $request->file;
			for($i = 0; $i < count($options); $i++) {
                $nome = time() . uniqid() . '-' . '-progetto';
			    Storage::put(
    				'images/' . $nome,
    				file_get_contents($options[$i]->getRealPath())
			    );

				DB::table('progetti_files')->insert([
					'id_progetto' => $progetto,
					'nome' => $nome,
				]);
			}
		}
		
		// Memorizza i dati sensibili
		if(isset($request->dati)) {
			$options = $request->dati;
			for($i = 0; $i < count($options); $i++) {
				DB::table('progetti_datisensibili')->insert([
					'id_progetto' => $progetto,
					'dettagli' => $options[$i],
				]);
			}
		}
        	
        // Memorizzo le note private
        if(isset($request->nome)) {
			$nome = $request->nome;
			$password = $request->pass;
			$dettagli = $request->dett;			
			for($i = 0; $i < count($nome); $i++) {
				DB::table('progetti_noteprivate')->insert([
					'id_progetto' => $progetto,
					'nome' => isset($nome[$i]) ? $nome[$i] : '',
					'password' =>isset($password[$i])?$password[$i] : '',
					'user' => isset($dettagli[$i]) ? $dettagli[$i] : ''
				]);
			}
		}
       
        // Memorizza i partecipanti al progetto
        if(isset($request->partecipanti)) {
			$options = $request->partecipanti;
			for($i = 0; $i < count($options); $i++) {
				DB::table('progetti_partecipanti')->insert([
					'id_progetto' => $progetto,
					'id_user' => $options[$i],
				]);
			}
		}
       $progessPercentage = 0;
        // Memorizzo le lavorazioni del progetto
          if(isset($request->ric)) {
			$appunti = $request->ric;
			$ricontattare = $request->ricontattare;
			$alle = $request->alle;
			$datainserimento = $request->datainserimento;
			$completato = $request->completato;
			$descrizione = $request->descrizione;
			$completamento = $request->percentvalue;
			$proceesingcode = $request->processing_code;

			for($i = 0; $i < count($appunti); $i++) {
			    // if($completato[$i] == null)
			    //     $completato[$i] = 0;
			    // else
			    //     $completato[$i] = 1;
				$procceingID = DB::table('progetti_lavorazioni')->insertGetId([
					'user_id' => $request->user()->id,
				    'id_progetto' => $progetto,
					'nome' => isset($appunti[$i]) ? $appunti[$i] : "",
					'descrizione' => isset($descrizione[$i]) ? $descrizione[$i] : "",
					'completato' => isset($completato[$i]) ? $completato[$i] : 0,
					'completamento' =>isset($completamento[$i]) ? $completamento[$i] : 0,
				]);
				DB::table('project_processing_comments')->where('code', $proceesingcode[$i])->update(array('processing_id' => $procceingID));
			}
			 $progessDetails = DB::select("select AVG(`progetti_lavorazioni`.`completamento`) as `completedPercentage` from `progetti_lavorazioni`    WHERE `progetti_lavorazioni`.`id_progetto` = $progetto ");
			 $progessPercentage = round($progessDetails[0]->completedPercentage,2);			 
		}
		DB::table('projects')->where('id', $progetto)->update(array('progresso' => $progessPercentage));


		/* Update Project Id in Media files Paras */
			DB::table('media_files')
			->where('code', $request->mediaCode)
			->update(array('master_id' => $progetto));
		/* Update Project Id in Media files */

		return redirect('/progetti/modify/project/' . $progetto)
                        ->with('error_code', 5)
                        ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_project_added_correctly').'</div>');
    }
    
    public function destroy(Request $request, Project $project)
    {
    	if(!checkpermission($this->module, $this->sub_id, 'scrittura')){
    		return redirect('/unauthorized');
    	}

        // $this->authorize('destroy', $project);
			
		DB::table('projects')
			->where('id', $project->id)
			->update(array(
            	'is_deleted' => 1
		));		

		$logs = $this->logmainsection.' -> Delete Project (ID: '. $project->id . ')';
		storelogs($request->user()->id, $logs);

		return Redirect::back()
            ->with('error_code', 5)
            ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_project_deleted_correctly').'</div>');
    }
    
    public function duplicate(Request $request, Project $project)
    {
    	if(!checkpermission($this->module, $this->sub_id, 'scrittura')){
    		return redirect('/unauthorized');
    	}

        // $this->authorize('duplicate', $project);
        
        $pid = DB::table('projects')->insertGetId([
            'user_id' => $request->user()->id,
            'nomeprogetto' => $project->nomeprogetto,
            'notetecniche' => $project->notetecniche,
            'noteprivate' => $project->noteprivate,
            'datainizio' => $project->datainizio,
            'datafine' => $project->datafine,
            'progresso' => $project->progresso
        ]);
		
		$logs = $this->logmainsection.' -> Copy(Duplicate) Project (ID: '. $pid . ')';
		storelogs($request->user()->id, $logs);

		return Redirect::back()
            ->with('error_code', 5)
            ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_project_duplicated_correctly').'</div>');
    }
    
    public function modify(Request $request, Project $project)
    {
    	/*if(!checkpermission($this->module, $this->sub_id, 'scrittura')){
    		return redirect('/unauthorized');
    	}*/

		// $this->authorize('modify', $project);
    	$project = DB::table('projects')->where('id', $project->id)->first();    	
    	$quote = DB::table('quotes')->where('id', $project->id_preventivo)->first();
    	$dipartimento= (isset($quote->dipartimento) && !empty($quote->dipartimento)) ? $quote->dipartimento : '1';
    	$processing = DB::table('lavorazioni')->where('departments_id', $dipartimento)->get();
    	$departments = DB::table('departments')->where('id', $dipartimento)->first();


        return view('progetti.modifica', [
            'progetto' => $project,
            'files' => DB::table('progetti_files')
                        ->where('id_progetto', $project->id)
                        ->get(),
            'projectmediafiles' => DB::table('media_files')
								->select('*')
								->where('master_id', $project->id)->where('master_type','1')
								->get(),								
            'datisensibili' => DB::table('progetti_datisensibili')
                        ->where('id_progetto', $project->id)
                        ->get(),
            'lavorazioni' => DB::table('progetti_lavorazioni')
                        ->where('id_progetto', $project->id)
                        ->get(),
            'partecipanti' => DB::table('progetti_partecipanti')
                                ->where('id_progetto', $project->id)
                                ->get(),
            'utenti' => DB::table('users')
                            ->get(),
            'noteprivate' => DB::table('progetti_noteprivate')
            					->where('id_progetto', $project->id)
            					->get(),
            'departments'=>$departments,
			'oggettostato' => $processing,
			 'chartdetails'=> DB::select("select `lavorazioni`.*, AVG(`progetti_lavorazioni`.`completamento`) as `completedPercentage` from `lavorazioni` left join `progetti_lavorazioni` on `lavorazioni`.`id` = `progetti_lavorazioni`.`completato` AND `progetti_lavorazioni`.`id_progetto` = $project->id WHERE `lavorazioni`.`departments_id`=$dipartimento GROUP BY id ORDER BY completedPercentage DESC"),
			'statiemotivi' => DB::table('statiemotiviprogetti')->get(),			
			'statoemotivoselezionato' => DB::table('statiprogetti')
				->where('id_progetto', $project->id)
				->first(),
        ]);
    }
    
    public function vedifiles(Request $request, Project $project)
    {
		$files = DB::table('progetti_files')
						->where([
							'id_progetto' => $project->id,
						])
    					->get();
		$files_return = array();
		foreach($files as $f) {
			if($f->dipartimento == $request->user()->dipartimento || $f->dipartimento == '-')
				$files_return[] = $f;	
		}
    	return view('progetti.files', [
    		'progetto' => $project,
    		'files' => $files_return
    	]);
    }
    
    public function eliminafile(Request $request)
    {
    	DB::table('progetti_files')
    		->where('id', $request->project)
    		->delete();
    	
    	return Redirect::back()
                        ->with('error_code', 5)
                        ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>File eliminato correttamente!</h4></div>');
    }
    
    public function update(Request $request, Project $project)
    {
    	if(!checkpermission($this->module, $this->sub_id, 'scrittura')){
    		return redirect('/unauthorized');
    	}

		// $this->authorize('modify', $project);
		
        $validator = Validator::make($request->all(), [
            'nomeprogetto' => 'required|max:50',
            'notetecniche' => 'max:1000',
        ]);
        
        
        if($validator->fails()) {
            return Redirect::back()
                ->withInput()
                ->with('error_code', 6)
                ->withErrors($validator);
        }
		
		DB::table('buffer')
				->where('id_progetto', $project->id)
				->delete();
		
        DB::table('projects')->where('id', $project->id)
        ->update(array(
                        'nomeprogetto' => $request->nomeprogetto,
                        'notetecniche' => $request->notetecniche,
                        'noteprivate' => $request->noteprivate,
                        'datainizio' => $request->datainizio,
                        'datafine' => $request->datafine,
                        'progresso' => $request->progresso,
						'statoemotivo' => $request->statoemotivo,
						'emotion_stat_id' => $request->statoemotivo
                      ));

        $logs = $this->logmainsection.' -> Update Project (ID: '. $project->id . ')';
		storelogs($request->user()->id, $logs);
		
		/*if($request->statoemotivo!=null) {
			// Aggiorno lo stato emotivo
			$tipo = DB::table('statiemotiviprogetti')
				->where('name', $request->statoemotivo)
				->first();
			DB::table('statiprogetti')
				->where('id_progetto', $project->id)
				->delete();
			DB::table('statiprogetti')
				->insert([
					'id_tipo' => $tipo->id,
					'id_progetto' => $project->id
				]);
		}*/
		
		// Salvo i file del preventivo, se è stato creato da un preventivo
		if(isset($request->salvafiles)) {
			$options = $request->salvafiles;
  
	    	DB::table('progetti_files')
				->where('id_preventivo', $options)
				->update(array(
					'id_progetto' => $project->id,
					'id_preventivo' => null
				));    
		}
		
		if(isset($request->dapreventivo)) {
			DB::table('quotes')
				->where('id', $request->dapreventivo)
				->update(array(
					'usato' => 1
				));
		}
		 
		
		// Aggiorno i file
		$options = $request->file;
			for($i = 0; $i < count($options); $i++) {
    			if(file_exists($options[$i])) {
                    $nome = time() . uniqid() . '-' . '-progetto';
    			    Storage::put(
	        			'images/' . $nome,
	        			file_get_contents($options[$i]->getRealPath())
    			    );
    			    	
	    
	    			DB::table('progetti_files')->insert([
	    				'id_progetto' => $project->id,
	    				'nome' => $nome,
	    			]);
			    }
		}
		

		// Memorizza le note private
		if(isset($request->nome)) {				
			$note = $request->nome;
			$password = $request->pass;
			$dettagli = $request->dett;
			$scadenza = $request->scad;
			DB::table('progetti_noteprivate')
			    ->where('id_progetto', $project->id)
			    ->delete();
			
			for($i = 0; $i < count($note); $i++) {
				DB::table('progetti_noteprivate')->insert([
					'id_progetto' => $project->id,
					'nome' => isset($note[$i]) ? $note[$i] : '',
					'password' => isset($password[$i]) ? $password[$i] : '',
					'user' => isset($dettagli[$i]) ? $dettagli[$i] : ''
					/*'scadenza' => $scadenza[$i]*/
				]);
			}
		} else {
		    DB::table('progetti_noteprivate')
			    ->where('id_progetto', $project->id)
			    ->delete();
		}
		
		// Memorizza i dati sensibili
		if(isset($request->dati)) {
			$options = $request->dati;
			
			DB::table('progetti_datisensibili')
			    ->where('id_progetto', $project->id)
			    ->delete();
			
			for($i = 0; $i < count($options); $i++) {
				DB::table('progetti_datisensibili')->insert([
					'id_progetto' => $project->id,
					'dettagli' => $options[$i],
				]);
			}
		} else {
		    DB::table('progetti_datisensibili')
			    ->where('id_progetto', $project->id)
			    ->delete();
		}
        
        // Memorizza i partecipanti al progetto
        if(isset($request->partecipanti)) {
			$options = $request->partecipanti;
			DB::table('progetti_partecipanti')
			    ->where('id_progetto', $project->id)
			    ->delete();
			for($i = 0; $i < count($options); $i++) {
				DB::table('progetti_partecipanti')->insert([
					'id_progetto' => $project->id,
					'id_user' => $options[$i],
				]);
			}
		} else {
		    DB::table('progetti_partecipanti')
			    ->where('id_progetto', $project->id)
			    ->delete();
		}
        
        // Memorizzo le lavorazioni del progetto (Processing Of Projects)
        if(isset($request->ric)) {
			$appunti = $request->ric;
			$ricontattare = $request->ricontattare;
			$alle = $request->alle;
			$descrizione = $request->descrizione;
			$datainserimento = $request->datainserimento;
			$completato = $request->completato;
			$completamento = $request->percentvalue;
			$proceesingcode = $request->processing_code;			

			DB::table('progetti_lavorazioni')->where('id_progetto', $project->id)->delete();
			for($i = 0; $i < count($appunti); $i++) {
			$procceingID = DB::table('progetti_lavorazioni')->insertGetId([
					'user_id' => $request->user()->id,
				    'id_progetto' => $project->id,
					'nome' => isset($appunti[$i]) ? $appunti[$i] : '',					
					'descrizione' => isset($descrizione[$i]) ? $descrizione[$i] : "",
					'completato' => isset($completato[$i]) ? $completato[$i] : 0,
					'completamento' =>isset($completamento[$i]) ? $completamento[$i] : 0,
				]);
				$arrwhereprocoment = array('code'=>$proceesingcode[$i]);
				DB::table('project_processing_comments')->where($arrwhereprocoment)->update(array('processing_id' => $procceingID));
			}
			$progessDetails = DB::select("select AVG(`progetti_lavorazioni`.`completamento`) as `completedPercentage` from `progetti_lavorazioni`    WHERE `progetti_lavorazioni`.`id_progetto` = $project->id ");
			 $progessPercentage = round($progessDetails[0]->completedPercentage,2);			 
		} else {
		    DB::table('progetti_lavorazioni')
			    ->where('id_progetto', $project->id)
			    ->delete();
			$progessPercentage = 0;
		}
		DB::table('projects')->where('id', $project->id)->update(array('progresso' => $progessPercentage));

		/* Update Project Id in Media files Paras */
			DB::table('media_files')
			->where('code', $request->mediaCode)
			->update(array('master_id' => $project->id));
		/* Update Project Id in Media files */

		return redirect("/progetti/modify/project/$project->id")
                        ->with('error_code', 5)
                        ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_project_edited_correctly').'</div>');
    }
    
    public function creadapreventivo(Request $request)
    {
    	//check project exit for this quote
    	$project = DB::table('projects')->where('id_preventivo', $request->id)->first();    	
    	$quote = DB::table('quotes')->where('id', $request->id)->first();
    	$dipartimento= (isset($quote->dipartimento) && !empty($quote->dipartimento)) ? $quote->dipartimento : '1';
		$processing = DB::table('lavorazioni')->where('departments_id', $dipartimento)->get();
		$departments = DB::table('departments')->where('id', $dipartimento)->first();
		
		if(count($project) > 0){    				
			$nuovoprogetto = $project->id;
		}
    	else {
		$nomecliente = DB::table('corporations')->where('id', $quote->idente)->first()->nomeazienda;
        $nuovoprogetto = DB::table('projects')->insertGetId([
			'user_id'=>$request->user()->id,
            'nomeprogetto' => $quote->oggetto . '_' . $nomecliente,
            'id_ente' => $quote->idente,
            'id_preventivo' => $quote->id,
            'notetecniche' => $quote->notetecniche,
            'noteprivate' => $quote->noteimportanti,
            'datainizio'=>date('d/m/Y'),
            'datafine' => $quote->finelavori,
            'progresso' => 10
        ]);
    	$project = DB::table('projects')->where('id', $nuovoprogetto)->first();    	    	
    	
    	/* Optional section from Quote to project processing */
		$quoteOptional = DB::table('optional_preventivi')->where('id_preventivo', $quote->id)->get();
		foreach($quoteOptional AS $keyqopt => $valqopt){
				$procceingID = DB::table('progetti_lavorazioni')->insertGetId([
					'user_id' => $request->user()->id,
				    'id_progetto' => $project->id,
					'nome' => isset($valqopt->oggetto) ? $valqopt->oggetto : '',					
					'descrizione' => isset($valqopt->descrizione) ? $valqopt->descrizione : "",
					'completato' => 0,
					'completamento' =>0,
				]);
			}
		
		/* Medai files from project to qoute */
		$medifilesQuote = DB::table('media_files')->where(['master_id'=>$quote->id,'master_type'=>'0'])->get();
		foreach ($medifilesQuote as $keymq => $valuemq) {
			$mediafileid = DB::table('media_files')->insertGetId([
					'name' => 'pro'.$valuemq->name,
				    'master_id' => $project->id,
					'type' => $request->user()->dipartimento,					
					'master_type' => 1,
					'title' => $valuemq->title,
					'description' =>$valuemq->description,
					'created_at'=>time()
				]);
			if(file_exists('storage/app/images/quote/'.$valuemq->name)){			
				copy('storage/app/images/quote/'.$valuemq->name, 'storage/app/images/projects/pro'.$valuemq->name);
			}
		}
		/* User added as participant */	
		DB::table('progetti_partecipanti')
			->insert([
				'id_progetto' => $nuovoprogetto,
				'id_user' => $request->user()->id
			]);

		// Buffer per tenere il progetto in memoria (DB) fino a quando non l'ho salvato,
		// Se uno non salva ed esce esso verrà eliminato al prossimo login
		DB::table('buffer')->insert(['id_user' => $request->user()->id,'id_progetto' => $nuovoprogetto]);

		}		
        
        return view('progetti.modifica', [
        	'progetto' => DB::table('projects')->where('id', $nuovoprogetto)->first(),
            'utenti' => DB::table('users')->get(),
            'files' => DB::table('progetti_files')->where('id_preventivo', $quote->id)->get(),
            'projectmediafiles' => DB::table('media_files')->select('*')->where('master_id', $nuovoprogetto)->where('master_type','1')->get(),		
            'datisensibili' => DB::table('progetti_datisensibili')->where('id_progetto', $nuovoprogetto)->get(),
            'lavorazioni' => DB::table('progetti_lavorazioni')->where('id_progetto', $nuovoprogetto)->get(),
            'partecipanti' => DB::table('progetti_partecipanti')->where('id_progetto', $nuovoprogetto)->get(),
            'noteprivate' => DB::table('progetti_noteprivate')->where('id_progetto', $nuovoprogetto)->get(),
			'dapreventivo' => 1,
			'idpreventivo' => $request->id,
			'departments'=>$departments,
			'oggettostato' => $processing,
			'chartdetails'=> DB::select("select `lavorazioni`.*, AVG(`progetti_lavorazioni`.`completamento`) as `completedPercentage` from `lavorazioni` left join `progetti_lavorazioni` on `lavorazioni`.`id` = `progetti_lavorazioni`.`completato` AND `progetti_lavorazioni`.`id_progetto` = $project->id WHERE `lavorazioni`.`departments_id`=$dipartimento GROUP BY id"),
			'statiemotivi' => DB::table('statiemotiviprogetti')->get(),			
			'statoemotivoselezionato' => DB::table('statiprogetti')
				->where('id_progetto', $project->id)
				->first(),
        ]);         
    }

    public function getprocessingcomment(Request $request) {
    	/*$where = (isset($request->id) && $request->id != '0') ? array('processing_id'=> $request->id) : array('code'=> $request->code); */
    	$where = array('code'=> $request->code); 
    	$orwhere = (isset($request->id) && $request->id != '0') ? array('processing_id'=> $request->id) : array();

    	return view('progetti.processingComments', [
        	'comments' => DB::table('project_processing_comments')->where($where)->orWhere($orwhere)->get()])->render();         
    }
    public function addprocessingcomment(Request $request){
    	if ($request->user()->id  != 0 && $request->user()->dipartimento != 0) {
            return redirect('/unauthorized');
        } 
        else {                	
			$validator = Validator::make($request->all(), ['frontlogo'=>'max:1000']);
			if ($validator->fails()) {
            	 echo 'fail'; 
            	 exit;
        	}        	        	
        	DB::table('project_processing_comments')->insert([
				'processing_id' => $request->processingid,
				'comments' => $request->comments,
				'code'=>$request->hdCode,				
				'date'=> date('Y-m-d')]);
			echo 'success';
			exit;
        }
    }

     public function deleteprocessingcomment(Request $request) {
     	if(isset($request->commentid)){
    		$response = DB::table('project_processing_comments')->where('id', $request->commentid)->delete();
    	}
    	echo (isset($response)) ? 'true' : 'false';
    	exit;
    }
}
