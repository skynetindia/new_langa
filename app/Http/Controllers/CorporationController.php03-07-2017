<?php

namespace App\Http\Controllers;

use DB;
use Storage;
use App\Corporation;
use Redirect;
use App\Repositories\CorporationRepository;
use Validator;
use Illuminate\Http\Request;
use Mail;
use App\Http\Controllers\Controller;

class CorporationController extends Controller
{
	protected $corporations;
	protected $chiave;
	protected $stato;
	protected $logmainsection;

	protected $module;
	protected $sub_id;
	
    public function __construct(CorporationRepository $corporations) {
        $this->middleware('auth');
        $this->corporations = $corporations;
		$this->logmainsection = 'Entity';

		$request = parse_url($_SERVER['REQUEST_URI']);
		$path = ($_SERVER['HTTP_HOST'] == 'localhost') ? rtrim(str_replace('/easylanganew/', '', $request["path"]), '/') : $request["path"];		
		$result = rtrim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $path), '/');
		$current_module = DB::select('select * from modulo where TRIM(BOTH "/" FROM modulo_link) = :link', ['link' => $result]);  
    	
        $this->module = (isset($current_module[0]->modulo_sub)) ? $current_module[0]->modulo_sub : 1;
        $this->sub_id = (isset($current_module[0]->id)) ? $current_module[0]->id : 12;
    }
	
	public function aggiornastatocliente(Request $request) {
		if($request->cliente == 0) {
			$ente = DB::table('corporations')
				->where('id', $request->id)
				->first();
				
			DB::table('corporations')
				->where('id', $request->id)
				->update(array(
					'id_cliente' => 0
			));
			DB::table('clienti')
				->where('id', $ente->id_cliente)
				->delete();
		}
		return Redirect::back();
	}	

	/**
	 * Crea una nuovo cliente partendo da un ente
	 * Le credenziali sono inviate via email all'ente
	 */
  public function newclient(Request $request, Corporation $corporation) {

  	if($request->user()->id == 0 ||
  		 $request->user()->dipartimento == 1) {
		  $password = substr(str_shuffle("abcdefghilmnopqrstuvz1234567890"), 0, 7);
		  $count = DB::table('clienti')->where('email',$corporation->email)->orWhere('name',$corporation->nomereferente)->count();
		  if($count == '0'){
			  $user = DB::table('clienti')
				->insertGetId([
					'name' => $corporation->nomeazienda,
					'id_ente' => $corporation->id,
					'email' => $corporation->email,
					'password' => bcrypt($password)				
			  	]);

				DB::table('users')->insert([
					'name' => $corporation->nomeazienda,
					'password' => bcrypt($password),
					'dipartimento' => 5,
					'email' => $corporation->email,
					'id_ente' => $corporation->id
			  ]);
			  
			  DB::table('corporations')
				->where('id', $corporation->id)
				->update(array(
					'id_cliente' => $user	
			  ));  

			$logs = $this->logmainsection.' -> Generate new client for entity -> ( Entity ID: '. $corporation->id . ' Client ID '. $user .')';
			storelogs($request->user()->id, $logs);

			  /*Mail::send('nuovocliente', ['nome' => $corporation->nomereferente, 'email' => $corporation->email, 'password' => $password], function ($m) use ($request, $corporation) {
				$m->from($request->user()->email, 'Easy LANGA');
				$subject = trans('messages.keyword_credentials_for_langa_client_panel');
				$m->to($corporation->email, $corporation->email)->subject($subject);
				$m->cc("amministrazione@langa.tv");
			  });*/
	  		  return Redirect::back()->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_client_created_send_credentials').'</div>');
		 }
		 else {
		    return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_client_already_exist').'</div>');

		 }

  	} 
	else {
  		return Redirect::back();
  	}
  }
	
	
	public function getjson(Request $request) {
		$enti = $this->corporations->forUser2($request->user());
		//$this->compilaStatiEmotivi($enti);
		//$this->compilaTipi($enti);
		return json_encode($enti);
	}
	
	// Mostra tutti gli enti
	public function show(Request $request)
	{
		return view('corporation', [
                'tabellatipi' => DB::table('masterdatatypes')->get(),
                'tabellastatiemotivi' => DB::table('statiemotivitipi')->get(),
				'loginuser' => $request->user(),
        ]);
	}
	
	// My enti : 11-05-2017
    public function myenti(Request $request) {

    	if(!checkpermission($this->module, $this->sub_id, 'lettura')){
    		return redirect('/unauthorized');
    	}

    	return view('corporation', [
            'tabellatipi' => DB::table('masterdatatypes')->get(),
            'tabellastatiemotivi' => DB::table('statiemotivitipi')->get(),
			'loginuser' => $request->user(),
			'miei' => 1,
        ]);
    }

	// Get json entity data : 11-05-2017
	public function getJsonMyenti(Request $request) {
		$enti = $this->corporations->forUser($request->user());		
		//$this->compilaStatiEmotivi($enti);
		//$this->compilaTipi($enti);
		return json_encode($enti);
	}

	public function duplicate(Request $request, Corporation $corporation) {

		if(!checkpermission($this->module, $this->sub_id, 'scrittura')){
    		return redirect('/unauthorized');
    	}

		// $this->authorize('duplicate', $corporation);
		// Duplica ente

		// $request->user()->corporations()->create([
		$corp =  DB::table('corporations')->insertGetId([ 
            'nomeazienda' => $corporation->nomeazienda,
            'statoemotivo' => $corporation->statoemotivo,
            'nomereferente' => $corporation->nomereferente,
            'settore' => $corporation->settore,
            'piva' => $corporation->piva,
            'cf' => $corporation->cf,
            'telefonoazienda' => $corporation->telefonoazienda,
			'sedelegale' => $corporation->sedelegale,
			'indirizzospedizione' => $corporation->indirizzospedizione,
            'cellulareazienda' => $corporation->cellulareazienda,
			'emailsecondaria' => $corporation->emailsecondaria,
            'fax' => $corporation->fax,
            'logo' => $corporation->logo,
            'email' => $corporation->email,
            'iban' => $corporation->iban,
            'noteenti' => $corporation->noteenti,
            'indirizzo' => $corporation->indirizzo,
			'responsabilelanga' => $corporation->responsabilelanga,
			'telefonoresponsabile' => $corporation->telefonoresponsabile,
        ]);

		$logs = $this->logmainsection.' -> Copy(Duplicate) Entity -> (ID: '. $corp . ')';
		storelogs($request->user()->id, $logs);

        return Redirect::back()->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_entity_duplicate_successfully').'</div>');
	
        }
	
	public function update(Request $request, Corporation $corporation) {

		if(!checkpermission($this->module, $this->sub_id, 'scrittura')){
    		return redirect('/unauthorized');
    	}

		$this->validate($request, [
            'nomeazienda' => 'required|max:35',
            'nomereferente' => 'required|max:35',
            'settore' => 'max:50',
            'piva' => 'max:11',
            'cf' => 'max:16',
            'telefonoazienda' => 'required|max:25',
            'cellulareazienda' => 'max:25',
			'emailsecondaria' => 'max:64',
            'fax' => 'max:35',
			'sedelegale' => 'max:1000',
			'indirizzospedizione' => 'max:1000',
            'email' => 'required|max:64',
            /*'indirizzo' => 'required',*/
            'noteenti' => 'max:255',
            'iban' => 'max:64',
            'statoemotivo' => 'max:64',
			'responsabilelanga' => 'required',
			'logo'=>'mimes:jpeg,jpg,png|max:1000',
			/*'telefonoresponsabile' => 'required|max:35',*/
        ]);
        $nome = "";
		$logo = DB::table('corporations')
                        ->select('logo')
                        ->where('id', $corporation->id)
                        ->first();
                $arr = json_decode(json_encode($logo), true);
                $nome = $arr['logo'];
		if($request->logo!=null) {
            $nome = time() . uniqid() . '-' . '-ente.' . pathinfo($request->file('logo')->getClientOriginalName(), PATHINFO_EXTENSION);

           Storage::put('images/'.$nome,file_get_contents($request->file('logo')->getRealPath()));
		}

		if($request->cliente == 0) {
			DB::table('clienti')
				->where('id', $corporation->id_cliente)
				->delete();	
			DB::table('corporations')
				->where('id', $corporation->id)
				->update(array(
					'id_cliente' => 0
				));
		}
		
		DB::table('corporations')
			->where('id', $corporation->id)
			->update(array(
				'nomeazienda' => $request->nomeazienda,
				'statoemotivo' => $request->statoemotivo,
				'nomereferente' => $request->nomereferente,
				'settore' => $request->settore,
				'piva' => $request->piva,
				'cf' => $request->cf,
				'sedelegale' => $request->sedelegale,
				'indirizzospedizione' => $request->indirizzospedizione,
				'telefonoazienda' => $request->telefonoazienda,
				'cellulareazienda' => $request->cellulareazienda,
				'emailsecondaria' => $request->emailsecondaria,
				/*'privato' => $request->privato,*/
				'fax' => $request->fax,
				'email' => $request->email,
				'logo' => $nome,
				'iban' => $request->iban,
				'swift'=>$request->swift,
				/*'noteenti' => $request->noteenti,*/
				'indirizzo' => $request->indirizzo,
				'responsabilelanga' => $request->responsabilelanga,
				'telefonoresponsabile' => $request->telefonoresponsabile,
				'skype_id'=>$request->skype_id,
			));
		
		$logs =  $this->logmainsection.' -> Update Entity (ID: '. $corporation->id . ')';
		storelogs($request->user()->id, $logs);

		DB::table('enti_partecipanti')->where(
			'id_ente', $corporation->id
		)
			->delete();
		
		// Memorizza i partecipanti al progetto
        if(isset($request->partecipanti)) {			
			$options = $request->partecipanti;
			$partecipantiNotifiche = $request->partecipantiNotifiche;
			/*echo count($options);
			print_r($options);
			print_r($partecipantiNotifiche);
			exit;*/
			//$partecipantiNotifiche[$i] = isset($partecipantiNotifiche[$i]) ? $partecipantiNotifiche[$i] : '0';
			for($i = 0; $i < count($options); $i++) {
				$notifiche = isset($partecipantiNotifiche[$options[$i]]) ? $partecipantiNotifiche[$options[$i]] : '0';
				//$partecipantiNotifiche = $request->partecipantiNotifiche.$options[$i]
				//$partecipantiNotifiche = isset() ? $request->partecipantiNotifiche.$options[$i] : '';
				DB::table('enti_partecipanti')->insert([
					'id_ente' => $corporation->id,
					'id_user' => $options[$i],
					'notifiche'=> $notifiche, 					
				]);
			}
		}
		
		/*DB::table('corporationtypes')->where(
			'id_ente', $corporation->id
		)->delete();*/
		
		// Memorizza i tipi
		/*if(isset($request->tipi)) {
			$options = $request->tipi;
			for($i = 0; $i < count($options); $i++) {
				// echo $options[$i];
				// select id from masterdatatypes where name = $options[$i] 
				// and insert into corporationtypes(id_tipo, id_ente)
				// VALUES(id preso da masterdatatypes,Corporation->id)
				$tipo = DB::table('masterdatatypes')
					->where('name', $options[$i])
					->first();
				DB::table('corporationtypes')->insert([
					'id_tipo' => $tipo->id,
					'id_ente' => $corporation->id,
				]);
			}
		}*/

		/*
		Appunti = ric
		Ricontattare il giorno = ricontattare
		Alle = alle
		Data inserimento = datainserimento
		*/
        if(isset($request->ric)) {
			$appunti = $request->ric;

			$utente = $request->utente;
			/*$utente = $request->user()->id;*/
			/*$ricontattare = $request->ricontattare;
			$alle = $request->alle;
			$datainserimento = $request->datainserimento;*/
			$datainserimento = $request->datepicker_to;
			/*$da_data = $request->datepicker_from;*/
			$banca = $request->banca;
			$cassa = $request->cassa;
			$notifiche = $request->notifiche;
			
			DB::table('messages')->where('id_ente', $corporation->id)->delete();
			for($i = 0; $i < count($appunti); $i++) {
				$frequenza = $request->frequenza;
				DB::table('messages')->insert([
					'id_ente' => $corporation->id,
					'id_utente' =>$utente[$i],
					'appunti' => $appunti[$i],
					/*'ricontattare' => $ricontattare[$i],
					'ora' => $alle[$i],*/
					'datainserimento' => $datainserimento[$i],
					/*'da_data' => $da_data[$i],*/
					'banca' => $banca[$i],
					'cassa' => $cassa[$i],
					'frequenza' => isset($frequenza[$i]) ? $frequenza[$i] : "0",
					'notifiche' => isset($notifiche[$i]) ? $notifiche[$i] : '0',
				]);
			}
		} else {
			DB::table('messages')
					->where('id_ente', $corporation->id)
					->delete();	
		}
		
		/*if(isset($request->oggettocosto)) {
			$appunti = $request->oggettocosto;
			$ricontattare = $request->costi;
			$alle = $request->datainserimentocosto;
			DB::table('costi')
					->where('id_ente', $corporation->id)
					->delete();
			for($i = 0; $i < count($appunti); $i++) {
				DB::table('costi')->insert([
					'id_ente' => $corporation->id,
					'oggetto' => $appunti[$i],
					'costo' => $ricontattare[$i],
					'datainserimento' => $alle[$i],
				]);
			}
		} else {
			DB::table('costi')
					->where('id_ente', $corporation->id)
					->delete();
		}*/

		if($request->statoemotivo!=null) {
			// Aggiorno lo stato emotivo
			$tipo = DB::table('statiemotivitipi')
				->where('name', $request->statoemotivo)
				->first();
			DB::table('statiemotivi')
				->where('id_ente', $corporation->id)
				->delete();
			DB::table('statiemotivi')
				->insert([
					'id_tipo' => $tipo->id,
					'id_ente' => $corporation->id
				]);
		} else {
			DB::table('statiemotivi')
				->where('id_ente', $corporation->id)
				->delete();
		}
                return Redirect::back()
                        ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_entity_updated_successfully').'</div>');
                
                }       
	
	public function destroy(Request $request, Corporation $corporation)
	{
		if(!checkpermission($this->module, $this->sub_id, 'scrittura')){
    		return redirect('/unauthorized');
    	}

		// $this->authorize('destroy', $corporation);	

		DB::table('corporations')
		  ->where('id', $corporation->id)
		  ->update(array(
			'is_deleted' => 1,
		  ));

		$logs =  $this->logmainsection.' -> Delete Entity (ID: '. $corporation->id . ')';
		storelogs($request->user()->id, $logs);

		return Redirect::back()
		  ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_entity_deleted_successfully').'</div>');
	}
	
	public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nomeazienda' => 'required|max:35',
            'nomereferente' => 'required|max:35',
            'settore' => 'max:50',
            'piva' => 'max:11',
            'cf' => 'max:16',
            'telefonoazienda' => 'required|max:25',
            'cellulareazienda' => 'max:25',
			'emailsecondaria' => 'max:64',
            'fax' => 'max:35',
			'sedelegale' => 'max:1000',
			'indirizzospedizione' => 'max:1000',
            'email' => 'required|max:64',
            /*'indirizzo' => 'required',*/
            'noteenti' => 'max:255',
            'iban' => 'max:64',
            'statoemotivo' => 'max:64',
			'responsabilelanga' => 'required',
			'logo'=>'mimes:jpeg,jpg,png|max:1000',
			/*'telefonoresponsabile' => 'required|max:35',*/
        ]);
        
        if($validator->fails()) {
            return Redirect::back()
                ->withInput()
                ->with('error_code', 6)
                ->withErrors($validator);
        }
		$nome = "";
		if($request->logo!=null) {
			// Memorizzo l'immagine nella cartella public/imagesavealpha
            $nome = time() . uniqid() . '-' . '-ente.' . pathinfo($request->file('logo')->getClientOriginalName(), PATHINFO_EXTENSION);
			Storage::put(
				'images/' . $nome,
				file_get_contents($request->file('logo')->getRealPath())
			);
		} else {
			// Imposto l'immagine di default
			$nome = "mancalogo.jpg";
		}
		
        // $corp = $request->user()->corporations()->create([

    	$corp =  DB::table('corporations')->insertGetId([ 
            'nomeazienda' => $request->nomeazienda,
            'nomereferente' => $request->nomereferente,
            'settore' => isset($request->settore) ? $request->settore : '',
            'piva' => isset($request->piva) ? $request->piva : '',
            'cf' => isset($request->cf) ? $request->cf : '',
            'telefonoazienda' => isset($request->telefonoazienda) ? $request->telefonoazienda : '',
            'cellulareazienda' => isset($request->cellulareazienda) ? $request->cellulareazienda : '',
			'emailsecondaria' => $request->emailsecondaria,
			'sedelegale' => $request->sedelegale,
			'indirizzospedizione' => $request->indirizzospedizione,
			'indirizzo' => $request->indirizzo,
            'fax' => isset($request->fax) ? $request->fax : '',
            'email' => $request->email,
			'logo' => $nome,
            'iban' => isset($request->iban) ? $request->iban : '',
			'swift'=> isset($request->swift) ? $request->swift : '',
			'responsabilelanga' => $request->responsabilelanga,
			'telefonoresponsabile' => isset($request->telefonoresponsabile) ? $request->telefonoresponsabile : '',
			'skype_id'=> isset($request->skype_id) ? $request->skype_id : '',
			'user_id'=>$request->user()->id
        ]);
		
		$logs =  $this->logmainsection.' -> Add New Entity (ID: '. $corp . ')';
		storelogs($request->user()->id, $logs);
		
		// Memorizza i partecipanti al progetto
        if(isset($request->partecipanti)) {			
			$options = $request->partecipanti;
			$partecipantiNotifiche = $request->partecipantiNotifiche;
			for($i = 0; $i < count($options); $i++) {
				$notifiche = isset($partecipantiNotifiche[$options[$i]]) ? $partecipantiNotifiche[$options[$i]] : '0';
				DB::table('enti_partecipanti')->insert([
					'id_ente' => $corp->id,
					'id_user' => $options[$i],
					'notifiche'=> $notifiche, 					
				]);
			}
		}
		
		// Memorizza i partecipanti al progetto
        /*if(isset($request->partecipanti)) {
			$options = $request->partecipanti;
			for($i = 0; $i < count($options); $i++) {
				DB::table('enti_partecipanti')->insert([
					'id_ente' => $corp->id,
					'id_user' => $options[$i],
				]);
			}
		}*/
		
		// Memorizza i tipi
		/*if(isset($request->tipi)) {
			$options = $request->tipi;
			for($i = 0; $i < count($options); $i++) {
				// echo $options[$i];
				// select id from masterdatatypes where name = $options[$i] 
				// and insert into corporationtypes(id_tipo, id_ente)
				// VALUES(id preso da masterdatatypes,Corporation->id)
				$tipo = DB::table('masterdatatypes')
					->where('name', $options[$i])
					->first();
				DB::table('corporationtypes')->insert([
					'id_tipo' => $tipo->id,
					'id_ente' => $corp->id,
				]);
			}
		}*/
        

        /*
		Appunti = ric
		Ricontattare il giorno = ricontattare
		Alle = alle
		Data inserimento = datainserimento
		*/
        if(isset($request->ric)) {
			$appunti = $request->ric;
			$utente = $request->utente;
			/*$utente = $request->user()->id;*/
			$datainserimento = $request->datepicker_to;
			/*$da_data = $request->datepicker_from;*/
			$banca = $request->banca;
			$cassa = $request->cassa;
			$notifiche = $request->notifiche;
			
			for($i = 0; $i < count($appunti); $i++) {
				$frequenza = $request->frequenza;	
				DB::table('messages')->insert([
					'id_ente' => $corp->id,
					'id_utente' =>$utente[$i],
					'appunti' => $appunti[$i],
					/*'ricontattare' => $ricontattare[$i],
					'ora' => $alle[$i],*/
					'datainserimento' => $datainserimento[$i],
					/*'da_data' => $da_data[$i],*/
					'banca' => $banca[$i],
					'cassa' => $cassa[$i],
					'frequenza' => isset($frequenza[$i]) ? $frequenza[$i] : "0",
					'notifiche' => isset($notifiche[$i]) ? $notifiche[$i] : '0',
				]);
			}
		}

		if($request->statoemotivo!=null) {
			// Memorizzo lo stato emotivo
			$tipo = DB::table('statiemotivitipi')
				->where('name', $request->statoemotivo)
				->first();
			DB::table('statiemotivi')->insert([
				'id_ente' => $corp->id,
				'id_tipo' => $tipo->id,
			]);
		}

		return Redirect::back()
                        ->with('error_code', 5)
                        ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_ente_added_successfully').'</div>');
    }
	
	
	
	public function modify(Request $request, Corporation $corporation)
	{
		
		//$this->authorize('modify', $corporation);		
		return view('modificaente', [
			'action'=>'edit',
			'corp' => $corporation,
			'users' => DB::table('users')
				->get(),
			'type' => DB::table('masterdatatypes')
				->get(),
			'selectedtype' => DB::table('corporationtypes')
				->where('id_ente', $corporation->id)
				->get(),
			'emotionState' => DB::table('statiemotivitipi')
				->get(),
			'selectedemotionState' => DB::table('statiemotivi')
				->where('id_ente', $corporation->id)
				->first(),
			'participant' => DB::table('enti_partecipanti')
                                ->where('id_ente', $corporation->id)
								->orderBy('id', 'asc')
                                ->get(),
			'actionmessages' => DB::table('messages')->leftJoin('users', 'users.id', '=', 'messages.id_utente')
            ->select('users.name as username','messages.*')->where('messages.id_ente', $corporation->id)->get(),
			'loginuser' => $request->user(),
			'frequency'=>DB::table('frequenze')->get(),
			'cost' => DB::table('costi')
					->where('id_ente', $corporation->id)
					->orderBy('datainserimento', 'asc')
					->get()
		]);
		/*return view('modificaente', [
			'corp' => $corporation,
			'utenti' => DB::table('users')
				->get(),
			'tipi' => DB::table('masterdatatypes')
				->get(),
			'tipiselezionati' => DB::table('corporationtypes')
				->where('id_ente', $corporation->id)
				->get(),
			'statiemotivi' => DB::table('statiemotivitipi')
				->get(),
			'statoemotivoselezionato' => DB::table('statiemotivi')
				->where('id_ente', $corporation->id)
				->first(),
			'partecipanti' => DB::table('enti_partecipanti')
                                ->where('id_ente', $corporation->id)
                                ->get(),
			'chiamate' => DB::table('messages')
				->where('id_ente', $corporation->id)
				->get(),
			'utente' => $request->user(),
			'costi' => DB::table('costi')
					->where('id_ente', $corporation->id)
					->orderBy('datainserimento', 'asc')
					->get()
		]);*/
	}

	public function add(Request $request)
	{
		if(!checkpermission($this->module, $this->sub_id, 'scrittura')){
    		return redirect('/unauthorized');
    	}

		/*return view('modificaente', [
			'action'=>'add',
			'utenti' => DB::table('users')
				->get(),
			'tipi' => DB::table('masterdatatypes')
				->get(),
			'statiemotivi' => DB::table('statiemotivitipi')
				->get(),
		]);*/

		return view('modificaente', [
			'action'=>'add',
			'users' => DB::table('users')
				->get(),
			'type' => DB::table('masterdatatypes')
				->get(),
			'selectedtype' => [],
			'emotionState' => DB::table('statiemotivitipi')
				->get(),
			'loginuser' => $request->user(),
			'frequency'=>DB::table('frequenze')->get(),
			'selectedemotionState' => [],
			'participant' => [],
			'actionmessages' => [],
			'cost' => []
		]);
		/*return view('aggiungiente', [
			'utenti' => DB::table('users')
				->get(),
			'tipi' => DB::table('masterdatatypes')
				->get(),
			'statiemotivi' => DB::table('statiemotivitipi')
				->get(),
		]);*/
	
	}
	public function getDetails(Request $request){		
		$data = DB::table('corporations')
				->join('users', 'corporations.user_id', '=', 'users.id')
				->select('corporations.*')
				->where('is_deleted','0')
				->where('corporations.id',$request->entity_id)
				->where('users.is_delete', '=', 0)
				->orderBy('corporations.id', 'desc')
				->first();
		if(count($data) > 0){
			return json_encode($data);
		}
		else {
			return 'fail';
		}

	}
	
	public function index(Request $request)
	{
		if(!checkpermission($this->module, $this->sub_id, 'lettura')){
    		return redirect('/unauthorized');
    	}
    	
		return $this->show($request);
	}
	
	public function compilaStatiEmotivi(&$enti)
	{
		$statiemotiviselezionati = DB::table('statiemotivi')
									->get();
		$tabellastatiemotivi = DB::table('statiemotivitipi')
									->get();
		foreach($enti as $corp) {
			foreach($statiemotiviselezionati as $statoselezionato) {
				if($corp->id == $statoselezionato->id_ente) {
					foreach($tabellastatiemotivi as $statoemotivo) {
						if($statoemotivo->id == $statoselezionato->id_tipo) {
							$corp->statoemotivo = "<p style='padding-left:5px;color:#ffffff;background-color: " . $statoemotivo->color . "'>".$statoemotivo->name."</p>";
							break;
						}
					}
				}
			}
		}	
	}
	
	public function compilaTipi(&$enti)
	{
		$tipiselezionati = DB::table('corporationtypes')->get();
		$tabellatipi = DB::table('masterdatatypes')->get();
		foreach($enti as $corp) {
			foreach($tipiselezionati as $tiposelezionato) {
				if($corp->id == $tiposelezionato->id_ente) {
					foreach($tabellatipi as $tipo) {
						if($tipo->id == $tiposelezionato->id_tipo) {
							$corp->tipo = "<p style='padding-left:5px;color:#ffffff;background-color:".$tipo->color."'>".$tipo->name."</p>";
							break;
						}
					}
				}
			}
		}
	}
}
