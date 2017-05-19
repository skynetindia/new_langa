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
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EventRepository $events, CorporationRepository $corporations)
    {
        $this->middleware('auth');

        $this->events = $events;
		
		$this->corporations = $corporations;
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
        if($request->user()->id != 0) {
            
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

            dd("End..!!");
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

                            dd($corporations);

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
dd("else");
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
		$this->authorize('modify', $event);
            $this->validate($request, [
            'giorno' => 'required',
            'giornoFine' => 'required',
            'ente' => 'required',
            'giornoFine' => 'required',
			'dove' => 'required',
            'titolo' => 'required|max:255',
            'dettagli' => 'max:500',
            'sh' => 'required',
            'eh' => 'required',
        ]);
        
        $giorno = substr($request->giorno, 0 , 2);
        $mese = substr($request->giorno, 3 , 2);
        $anno = substr($request->giorno, 6, 4);
        $giornoFine = substr($request->giornoFine, 0, 2);
        $meseFine = substr($request->giornoFine, 3, 2);
        $annoFine = substr($request->giornoFine, 6, 4);
		
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
		$this->authorize('destroy', $event);
		DB::table('events')
			->where('id', $event->id)
			->delete();
		return Redirect::back();
	}
	
    /**
     * Store a new calendar event.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'giorno' => 'required',
            // 'giornoFine' => 'required',
            'ente' => 'required',
            // 'giornoFine' => 'required',
            'titolo' => 'required|max:255',
            'dettagli' => 'max:500',
			'dove' => 'required'
            // 'sh' => 'required',
            // 'eh' => 'required',
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

        $evento = DB::table('events')->insert([        
            'name' => $request->user()->name,
            'dipartimento' => $request->user()->dipartimento,
			'ente' => $ente->nomeazienda,
            'giorno' => $giorno,
            // 'giornoDate' => $giorno,
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
		
		$user = DB::table('corporations')
					->where('id', $ente->id)
					->first();
		
		if($request->notifica == 1) {
			Mail::send('layouts.notifica', ['evento' => $evento, 'ente' => $user, 'utente' => $request->user()], function ($m) use ($ente) {
				$m->from('easy@langa.tv', 'Appuntamento LANGA');
				$m->to($ente->email)->subject("Hey! NUOVO APPUNTAMENTO / IMPEGNO_LANGA");
        	});	
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
        if($request->month == date('n') && $request->day == 0 && $request->year == date('Y'))
            $request->day = date('j');

		if($request->tipo == 0) {
			// miei
			$eventi = $this->events->forUser($request->user(), $request->month, $request->year);

		} else {
            
			// tutti
			$eventi = $this->events->forUser2($request->user(), $request->month, $request->year);
		}
        return view('calendario', [
            'day' => $request->day,
            'month' => $request->month,
            'year' => $request->year,
            'giorniMese' => date('t', mktime(0, 0, 0, $request->month, $request->day, $request->year)),
            'nomiMesi' => $this->nomiMesi,
            'events' => $eventi,
            'enti' => $this->corporations->forUser($request->user()),
            'utenti' => DB::table('users')
				->get(),
			'tipo' => $request->tipo
        ]);
    }
    
    /**
     * Calls the show method with the today date.
     *
     * @return void
     */
    public function index(Request $request)
    {
        $request->day = date('j');
        $request->month = date('n');
        $request->year = date('Y');
        return $this->show($request);
    }

}
