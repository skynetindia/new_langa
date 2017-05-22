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

class AccountingController extends Controller
{
    protected $pagamenti;
	protected $progetti;
    
    public function __construct(AccountingRepository $accountings, ProjectRepository $projects)
    {
        $this->middleware('auth');
        $this->pagamenti = $accountings;
		$this->progetti = $projects;
		
    }
	
	
	public function elencotranche(Request $request)
	{
		if ($request->user()->id === 0 || $request->user()->dipartimento === "AMMINISTRAZIONE")
			return view('pagamenti.elencotranche');
		else
			return redirect('/unauthorized');
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
						
				$tra->statoemotivo = $statoemotivo->name;
			}
			if ($user->id === 0 || $user->dipartimento === "AMMINISTRAZIONE") {
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
			'utenti' => DB::table('users')
							->get(),
			'enti' => DB::table('corporations')
							->orderBy('id', 'asc')
							->get(),
			'statiemotivi' => DB::table('statiemotivipagamenti')
				->get(),
			'statoemotivoselezionato' => DB::table('statipagamenti')
				->where('id_pagamento', $tranche->id)
				->first(),
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

		$pdf = new FPDF('P', 'mm', 'A4');
		$pdf->AddPage();
		$pdf->AddFont('Nexa', '', 'NexaLight.php');
		$pdf->AddFont('Nexa', 'B', 'NexaBold.php');
		
		// Stampo lo scheletro della fattura
		$pdf->Image('http://easy.langa.tv/public/images/PDF/FATTURA.png',0,0,210,297,'PNG');
		
		/**
		 * Stampo il logo dell'ente di chi ha fatto la fattura (DA)
		 */ 
		
		$ente_DA = DB::table('corporations')
					->where('id', $tranche->DA)
					->first();
					
		$disposizione = DB::table('accountings')
							->where('id', $tranche->id_disposizione)
							->first();

		$pdf->SetTitle($tranche->idfattura . '_' . $disposizione->nomeprogetto . '_LANGA Group');
		
		// Stampo il logo
		$logo = 'http://easy.langa.tv/storage/app/images' . '/' . $ente_DA->logo;
		if(substr($logo, -3) == "png")
			$estensione = "PNG";
		else if(substr($logo, -3) == "jpg")
			$estensione = "JPG";
		else
			$estensione = "JPEG";
		$pdf->Image($logo, 10, 7.5, 20, 20, $estensione);
		/**
		 * Stampo la sede legale dell'ente (DA)
		 */
		// Stampo la sede legale dell'ente DA
		
		$this->stampaTesto($pdf, 140, 10, $ente_DA->sedelegale, 58, 'R', 3, 'Nexa', '', 8);
		/**
		 * Stampo il tipo di fattura, l'emissione, la base
		 */
		if($tranche->tipofattura == 0) {
			$tipofattura = "FATTURA DI VENDITA";
		} else {
			$tipofattura = "NOTA DI CREDITO";
		}
		// Stampo il tipofattura
		$this->stampatesto($pdf, 10, 33.5, $tipofattura, 27, 'L', 1, 'Nexa', '', 8);
		// Stampo l'id della fattura
		$this->stampatesto($pdf, 39, 33.5, $tranche->idfattura, 17, 'L', 1, 'Nexa', 'B', 7.75);
		// Stampo l'emissione
		$this->stampatesto($pdf, 56, 33.5, "EMISSIONE DEL", 180, 'L', 1, 'Nexa', '', 8);
		$this->stampatesto($pdf, 78, 33.5, $tranche->emissione, 34, 'L', 1, 'Nexa', 'B', 7.75);
		// Stampo su base
		$this->stampatesto($pdf, 96, 33.5, "SU BASE", 12, 'L', 1, 'Nexa', '', 8);
		$this->stampatesto($pdf, 110, 33.5, $tranche->base, 80, 'L', 1, 'Nexa', 'B', 7.75);
		/**
		 * Stampo la sede legale del cliente (A) e l'indirizzo di spedizione (A)
		 */
		$ente_A = DB::table('corporations')
					->where('id', $tranche->A)
					->first();
		// Stampo la sede legale (A)
		$this->stampatesto($pdf, 11, 47.5, $ente_A->sedelegale, 90, 'L', 2.5, 'Nexa', '', 8);
		// Stampo lindirizzo di spedizione (A)
		$this->stampatesto($pdf, 104.5, 47.5, $tranche->indirizzospedizione, 90, 'L', 1, 'Nexa', '', 8);
		/**
		 * Stampo la modalità, la scadenza di disposizione, l'iban e la % del laovoro
		 */
		// Stampo la modalita
		$this->stampatesto($pdf, 34, 71.5, $tranche->modalita, 35, 'C', 1, 'Nexa', 'B', 7.75);
		// Stampo la scadenza di disposizione
		$pdf->SetTextColor(243, 127, 13);
		$this->stampatesto($pdf, 101, 71.5, $tranche->datascadenza, 35, 'L', 1, 'Nexa', 'B', 7.75);
		$pdf->SetTextColor(0, 0, 0);
		// Stampo l'iban
		$this->stampatesto($pdf, 148, 71.5, $tranche->iban, 50, 'L', 1, 'Nexa', 'B', 7.75);
		// Stampo la % della fattura
		if($tranche->percentuale == 0) {
			$this->stampatesto($pdf, 33, 76.5, "FATTURA RELATIVA A TRANCHE CONCORDATA DI EURO ", 30, 'C', 1, 'Nexa', '', 7.75);
			$this->stampatesto($pdf, 82.5, 76.5, $tranche->testoimporto, 16, 'C', 1, 'Nexa', 'B', 7.75);
		} else {
			$this->stampatesto($pdf, 20, 76.5, "FATTURA SUL TOTALE LAVORO DEL ", 30, 'C', 1, 'Nexa', '', 7.75);
			$this->stampatesto($pdf, 56, 76.5, $tranche->percentuale . '%', 16, 'C', 1, 'Nexa', 'B', 7.75);
		}
		// Se è un rinnovo stampo 'Rinnovo per &n giorni da data emissione'
		if($tranche->tipo == 1) {
			$this->stampatesto($pdf, 147, 76.5, "RINNOVO PER " . $tranche->frequenza . " GIORNI DA DATA EMISSIONE", 40, 'C', 1, 'Nexa', '', 7.75);
		}
		/**
		 * Stampo il corpo della fattura
		 */
		$corpofattura = json_decode(json_encode(DB::table('corpofattura')
							->where('id_tranche', $idtranche)
							->orderBy('ordine_numerico', 'asc')
							->get()), true);

		// Ascisse per gli elementi del corpo fattura
		$posizioni_x = array(
			0 => 11,
			1 => 26,
			2 => 123,
			3 => 133,
			4 => 151,
			5 => 169,
			6 => 187
		);
		// 'Larghezza' del campo di un elemento di un corpo fattura a partire dalla fine dell'elemento precedente
		$larghezza = array(
			0 => 14,
			1 => 95,
			2 => 9,
			3 => 17,
			4 => 17,
			5 => 17,
			6 => 17
		);
		$index = array(
			'ordine',
			'descrizione',
			'qta',
			'subtotale',
			'scontoagente',
			'netto',
			'percentualeiva'
		);
		// Elimino i campi che hanno qt, prezzo, %sconto, netto o %iva a 0
		for($i = 0; $i < count($corpofattura); $i++) {
			for($k = 2; $k < count($index); $k++) {
				if($corpofattura[$i][$index[$k]] == 0) {
					$corpofattura[$i][$index[$k]] = "";
				}
			}
		}
		for($i = 0; $i < count($corpofattura); $i++) {
			for($k = 0; $k < count($posizioni_x); $k++) {
				if($index[$k] =="descrizione") {
					$this->stampatesto($pdf, $posizioni_x[$k], 90.5 + $i * 10, $corpofattura[$i][$index[$k]], $larghezza[$k], 'L', 3, 'Nexa', '', 7);	
				} else {
					$this->stampatesto($pdf, $posizioni_x[$k], 90.5 + $i * 10, $corpofattura[$i][$index[$k]], $larghezza[$k], 'L', 1, 'Nexa', '', 7);
				}
			}
		}
		/**
		 * Stampo la base della fattura
		 */
		$pdf->SetAutoPageBreak(false);
		if($tranche->peso == 0) $tranche->peso = "";
		if($tranche->netto == 0) $tranche->netto = "";
		if($tranche->scontoaggiuntivo == 0) $tranche->scontoaggiuntivo = "";
		if($tranche->imponibile == 0) $tranche->imponibile = "";
		if($tranche->prezzoiva == 0) $tranche->prezzoiva = "";
		if($tranche->percentualeiva == 0) $tranche->percentualeiva = "";
		if($tranche->dapagare == 0) $tranche->dapagare = "";
		$this->stampatesto($pdf, 11, -13, $tranche->peso, 24, 'L', 1, 'Nexa', '', 7);
		$this->stampatesto($pdf, 34, -13, $tranche->netto, 24, 'L', 1, 'Nexa', '', 7);
		$this->stampatesto($pdf, 67, -13, $tranche->scontoaggiuntivo, 24, 'L', 1, 'Nexa', '', 7);
		$this->stampatesto($pdf, 99, -13, $tranche->imponibile, 24, 'L', 1, 'Nexa', '', 7);
		$this->stampatesto($pdf, 122, -13, $tranche->prezzoiva, 24, 'L', 1, 'Nexa', '', 7);
		$this->stampatesto($pdf, 137, -13, $tranche->percentualeiva, 24, 'L', 1, 'Nexa', '', 7);
		$this->stampatesto($pdf, 178, -13, $tranche->dapagare, 24, 'L', 1, 'Nexa', 'B', 8);
		$id_perfile = substr($tranche->idfattura, 0, 5) . '-' . substr($tranche->idfattura, 6);
		$pdf->Output($id_perfile . '_' . $disposizione->nomeprogetto . '_LANGA Group' . '.pdf', 'I');
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
		if ($user->id === 0 || $user->dipartimento === "AMMINISTRAZIONE") {
            return true;
    	}
    	return $accounting->user_id === $user->id;
	}

	public function aggiornatranche(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'datainserimento' => 'required',
			'datascadenza' => 'required',
			'percentuale' => 'required',
			'dettagli' => 'max:1000',
			'DA' => 'max:1000',
			'A' => 'max:1000',
			'idfattura' => 'max:30',
			'indirizzospedizione' => 'max:1000',
			'base' => 'max:100',
			'modalita' => 'max:100',
			'iban' => 'max:100',
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
                        ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Non ti è permesso imporre uno sconto agente maggiore a ' . $scontoagente_max . '</h4></div>');
				} else if($scontobonus[$i] > $scontobonus_max) {
					return Redirect::back()
						->withInput()
                        ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Non ti è permesso imporre uno sconto bonus maggiore a ' . $scontobonus_max . '</h4></div>');	
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
		
		DB::table('tranche')
			->where('id', $request->id)
			->update(array(
            	'user_id' => $request->user()->id,
				'tipo' => $request->tipo,
				'datainserimento' => $request->datainserimento,
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
			$scontoagente = $request->scontoagente;
			$prezzonetto = $request->prezzonetto;
			$iva = $request->iva;
			for($i = 0; $i < count($ordine); $i++) {
				DB::table('corpofattura')->insert([
					'id_tranche' => $request->id,
					'ordine' => $ordine[$i],
					'descrizione' => $descrizione[$i],
					'qta' => $qt[$i],
					'subtotale' => $subtotale[$i],
					'scontoagente' => $scontoagente[$i],
					'netto' => $prezzonetto[$i],
					'percentualeiva' => $iva[$i],
				]);
			}
		}
					  
		return redirect('/pagamenti/mostra/accounting/' . $iddisposizione->id_disposizione)
                        ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Disposizione modificata correttamente!</h4></div>');
	}
	
}
