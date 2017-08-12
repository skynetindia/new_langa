<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\AccountingRepository;
use App\Repositories\ProjectRepository;
use DB;
use Validator;
use Redirect;
use App\Http\Requests;
use App\Accounting;
use App\PDF\fpdf;
use Storage;
use DateTime;
use App\Classes\PdfWrapper as PDF;

class AccountingController extends Controller
{
    protected $pagamenti;
	protected $progetti;
	protected $logmainsection;

	protected $module;
	protected $sub_id;
    
    public function __construct(AccountingRepository $accountings, ProjectRepository $projects)
    {
        $this->middleware('auth');
        $this->pagamenti = $accountings;
		$this->progetti = $projects;
		$this->logmainsection = 'Accounting';		
		

		$request = parse_url($_SERVER['REQUEST_URI']);
		$path = ($_SERVER['HTTP_HOST'] == 'localhost') ? rtrim(str_replace('/easylanganew/', '', $request["path"]), '/') : $request["path"];		
		$result = rtrim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $path), '/');
		$current_module = DB::select('select * from modulo where TRIM(BOTH "/" FROM modulo_link) = :link', ['link' => $result]);

     	$this->module = (isset($current_module[0]->modulo_sub)) ? $current_module[0]->modulo_sub : 5;
        $this->sub_id = (isset($current_module[0]->id)) ? $current_module[0]->id : 20;
        
    }
	
	
	public function elencotranche(Request $request)
	{
		// if ($request->user()->id === 0 || $request->user()->dipartimento === 1)			
		if(!checkpermission($this->module, $this->sub_id, 'lettura')){
    		return redirect('/unauthorized');
    	}

			return view('pagamenti.elencotranche');
		// else
			// return redirect('/unauthorized');
	}

	public function getjsontuttetranche(Request $request)
	{
		// $tranche = DB::table('tranche')->get();

		$tranche = DB::table('tranche')
				->join('users', 'tranche.user_id','=','users.id')
				->select(DB::raw('tranche.*, users.id as uid, users.is_delete'))
				->where('users.is_delete', '=', 0)
				->get();

		foreach($tranche as $tr) {
			if($tr->is_deleted == 0)
				$tranche_return[] = $tr;	
		}
		$tranche_return = $this->aggiungiNomeQuadro($tranche_return, $request->user());
		return json_encode($tranche_return);
	}

	public function aggiungiNomeQuadro(&$tranche, $user)
	{
		$elenco_tranche = [];
		foreach($tranche as $tra) {
			if($tra->tipo == 1) {
				$tra->tipo = "Rinnovo";
			} else {
				$tra->tipo = "Pagamento";
			}
			$tra->ente = DB::table('corporations')
				->where('id', $tra->A)
				->first()->nomeazienda;
			$disposizione = DB::table('accountings')
							->where('id', $tra->id_disposizione)
							->first();
			$tra->nomequadro = $disposizione->nomeprogetto;
			$stato = DB::table('statipagamenti')
						->where('id_pagamento', $tra->id)
						->first();
			if($stato) {
				$statoemotivo = DB::table('statiemotivipagamenti')
								->where('id', $stato->id_tipo)
								->first();
						
				$tra->statoemotivo = '<span style="color:'.$statoemotivo->color.'">'.$statoemotivo->name.'</span>';			
				
			}
			if ($user->id === 0 || $user->dipartimento === 1) {
            	$elenco_tranche[] = $tra;
        	} else if($user->id == $tra->user_id) {
				$elenco_tranche[] = $tra;	
			}
		}
		return $elenco_tranche;
	}
	
	public function modificatranche(Request $request)
	{
		$tranche = DB::table('tranche')
			->where('id', $request->id)
			->first();
   
		return view('pagamenti.modificatranche', [
			'tranche' => $tranche,
			'utenti' => DB::table('users')->get(),
			'quotefiles' => DB::table('media_files')->select('*')->where('master_id', $request->id)->where('master_type','3')->get(),								
			'enti' => DB::table('corporations')->orderBy('id', 'asc')->get(),
			'statiemotivi' => DB::table('statiemotivipagamenti')->get(),
			'statoemotivoselezionato' => DB::table('statipagamenti')->where('id_pagamento', $tranche->id)->first(),
		]);
	}
	
	public function generapdftranche(Request $request)
	{
		$idtranche = $request->id;
		$tranche = DB::table('tranche')
			->where('id', $idtranche)
			->first();

		$user = $request->user();
		
		if(!$this->hasPower($user, $tranche)) {
			return redirect('/unauthorized');
		}
		$arrSettings = adminSettings();
		$ente_DA = DB::table('corporations')
					->where('id', $tranche->DA)
					->first();					
		$disposizione = DB::table('accountings')
							->where('id', $tranche->id_disposizione)
							->first();
		/*$corpofattura = json_decode(json_encode(DB::table('corpofattura')
							->where('id_tranche', $idtranche)
							->orderBy('ordine_numerico', 'asc')
							->get()), true);*/
		$corpofattura = DB::table('corpofattura')
							->where('id_tranche', $idtranche)
							->orderBy('ordine_numerico', 'asc')
							->get();
		$ente_A = DB::table('corporations')
					->where('id', $tranche->A)
					->first();

		$pdf = new PDF('utf-8');
		$pdf->mirrorMargins(1);
						
		//$header = \View::make('pdf.quotation_header')->render();		
		$footer = \View::make('pdf.invoice_footer')->render();
		
		//$pdf->SetHTMLHeader($header, 'O');
		//$pdf->SetHTMLHeader($header, 'E');
		$pdf->SetHTMLFooter($footer, 'O');
		$pdf->SetHTMLFooter($footer, 'E');
		/*$pdf->AddPage('Portrait', margin-left, margin-right, margin-top, margin-bottom, margin-header, margin-footer, 'A4');*/
		$pdf->AddPage('P', 10, 10, 10, 20, 0, 10, 'Letter');

		$id_perfile = substr($tranche->idfattura, 0, 5) . '-' . substr($tranche->idfattura, 6);
		$pdf->SetTitle($id_perfile . '_' . $disposizione->nomeprogetto . '_LANGA Group');
		
		/*echo view('pdf.invoice', [
			'ente_DA' => $ente_DA,
			'ente_A'=>$ente_A,
			'disposizione'=>$disposizione,
			'corpofattura'=>$corpofattura,
			'tranche'=>$tranche,
			'arrSettings'=>$arrSettings]);
		echo $footer;
		exit;*/
			
		$pdf->loadView('pdf.invoice', [
			'ente_DA' => $ente_DA,
			'ente_A'=>$ente_A,
			'disposizione'=>$disposizione,
			'corpofattura'=>$corpofattura,
			'tranche'=>$tranche,
			'arrSettings'=>$arrSettings]);

		$logs = $this->logmainsection.' -> Generate pdf for Invoice (ID: '. $request->id . ')';
		storelogs($request->user()->id, $logs);		

		/*$pdf->download('test.pdf');*/
		$pdf->stream($id_perfile . '_' . $disposizione->nomeprogetto . '_LANGA Group' . '.pdf');							
	}

	public function stampaTesto(&$pdf, $x, $y, $testo, $larghezza, $allineamento, $spessore, $family, $type, $size)
	{
		$pdf->SetFont($family, $type, $size);
		$array = explode("\n", $testo);
		
		for($i = 0; $i < count($array); $i++) {
			$pdf->SetXY($x, $y + $i * $spessore);
			$pdf->Cell($larghezza, 0, $array[$i], 0, 1, $allineamento);
		}
	}

	public function hasPower($user, $accounting)
	{
		if ($user->id === 0 || $user->dipartimento === 1) {
            return true;
    	}
    	return $accounting->user_id === $user->id;
	}

	public function salvatranche(Request $request)
	{
		if(!checkpermission($this->module, $this->sub_id, 'scrittura')){
    		return redirect('/unauthorized');
    	}
    	
		$validator = Validator::make($request->all(), [
			'DA' => 'required',
			'A' => 'required',
			'datascadenza' => 'required',
			'percentuale' => 'required',
			'emissione' => 'required',
			'tipofattura' => 'required',
			'base' => 'required',
        ]);
        
        if($validator->fails()) {
            return Redirect::back()
                ->withInput()
                ->with('error_code', 6)
                ->withErrors($validator);
        }
		
		// Controllo lo sconto e lo sconto bonus
		if(isset($request->ordine)) {			
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
			for($i = 0; $i < count($scontoagente); $i++) {
				if($scontoagente[$i] > $scontoagente_max) {
					return Redirect::back()
						->withInput()
                        ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Non ti è permesso imporre uno sconto agente maggiore a ' . $scontoagente_max . '</div>');
				} else if($scontobonus[$i] > $scontobonus_max) {
					return Redirect::back()
						->withInput()
                        ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Non ti è permesso imporre uno sconto bonus maggiore a ' . $scontobonus_max . '</div>');	
				}
			}
		}
			  
		if($request->tipofattura == 0) {
			$tipofattura = "FATTURA DI VENDITA";	
		} else {
			$tipofattura = "NOTA DI CREDITO";	
		}		
		
		$tranche = DB::table('tranche')->insertGetId([
                        'user_id' => $request->user()->id,
                        'id_disposizione' => $request->id_disposizione,
						'tipo' => $request->tipo,
						// 'datainserimento' => isset($request->datainserimento) ? $request->datainserimento : '',
						'datainserimento' => date('Y-m-d',strtotime($request->emissione)),
						'datascadenza' => $request->datascadenza,
						'percentuale' => $request->percentuale,
						'dettagli' => isset($request->dettagli) ? $request->dettagli : '',
						'frequenza' => $request->frequenza,
						'DA' => $request->DA,
						'A' => $request->A,
						'idfattura' => isset($request->idfattura) ? $request->idfattura : '',
						'emissione' => $request->emissione,
						'indirizzospedizione' => $request->indirizzospedizione,
						'privato' => $request->privato,
						'testoimporto' => $request->importo_nopercentuale,
						'base' => $request->base,
						'modalita' => isset($request->modalita) ? $request->modalita : '',
						'tipofattura' => $tipofattura,
						'iban' => isset($request->iban) ? $request->iban : '',
						'peso' => isset($request->peso) ? $request->peso : '',
						'netto' => isset($request->netto) ? $request->netto : '',
						'scontoaggiuntivo' => isset($request->scontoaggiuntivo) ? $request->scontoaggiuntivo : '',
						'imponibile' => isset($request->imponibile) ? $request->imponibile : '',
						'prezzoiva' => isset($request->prezzoiva) ? $request->prezzoiva : '',
						'percentualeiva' => isset($request->percentualeiva) ? $request->percentualeiva : '',
						'dapagare' => isset($request->dapagare) ? $request->dapagare : '',
                      ]);
		
		DB::table('media_files')
				->where('code', $request->mediaCode)
				->update(array('master_id' => $tranche));

		$logs = $this->logmainsection.' -> Add New Invoice (ID: '. $tranche . ')';
		storelogs($request->user()->id, $logs);

		if($request->statoemotivo!=null) {
			// Memorizzo lo stato emotivo
			$tipo = DB::table('statiemotivipagamenti')
				->where('name', $request->statoemotivo)
				->first();
			DB::table('statipagamenti')->insert([
				'id_pagamento' => $tranche,
				'id_tipo' => $tipo->id,
			]);
		}
				
		// Salvo il corpo fattura
		if(isset($request->ordine)) {
			
			$ordine = isset($request->ordine) ? $request->ordine : '';
			$descrizione = $request->desc;
			$qt = $request->qt;
			$subtotale = $request->subtotale;
			$scontoagente = isset($request->scontoagente) ? $request->scontoagente : 0;
			$scontobonus = $request->scontobonus;
			$prezzonetto = $request->prezzonetto;
			$iva = $request->iva;

			for($i = 0; $i < count($ordine); $i++) {
				DB::table('corpofattura')->insert([
					'id_tranche' => $tranche,
					'ordine' => isset($ordine[$i]) ? $ordine[$i] : '',
					'descrizione' => isset($descrizione[$i]) ? $descrizione[$i] : '',
					'qta' => isset($qt[$i]) ? $qt[$i] : 0,
					'subtotale' => isset($subtotale[$i]) ? $subtotale[$i] : 0,
					'scontoagente' => isset($scontoagente[$i]) ? $scontoagente[$i] : 0 ,
					'scontobonus' => $scontobonus[$i],
					'netto' => isset($prezzonetto[$i]) ? $prezzonetto[$i] : 0,
					'percentualeiva' => isset($iva[$i]) ? $iva[$i] : 0,
				]);
			}
		}				  
		return redirect('/pagamenti/mostra/accounting/' . $request->id_disposizione)
                        ->with('error_code', 5)
                        ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_addsuccessmsg').'!</div>');
	}
                                                                                                                                                                      

	public function aggiornatranche(Request $request)
	{
		if(!checkpermission($this->module, $this->sub_id, 'scrittura')){
    		return redirect('/unauthorized');
    	}
    	
		$validator = Validator::make($request->all(), [			
			'DA' => 'required',
			'A' => 'required',
			'datascadenza' => 'required',
			'percentuale' => 'required',
			'emissione' => 'required',
			'tipofattura' => 'required',
			'base' => 'required'
        ]);        
        
        if($validator->fails()) {
            return Redirect::back()
                ->withInput()
                ->with('error_code', 6)
                ->withErrors($validator);
        }
		
		// Controllo lo sconto e lo sconto bonus
		if(isset($request->ordine)) {
			$scontoagente = isset($request->scontoagente) ? $request->scontoagente : 0;
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
			for($i = 0; $i < count($scontoagente); $i++) {
				if($scontoagente[$i] > $scontoagente_max) {
					return Redirect::back()
						->withInput()
                        ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_arenotallowed_impose_agent_discount').' ' . $scontoagente_max . '</div>');
				} else if($scontobonus[$i] > $scontobonus_max) {
					return Redirect::back()
						->withInput()
                        ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_arenotallowed_impose_bonus').' ' . $scontobonus_max . '</div>');	
				}
			}
		}
		
		$iddisposizione = DB::table('tranche')
							->where('id', $request->id)
							->first();
		
		if($request->tipofattura == 0) {
			$tipofattura = "FATTURA DI VENDITA";	
		} else {
			$tipofattura = "NOTA DI CREDITO";	
		}
		
		$tranche = DB::table('tranche')
					->where('id', $request->id)
					->first();
		
		DB::table('notifiche')
			->where('id', $tranche->id_notifica)
			->delete();
		// dd($request->emissione);
		DB::table('tranche')
			->where('id', $request->id)
			->update(array(
            	'user_id' => $request->user()->id,
				'tipo' => $request->tipo,
				// 'datainserimento' => isset($request->datainserimento) ? $request->datainserimento : '',
				'datainserimento' => date('Y-m-d',strtotime($request->emissione)),
				'datascadenza' => $request->datascadenza,
				'percentuale' => $request->percentuale,
				'dettagli' => $request->dettagli,
				'frequenza' => $request->frequenza,
				'DA' => $request->DA,
				'A' => $request->A,
				'idfattura' => $request->idfattura,
				'emissione' => $request->emissione,
				'indirizzospedizione' => $request->indirizzospedizione,
				'testoimporto' => $request->importo_nopercentuale,
				'id_notifica' => 0,
				'privato' => $request->privato,
				'base' => $request->base,
				'modalita' => $request->modalita,
				'tipofattura' => $tipofattura,
				'iban' => $request->iban,
				'peso' => $request->peso,
				'netto' => $request->netto,
				'scontoaggiuntivo' => $request->scontoaggiuntivo,
				'imponibile' => $request->imponibile,
				'prezzoiva' => $request->prezzoiva,
				'percentualeiva' => $request->percentualeiva,
				'dapagare' => $request->dapagare,
        ));
		

		$logs = $this->logmainsection.' -> Update Invoice (ID: '. $request->id . ')';
		storelogs($request->user()->id, $logs);


		if($request->statoemotivo!=null) {
			// Aggiorno lo stato emotivo
			$tipo = DB::table('statiemotivipagamenti')
				->where('name', $request->statoemotivo)
				->first();
			DB::table('statipagamenti')
				->where('id_pagamento', $request->id)
				->delete();
			DB::table('statipagamenti')
				->insert([
					'id_tipo' => $tipo->id,
					'id_pagamento' => $request->id
				]);
		}
		

		// Aggiorno il corpo fattura
		if(isset($request->ordine)) {
			$ordine = $request->ordine;
			$descrizione = $request->desc;
			$qt = $request->qt;
			$subtotale = $request->subtotale;
			$scontoagente = isset($request->scontoagente) ? $request->scontoagente : 0;
			$prezzonetto = $request->prezzonetto;
			$iva = $request->iva;
			for($i = 0; $i < count($ordine); $i++) {
				DB::table('corpofattura')->insert([
					'id_tranche' => $request->id,
					'ordine' => isset($ordine[$i]) ? $ordine[$i] : '',					
					'descrizione' => isset($descrizione[$i]) ? $descrizione[$i] : '',
					'qta' => isset($qt[$i]) ? $qt[$i] : '',
					'subtotale' => isset($subtotale[$i]) ? $subtotale[$i] : '',
					'scontoagente' => isset($request->scontoagente[$i]) ? $request->scontoagente[$i] : 0,
					'netto' => isset($request->prezzonetto[$i]) ? $request->prezzonetto[$i] : 0,
					'percentualeiva' => isset($request->iva[$i]) ? $request->iva[$i] : 0,
				]);
			}
		}
					  
		return Redirect::back()
                        ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_modified_layout_correctly').' !</div>');
	}

	public function mostradisposizione(Request $request, Accounting $accounting)
	{
		if(!checkpermission($this->module, $this->sub_id, 'lettura')){
    		return redirect('/unauthorized');
    	}

		// $this->authorize('mostra', $accounting);

		return view('pagamenti.mostra', [
			'idfattura' => $accounting->id
		]);
	}

	public function aggiungitranche(Request $request)
    {
        return $this->aggiungi($request);
    }

    public function aggiungi(Request $request)
    {
		if ($request->user()->id === 0 || $request->user()->dipartimento !== 4) {
			 
			 $disposizione = DB::table('accountings')
			 				->where('id', $request->id)
							->first();

			 $progetto = DB::table('projects')
			 				->where('id', $disposizione->id_progetto)
							->first();

			 $preventivo = DB::table('quotes')
			 				->where('id', $progetto->id_preventivo)
							->first();
			 if($preventivo) {
				$corpofattura = DB::table('optional_preventivi')
					->where('id_preventivo', $preventivo->id)
					->get();
				$ordine = $preventivo->id;
				$year = $preventivo->year;
				$prev = DB::table('quotes')->where('id', $preventivo->id)->first();
				$sconto = $prev->scontoagente;
				$scontobonus = $prev->scontobonus;
			 } else {
			 	$ordine = null;
				$year = null;
				$corpofattura = null;
				$sconto = null;
				$scontobonus = null;
			 }
             return view('pagamenti.aggiungitranche', [
				'utenti' => DB::table('users')
							->get(),
				'progetti' => $this->progetti->forUser2($request->user()), 
				'enti' => DB::table('corporations')
							->orderBy('id', 'asc')
							->get(),
				'idfattura' => $request->id,
				'statiemotivi' => DB::table('statiemotivipagamenti')
									->get(),
				'preventiviconfermati' => DB::table('quotes')
            					->where('legameprogetto', 1)
								->having('usato', '=', 0)
            					->get(),
				'corpofattura' => $corpofattura,
				'ordine' => $ordine,
				'year' => $year,
				'sconto' => $sconto,
				'scontobonus' => $scontobonus
        	]);
        } else {
			return view('errors.403');
		}
    }

    public function getjsontranche(Request $request)
	{
		$tranche = DB::table('tranche')
			->where('id_disposizione', $request->id)
			->get();
			
		foreach($tranche as $tr) {
			if($tr->is_deleted == 0)
				$tranche_return[] = $tr;	
		}
		$this->compilaTranche($tranche_return);
		return json_encode($tranche_return);
	}

	public function compilaTranche(&$tranche)
	{
		foreach($tranche as $tra) {
			if($tra->tipo == 1) {
				$tra->tipo = "Rinnovo";
			} else {
				$tra->tipo = "Pagamento";
			}
			$tra->ente = DB::table('corporations')
				->where('id', $tra->A)
				->first()->nomeazienda;
			// Compilo lo stato emotivo
			$stato = DB::table('statipagamenti')
						->where('id_pagamento', $tra->id)
						->first();
			if($stato) {
				$statoemotivo = DB::table('statiemotivipagamenti')
								->where('id', $stato->id_tipo)
								->first();
						
				$tra->statoemotivo = $statoemotivo->name;
			}
		}
	}

	public function fileupload(Request $request){
	
		Storage::put(
				'images/invoice/' . $request->file('file')->getClientOriginalName(), file_get_contents($request->file('file')->getRealPath())
		);
		
		$nome = $request->file('file')->getClientOriginalName();			
			DB::table('media_files')->insert([
			'name' => $nome,
			'code' => $request->code,
			'master_type' => 3,
			'type'=>$request->user()->dipartimento,
			'master_id' => isset($request->idtranche) ? $request->idtranche : 0,
			'date_time'=>time()
		]);					
	}

	public function fileget(Request $request){
		if(isset($request->quote_id)){
			$updateData = DB::table('media_files')->where('quote_id', $request->quote_id)->get();	
		} else {
			$updateData = DB::table('media_files')->where('code', $request->code)->get();				
		}					
		foreach($updateData as $prev) {
			$imagPath = url('/storage/app/images/invoice/'.$prev->name);
			$titleDescriptions = (!empty($prev->title)) ? '<hr><strong>'.$prev->title.'</strong><p>'.$prev->description.'</p>' : "";			
			$html = '<tr class="quoteFile_'.$prev->id.'"><td><img src="'.$imagPath.'" height="100" width="100"><a class="btn btn-danger pull-right" style="text-decoration: none; color:#fff" onclick="deleteQuoteFile('.$prev->id.')"><i class="fa fa-trash"></i></a>'.$titleDescriptions.'</td></tr>';
			$html .='<tr class="quoteFile_'.$prev->id.'"><td>';

			$utente_file = DB::table('ruolo_utente')->select('*')->where('is_delete', 0)->get();							
			foreach($utente_file as $key => $val){
				if($request->user()->dipartimento == $val->ruolo_id){
					$response = DB::table('media_files')->where('id', $prev->id)->update(array('type' => $val->ruolo_id));	    
					
					$specailcharcters = array("'", "`");
                    $rolname = str_replace($specailcharcters, "", $val->nome_ruolo);
                    $html .=' <div class="cust-checkbox"><input type="checkbox" checked="checked" name="rdUtente_'.$prev->id.'" id="'.$rolname.'_'.$prev->id.'" onchange="updateType('.$val->ruolo_id.','.$prev->id.',this.id);"  value="'.$val->ruolo_id.'" /><label for="'.$rolname.'_'.$prev->id.'"> '.$val->nome_ruolo.'</label><div class="check"><div class="inside"></div></div></div>';
				} else {
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
		echo ($response) ? 'success' : 'fail';		
		exit;
	}


	public function duplicatranche(Request $request)
	{
		if(!checkpermission($this->module, $this->sub_id, 'scrittura')){
    		return redirect('/unauthorized');
    	}

		$tranche = DB::table('tranche')
					->where('id', $request->id)
					->first();
					
		$id = DB::table('tranche')->insertGetId([
            'user_id' => $request->user()->id,
            'id_disposizione' => $tranche->id_disposizione,
			'tipo' => $tranche->tipo,
			// 'datainserimento' => $tranche->datainserimento,
			'datainserimento' => date('Y-m-d',strtotime($tranche->datainserimento)),
			'datascadenza' => $tranche->datascadenza,
			'percentuale' => $tranche->percentuale,
			'dettagli' => $tranche->dettagli,
			'frequenza' => $tranche->frequenza,
			'DA' => $tranche->DA,
			'A' => $tranche->A,
			'idfattura' => $tranche->idfattura,
			'emissione' => $tranche->emissione,
			'indirizzospedizione' => $tranche->indirizzospedizione,
			'privato' => $tranche->privato,
			'base' => $tranche->base,
			'modalita' => $tranche->modalita,
			'iban' => $tranche->iban,
			'peso' => $tranche->peso,
			'netto' => $tranche->netto,
			'scontoaggiuntivo' => $tranche->scontoaggiuntivo,
			'imponibile' => $tranche->imponibile,
			'prezzoiva' => $tranche->prezzoiva,
			'percentualeiva' => $tranche->percentualeiva,
			'dapagare' => $tranche->dapagare,
        ]);
		

		$logs = $this->logmainsection.' -> Copy(Duplicate) Invoice (ID: '. $id . ')';
		storelogs($request->user()->id, $logs);

		$items = DB::table('corpofattura')
            ->where('id_tranche', $request->id)
            ->get();

        foreach($items as $item) {
            DB::table('corpofattura')->insert([
				'id_tranche' => $id,
				'ordine' => $item->ordine,
				'descrizione' => $item->descrizione,
				'qta' => $item->qta,
				'subtotale' => $item->subtotale,
				'scontoagente' => $item->scontoagente,
				'scontobonus' => $item->scontobonus,
				'netto' => $item->netto,
				'percentualeiva' => $item->percentualeiva
			]);
        }

		return Redirect::back()
                       ->with('error_code', 5)
                       ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_duplicatesuccessmsg').' !</div>');
	}


	public function eliminatranche(Request $request)
	{
        DB::table('tranche')
			->where('id', $request->id)
			->update(array(
				'is_deleted' => 1	
		));		

		/*$logs = $this->logmainsection.' -> Delete Invoice -> (ID: '. $request->id . ')';
		storelogs($request->user()->id, $logs);*/

		return Redirect::back()
            ->with('error_code', 5)
            ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_deletesuccessmsg').' !</div>');
	}


	/* =========================  Provisions Functions ========================= */

	public function index(Request $request)
	{
		if(!checkpermission($this->module, $this->sub_id, 'lettura')){
    		return redirect('/unauthorized');
    	}

		if ($request->user()->id === 0 || $request->user()->dipartimento !== 3) {		
			$data = DB::table('projects')
    			->join('users', 'projects.user_id', '=', 'users.id')
    			->join('accountings', 'projects.id', '=', 'accountings.id_progetto')	
    			->select(DB::raw('projects.*, users.id as uid, users.is_delete,accountings.nomeprogetto as groupname,accountings.id as groupid'))
				->where('is_deleted','0')
				->where('users.is_delete', '=', 0)
				->orderBy('projects.id', 'asc')
				->paginate(12);

			$tranche = DB::table('tranche')
				->join('projects', 'projects.id', '=', 'tranche.id_disposizione')
				->select(DB::raw('tranche.*'))
				->where('tranche.is_deleted', 0)
				->where('projects.is_deleted', 0)
				->get();

			$arrDetail = array();
			foreach($tranche as $key => $val) {
				$stato = DB::table('statipagamenti')->where('id_pagamento', $val->id)->first();				
				if($stato) {
					$statoemotivo = DB::table('statiemotivipagamenti')->where('id', $stato->id_tipo)->first();							
					$val->statoemotivo = $statoemotivo->color;
				}	
				$arrDetail[] = $val;
			}

			if ($request->ajax()) {
	            return view('pagamenti.main_ajax', [
	            'progetti' => $this->progetti->forUser2($request->user()), 
				'dipartimenti' => DB::table('departments')->get(),
				'quadri' => DB::table('accountings')->get(),
				'groupdetails'=>$data,
				'invoiceDetails'=>$arrDetail
	            ])->render();  
        	}          
  
            return view('pagamenti.main', [
				'progetti' => $this->progetti->forUser2($request->user()), 
				'dipartimenti' => DB::table('departments')->get(),
				'quadri' => DB::table('accountings')->get(),
				'groupdetails'=>$data,
				'invoiceDetails'=>$arrDetail
			]);

        } else {        	
			return view('errors.403');
		}
	}

	public function getjson(Request $request)
	{
		$pagamenti = $this->pagamenti->forUser($request->user());
		
		//$this->compila($pagamenti);
		return json_encode($pagamenti);
	}

	public function compila(&$pagamenti)
	{
		foreach($pagamenti as $pagamento) {
			$progetto = DB::table('projects')
				->get();
			foreach($progetto as $prog) {
				if($prog->id == $pagamento->id_progetto) {
					$pagamento->id_progetto = $prog->nomeprogetto;
					if($prog->id_ente != null)
						$pagamento->ente = DB::table('corporations')
							->where('id', $prog->id_ente)
							->first()->nomeazienda;
					break;
				}	
			}
		}
	}

	public function creadisposizione(Request $request)
	{
		if(!checkpermission($this->module, $this->sub_id, 'scrittura')){
    		return redirect('/unauthorized');
    	}

		$validator = Validator::make($request->all(), [
            'nomeprogetto' => 'required|max:50',
            'idprogetto' => 'required'
        ]);        
        
        if($validator->fails()) {
            return Redirect::back()
                ->withInput()
                ->with('error_code', 6)
                ->withErrors($validator);
        }
		
		$progetto = DB::table('accountings')->insertGetId([
                        'user_id' => $request->user()->id,
                        'nomeprogetto' => $request->nomeprogetto,
						'id_progetto' => $request->idprogetto,
                      ]);
		
		$logs = $this->logmainsection.' -> Add New Provision -> (ID: '. $progetto . ')';
		storelogs($request->user()->id, $logs);

		return Redirect::back()
            ->with('error_code', 5)
            ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_addsuccessmsg').'!</div>');
	}


	public function modificadisposizione(Request $request, Accounting $accounting)
	{
		$this->authorize('modify', $accounting);
       $validator = Validator::make($request->all(), [
            'nomeprogetto' => 'required|max:50',
        ]);
        
        
        if($validator->fails()) {
            return Redirect::back()
                ->withInput()
                ->with('error_code', 6)
                ->withErrors($validator);
        }
		
        $results = DB::table('accountings')
			->where('id', $accounting->id)
			->update(array(
				'nomeprogetto' => $request->nomeprogetto
				/*'id_progetto' => $request->idprogetto,*/
        	));
        $logs = $this->logmainsection.' -> Update Provision -> (ID: '. $accounting->id . ')';
		storelogs($request->user()->id, $logs);
		return "true";
		/*if($results) {
			return "true";
		}
		else {
			return "false";	
		}*/
		/*return Redirect::back()
                        ->with('error_code', 5)
                        ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_editsuccessmsg').' !</div>');*/
	}

	public function duplicadisposizione(Request $request, Accounting $accounting)
	{
		if(!checkpermission($this->module, $this->sub_id, 'scrittura')){
    		return redirect('/unauthorized');
    	}

		// $this->authorize('duplicate', $accounting);
        
        $did = DB::table('accountings')->insertGetId([
            'user_id' => $request->user()->id,
            'nomeprogetto' => $accounting->nomeprogetto,
			'id_progetto' => $accounting->idprogetto,
        ]);
		
		$logs = $this->logmainsection.' -> Copy(Duplicate) Disposal -> (ID: '. $did . ')';
		storelogs($request->user()->id, $logs);

		return Redirect::back()
            ->with('error_code', 5)
            ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_duplicatesuccessmsg').'!</div>');
	}

	public function destroydisposizione(Request $request, Accounting $accounting)
	{
		if(!checkpermission($this->module, $this->sub_id, 'scrittura')){
    		return redirect('/unauthorized');
    	}

		// $this->authorize('destroy', $accounting);
		
		DB::table('tranche')
			->where('id_disposizione', $accounting->id)
			->delete();
		
		$accounting->delete();
		
		$logs = $this->logmainsection.' -> Delete Disposal -> (ID: '. $accounting->id . ')';
		storelogs($request->user()->id, $logs);

		return Redirect::back()
	        ->with('error_code', 5)
	        ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_deletesuccessmsg').'!</div>');
	}

	public function mostracoordinate(Request $request){
		
		if(!checkpermission($this->module, $this->sub_id, 'lettura')){
    		return redirect('/unauthorized');
    	}

		return view('pagamenti.coordinate');	
	}


	/* =========================  Stat Functions ========================= */

	public function mostrastatistiche(Request $request)
	{
		if(!checkpermission($this->module, $this->sub_id, 'lettura')){
    		return redirect('/unauthorized');
    	}

		$request->year = date('Y');
		return $this->statisticheeconomiche($request);
	}

	public function statisticheeconomiche(Request $request)
	{
		if ($request->user()->id === 0 || $request->user()->dipartimento === 1 || $request->user()->dipartimento === 2) {

			$guadagno = []; $revenues = []; $expenses = [];
			
			$this->compexpense($expenses, $request->year);
			$this->compRevenue($revenues, $request->year);
			$this->calcolaGuadagno($guadagno, $revenues, $expenses);

			$month = array(
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
					''.trans("messages.keyword_december").'' );

			$statistics = array('month' => $month, 'revenue' => $revenues, 'expense' => $expenses, 'earn' => $guadagno);

			return view('statistiche', [
				'statistics' =>$statistics,
				'year' => $request->year
			]);

		} else
			return redirect('/unauthorized');
	}

	public function compexpense(&$expenses, $year)
	{
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

	/*public function query($month, $year){	
	
		$timestamp=strtotime('1-'.$month.'-'.$year);;
		$expenses = DB::table('costi')
		->selectRaw("sum(costo) as cost")
		->whereBetween('datainserimento',[date('Y-m-01',$timestamp),date('Y-m-t',$timestamp)])
		->first();
	
		//echo($expenses->cost);
		
		/*$expenses_array = [];
		foreach($expenses as $expense) {
			$expense_month = date('m',strtotime($expense->datainserimento));			
			$expense_year = date('Y',strtotime($expense->datainserimento));			
			if($expense_month== $month&& $expense_year == $year)
				$expenses_array[] = $expense->costo;
		}
		
		return ($expenses->cost!=null)?$expenses->cost:0;
	}

	public function calcola($expenses)
	{				
		$totale = 0;
		for($i = 0; $i < count($expenses); $i++)
			$totale += $expenses[$i];

		return $totale;	
	}
	*/	

	public function compRevenue(&$revenues, $year)
	{
		DB::connection()->enableQueryLog();
		for($i = 1; $i <= 12; $i++) {
			if($i < 10)
				$i = '0' . $i;
		$timestamp=strtotime('1-'.$i.'-'.$year);;
		$revenue = DB::table('tranche')
		->Join('users', 'users.id', '=', 'tranche.user_id')
		->selectRaw("sum(imponibile) as cost,dipartimento ")
		->where('privato', 0)
		//->where('dipartimento', 2)
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
		// dd($revenues);
	}

	/*public function queryrevenues($month, $year)
	{
		$revenues = DB::table('tranche')
		
		->where('privato', 0)->get();
		$utenti = DB::table('users')->get();
		$revenues_array = [];

		foreach($revenues as $revenue) {
			$revenue_month= date('m',strtotime($revenue->datainserimento));
			$revenue_year = date('Y',strtotime($revenue->datainserimento));

			// Check if the one who made the tranche is a commercial one,
			// If yes, then I have to count the revenue as a expense (-)
			for($i = 0; $i < count($utenti); $i++) {
				if($utenti[$i]->id == $revenue->user_id) {
					if($utenti[$i]->dipartimento === 2) {
						$revenue->imponibile *= -1;
					}
					break;	
				}	
			}
			if($revenue_month== $month&& $revenue_year == $year)
				$revenues_array[] = $revenue->imponibile;
		}
		return $revenues_array;
	}

	public function calcolarevenues($expenses)
	{
		$totale = 0;
		for($i = 0; $i < count($expenses); $i++)
			$totale += $expenses[$i];
		return $totale;	
	}
	*/
	public function calcolaGuadagno(&$guadagno, $revenues, $expenses)
	{		
		foreach($revenues as $key=>$val) {
			$guadagno[] = $val + $expenses[$key];
		}	
	}


	// ==================  Start Date Range ======================= // 

	public function statisticheeconomichedate(Request $request)
	{

		if ($request->user()->id === 0 || $request->user()->dipartimento === 1 || $request->user()->dipartimento === 2) {

			$guadagno = []; $revenues = [];	$expenses = [];
			$spece_date = []; $revenues_date = []; $guadagno_date = [];

			$month = array(
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
				''.trans("messages.keyword_december").'' );

			// $month = array("1" => "Jan", "2" => "Feb", "3" => "Mar", "4" => "Apr", "5" => "May", "6" => "Jun" , "7" => "July", "8" => "Aug", "9" => "Sep", "10" => "Oct", "11" => "Nov", "12" => "Dec");

			$this->compexpenseDate($expenses, $request->startDate, $request->endDate, $spece_date);
			$this->compRevenueDate($revenues, $request->startDate, $request->endDate, $revenues_date);
			$this->calcolaGuadagnoDate($guadagno, $revenues_date, $spece_date, $guadagno_date);

			if($guadagno_date) {
				foreach ($guadagno_date as $key => $value) {

					if(array_key_exists($key, $revenues_date)){
						$revenues_date[$key] =  $revenues_date[$key];
						$revenue[] =  $revenues_date[$key];
					} else {
						$revenues_date[$key] = 0; $revenue[] = 0;
					}
					if(array_key_exists($key, $spece_date)){					
						$spece_date[$key] =  $spece_date[$key];
						$expense[] =  $spece_date[$key];
					} else {
						$spece_date[$key] = 0; $expense[] = 0;
					}

					$year = substr($key, 0, 4);
					$mon = substr($key, 5, 2);		

					for ($i=1; $i <=12 ; $i++) {						
						if($mon == $i){ $date_month[] = $month[$i-1]." / ".$year; }
					}					
					ksort($spece_date); ksort($revenues_date);
					$earn[] = $value;		
				}
				$statistics = array('month' => $date_month, 'revenue' => $revenue, 'expense' => $expense, 'earn' => $earn);
				unset($guadagno); unset($revenues); unset($expenses);
				unset($spece_date); unset($revenues_date); unset($guadagno_date);	

			} else {
							
				$fromdate = $request->startDate;
				$monFrom = substr($fromdate, 5, 1);				
				$year = substr($fromdate, 0, 4);

				$todate = $request->endDate;
				$monTo = substr($todate, 5, 1);
				
				for ($i=0; $i <12 ; $i++) {		
					if($monFrom == $i){ 
						$date_month[] = $month[$i-1]." / ".$year; 
						if($monFrom < $monTo){ $monFrom++; }
					}										
				}

				for ($i=0; $i < count($date_month) ; $i++) { 
					$revenue[] = 0; $expense[] = 0; $earn[] = 0;
				}
				
				$statistics = array('month' => $date_month, 'revenue' => $revenue, 'expense' => $expense, 'earn' => $earn);				
			}		
			return view('statistics-date', [
				'statistics' => $statistics,
				'year' => date("Y")
			]);
		} else
			return redirect('/unauthorized');
	}

	public function compexpenseDate(&$expenses, $startDate, $endDate, &$spece_date)
	{	
		$spece_date = $this->queryDate($startDate, $endDate);
		$expenses = [];

		foreach ($spece_date as $key => $value) {			
			$expenses[] = $value;
		}	
	}

	public function queryDate($startDate, $endDate)
	{			
		$expenses = DB::table('costi')
			->whereBetween('datainserimento', [$startDate, $endDate])
			->orderBy('datainserimento')->get();

		$sMonth = date("m", strtotime($startDate));
		$eMonth = date("m", strtotime($endDate));

		// if($expenses){

		// 	$expenses_array = []; $month= [];
		// 	for ($i=$sMonth; $i<=$eMonth; $i++) { 
		// 		echo $i. " ";
		// 	}

		// 	foreach($expenses as $expense) {				
		// 		$expense_month= date("m", strtotime($expense->datainserimento));
		// 		echo "month".$expense_month." ";

		// 		$month[] = $expense_month;
		// 	}

		// } else {
		// 	return $expenses_array = [];
		// }

		if($expenses){

			$expenses_array = []; $month= [];

			foreach($expenses as $expense) {

				$expense_month= substr($expense->datainserimento, 0, 7);

				if(in_array($expense_month, $month)){
					$expenses_array[$expense_month] += floatval($expense->costo);			
				} else {
					$expenses_array[$expense_month] = floatval($expense->costo);
				}

				$month[] = $expense_month;			
			}

			// dd($expenses_array);
			unset($month);
			return $expenses_array;

		} else {
			return $expenses_array = [];
		}
		
	}
	
	public function compRevenueDate(&$revenues, $startDate, $endDate, &$revenues_date)
	{		
		$revenues_date =$this->queryrevenuesDate($startDate, $endDate);
		$revenues = [];

		foreach ($revenues_date as $value) {
			$revenues[] = $value;	
		}	
	}

	public function queryrevenuesDate($startDate, $endDate)
	{
		$revenues = DB::table('tranche')
			->whereBetween('datainserimento', [$startDate, $endDate])
			->where('privato', 0)->orderBy('datainserimento')->get();

		$revenues_array = []; $month= [];

		$utenti = DB::table('users')->get();

		foreach($revenues as $revenue) {			

			for($i = 0; $i < count($utenti); $i++) {
				if($utenti[$i]->id == $revenue->user_id) {					
					if($utenti[$i]->dipartimento === 2) {
						$revenue->imponibile *= -1;
					}
					break;	
				}	
			}

			$revenues_month= substr($revenue->datainserimento, 0, 7);

			if(in_array($revenues_month, $month)){
				$revenues_array[$revenues_month] += floatval($revenue->imponibile);
			} else {
				$revenues_array[$revenues_month] = floatval($revenue->imponibile);
			}

			$month[] = $revenues_month;	
		}		
		unset($month);
		return $revenues_array;
	}

	public function calcolaGuadagnoDate(&$guadagno, $revenues_date, $spece_date, &$guadagno_date)
	{	
		if(count($spece_date) > count($revenues_date) || count($spece_date) == count($revenues_date)){
			
			if(count($spece_date) !=0 || count($revenues_date) !=0 ){	
				foreach ($spece_date as $spece_key => $spece_value) {	
					if(array_key_exists($spece_key, $revenues_date)){					
						$earn[$spece_key] =  $spece_value + $revenues_date[$spece_key];
					} else {
						$earn[$spece_key] = $spece_value;
					}						
				}

				$revenues = array_diff_key($revenues_date, $earn);
				$guadagno_date = array_merge($earn, $revenues);

			} else {
				$earn = [];
			}

		} else if(count($spece_date) < count($revenues_date)){
			foreach ($revenues_date as $revenues_key => $revenues_value) {	

				if(array_key_exists($revenues_key, $spece_date)){					
					$earn[$revenues_key] =  $revenues_value + $spece_date[$revenues_key];
				} else {
					$earn[$revenues_key] = $revenues_value;
				}						
			}

			$expenses = array_diff_key($spece_date, $earn);
			$guadagno_date = array_merge($earn, $expenses);

		} else {
			$earn = [];
		}
		
		foreach ($guadagno_date as $value) {
			$guadagno[] = $value;
		}
	}

	// ==================  End Date Range ======================= // 


	public function getjsoncosti(Request $request)
	{
		$costi = DB::table('costi')->get();
		$costi = $this->aggiungiNomeEnte($costi, $request->user());
		return json_encode($costi);
	}

	public function aggiungiNomeEnte(&$costi, $user)
	{
		$elenco_costi = [];
		foreach($costi as $costo) {
			$ente = DB::table('corporations')
							->where('id', $costo->id_ente)
							->first();
			$costo->ente = $ente->nomeazienda;
			if ($user->id === 0 || $user->dipartimento === 1) {
				$elenco_costi[] = $costo;
			} else if($user->id == $tra->user_id) {
				$elenco_costi[] = $costo;	
			}
		}
		return $elenco_costi;
	}

	public function modificacosto(Request $request)
	{
		$costo = DB::table('costi')
					->where('id', $request->id)
					->first();
		return view('modificacosto', [
			'costo' => $costo,
			'enti' => DB::table('corporations')->get()
		]);	
	}

	public function aggiornacosto(Request $request)
	{		
		if(!checkpermission($this->module, $this->sub_id, 'scrittura')){
    		return redirect('/unauthorized');
    	}

		$validator = Validator::make($request->all(), [
			'oggetto' => 'required',
			'costo' => 'required',
			'datainserimento' => 'required'
		]);
		
		if($validator->fails()) {
			return Redirect::back()
				->withInput()
				->withErrors($validator);
		}

		DB::table('costi')
			->where('id', $request->id)
			->update(array(
				'oggetto' => $request->oggetto,
				'costo' => $request->costo,
				'datainserimento' => $request->datainserimento,
				'id_ente' => $request->ente
			));
		return Redirect::back()
			->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_editsuccessmsg').'!</div>');
	}

	public function destroycosto(Request $request)
	{
		if(!checkpermission($this->module, $this->sub_id, 'scrittura')){
    		return redirect('/unauthorized');
    	}

		DB::table('costi')
			->where('id', $request->id)
			->delete();

		return Redirect::back()
			->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_deletesuccessmsg').'!</div>');
	}
}
