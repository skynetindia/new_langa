<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Repositories\QuoteRepository;
use App\Repositories\CorporationRepository;
use Validator;
use Redirect;
use App\Quote;
use DB;
use Storage;
use Auth;
use App\Classes\PdfWrapper as PDF;
use App\PDF\QuotationPDF;
use App\PDF\QuotationPDFNoPrezzi;


class QuoteController extends Controller
{
	protected $quotes;
	protected $corporations;
	protected $logmainsection;

	protected $module;
	protected $sub_id;
	
	public function __construct(QuoteRepository $quotes, CorporationRepository $corporations)
	{
		$this->middleware('auth');
		$this->quotes = $quotes;		
		$this->corporations = $corporations;
		$this->logmainsection = 'Quotes';

		$request = parse_url($_SERVER['REQUEST_URI']);
		$path = ($_SERVER['HTTP_HOST'] == 'localhost') ? rtrim(str_replace('/easylangaw/', '', $request["path"]), '/') : $request["path"];		
		$result = rtrim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $path), '/');
		$current_module = DB::select('select * from modulo where TRIM(BOTH "/" FROM modulo_link) = :link', ['link' => $result]);
    	
        $this->module = (isset($current_module[0]->modulo_sub)) ? $current_module[0]->modulo_sub : 3;
        $this->sub_id = (isset($current_module[0]->id)) ? $current_module[0]->id : 16;
	}
	
	public function filequote(Request $request) {
		return view('estimates.files', [
			'files' => DB::table('progetti_files')
				->where([
					'id_preventivo' => $request->id,
					'dipartimento' => $request->user()->dipartimento
				])
				->get(),
			'oggetto' => DB::table('quotes')
				->where('id', $request->id)
				->first()->oggetto
		]);
	}
	
	public function completeListCode(&$preventivi)
	{
		$statiemotivi = DB::table('statiemotivipreventivi')->get();
		
		foreach($preventivi as $prev) {
			$id = $prev->id;
			$yearid=(isset($prev->anno) && $prev->anno!=0)?$prev->anno:date('y');
			$prev->id = ':' . $prev->id . '/' .$yearid ;
		
			$prev->data = str_replace('/', '-', $prev->data);
			$prev->valenza = str_replace('/', '-', $prev->valenza);
			$prev->data = dateFormate($prev->data,'d/m/Y');
			$prev->valenza = dateFormate($prev->valenza,'d/m/Y');			
			
			$prev->ente = DB::table('corporations')
				->where('id', $prev->idente)
				->first()->nomeazienda;
			$departmentsP = DB::table('departments')
				->where('id', $prev->dipartimento )
				->first();
			$prev->dipartimento = isset($departmentsP->nomedipartimento) ? $departmentsP->nomedipartimento :"";
			
			$Querytype = DB::table('ruolo_utente')->where('ruolo_id', Auth::user()->dipartimento)->first();
        	$type = isset($Querytype->nome_ruolo) ? $Querytype->nome_ruolo : "";
        	/*$arrwhere = ($type === 'Client') ? array('is_deleted'=>0,'is_published'=>1) : array('is_deleted'=>0);*/

        	$checked = ($prev->is_published==1) ? 'checked' : '';
        	$prev->publishstatus = '<div class="switch"><input name="status" readonly="readonly" disabled="disabled"  id="activestatus_'.$id.'" '.$checked.' on value="1"  type="checkbox"><label for="activestatus_'.$id.'"></label></div>';

        	if(Auth::user()->id == '0' || (Auth::user()->dipartimento == 0) || $prev->user_id == Auth::user()->id){				
        		$prev->publishstatus = '<div class="switch"><input name="status" onchange="updateStaus('.$id.')" id="activestatus_'.$id.'" '.$checked.' on value="1"  type="checkbox"><label for="activestatus_'.$id.'"></label></div>';
        	}

			$statoselezionato = DB::table('statipreventivi')->where('id_preventivo', $id)->first();
			foreach($statiemotivi as $stat) {
				if($statoselezionato != null){
					if($statoselezionato->id_tipo == $stat->id) {
						if(isset($stat->language_key)){
							$stat->name = (!empty($stat->language_key)) ? trans('messages.'.$stat->language_key) : $stat->name;
						}
						if(isset($stat->color)){
							//$prev->statoemotivo = $stat->name;						
							$prev->statoemotivo = '<span style="color:'.$stat->color.'">'.$stat->name.'</span>';
						}
						break;
					}
					//$statiemotivitipi = DB::table('statiemotivitipi')->where('name',$prev->statoemotivo)->orderBy('id', 'asc')->get();
					/*if(isset($stat->color)){
						$prev->statoemotivo = '<span style="color:'.$stat->color.'">'.$prev->statoemotivo.'</span>';
					}*/
				}
			}
		}
	}

	public function updatepublishstatus(Request $request) {				
		$update = DB::table('quotes')->where('id', $request->id)->update(array('is_published' => $request->status));
		return ($update) ? 'true' : 'false';		
	}

	public function fileupload(Request $request){		
			Storage::put(
					'images/quote/' . $request->file('file')->getClientOriginalName(), file_get_contents($request->file('file')->getRealPath())
			);
			$nome = $request->file('file')->getClientOriginalName();	
				DB::table('media_files')->insert([
				'name' => $nome,
				'code' => $request->code,
				'master_type' => 0,
				'type'=>$request->user()->dipartimento,
				'master_id' => isset($request->idpreventivo) ? $request->idpreventivo : 0,
				'date_time'=>time()
			]);					
	}
		
	public function fileget(Request $request){	
		DB::enableQueryLog();
		if(isset($request->quote_id)){
			//$updateData = DB::table('media_files')->where('quote_id',$request->quote_id)->get();									
			$query = "SELECT * FROM media_files WHERE master_id=$request->quote_id and master_type='0'";
		
			$userprofileid = $request->user()->dipartimento;
	 		$Querytype = DB::table('ruolo_utente')->where('ruolo_id', $userprofileid)->first();
	        $type = isset($Querytype->nome_ruolo) ? $Querytype->nome_ruolo : "";
                
			if(isset($request->term) && $request->term != ""){
				$where = ($request->user()->id === 0 || $type === 'SupperAdmin') ? "" : " AND find_in_set('$userprofileid',type) <> 0";
				$query = "SELECT * FROM media_files WHERE master_id=$request->quote_id and master_type='0' $where  AND (title LIKE '%$request->term%' OR  description LIKE '%$request->term%')";
			}			
			$updateData = DB::select($query);
		}
		else {
			$query = "SELECT * FROM media_files WHERE code=$request->code";		
			$updateData = DB::select($query);
			/*DB::table('media_files')->where('code',$request->code)->get();*/				
		}		
		
		foreach($updateData as $prev) {
			$imagPath = url('/storage/app/images/quote/'.$prev->name);
			$downloadlink = url('/storage/app/images/quote/'.$prev->name);
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
			$html = '<tr class="quoteFile_'.$prev->id.'"><td><img src="'.$imagPath.'" height="100" width="100"><a href="'.$downloadlink.'" class="btn btn-info pull-right"  download><i class="fa fa-download"></i></a><a class="btn btn-danger pull-right" style="text-decoration: none; color:#fff" onclick="deleteQuoteFile('.$prev->id.')"><i class="fa fa-trash"></i></a>'.$titleDescriptions.'</td></tr>';

			$html .='<tr class="quoteFile_'.$prev->id.'"><td>';
			$utente_file = DB::table('ruolo_utente')->select('*')->where('is_delete', 0)->where('nome_ruolo','!=','SupperAdmin')->get();							
			foreach($utente_file as $key => $val){
				if($request->user()->dipartimento == $val->ruolo_id){
					$response = DB::table('media_files')->where('id', $prev->id)->update(array('type' => $val->ruolo_id));	    
					$specailcharcters = array("'", "`");
                    $rolname = str_replace($specailcharcters, "", $val->nome_ruolo);
                    $html .=' <div class="cust-checkbox"><input type="checkbox" checked="checked" name="rdUtente_'.$prev->id.'" id="'.trim($rolname).'_'.$prev->id.'" onchange="updateType('.$val->ruolo_id.','.$prev->id.',this.id);"  value="'.$val->ruolo_id.'" /><label for="'.trim($rolname).'_'.$prev->id.'"> '.wordformate($val->nome_ruolo).'</label><div class="check"><div class="inside"></div></div></div>';
				}
				else {
					$check = '';
					$array = explode(',', $prev->type);
                    if(in_array($val->ruolo_id,$array)){                    
                        $check = 'checked';
                    }
					$specailcharcters = array("'", "`");
                    $rolname = str_replace($specailcharcters, "", $val->nome_ruolo);
                    $html .=' <div class="cust-checkbox"><input type="checkbox" name="rdUtente_'.$prev->id.'" '.$check.' id="'.trim($rolname).'_'.$prev->id.'" onchange="updateType('.$val->ruolo_id.','.$prev->id.',this.id);"  value="'.$val->ruolo_id.'" /><label for="'.trim($rolname).'_'.$prev->id.'"> '.wordformate($val->nome_ruolo).'</label><div class="check"><div class="inside"></div></div></div>';
				}
			}
			echo $html .='</td></tr>';
		}
		exit;			
	}
		
	public function filedelete(Request $request){		
	    $response = DB::table('media_files')->where('id', $request->id)->delete();
	    echo ($response) ? 'success' :'fail';   				
		exit;
	}
	
	public function filetypeupdate(Request $request){		 
		$request->ids = isset($request->ids) ? implode(",",$request->ids) : "";
		$response = DB::table('media_files')->where('id', $request->fileid)->update(array('type' => $request->ids));	    
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
	public function confirmQuote(Request $request){		 				
		$response = DB::table('quotes')->where('id', $request->id)->update(array('signature' => $request->signature));	    
		// Get confirm state id
		$tipo = DB::table('statiemotivipreventivi')->where('id', '6')->first();
		DB::table('statipreventivi')->where('id_preventivo', $request->id)->delete();
		DB::table('statipreventivi')->insert([
				'id_tipo' => $tipo->id,
				'id_preventivo' => $request->id,
				'created_at'=>date('Y-m-d H:i:s')
			]);
	
		if($response) {
			$this->createquoteinvoice($request->id);
		}
		echo ($response) ? 'success' :'fail';   				
		exit;
	}
	
	
	public function getJsonMyestimates(Request $request)
	{DB::enableQueryLog();
		$particpantid=check_participant();
		if(($request->user()->id == 0) || ($request->user()->dipartimento == 0)) {
			$preventivi = DB::table('quotes')
			->where('is_deleted', 0)
			->orderBy('id', 'desc')			
			->get();
			$this->completeListCode($preventivi);
			return json_encode($preventivi);
		}
		else {
			$Querytype = DB::table('ruolo_utente')->where('ruolo_id', Auth::user()->dipartimento)->first();
        	$type = isset($Querytype->nome_ruolo) ? $Querytype->nome_ruolo : "";
        	$arrwhere = ($type === 'Client' || Auth::user()->dipartimento == '16' || Auth::user()->dipartimento == '13') ? array('is_deleted'=>0,'is_published'=>1) : array('is_deleted'=>0); 

			$preventivi = DB::table('quotes')->where($arrwhere)->orderBy('id', 'desc')->get();
			
			$id = $request->user()->id;
			foreach($preventivi as $prev) {
				if($prev->user_id == $id || $prev->idutente == $id ||in_array($prev->idente,$particpantid))
				   $to_return[] = $prev;				   
			}
			$this->completeListCode($to_return);
			return json_encode($to_return);
		}
	}

	public function getpendingquote(Request $request)
	{

		$particpantid=check_participant();
		$userid = $request->user()->id;
		if(($request->user()->id == 0) || ($request->user()->dipartimento == 0) || $request->type == 'all') {
			$arrwhere['quotes.is_deleted'] = 0;
            $arrwhere['statiemotivipreventivi.id'] = '9'; /* Pending Quotes */                        
            $preventivi = DB::table('quotes')
            ->Join('statipreventivi', 'statipreventivi.id_preventivo', '=', 'quotes.id')
            ->Join('statiemotivipreventivi', 'statiemotivipreventivi.id', '=', 'statipreventivi.id_tipo')
            ->leftJoin('users', 'users.id', '=', 'quotes.user_id')
            ->where($arrwhere)
            ->where(function ($query) use ($userid)  {                
                $query->where('quotes.user_id', $userid)
                      ->orWhere('quotes.idutente', $userid);
            })
            ->select('users.color as color','users.name','quotes.*')->orderBy('quotes.id', 'desc')->get();                
			$this->completeListCode($preventivi);
			return json_encode($preventivi);
		}
		else {
			$Querytype = DB::table('ruolo_utente')->where('ruolo_id', Auth::user()->dipartimento)->first();
        	$type = isset($Querytype->nome_ruolo) ? $Querytype->nome_ruolo : "";
        	$arrwhere = ($type === 'Client' || Auth::user()->dipartimento == '13' || Auth::user()->dipartimento == '16') ? array('is_deleted'=>0,'is_published'=>1) : array('is_deleted'=>0); 

			$arrwhere['quotes.is_deleted'] = 0;
            $arrwhere['statiemotivipreventivi.id'] = '9'; /* Pending Quotes */                      
            $preventivi = DB::table('quotes')
            ->Join('statipreventivi', 'statipreventivi.id_preventivo', '=', 'quotes.id')
            ->Join('statiemotivipreventivi', 'statiemotivipreventivi.id', '=', 'statipreventivi.id_tipo')
            ->leftJoin('users', 'users.id', '=', 'quotes.user_id')
            ->where($arrwhere)
            ->where(function ($query) use ($userid)  {                
                $query->where('quotes.user_id', $userid)
                      ->orWhere('quotes.idutente', $userid);
            })
            ->select('users.color as color','users.name','quotes.*')->orderBy('quotes.id', 'desc')->get();                

			$id = $request->user()->id;
			foreach($preventivi as $prev) {
				if($prev->user_id == $id || $prev->idutente == $id ||in_array($prev->idente,$particpantid))
				   $to_return[] = $prev;				   
			}
			$this->completeListCode($to_return);
			return json_encode($to_return);
		}
	}

	
	public function getconfirmedquote(Request $request) {
		$particpantid=check_participant();
		$userid = $request->user()->id;
		if(($request->user()->id == 0) || ($request->user()->dipartimento == 0) || $request->type == 'all') {
			$arrwhere['quotes.is_deleted'] = 0;
            $arrwhere['statiemotivipreventivi.id'] = '6'; /* Pending Quotes */                        
            $preventivi = DB::table('quotes')
            ->Join('statipreventivi', 'statipreventivi.id_preventivo', '=', 'quotes.id')
            ->Join('statiemotivipreventivi', 'statiemotivipreventivi.id', '=', 'statipreventivi.id_tipo')
            ->leftJoin('users', 'users.id', '=', 'quotes.user_id')
            ->where($arrwhere)
            ->where(function ($query) use ($userid)  {                
                $query->where('quotes.user_id', $userid)
                      ->orWhere('quotes.idutente', $userid);
            })
            ->select('users.color as color','users.name','quotes.*')->orderBy('quotes.id', 'desc')->get();                

			$this->completeListCode($preventivi);
			return json_encode($preventivi);
		}
		else {
			$Querytype = DB::table('ruolo_utente')->where('ruolo_id', Auth::user()->dipartimento)->first();
        	$type = isset($Querytype->nome_ruolo) ? $Querytype->nome_ruolo : "";
        	$arrwhere = ($type === 'Client' || Auth::user()->dipartimento == '16' || Auth::user()->dipartimento == '13') ? array('is_deleted'=>0,'is_published'=>1) : array('is_deleted'=>0); 

			$arrwhere['quotes.is_deleted'] = 0;
            $arrwhere['statiemotivipreventivi.id'] = '6'; /* Pending Quotes */                      
            $preventivi = DB::table('quotes')
            ->Join('statipreventivi', 'statipreventivi.id_preventivo', '=', 'quotes.id')
            ->Join('statiemotivipreventivi', 'statiemotivipreventivi.id', '=', 'statipreventivi.id_tipo')
            ->leftJoin('users', 'users.id', '=', 'quotes.user_id')
            ->where($arrwhere)
            ->where(function ($query) use ($userid)  {                
                $query->where('quotes.user_id', $userid)
                      ->orWhere('quotes.idutente', $userid);
            })
            ->select('users.color as color','users.name','quotes.*')->orderBy('quotes.id', 'desc')->get();                

			$id = $request->user()->id;
			foreach($preventivi as $prev) {
				if($prev->user_id == $id || $prev->idutente == $id ||in_array($prev->idente,$particpantid))
				   $to_return[] = $prev;				   
			}
			$this->completeListCode($to_return);
			return json_encode($to_return);
		}
	}
	
	
	public function getjson(Request $request)
	{
		$preventivi = DB::table('quotes')
			->where('is_deleted', 0)->orderBy('id', 'desc')
			->get();
		$this->completeListCode($preventivi);
		return json_encode($preventivi);
	}
	
	// Calls the show method
	public function index(Request $request)
	{
		if(!checkpermission($this->module, $this->sub_id, 'lettura')){
    		return redirect('/unauthorized');
    	}

		return $this->show($request);
	}
	
	public function myestimates(Request $request)
	{
		//is_array(check_participant());
		if(!checkpermission($this->module, $this->sub_id, 'lettura')){
    		return redirect('/unauthorized');
    	}

		return view('estimates.main', [
			'miei' => 1
		]);
	}
	
	// Render the estimates views
	public function show(Request $request)
	{
		return view('estimates.main');
	}
	
	public function newEstimates(Request $request)
	{
		return $this->add($request);
	}
	
	// Mostra la pagina per aggiungere un nuovo preventivo
	public function add(Request $request)
	{
		if(!checkpermission($this->module, $this->sub_id, 'scrittura')){
    		return redirect('/unauthorized');
    	}

		return view('estimates.add', [
			'utenti' => DB::table('users')->select('*')->get(),
			'enti' => $this->corporations->forUser2($request->user()),
			'dipartimenti' => DB::table('departments')->select('*')->get(),
			'optional' => DB::table('optional')->select('*')->get(),
			'pacchetti' => DB::table('pack')->select('*')->get(),
			'optional_pack' => DB::table('optional_pack')->select('*')->get(),
			'frequency'=>DB::table('frequenze')->get(),
			'statiemotivi' => DB::table('statiemotivipreventivi')->get()
		]);
	}
	


// Salvo il preventivo nel DB
	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'data' => 'required',
			'oggetto' => 'required|max:150',
			'dipartimento' => 'required',
			'idente'=>'required',
			'considerazioni' => 'required|max:2000',
			'valenza' => 'required',
			'finelavori' => 'required'
		]);
		
		if($validator->fails()) {
			return Redirect::back()
				->withInput()
				->withErrors($validator);
		}
		
			// Controllo lo sconto e lo sconto bonus
			$scontoagente = $request->scontoagente;
			$scontobonus = $request->scontobonus;
			$scontibonus = [];
			// Seleziono l'ente relativo alla utenza in uso
			$ente = DB::table('corporations')
						->where('id', $request->user()->id_ente)
						->first();
	
			$elenco = DB::table('corporationtypes')
						->where('id_ente', $ente->id)
						->get();
			// Variabile per contenere gli sconto assegnati a quell'ente
			$sconti = [];
			// Per tutti i tipi assegnati a quell'ente
			for($i = 0; $i < count($elenco); $i++) {
				$sc = DB::table('entisconti')
							->where('id_sconto', $elenco[$i]->id_tipo)
							->first();
				if($sc)
				$sconto = DB::table('sconti')
							->where('id', $sc->id_sconto)
							->first();
				if(isset($sconto))
				$sconti[] = $sconto->sconto;
			}
			$max = 0;
			for($i = 0; $i < count($sconti); $i++) {
				if($max < $sconti[$i])
					$max = $sconti[$i];
			}
			$scontoagente_max = $max;
			// Sconto bonus
			$elenco = DB::table('entiscontibonus')
						->where('id_tipo', $request->user()->id)
						->get();
			$sconti = [];
			for($i = 0; $i < count($elenco); $i++) {
				$sconto = DB::table('scontibonus')
							->where('id', $elenco[$i]->id_sconto)
							->first();
				if($sconto)
				$scontibonus[] = $sconto->sconto;
			}
			$max = 0;
			for($i = 0; $i < count($scontibonus); $i++) {
				if($max < $scontibonus[$i])
					$max = $scontibonus[$i];
			}
			$scontobonus_max = $max;

			if($scontoagente > $scontoagente_max) {
				return Redirect::back()
					->withInput()
					->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.	keyword_major_agent_discount_estimate_validation').' '.$scontoagente_max . '</div>');
			} else if($scontobonus > $scontobonus_max) {
				return Redirect::back()
					->withInput()
					->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.	keyword_major_agent_discount_estimate_validation') .' ' .$scontobonus_max . '</div>');	
			}
		
			// $nuovopreventivo = $request->user()->quotes()->create([
			$nuovopreventivo = DB::table('quotes')->insertGetId([
				'anno' => date('y'),
				'idutente' => $request->user()->id,
				'idente' => $request->idente,
				'data' => $request->data,
				'oggetto' => $request->oggetto,
				'dipartimento' => $request->dipartimento,
				'considerazioni' => $request->considerazioni,
				'noteimportanti' => isset($request->noteimportanti) ? $request->noteimportanti : '',
				'valenza' => $request->valenza,
				'finelavori' => $request->finelavori,
				'id_notifica' => 0,
				'subtotale' => isset($request->subtotale) ? $request->subtotale : 0,
				'scontoagente' => isset($request->scontoagente) ? $request->scontoagente : 0,
				'scontobonus'=> isset($request->scontobonus) ? $request->scontobonus : 0, 
				'totale' => isset($request->totale) ? $request->totale : 0,
				'totaledapagare'  => isset($request->totaledapagare) ? $request->totaledapagare : 0,
				'legameprogetto' => isset($request->legameprogetto) ? $request->legameprogetto : 0,
			]);
			
			DB::table('media_files')
				->where('code', $request->mediaCode)
				->update(array('master_id' => $nuovopreventivo));

			$logs = $this->logmainsection.' -> Add New Quote (ID: '. $nuovopreventivo . ')';
			storelogs($request->user()->id, $logs);

			if($request->statoemotivo!=null) {
				// Memorizzo lo stato emotivo
				/*$tipo = DB::table('statiemotivipreventivi')
					->where('name', $request->statoemotivo)
					->first();*/
				DB::table('statipreventivi')->insert([
					'id_preventivo' => $nuovopreventivo,
					'id_tipo' => $request->statoemotivo,
					'created_at'=>date('Y-m-d H:i:s')
				]);
			}
				
			if(isset($request->filetecnico)) {
				$options = $request->filetecnico;
				for($i = 0; $i < count($options); $i++) {
					$nome = time() . uniqid() . '-' . '-preventivo';
					Storage::put(
						'images/' . $nome,
						file_get_contents($options[$i]->getRealPath())
					);

					DB::table('progetti_files')->insert([
						'id_preventivo' => $nuovopreventivo,
						'nome' => $nome,
						'dipartimento' => "TECNICO"
					]);
				}
			}
		
			if(isset($request->filee)) {
				$optionss = $request->filee;
				for($i = 0; $i < count($optionss); $i++) {
					$nome = time() . uniqid() . '-' . '-scansione_preventivo';
					Storage::put(
						'images/' . $nome,
						file_get_contents($optionss[$i]->getRealPath())
					);

					DB::table('progetti_files')->insert([
						'id_preventivo' => $nuovopreventivo,
						'nome' => $nome,
						'dipartimento' => "AMMINISTRAZIONE"
					]);
				}
			}
			
			if(isset($request->datapay)) {
				$datapay = $request->datapay;
				$amountper = $request->amountper;
				$importo = $request->importo;
				for($i = 0; $i < count($datapay); $i++) {
					if(isset($amountper[$i]) && $amountper[$i] != "" && isset($datapay[$i]) && $datapay[$i] != ""){
						DB::table('quote_paymento')->insert([
							'qp_quote_id' => $nuovopreventivo,
							'qp_data' => date('Y-m-d',strtotime(str_replace('/','-',$datapay[$i]))),
							'qp_percenti' => $amountper[$i],
							'qp_amnt' => isset($importo[$i]) ? $importo[$i]:0,
							'qp_entryby' => $request->user()->id,
						]);
					}
				}
			}

			
			// Salvo i pacchetti e gli optional
			if(isset($request->codici)) {
				
				$codice = $request->codici;
				$ordine = $request->ordine;
				$oggetto = $request->oggetti;
				$descrizione = $request->desc;
				$qta = $request->qt;
				$prezzounitario = $request->pru;
				$totale = $request->tot;
				$asterisca = $request->ast;
				$cicli = $request->cicli;
				
				for($i = 0; $i < count($codice); $i++) {
					
					if(isset($asterisca[$i]) && $asterisca[$i] == 'on')
						$asterisca[$i] = 1;
					else
						$asterisca[$i] = 0;
					
					// Salvo l'optional
					DB::table('optional_preventivi')->insert([
						'id_preventivo' => $nuovopreventivo,
						'ordine' => isset($ordine[$i]) ? $ordine[$i] : "",
						'codice' => isset($codice[$i]) ? $codice[$i] : "",
						'oggetto' => isset($oggetto[$i]) ? $oggetto[$i] : "",
						'descrizione' => isset($descrizione[$i]) ? $descrizione[$i] : "",
						'qta' => isset($qta[$i]) ? $qta[$i] : 0,
						'prezzounitario' => isset($prezzounitario[$i]) ? $prezzounitario[$i] : 0,
						'totale' => isset($totale[$i]) ? $totale[$i] : 0,
						'asterisca' => isset($asterisca[$i]) ? $asterisca[$i] : 0,
						'Ciclicita' => isset($cicli[$i]) ? $cicli[$i] : 0
					]);
					
					$optional = DB::table('optional_preventivi')
									->select('codice')
									->where('codice', $codice[$i])
									->first();
									
					// Collego l'optional al preventivo
					DB::table('tabellaoptionalpreventivi')->insert([
						'id_opt' => $optional->codice,
						'id_preventivo' => $nuovopreventivo
					]);
				}
			}		

			/* Update Quote Id in Media files Paras */
				DB::table('media_files')
				->where('code', $request->mediaCode)
				->update(array('master_id' => $nuovopreventivo));
			/* Update Quote Id in Media files */
		
			return redirect('/estimates/modify/quote/' . $nuovopreventivo)
				->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_quotation_created_correctly').'</div>');
	}
	
	// Mostro la pagina di modifica di un preventivo
	public function modify(Request $request, Quote $quote)
	{
		/*if(!checkpermission($this->module, $this->sub_id, 'scrittura')){
    		return redirect('/unauthorized');
    	}*/

		// $this->authorize('modify', $quote);
		$userprofileid = $request->user()->dipartimento;
 		$Querytype = DB::table('ruolo_utente')->where('ruolo_id', $userprofileid)->first();
        $type = isset($Querytype->nome_ruolo) ? $Querytype->nome_ruolo : "";
        // print_r($type);
        // exit;
        if ($request->user()->id === 0 || $type === 'SupperAdmin') {
			$quotefiles = DB::table('media_files')->select('*')->where('master_id', $quote->id)->where('master_type', '0')->get();
		}
		else {
    		$quotefiles = DB::select("select * from media_files where master_id = ".$quote->id." AND master_type = '0' AND find_in_set('$userprofileid',type) <> 0");
    	}

		return view('estimates.modifica', [
			'preventivo' => DB::table('quotes')
								->select('*')
								->where('id', $quote->id)
								->first(),
			'quotefiles' => $quotefiles,								
			'utenti' => DB::table('users')
							->select('*')
							->get(),
			'enti' => $this->corporations->forUser2($request->user()),
			'dipartimenti' => DB::table('departments')
								->select('*')
								->get(),
			'optional' => DB::table('optional')
							->select('*')
							->get(),
			'pacchetti' => DB::table('pack')
							->select('*')
							->get(),
			'optional_pack' => DB::table('optional_pack')
								->select('*')
								->get(),
			'optional_preventivi' => DB::table('optional_preventivi')
					->where('id_preventivo', $quote->id)->orderBy('ordine', 'asc')
					->get(),					
			'quote_paymento' => DB::table('quote_paymento')
					->where('qp_quote_id', $quote->id)
					->get(),
			'statiemotivi' => DB::table('statiemotivipreventivi')->get(),
			'frequency'=>DB::table('frequenze')->get(),
			'statoemotivoselezionato' => DB::table('statipreventivi')
				->where('id_preventivo', $quote->id)
				->first()
		]);
	}	


	// Salvo le modifiche di un preventivo
	public function update(Request $request, Quote $quote)
	{
		if(!checkpermission($this->module, $this->sub_id, 'scrittura')){
    		return redirect('/unauthorized');
    	}

		// $this->authorize('modify', $quote);	
		
		$validator = Validator::make($request->all(), [
			'data' => 'required',
			'oggetto' => 'required|max:150',	
			'dipartimento' => 'required',
			'idente'=>'required',
			'considerazioni' => 'required|max:2000',
			'valenza' => 'required',
			'finelavori' => 'required'
		]);
		
		if($validator->fails()) {
			return Redirect::back()
				->withInput()
				->withErrors($validator);
		}
		
		// Controllo lo sconto e lo sconto bonus
			$scontoagente = $request->scontoagente;
			$scontobonus = $request->scontobonus;
			$scontibonus = [];
			// Seleziono l'ente relativo alla utenza in uso
			$ente = DB::table('corporations')
						->where('id', $request->user()->id_ente)
						->first();
	
			$elenco = DB::table('corporationtypes')
						->where('id_ente', $ente->id)
						->get();
			// Variabile per contenere gli sconto assegnati a quell'ente
			$sconti = [];
			// Per tutti i tipi assegnati a quell'ente
			for($i = 0; $i < count($elenco); $i++) {
				$sc = DB::table('entisconti')
							->where('id_sconto', $elenco[$i]->id_tipo)
							->first();
				if($sc) {
				$sconto = DB::table('sconti')
							->where('id', $sc->id_sconto)
							->first();
				}
				
				if(isset($sconto))	
				$sconti[] = $sconto->sconto;
			}
			$max = 0;
			for($i = 0; $i < count($sconti); $i++) {
				if($max < $sconti[$i])
					$max = $sconti[$i];
			}
			$scontoagente_max = $max;
			// Sconto bonus
			$elenco = DB::table('entiscontibonus')
						->where('id_tipo', $request->user()->id)
						->get();
			$sconti = [];
			for($i = 0; $i < count($elenco); $i++) {
				$sconto = DB::table('scontibonus')
							->where('id', $elenco[$i]->id_sconto)
							->first();
				if($sconto)
				$scontibonus[] = $sconto->sconto;
			}
			$max = 0;
			for($i = 0; $i < count($scontibonus); $i++) {
				if($max < $scontibonus[$i])
					$max = $scontibonus[$i];
			}
			$scontobonus_max = $max;
		if($scontoagente > $scontoagente_max) {
					return Redirect::back()
						->withInput()
						->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_major_agent_discount_estimate_validation').' '.$scontoagente_max . '</div>');
		} else if($scontobonus > $scontobonus_max) {
					return Redirect::back()
						->withInput()
						->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_major_agent_discount_estimate_validation').' '. $scontobonus_max . '</div>');	
		}
		
		DB::table('notifiche')
			->where('id', $quote->id_notifica)
			->delete();
		
		DB::table('quotes')
			->where('id', $quote->id)
			->update(array(
				'idutente' => $request->idutente,
				'idente' => $request->idente,
				'data' => $request->data,
				'oggetto' => $request->oggetto,
				'dipartimento' => $request->dipartimento,
				
				/*'metodo' => $request->metodo,*/
				'considerazioni' => $request->considerazioni,
				
				'valenza' => $request->valenza,
				'finelavori' => $request->finelavori,
				/*'notetecniche' => $request->notetecniche,
				'noteimportanti' => $request->noteimportanti,
				'noteintestazione' => $request->noteintestazione,
				*/
				'lineebianche' => $request->lineebianche,
				'id_notifica' => 0,
				'subtotale' => $request->subtotale,
				'scontoagente' => $request->scontoagente,
				'scontobonus' => $request->scontobonus,
				'totale' => $request->totale,
				'totaledapagare'  => $request->totaledapagare,
				'legameprogetto' => $request->legameprogetto,
				'prezzo_confermato' => $request->prezzo
		));

		$logs = $this->logmainsection.' -> Update Quote (ID: '. $quote->id . ')';
		storelogs($request->user()->id, $logs);
		$emotionalstatusold = DB::table('statipreventivi')->where('id_preventivo', $quote->id)->first();		
		if($request->statoemotivo!=null) {
			// Aggiorno lo stato emotivo
			/*$tipo = DB::table('statiemotivipreventivi')
				->where('name', $request->statoemotivo)
				->first();*/
			DB::table('statipreventivi')
				->where('id_preventivo', $quote->id)
				->delete();
			DB::table('statipreventivi')
				->insert([
					'id_tipo' => $request->statoemotivo,
					'id_preventivo' => $quote->id,
					'created_at'=>date('Y-m-d H:i:s')
				]);
		}
		
		if(isset($request->filetecnico)) {
			$options = $request->filetecnico;
			for($i = 0; $i < count($options); $i++) {
				$nome = time() . uniqid() . '-' . '-preventivo';
				Storage::put(
					'images/' . $nome,
					file_get_contents($options[$i]->getRealPath())
				);

				DB::table('progetti_files')->insert([
					'id_preventivo' => $quote->id,
					'nome' => $nome,
					'dipartimento' => "TECNICO"
				]);
			}
		}
		
		if(isset($request->filee)) {
			$optionss = $request->filee;
			for($i = 0; $i < count($optionss); $i++) {
				$nome = time() . uniqid() . '-' . '-scansione_preventivo';
				Storage::put(
					'images/' . $nome,
					file_get_contents($optionss[$i]->getRealPath())
				);

				DB::table('progetti_files')->insert([
					'id_preventivo' => $quote->id,
					'nome' => $nome,
					'dipartimento' => "AMMINISTRAZIONE"
				]);
			}
		}

		DB::table('quote_paymento')->where('qp_quote_id', $quote->id)->delete();
		if(isset($request->datapay)) {
			
			$datapay = $request->datapay;
			$amountper = $request->amountper;
			$importo = $request->importo;
			/*print_r($datapay);
			echo ' >>> ';
			print_r($amountper);
			echo ' >>> ';
			print_r($importo);
			exit;*/

			//var_dump($datapay);
			for($i = 0; $i < count($datapay); $i++) {				
				if((isset($amountper[$i]) && $amountper[$i] != "") || (isset($datapay[$i]) && $datapay[$i] != "")){
					$datapay[$i] = str_replace('/', '-', $datapay[$i]);				
					DB::table('quote_paymento')->insert([
						'qp_quote_id' => $quote->id,
						'qp_data' => date('Y-m-d',strtotime($datapay[$i])),
						'qp_percenti' => isset($amountper[$i]) ? $amountper[$i] : '',
						'qp_amnt' => isset($importo[$i]) ? $importo[$i]:0,
						'qp_entryby' => $request->user()->id,
					]);
				}
			}
		}
		
		// Salvo i pacchetti e gli optional
		if(isset($request->codici)) {
			DB::table('optional_preventivi')
			->where('id_preventivo', $quote->id)
			->delete();
			
			$codice = $request->codici;
			$oggetto = $request->oggetti;
			$descrizione = $request->desc;
			$qta = $request->qt;
			$prezzounitario = $request->pru;
			$totale = $request->tot;
			$ordine = $request->ordine;
			$asterisca = $request->ast;
			$cicli = $request->cicli;
			
			for($i = 0; $i < count($codice); $i++) {
				if(isset($asterisca[$i]) && $asterisca[$i] == 'on')
					$asterisca[$i] = 1;
				else
					$asterisca[$i] = 0;

				// Salvo l'optional
				DB::table('optional_preventivi')->insert([
					'id_preventivo' => $quote->id,
					'ordine' => isset($ordine[$i]) ? $ordine[$i] : "",
					'codice' => isset($codice[$i]) ? $codice[$i] : "",
					'oggetto' => isset($oggetto[$i]) ? $oggetto[$i] : "",
					'descrizione' => isset($descrizione[$i]) ? $descrizione[$i] : "",
					'qta' => isset($qta[$i]) ? $qta[$i] : 0,
					'prezzounitario' => isset($prezzounitario[$i]) ? $prezzounitario[$i] : 0,
					'totale' => isset($totale[$i]) ? $totale[$i] : 0,
					'asterisca' => isset($asterisca[$i]) ? $asterisca[$i] : 0,
					'Ciclicita' => isset($cicli[$i]) ? $cicli[$i] : 0
				]);
				
				$optional = DB::table('optional_preventivi')
					->select('codice')
					->where('codice', $codice[$i])
					->first();
								
				// Collego l'optional al preventivo
				DB::table('tabellaoptionalpreventivi')->insert([
					'id_opt' => $quote->id,
					'id_preventivo' => $quote->id
				]);
			}
		}
		
		DB::table('media_files')
			->where('code', $request->mediaCode)
			->update(array('master_id' => $quote->id));

		/*If new status confirmed AND Old status is not already confirmed then create invoice */
		if($request->statoemotivo!=null && $request->statoemotivo == '6' && $emotionalstatusold->id_tipo != '6') {
			$this->createquoteinvoice($quote->id);
		}
		
		return Redirect::back()
				->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_estimated_edited_correctly').'</div>');
	}

	public function createquoteinvoice($quoteId = "") {		
    	
    	if($quoteId=="") {
    		return false;
    	}
		$quote = DB::table('quotes')->where('id', $quoteId)->first();
		$dipartimento= (isset($quote->dipartimento) && !empty($quote->dipartimento)) ? $quote->dipartimento : '1';
		$ente = DB::table('corporations')->where('id', $quote->idente)->first();

    	$project = DB::table('projects')->where('id_preventivo', $quoteId)->first();  	  
		$tipofattura = "FATTURA DI VENDITA"; /* Sales note */	
		
		$date = isset($quote->data) ? str_replace('/', '-', $quote->data) :  date('Y-m-d');
		$datainserimento = date('Y-m-d', strtotime($date));		

		/*$date = str_replace('/', '-', $request->datascadenza);
		$datascadenza = date('Y-m-d', strtotime($date));*/

		//$date = str_replace('/', '-', $request->data);
		$emissione = date('Y-m-d', strtotime($date));

		$tranche = DB::table('tranche')->insertGetId([
                        'user_id' => Auth::user()->id,
                        'id_disposizione' => isset($project->id) ? $project->id : '0',/* Project id */
						'tipo' => 0,
						//'datainserimento' => isset($request->datainserimento) ? $request->datainserimento : '',
						'datainserimento' => $datainserimento,
						'datascadenza' => isset($quote->finelavori) ? $quote->finelavori : '',
						'percentuale' => 0,
						'dettagli' => isset($quote->considerazioni) ? $quote->considerazioni : '',
						/*'frequenza' => $request->frequenza,*/
						'DA' => isset($quote->dipartimento) ? $quote->dipartimento : Auth::user()->dipartimento,
						'A' => isset($quote->idente) ? $quote->idente : '',
						'idfattura' => isset($request->idfattura) ? $request->idfattura : '',
						'emissione' => $emissione,
						'indirizzospedizione' => isset($ente->indirizzospedizione) ? $ente->indirizzospedizione : '',
						'privato' => 0,
						/*'testoimporto' => $request->importo_nopercentuale,*/
						/*'base' => $request->base,*/
						/*'modalita' => isset($request->modalita) ? $request->modalita : '',*/
						'tipofattura' => $tipofattura,
						'iban' => isset($ente->iban) ? $ente->iban : '',
						/*'peso' => isset($request->peso) ? $request->peso : '',*/
						/*'netto' => isset($request->netto) ? $request->netto : '',*/
						/*'scontoaggiuntivo' => isset($request->scontoaggiuntivo) ? $request->scontoaggiuntivo : '',*/
						/*'imponibile' => isset($request->imponibile) ? $request->imponibile : '',*/
						/*'prezzoiva' => isset($request->prezzoiva) ? $request->prezzoiva : '',*/
						/*'percentualeiva' => isset($request->percentualeiva) ? $request->percentualeiva : '',*/
						/*'dapagare' => isset($request->dapagare) ? $request->dapagare : '',*/
                      ]);

		/* Medai files from project to qoute */
		$arrwhere = (isset($project->id)) ? array('master_id'=>$project->id,'master_type'=>'1') : array('master_id'=>$quoteId,'master_type'=>'0');
		$medifilesQuote = DB::table('media_files')->where($arrwhere)->get();
		foreach ($medifilesQuote as $keymq => $valuemq) {
			$mediafileid = DB::table('media_files')->insertGetId([
					'name' => 'inv'.$valuemq->name,
				    'master_id' => $tranche,
					'type' => Auth::user()->dipartimento,					
					'master_type' => 3,
					'title' => $valuemq->title,
					'description' =>$valuemq->description,
					'created_at'=>time()
				]);
			if(isset($project->id)){
				if(file_exists('storage/app/images/projects/'.$valuemq->name)){			
					copy('storage/app/images/projects/'.$valuemq->name, 'storage/app/images/invoice/inv'.$valuemq->name);
				}
			}
			else {
				if(file_exists('storage/app/images/quote/'.$valuemq->name)){			
					copy('storage/app/images/quote/'.$valuemq->name, 'storage/app/images/invoice/inv'.$valuemq->name);
				}	
			}
		}

		$logs = $this->logmainsection.' -> Add New Invoice (ID: '. $tranche . ')';
		storelogs(Auth::user()->id, $logs);

		//if($request->statoemotivo!=null) {
			// Memorizzo lo stato emotivo
			$tipo = DB::table('statiemotivipagamenti')->where('id', '12')->first();
			if(isset($tipo->id)){
				DB::table('statipagamenti')->insert([
					'id_pagamento' => $tranche,
					'id_tipo' => $tipo->id,
				]);
			}
		//}
		
		/* ================= Invoice Body Sections ==================== */
		$ordine = isset($quote->id) ? ':'.$quote->id.'/'.$quote->anno : '';
		$project_refer_no = isset($project->id) ? ':'.$project->id.'/'.substr($project->datainizio, -2) : '';		
		if(isset($quote->id)) {
			$quote_optional = DB::table('optional_preventivi')->where('id_preventivo', $quote->id)->get();		
			foreach ($quote_optional as $quoteopkey => $quoteopvalue) {
				DB::table('corpofattura')->insert([
						'id_tranche' => $tranche,
						'ordine' => $ordine,
						'project_refer_no'=>$project_refer_no,
						'descrizione' => $quoteopvalue->descrizione,
						'qta' => $quoteopvalue->qta,
						'subtotale' =>$quoteopvalue->totale,
						/*'scontoagente' => isset($scontoagente[$i]) ? $scontoagente[$i] : 0 ,
						'scontobonus' => $scontobonus[$i],*/
						'netto' => $quoteopvalue->prezzounitario,						
						'percentualeiva' => 0,
						'is_active' => 0,
					]);
			}
		}
		return true;
		/*return redirect('/pagamenti/tranche/modifica/' . $tranche)
                        ->with('error_code', 5)
                        ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_addsuccessmsg').'!</div>');*/
	}
	// Elimina un preventivo
	public function deleteEstimates(Request $request, Quote $quote)
	{
		if(!checkpermission($this->module, $this->sub_id, 'scrittura')){
    		return redirect('/unauthorized');
    	}

		// $this->authorize('destroy', $quote);

		DB::table('quotes')
			->where('id', $quote->id)
			->update(array(
				'is_deleted' => 1
		));
		
		$logs = $this->logmainsection.' -> Delete Quote (ID: '. $quote->id . ')';
		storelogs($request->user()->id, $logs);

		return Redirect::back()
				->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_quote_deleted_correctly').'</div>');
	}
	
	public function eliminaoptionaldalprev(Request $request, Quote $quote)
	{
		DB::table('optional_preventivi')
			->where('id', $request->id)
			->delete();
			return Redirect::back()
				->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_optional_deleted_correctly').'</div>');
	}
	
public function eliminaoptional(Request $request, Quote $quote)
	{
		return view('estimates.optional', [
			'preventivo' => $quote,
			'frequency'=>DB::table('frequenze')->get(),
			'optional' => DB::table('optional_preventivi')
				->where('id_preventivo', $quote->id)
				->get(),
		]);
	}
	
	public function aggiornaoptional(Request $request)
	{ 
	
		DB::table('optional_preventivi')
			->where('id_preventivo', $request->id)
			->delete();
		
		  $ordine = $request->ord;
		  $oggetto = $request->oggetti;		  
		  $descrizione = $request->desc;
		  $qta = $request->qt;
		  $prezzounitario = $request->pru;
		  $totale = $request->tot;
		  $asterisca = $request->ast;
		  $Ciclicita = $request->cicli;
	  
		  for($i = 0; $i < count($ordine); $i++) {
		  	
			if(isset($asterisca[$i]))
				$asterisca[$i] = 1;
			else
				$asterisca[$i] = 0;
		  
			// Salvo l'optional
			DB::table('optional_preventivi')->insert([

			  'id_preventivo' => $request->id,
			  'ordine' => $ordine[$i],
			  'oggetto' => isset($oggetto[$i]) ? $oggetto[$i] : '',
			  'descrizione' => isset( $descrizione[$i]) ? $descrizione[$i] : '',
			  'qta' => isset($qta[$i]) ? $qta[$i] : 0,
			  'prezzounitario' => isset($prezzounitario[$i]) ? $prezzounitario[$i] : 0,
			  'totale' => isset($totale[$i]) ? $totale[$i] : 0,
			  'asterisca' => isset($asterisca[$i]) ? $asterisca[$i] : 0,
			  'Ciclicita' => isset($Ciclicita[$i]) ? $Ciclicita[$i] : ""
			]);
		  }		
		  
		return Redirect::back()->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.	keyword_optional_modified_correctly').'</div>');
	}
	
	public function duplicatEstimates(Request $request, Quote $quote)
	{
		if(!checkpermission($this->module, $this->sub_id, 'scrittura')){
    		return redirect('/unauthorized');
    	}

		// $this->authorize('duplicate', $quote);

		// $id = $request->user()->quotes()->create([
		$id = DB::table('quotes')->insertGetId([
			'anno' => date('y'),
			'user_id' => $request->user()->id,
			'idente' => $quote->idente,
			'data' => $quote->data,
			'oggetto' => $quote->oggetto,
			'dipartimento' => $quote->dipartimento,
			'noteintestazione' => $quote->noteintestazione,
			'metodo' => $quote->metodo,
			'considerazioni' => $quote->considerazioni,
			'noteimportanti' => $quote->noteimportanti,
			'notetecniche' => $quote->notetecniche,
			'valenza' => $quote->valenza,
			'finelavori' => $quote->finelavori,
			'subtotale' => $quote->subtotale,
			'scontoagente' => $quote->scontoagente,
			'scontobonus' => $quote->scontobonus,
			'totale' => $quote->totale,
			'totaledapagare'  => $quote->totaledapagare,
			'lineebianche' => $quote->lineebianche
		]);

		$logs = $this->logmainsection.' -> Copy(Duplicate) Quote (ID: '. $id . ')';
		storelogs($request->user()->id, $logs);

		$items = DB::table('optional_preventivi')
			->where('id_preventivo', $quote->id)
			->get();

		foreach($items as $item) {
			DB::table('optional_preventivi')->insert([
					'id_preventivo' => $id,
					'codice' => $item->codice,
					'ordine' => $item->ordine,
					'oggetto' => $item->oggetto,
					'descrizione' => $item->descrizione,
					'qta' => $item->qta,
					'prezzounitario' => $item->prezzounitario,
					'totale' => $item->totale,
					'asterisca' => $item->asterisca
				]);
		}

		$tipo = DB::table('statiemotivipreventivi')
					->where('id', '8')
					->first();

		DB::table('statipreventivi')->insert([
			'id_preventivo' => $id,
			'id_tipo' => $tipo->id,
			'created_at'=>date('Y-m-d H:i:s')
		]);

		return Redirect::back()
				->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_duplicate_quote_correctly').'</div>');
	}
	
	// PDF	
	public function pdfnoprice(Request $request, Quote $quote) {
		// Prendo i dati del preventivo
		$this->authorize('visualizzapdf', $quote);
		$preventivo = DB::table('quotes')
						->where('id', $quote->id)
						->first();
		// Prendo i dati dell'ente a cui è indirizzato il preventivo
		$ente = DB::table('corporations')
					->where('id', $preventivo->idente)
					->first();
		$utente = DB::table('users')
					->where('id', $preventivo->user_id)
					->first();
		$ente_DA = DB::table('corporations')
					->where('id', $utente->id_ente)
					->first();
		$pdf = new QuotationPDFNoPrezzi($preventivo, $ente, $ente_DA);
		$pdf->AddFont('Nexa', '', 'NexaLight.php');
		$pdf->AddFont('Nexa', 'B', 'NexaBold.php');
		//$pdf->writePdf();
	}
	
	public function pdf(Request $request, Quote $quote)
	{		
		if(!checkpermission($this->module, $this->sub_id, 'lettura')){
    		return redirect('/unauthorized');
    	}
    	
		$preventivo = DB::table('quotes')->where('id', $quote->id)->first();		
		$ente = DB::table('corporations')->where('id', $preventivo->idente)->first();
		$utente = DB::table('users')->where('id', $preventivo->user_id)->first();
		$responsabile = DB::table('users')->where('name', $ente->responsabilelanga)->first();
		$ente_DA = array();
		if(isset($utente->id_ente)){
			$ente_DA = DB::table('corporations')->where('id', $utente->id_ente)->first();
		}
		$ownerDepartments = DB::table('departments')->where('id', $preventivo->dipartimento)->first();
		$optional_preventivi = DB::table('optional_preventivi')->where('id_preventivo', $preventivo->id)->get();
		$taxation = DB::table('tassazione')->where('is_active',0)->get();

			
		$pdf = new PDF('utf-8');
		$pdf->shrink_tables_to_fit = 1;
		//$pdf->tableMinSizePriority = false;
		//$pdf->mirrorMargins(1);
						
		$header = \View::make('pdf.quotation_header')->render();				
		$footer = \View::make('pdf.quotation_footer')->render();
		
		$pdf->SetHTMLHeader($header, 'O');
		$pdf->SetHTMLHeader($header, 'E');
		$pdf->SetHTMLFooter($footer, 'O');
		$pdf->SetHTMLFooter($footer, 'E');
		
		/*$pdf->AddPage('Portrait', margin-left, margin-right, margin-top, margin-bottom, margin-header, margin-footer, 'A4');*/
		$pdf->AddPage('P', 0, 0, 40, 15, 0, 0, 'Letter');
		/*echo $header;
		echo view('pdf.quotation', [
			'preventivo' =>$preventivo,										
			'ente' => $ente,
			'utente' => $utente,
			'ente_DA' => $ente_DA,
			'owner'=>$ownerDepartments,
			'responsabile'=>$responsabile,
			'optional_preventivi'=>$optional_preventivi]);
		echo $footer;
		exit;*/
		
		
		$pdf->loadView('pdf.quotation', [
			'preventivo' =>$preventivo,										
			'ente' => $ente,
			'utente' => $utente,
			'ente_DA' => $ente_DA,
			'owner'=>$ownerDepartments,
			'responsabile'=>$responsabile,
			'optional_preventivi'=>$optional_preventivi,
			'taxation'=>$taxation]);
		
		$logs = $this->logmainsection.' -> Generate pdf for Quote -> (ID: '. $quote->id .')';
		storelogs($request->user()->id, $logs);
		
		/*$pdf->download('test.pdf');*/
		$pdf->stream('quote.pdf');				
	
	}
	
	public function getJsonMyconfirmedestimates(Request $request)
	{
		if(($request->user()->id == 0) || ($request->user()->dipartimento == 0)){
			$quotes = DB::table('quotes')->where('is_deleted', 0)
            ->where('user_id', $request->user()->id)->orderBy('id', 'desc')->get();
		} else {
			$quotes = DB::table('quotes')->where('is_deleted', 0)
            ->where('user_id', $request->user()->id)->orderBy('id', 'desc')->get();
		}

		$jsonQuotes[] = '';
		foreach($quotes as $quote) {

			$check = DB::table('statipreventivi')
            ->join('statiemotivipreventivi', 'statipreventivi.id_tipo', '=', 'statiemotivipreventivi.id')
            ->select('statipreventivi.*', 'statiemotivipreventivi.*')
            ->where('statipreventivi.id_preventivo', $quote->id)
            ->where('statiemotivipreventivi.id', '6')->first();

            if($check){
            	$quote->ente = DB::table('corporations')
					->where('id', $quote->idente)
					->first()->nomeazienda;
            	$jsonQuotes[] = $quote;
            }
			
		}

		return json_encode($jsonQuotes);
	}
}
