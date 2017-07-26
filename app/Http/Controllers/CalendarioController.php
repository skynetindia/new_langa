<?php

namespace App\Http\Controllers;

use DB;
use Redirect;
use Validator;
use App\Repositories\CorporationRepository;
use App\Repositories\EventRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;
use App\Event;

class CalendarioController extends Controller

{

    private $nomiMesi = array(null, "Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre");

    protected $events;
    protected $logmainsection;

    protected $module;
    protected $sub_id;

    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function __construct(EventRepository $events, CorporationRepository $corporations)

    {

        $this->middleware('auth');

        $Gennaio = trans('messages.keyword_january');

        $Febbraio = trans('messages.keyword_february');

        $Marzo = trans('messages.keyword_march');

        $Aprile = trans('messages.keyword_april');

        $Maggio = trans('messages.keyword_may');

        $Giugno = trans('messages.keyword_june');

        $Luglio = trans('messages.keyword_july');

        $Agosto = trans('messages.keyword_august');

        $Settembre = trans('messages.keyword_september');

        $Ottobre = trans('messages.keyword_october');

        $Novembre = trans('messages.keyword_november');

        $Dicembre = trans('messages.keyword_december'); 

        $this->nomiMesi = array(null, $Gennaio, $Febbraio, $Marzo, $Aprile, $Maggio, $Giugno, $Luglio, $Agosto, $Settembre, $Ottobre, $Novembre, $Dicembre);



        $this->events = $events;
		$this->corporations = $corporations;
        $this->logmainsection = 'Event';

       $request = parse_url($_SERVER['REQUEST_URI']);
        $path = ($_SERVER['HTTP_HOST'] == 'localhost') ? rtrim(str_replace('/easylanganew/', '', $request["path"]), '/') : $request["path"];        
        $result = rtrim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $path), '/');
        $current_module = DB::select('select * from modulo where TRIM(BOTH "/" FROM modulo_link) = :link', ['link' => $result]);
		
		$this->module = (isset($current_module[0]->modulo_sub)) ? $current_module[0]->modulo_sub : 2;
        $this->sub_id = (isset($current_module[0]->id)) ? $current_module[0]->id : 14;
    }



    // user read notification

    public function userreadevent(Request $request)

    {



        $today = date("Y-m-d h:i:s");

        $id = $request->input('id');

        $user_id = $request->input('user_id');

     

         DB::table('invia_notifica')

                ->where('notification_id', $id)

                ->where('user_id', $user_id)

                ->update(array(

                    'data_lettura' => $today,

                    'conferma' => 'LETTO'

                    ));

                

        return Redirect::back();

        

    }



    // make comment in notification

    public function eventmakecomment(Request $request)

    {

        $messaggio = $request->input('messaggio');

        $id = $request->input('id');

        $user_id = $request->input('user_id');

        

         DB::table('invia_notifica')

                ->where('notification_id', $id)

                ->where('user_id', $user_id)

                ->update(array(

                    'comment' => $messaggio,

                    'conferma' => 'LETTO'

                    ));

                

        return Redirect::back();

        

    }    





    // send event notification 

    public function sendeventnotification(Request $request)

    {

        if($request->user()->id != 0 && $request->user()->dipartimento != 0) {

            

            return redirect('/unauthorized');



        } else {



            $userID = $request->user()->id;

            $today = date("Y-m-d");



            $event_notification = DB::table('events')

                  ->where('giornoDate', '>', $today)

                  ->get();  



            $nextday = strftime("%Y-%m-%d", strtotime("$today +1 day"));



            if(empty($event_notification)) {



                return "No event set for today.!!";

            }



            foreach ($event_notification as $event) {                



                if($nextday == $event->giornoDate){ 



                    if($event->id_ente >= 0){



                        $getente = DB::table('enti_partecipanti')

                            ->select('id_user')

                            ->where('id_ente', $event->id_ente)

                            ->get();



                        foreach ($getente as $getente) {

           

                            $corporations = DB::table('corporations')

                                ->where('id', $event->id_ente)

                                ->first(); 

                                                             

                            $true = DB::table('invia_notifica')->insert([

                                    'id_ente' => $corporations->id,

                                    'ruolo' => '',

                                    'user_id' => $getente->id_user,

                                    'notification_id' => $event->id,

                                    'nome_azienda' => $corporations->nomeazienda,

                                    'nome_referente' => $corporations->nomereferente,

                                    'settore' => $corporations->settore,

                                    'telefono_azienda' => $corporations->telefonoazienda,

                                    'email' => $corporations->email,

                                    'data_lettura' => '',

                                    'conferma' => 'NON LETTO'

                                ]);

                        }



                    } else {



                       return "event not set for any partecipanti.!!";

                    } 

                } 

            }     



            if($true){



                return "Even notification send succesfully.!";



            } else {



                return false;

            }   

            

// else {



//                     return "No event set for today.!!";



//                 }



                if($event->id_ente >= 0){

                      

                    $getente = DB::table('enti_partecipanti')

                        ->select('id_user')

                        ->where('id_ente', $event->id_ente)

                        ->get();



                    foreach ($getente as $getente) {



                            $corporations = DB::table('corporations')

                                ->where('id', $event->id_ente)

                                ->first();







                            $true = DB::table('invia_notifica')->insert([

                                    'id_ente' => $corporations->id,

                                    'ruolo' => '',

                                    'user_id' => $corporations->user_id,

                                    'notification_id' => '',

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



    

	public function update(Request $request, Event $event)

	{        
        if(!checkpermission($this->module, $this->sub_id, 'scrittura')){
            return redirect('/unauthorized');
        }
       
            // $this->authorize('modify', $event);

                $this->validate($request, [

                'giorno' => 'required',

                'ente' => 'required',

                'titolo' => 'required|max:255',

                'dettagli' => 'max:500',

            ]);

/*    $date=explode(' - ',$request->giorno);
	echo $date[0];
echo 	$sdate=strtotime($date[0]);
echo "======<br>";
echo $date[1];
echo 	$edate=strtotime($date[1]);
exit;*/            

            $date=explode('-',$request->giorno);

            $sdate=strtotime($date[0]);

            $edate=strtotime($date[1]);

          

            $mese= date('m',$sdate);

            $giorno = date('d',$sdate);

            $anno = date('Y',$sdate);

            $sh = date('h:i:s a',$sdate);

            

            $meseFine= date('m',$edate);

            $giornoFine = date('d',$edate);

            $annoFine = date('Y',$edate);

            $eh = date('h:i:s a',$edate);

            $ente = DB::table('corporations')

                        ->where('id', $request->ente)

                        ->first();

    		

    		$ente = DB::table('corporations')

    					->where('id', $request->ente)

    					->first();

    		

    		$evento = DB::table('events')

    					->where('id', $event->id)

    					->first();

    		

    		DB::table('notifiche')

    				->where('id', $evento->id_notifica)

    				->delete();

    		

    		DB::table('events')

    			->where('id', $event->id)

    			->update(array(

    				'id_ente' => $request->ente,

    			    'ente' => $ente->nomeazienda,

                                    'giorno' => $giorno,

                                    'giornoFine' => $giornoFine,

                                    'mese' => $mese,

                                    'meseFine' => $meseFine,

                                    'anno' => $anno,

                                    'annoFine' => $annoFine,

    				'privato' => $request->privato,

    				'sh' => $request->sh,

    				'eh' => $request->eh,

    				'notifica' => $request->notifica,

    				'id_notifica' => 0,

    				'titolo' => $request->titolo,

    				'privato' => $request->privato,

    				'dove' => $request->dove,

    				'dettagli' => $request->dettagli,

    			));



            $logs = $this->logmainsection.' -> Update Event (ID: '. $event->id . ')';

            storelogs($request->user()->id, $logs);

    		return redirect('/calendario/0');

	}



	

	public function edit(Request $request, Event $event)

	{

		$this->authorize('modify', $event);

        

		return view('calendarioEdit', [

			'id' => $request->event,

            'event' => $event,

			'enti' => $this->corporations->forUser($request->user()),

        ]);

	}

	

	public function destroy(Request $request, Event $event)

	{
        if(!checkpermission($this->module, $this->sub_id, 'scrittura')){
            return redirect('/unauthorized');
        }

		// $this->authorize('destroy', $event);

		DB::table('events')

			->where('id', $event->id)

			->delete();

        $logs = $this->logmainsection.' -> Delete Event (ID: '. $event->id . ')';

        storelogs($request->user()->id, $logs);

		return Redirect::back();

	}

	

    /**

     * Store a new calendar event.

     *

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request, Event $event)

    {

        if(!checkpermission($this->module, $this->sub_id, 'scrittura')){
            return redirect('/unauthorized');
        }

        $validator = Validator::make($request->all(), [

            'giorno' => 'required',

            'ente' => 'required',

            'titolo' => 'required|max:255',

            'dettagli' => 'max:500',

			'dove' => 'required'

        ]);

        

        if($validator->fails()) {

            return Redirect::back()

                ->with('error_code', 5)

                ->withErrors($validator);

        }

        $date=explode('-',$request->giorno);

		$sdate=strtotime($date[0]);

		$edate=strtotime($date[1]);

      

	    $mese= date('m',$sdate);

        $giorno = date('d',$sdate);

        $anno = date('Y',$sdate);

		$sh = date('h:i:s a',$sdate);

		

		$meseFine= date('m',$edate);

        $giornoFine = date('d',$edate);

       	$annoFine = date('Y',$edate);

		$eh = date('h:i:s a',$edate);

		$ente = DB::table('corporations')

					->where('id', $request->ente)

					->first();

		

		

        // $evento = $request->user()->events()->create([



        $evento = DB::table('events')->insertGetID([        

            'name' => $request->user()->name,

            'dipartimento' => $request->user()->dipartimento,

			'ente' => $ente->nomeazienda,

            'giorno' => $giorno,

            'user_id' => $request->user()->id,

            'giornoFine' => $giornoFine,

            'mese' => $mese,

            'meseFine' => $meseFine,

            'anno' => $anno,

			'privato' => $request->privato,

            'annoFine' => $annoFine,

            'id_ente' => $ente->id,

			'notifica' => $request->notifica,

			'privato' => $request->privato,

            'sh' => $sh,

            'eh' =>$eh,

            'titolo' => $request->titolo,

            'dettagli' => $request->dettagli,

			'dove' => $request->dove

        ]);

		

        $logs = $this->logmainsection.' -> Add New Event (ID: '. $evento . ')';

        storelogs($request->user()->id, $logs);



		$user = DB::table('corporations')

					->where('id', $ente->id)

					->first();

		$evento = DB::table('events')

					->where('id', $evento)

					->first();

		

		if($request->notifica == 1) {

			/*Mail::send('layouts.notifica', ['evento' => $evento, 'ente' => $user, 'utente' => $request->user()], function ($m) use ($ente) {

				$m->from('easy@langa.tv', 'Appuntamento LANGA');

				$m->to($ente->email)->subject("Hey! NUOVO APPUNTAMENTO / IMPEGNO_LANGA");

        	});*/

		}		

        return Redirect::back();

    }



    /**

     * Show the calendar view w/ any passed date.

     *

     * @return \Illuminate\Http\Response

     */

    public function show(Request $request)
    {
        DB::enableQueryLog();
        if($request->month == date('n') && $request->day == 0 && $request->year == date('Y'))
            $request->day = date('j');

		if($request->user()->id==0 || $request->tipo==1 || $request->user()->dipartimento == 0)
			$eventi=DB::table('events')  ->orderBy('mese', 'asc')->get();
		elseif($request->tipo==0)
			$eventi=DB::table('events')-> where('user_id', $request->user()->id)  ->orderBy('mese', 'asc')-> get();

        /* === Estimates Details === */
        $estimates = array();
        $projects = array();
        $invoices = array();
        if(($request->user()->id==0 && $request->tipo==2 && $request->user()->dipartimento == 0)){
            $estimates = DB::table('quotes')
            ->leftJoin('users', 'users.id', '=', 'quotes.user_id')
            ->select('users.color as color','users.name','quotes.*')
            ->where('quotes.is_deleted', 0)->where('users.is_delete',0)->get();                                           
            $eventi = array();
        }
        elseif($request->tipo==2) {            
            $userid = $request->user()->id;
            $arrwhere['quotes.is_deleted'] = 0;
            $arrwhere['statiemotivipreventivi.id'] = '8';                        
            $estimates = DB::table('quotes')
            ->Join('statipreventivi', 'statipreventivi.id_preventivo', '=', 'quotes.id')
            ->Join('statiemotivipreventivi', 'statiemotivipreventivi.id', '=', 'statipreventivi.id_tipo')
            ->leftJoin('users', 'users.id', '=', 'quotes.user_id')
            ->where($arrwhere)
            ->where(function ($query) use ($userid)  {                
                $query->where('quotes.user_id', $userid)
                      ->orWhere('quotes.idutente', $userid);
            })
            ->select('users.color as color','users.name','quotes.*')->get();                
            $eventi = array();
        }

        /* === Project Details === */
        if($request->tipo==2){
        $projectwhere['is_deleted'] = 0;
        $projectwhere['users.is_delete'] = 0;
        if($request->user()->id != 0 && $request->user()->dipartimento != 0) {
            $projectwhere['projects.user_id'] = $request->user()->id;
        }
        
        $projects = DB::table('projects')
            ->join('users', 'projects.user_id', '=', 'users.id')
            ->select(DB::raw('projects.*, users.id as uid, users.is_delete, users.color'))
            ->where('datafine','!=','')                
            ->where($projectwhere)
            ->orderBy('projects.id', 'asc')
            ->get();
        

        /* Invoice Details */
        $invoicewhere['users.is_delete']=0;
        if($request->user()->id != 0 && $request->user()->dipartimento != 0) {
            $invoicewhere['tranche.user_id']=$request->user()->id;            
        }
        $invoices = DB::table('tranche')
                ->join('users', 'tranche.user_id','=','users.id')
                ->select(DB::raw('tranche.*, users.id as uid, users.is_delete, users.color'))                
                ->where($invoicewhere)
                ->get();            
        /*$queries = DB::getQueryLog();
        $last_query = end($queries);
        print_r($last_query);
        exit;*/
        /*print('<pre>');
        print_r($eventi);
        exit;*/
        }
        return view('calendario', [
            'day' => $request->day,
            'month' => $request->month,
            'year' => $request->year,
            'giorniMese' => date('t', mktime(0, 0, 0, $request->month, $request->day, $request->year)),
            'nomiMesi' => $this->nomiMesi,
            'events' => $eventi,
            'enti' => $this->corporations->forUser($request->user()),
            'utenti' => DB::table('users')->get(),
			'tipo' => $request->tipo,
            'estimates' => $estimates,
            'projects' => $projects,
            'invoices' => $invoices
        ]);

    }

	 /**

     * Calls the show method with the today date.

     *

     * @return void

     */

	public function jsondata(Request $request) {

        $event = array();
		if($request->user()->id==0 || $request->tipo==1 || $request->user()->dipartimento == 0)
		$event=DB::table('events')->orderBy('mese', 'asc')->get();
		elseif($request->tipo==0)
		$event=DB::table('events')-> where('user_id', $request->user()->id)  ->orderBy('mese', 'asc')-> get();

        $eventi= array();
		foreach($event as $evkey=>$evval) {
			$utente = DB::table('users')->where('id', $evval->user_id)->first();									
			$colore = (isset($utente->color))?$utente->color:'#666';
			$newarray['id']=$evval->id;
			$newarray['title']=$evval->titolo;
			$newarray['start']=date('Y-m-d',strtotime($evval->anno.'-'.$evval->mese.'-'.$evval->giorno));
			$newarray['end']=date('Y-m-d',strtotime($evval->annoFine.'-'.$evval->meseFine.'-'.$evval->giornoFine.' +1 days'));
			$newarray['color']=$colore;
		    $eventi[]=$newarray;	
		}        

        $finalDetails = array();
        /* Display the deadlines */
        if($request->tipo == 2){        
            $estimatesDetails = $this->estimates($request);   
            $finalDetails = $estimatesDetails;
            /*$finalDetails =  array_merge($eventi,$estimatesDetails);*/

            $invoiceDetails = $this->invoice($request);           
            $finalDetails =  array_merge($finalDetails,$invoiceDetails);                   
        
            $projectDetails = $this->project($request);           
            $finalDetails = array_merge($finalDetails,$projectDetails);                   
        }
        else {
            $finalDetails = $eventi;    
        }

    	return json_encode($finalDetails);
	}
    
    /* Estimates  */            
    public function estimates($request){
        
        if($request->user()->id == 0 || $request->user()->dipartimento == 0) {
            $estimates = DB::table('quotes')->where('is_deleted', 0)->where('quotes.valenza','!=',"")->where('quotes.finelavori','!=',"")->get();
        }
        else {     
            DB::connection()->enableQueryLog();               
            $arrwhere['quotes.user_id'] = $request->user()->id;
            $arrwhere['quotes.is_deleted'] = 0;
            $arrwhere['statiemotivipreventivi.id'] = '8';/*NON CONFERMATO*/

            $arrORwhere['quotes.idutente'] = $request->user()->id;
            $arrORwhere['quotes.is_deleted'] = 0;
            $arrORwhere['statiemotivipreventivi.id'] = '8';
            

            $estimates = DB::table('quotes')
            ->Join('statipreventivi', 'statipreventivi.id_preventivo', '=', 'quotes.id')
            ->Join('statiemotivipreventivi', 'statiemotivipreventivi.id', '=', 'statipreventivi.id_tipo')
            ->where($arrwhere)->where($arrwhere)->orWhere($arrORwhere)->where('quotes.valenza','!=',"")->where('quotes.finelavori','!=',"")->get();                
            /*$queries = DB::getQueryLog();
            $last_query = end($queries);
            print_r($last_query);                
            exit;*/
        }
        $finalEst = array();            
        foreach ($estimates as $estkey => $estvalue) {
            $utente = DB::table('users')->where('id', $estvalue->user_id)->first();                                  
            $colore = (isset($utente->color))?$utente->color:'#666';
            $newarrayEst['id']=$estvalue->id;
            $newarrayEst['title']="Quote :".$estvalue->id."/".$estvalue->anno;            
            /* Commercials Or Admistator */

            $startdate = ""; 
            if($request->user()->dipartimento === 2 || $request->user()->dipartimento === 1 || $request->user()->id == 0 || $request->user()->dipartimento == 0) {                 
                if(isset($estvalue->valenza) && $estvalue->valenza != ""){
                    $parts =  explode('/',$estvalue->valenza);               
                    $yyyy_mm_dd = $parts[2] . '-' . $parts[1] . '-' . $parts[0];                
                    $startdate = date('Y-m-d', strtotime($yyyy_mm_dd.' +'.$GLOBALS['datedays'].' days'));                            
                }
            }/* Tehcnician */
            else if($request->user()->dipartimento === 3) { 
                //$estvalue->valenza = str_replace('/', '-', $estvalue->finelavori);          
                $partsf = explode('/',$estvalue->finelavori);               
                $finaldate = $parts[2] . '-' . $parts[1] . '-' . $parts[0];                  
                $startdate = date('Y-m-d', strtotime($finaldate.' +'.$GLOBALS['datedays'].' days'));            
            }

            if($startdate != ""){
                $newarrayEst['start']=$startdate;
                $newarrayEst['end']=$startdate;
                $newarrayEst['color']=$colore;            
                $finalEst[]=$newarrayEst;                
            }
        }                      
        return $finalEst;
    }

     /*=========== Invoice ====================== */            
    public function invoice($request){
        DB::connection()->enableQueryLog();               
        $invoicewhere['users.is_delete']=0;
        if($request->user()->id != 0 && $request->user()->dipartimento != 0) {
            $invoicewhere['tranche.user_id']=$request->user()->id;            
        }
        $invoices = DB::table('tranche')
                ->join('users', 'tranche.user_id','=','users.id')
                ->select(DB::raw('tranche.*, users.id as uid, users.is_delete'))                
                ->where($invoicewhere)
                ->get();     
          /*$queries = DB::getQueryLog();
            $last_query = end($queries);
            print_r($last_query);                
            exit;*/
        $finalInv = array();            
        foreach ($invoices as $invkey => $invvalue) {
            $utente = DB::table('users')->where('id', $invvalue->user_id)->first();                                  
            $colore = (isset($utente->color))?$utente->color:'#666';
            $newarrayInv['id']=$invvalue->id;
            $newarrayInv['title']="Invoice :".$invvalue->idfattura;
            /* Commercials Or Admistator */

            $startdate = ""; 
            if($request->user()->dipartimento === 2 || $request->user()->dipartimento === 1 || $request->user()->id == 0 || $request->user()->dipartimento == 0) {                 
                $parts = explode('/',$invvalue->datascadenza);               
                if(isset($parts[2])){
                    $yyyy_mm_dd = $parts[2] . '-' . $parts[1] . '-' . $parts[0];                
                    $startdate = date('Y-m-d', strtotime($yyyy_mm_dd));                                            
                }
            }
            /* Tehcnician */
            /*else if($request->user()->dipartimento === 3) { 
                //$estvalue->valenza = str_replace('/', '-', $estvalue->finelavori);          
                $partsf = explode('/',$estvalue->finelavori);               
                $finaldate = $parts[2] . '-' . $parts[0] . '-' . $parts[1];                  
                $startdate = date('Y-m-d', strtotime($finaldate);            
            }*/
            if($startdate != ""){
                $newarrayInv['start']=$startdate;
                $newarrayInv['end']=$startdate;
                $newarrayInv['color']=$colore;            
                $finalInv[]=$newarrayInv;                
            }
        }            
        return $finalInv;
    }

     /* Project */            
    public function project($request){        

        $projectwhere['is_deleted'] = 0;
        $projectwhere['users.is_delete'] = 0;
        if($request->user()->id != 0 && $request->user()->dipartimento != 0) {
            $projectwhere['projects.user_id'] = $request->user()->id;
        }
        $projects = DB::table('projects')
            ->join('users', 'projects.user_id', '=', 'users.id')
            ->select(DB::raw('projects.*, users.id as uid, users.is_delete'))
            ->where('datafine','!=','')                
            ->where($projectwhere)
            ->orderBy('projects.id', 'asc')
            ->get();
       
        $finalPro = array();            
        foreach ($projects as $prokey => $provalue) {
            $utente = DB::table('users')->where('id', $provalue->user_id)->first();                                  
            $colore = (isset($utente->color))?$utente->color:'#666';
            $newarrayPro['id']=$provalue->id;
            
            $anno = substr($provalue->datainizio, -2);            
            $newarrayPro['title']="Project :".$provalue->id . "/" . $anno;
            /* Commercials Or Admistator */

            $startdate = ""; 
            if($request->user()->dipartimento === 2 || $request->user()->dipartimento === 1 || $request->user()->id == 0 || $request->user()->dipartimento == 0) {                 
                $parts = explode('/',$provalue->datafine);
                $yyyy_mm_dd = $parts[2] . '-' . $parts[1] . '-' . $parts[0];                
                $startdate = date('Y-m-d', strtotime($yyyy_mm_dd));                       
            }/* Tehcnician */
            /*else if($request->user()->dipartimento === 3) {                 
                $partsf = explode('/',$estvalue->datafine);               
                $finaldate = $parts[2] . '-' . $parts[0] . '-' . $parts[1];                  
                $startdate = date('Y-m-d', strtotime($finaldate.' +'.$GLOBALS['datedays'].' days'));            
            }*/
            if($startdate != ""){
                $newarrayPro['start']=$startdate;
                $newarrayPro['end']=$startdate;
                $newarrayPro['color']=$colore;            
                $finalPro[]=$newarrayPro;                
            }
        }                  
        return $finalPro;
    }



	

	public function rgb2hex($rgb) {

		if (strpos($a, 'are') !== false) {

		}

		   $hex = "#";

		   $hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);

		   $hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);

		   $hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);

		   return $hex; // returns the hex value including the number sign (#)

	}

    

    /**

     * Calls the show method with the today date.

     *

     * @return void

     */

    public function index(Request $request)
    {
        if(!checkpermission($this->module, $this->sub_id, 'lettura')){
            return redirect('/unauthorized');
        }

        $request->day = date('j');

        $request->month = date('n');

        $request->year = date('Y');

        return $this->show($request);

    }
}

