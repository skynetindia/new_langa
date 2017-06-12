<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Mail;
use App\Repositories\CorporationRepository;
use App\Repositories\EventRepository;
use Redirect;
use Validator;
use DB;
use Storage;
use Auth;
use App\Event;

class Cestino {

    public $id;
    public $tipo;
    public $nome;

}

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    private $monthnames = array(null, "Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre");
    protected $events;
    public function __construct(EventRepository $events,CorporationRepository $corporations) {
        $this->middleware('auth');
        $this->corporations = $corporations;
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
        $this->monthnames = array(null, $Gennaio, $Febbraio, $Marzo, $Aprile, $Maggio, $Giugno, $Luglio, $Agosto, $Settembre, $Ottobre, $Novembre, $Dicembre);
        $this->events = $events;
    }

    public function getjsoncestino(Request $request) {

        $enti = DB::table('corporations')
                ->where('is_deleted', 1)
                ->get();
        $preventivi = DB::table('quotes')
                ->where('is_deleted', 1)
                ->get();
        $progetti = DB::table('projects')
                ->where('is_deleted', 1)
                ->get();
        $tranche = DB::table('tranche')
                ->where('is_deleted', 1)
                ->get();

        foreach ($enti as $e) {
            $tmp = new Cestino();
            $tmp->id = $e->id;
            $tmp->tipo = "ente";
            $tmp->nome = $e->nomeazienda;
            $stuff[] = $tmp;
        }
        foreach ($preventivi as $p) {
            $tmp = new Cestino();
            $tmp->id = $p->id;
            $tmp->tipo = "preventivo";
            $tmp->nome = $p->oggetto;
            $stuff[] = $tmp;
        }
        foreach ($progetti as $pr) {
            $tmp = new Cestino();
            $tmp->id = $pr->id;
            $tmp->tipo = "progetto";
            $tmp->nome = $pr->nomeprogetto;
            $stuff[] = $tmp;
        }

        foreach ($tranche as $t) {
            $tmp = new Cestino();
            $tmp->id = $t->id;
            $tmp->tipo = "tranche";
            $tmp->nome = DB::table('accountings')
                            ->where('id', $t->id_disposizione)
                            ->first()->nomeprogetto;
            $stuff[] = $tmp;
        }
        return json_encode($stuff);
    }

    public function ripristina(Request $request) {
        $user = $request->user();
        switch ($request->tipo) {
            case "ente":
                $corporation = DB::table('corporations')
                        ->where('id', $request->id)
                        ->first();

                $partecipanti = DB::table('enti_partecipanti')
                                ->where([
                                    'id_ente' => $corporation->id,
                                    'id_user' => $user->id
                                ])->first();
                $partecipante = ($partecipanti != null) ? true : false;
                if ($corporation->user_id == $user->id || $corporation->responsabilelanga == $user->name || $partecipante || $user->id == 0) {
                    DB::table('corporations')
                            ->where('id', $request->id)
                            ->update(array(
                                'is_deleted' => 0
                    ));
                }
                break;
            case "preventivo":
                $quote = DB::table('quotes')
                        ->where('id', $request->id)
                        ->first();

                $partecipanti = DB::table('enti_partecipanti')
                                ->where([
                                    'id_ente' => $quote->idente,
                                    'id_user' => $user->id
                                ])->first();
                $partecipante = ($partecipanti != null) ? true : false;

                if ($quote->user_id == $user->id || $quote->idutente == $user->id || $partecipante || $user->id == 0) {
                    DB::table('quotes')
                            ->where('id', $request->id)
                            ->update(array(
                                'is_deleted' => 0
                    ));
                }
                break;
            case "progetto":
                $project = DB::table('projects')
                        ->where('id', $request->id)
                        ->first();

                $partecipanti = DB::table('progetti_partecipanti')
                        ->where([
                            'id_progetto' => $project->id,
                            'id_user' => $user->id
                        ])
                        ->first();
                $partecipante = ($partecipanti != null) ? true : false;
                if ($project->user_id == $user->id || $partecipante || $user->id == 0) {
                    DB::table('projects')
                            ->where('id', $request->id)
                            ->update(array(
                                'is_deleted' => 0
                    ));
                }
                break;
            case "tranche":
                $accounting = DB::table('tranche')
                        ->where('id', $request->id)
                        ->first();
                if ($accounting->user_id == $user->id || $user->id == 0) {
                    DB::table('tranche')
                            ->where('id', $request->id)
                            ->update(array(
                                'is_deleted' => 0
                    ));
                }
                break;
        }
        return Redirect::back()
                        ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Elemento ripristinato correttamente</h4></div>');
    }

    public function eliminadefinitivamente(Request $request) {
        if ($request->user()->id != 0)
            return redirect('/unauthorized');
        switch ($request->tipo) {
            case 'ente':
                DB::table('corporations')
                        ->where('id', $request->id)
                        ->delete();
                break;
            case 'preventivo':
                DB::table('quotes')
                        ->where('id', $request->id)
                        ->delete();

                DB::table('optional_preventivi')
                        ->where('id_preventivo', $request->id)
                        ->delete();

                DB::table('tabellaoptionalpreventivi')
                        ->where('id_preventivo', $request->id)
                        ->delete();
                break;
            case 'progetto':
                DB::table('progetti_partecipanti')
                        ->where('id_progetto', $request->id)
                        ->delete();
                DB::table('progetti_lavorazioni')
                        ->where('id_progetto', $request->id)
                        ->delete();
                DB::table('progetti_files')
                        ->where('id_progetto', $request->id)
                        ->delete();
                break;
            case 'tranche':
                DB::table('tranche')
                        ->where('id', $request->id)
                        ->delete();
                break;
        }
        return Redirect::back()
                        ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Elemento eliminato correttamente</h4></div>');
    }

    public function mostracestino(Request $request) {
        return view('cestino');
    }

    public function invianewsletter(Request $request) {
        // email e contenuto
        $user = $request->user();
        $email = $request->email;
        Mail::send('layouts.news', ['contenuto' => $request->contenuto], function ($m) use ($user, $email) {
            $m->from('gestione.langa@gmail.com', 'Easy LANGA');
            $m->to($email)->subject('News da Easy LANGA');
        });

        return Redirect::back()
                        ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Newsletter inviata correttamente</h4></div>');
    }

    public function newsletter(Request $request) {
        return view('newsletter', [
            'newsletter' => DB::table('newsletter')
                    ->where('dipartimento', $request->user()->dipartimento)
                    ->get(),
            'enti' => $this->corporations->forUser($request->user())
        ]);
    }

    public function getjsonnewsletter(Request $request) {
        $newsletter = DB::table('newsletter')
                ->get();
        return json_encode($newsletter);
    }

    public function getjsonnotifiche(Request $request) {
        $userId = $request->user()->id;
        $notifications = DB::table('invia_notifica')
          ->leftjoin('notifica', 'invia_notifica.notification_id', '=', 'notifica.id')
          ->select(DB::raw('invia_notifica.*, notifica.id as noti_id, notifica.notification_type, notifica.notification_desc'))
          ->where('user_id', $userId)
          ->where('is_deleted', 0)
          ->orderBy('data_lettura', 'asc')           
          ->get();

        return json_encode($notifications);
    
    }

    public function cancellanotifica(Request $request) {
        DB::table('invia_notifica')
           ->where('id', $request->id)
           ->update(array(
                'is_deleted' => 1
        ));
        return Redirect::back()
            ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans("messages.keyword_deletesuccessmsg?").'!</div>');    
    }

   

    public function mostrachangelog(Request $request) {
        return view('changelog');
    }

    public function mostrafaq(Request $request) {
        return view('faq');
    }

    public function mostranotifiche(Request $request) {
        return view('notifiche');
    }

    public function mostracontatti(Request $request) {
        return view('contatti');
    }

    public function disdiscinotifica(Request $request) {
        DB::table('notifiche')
                ->where('id', $request->id)
                ->update(array(
                    'cancellata' => 1
        ));
        return Redirect::back();
    }

    /* Error message send to  */
    public function segnalazionerrore(Request $request) {
        $user = $request->user();
        if ($request->screen != null) {
            $validator = Validator::make($request->all(), [
                    'screen'=>'mimes:jpeg,jpg,png|max:2000'
                ]);
             if ($validator->fails()) {
                return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }
            // Salvo lo screen con un nome unico
            $nome = time() . uniqid() . '-' . '-screen';
            Storage::put(
                    'images/' . $nome, file_get_contents($request->file('screen')->getRealPath())
            );
            $url = url('/storage/app/images') . '/' . $nome;
        } 
        else { 
            $url = null;
        }
        if (isset($request->love)) {
            Mail::send('layouts.emailringraziamento', ['user' => $request->user(), 'love' => $request->love, 'screen' => $url], function ($m) use ($user) {
                $m->from($user->email, 'Valutazione');
                 $m->to('developer5@mailinator.com')->cc('developer6@mailinator.com')->subject("{{trans('messages.keyword_easy_language_assessment')}}");
               /* $m->to('gestione.langa@gmail.com')->cc('easy@langa.tv')->subject('VALUTAZIONE IN EASY LANGA');*/
            });
            return Redirect::back()
                            ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_error_notification_messages_saven').'</div>');
        } else {
            Mail::send('errors.bug', ['user' => $request->user(), 'url' => $request->posizione, 'errore' => $request->errore, 'screen' => $url], function ($m) use ($user) {
                $m->from($user->email, 'Errore');
                //$m->to('gestione.langa@gmail.com')->cc('easy@langa.tv')->subject('ERRORE IN EASY LANGA');
                $m->to('developer5@mailinator.com')->cc('developer6@mailinator.com')->subject("{{trans('messages.keyword_errore_in_easy_langa')}}");
            });
            return Redirect::back()
                            ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_error_notification_messages_eight').'</div>');
        }
    }

    public function confermautente(Request $request) {

        Session::put('confermaregistrazione', 'gg');
        // dd(Session::get('confermaregistrazione'));
        return redirect('/');
    }

    public function nuovoutente(Request $request) {
        Session::put('nuovaregistrazione', 'gg');
        return redirect('/logout');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {         
        if (Auth::user()->id === 0 || Auth::user()->dipartimento === 1){
            return $this->adminstrator();        
        }
        elseif(Auth::user()->dipartimento === 2){ /* Commercial */ 

        }
        elseif(Auth::user()->dipartimento === 3){ /* Technician */ 

        }
        elseif(Auth::ser()->dipartimento === 4){ /* Reseller */ 

        }
    }

    public function adminstrator() {
        $day = date('j');
        $month = date('n');
        $year = date('Y');
        $arrCurrentLocation = getLocationInfoByIp();

        /*=============== Statistics sections ============== */            
            $guadagno = []; $revenues = []; $expenses = [];
            //dd($expenses);
            $this->compexpense($expenses, $year);
            $this->compRevenue($revenues, $year);
            $this->calcolaGuadagno($guadagno, $revenues, $expenses);            
            $monthName = array(
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
        $statistics = array('month' => $monthName, 'revenue' => $revenues, 'expense' => $expenses, 'earn' => $guadagno);        
        /* ===================== Weather section =========================== */     
        $url = str_replace(' ', '%20', 'http://api.wunderground.com/api/2d5fc4594633a8dc/forecast10day/q/'.$arrCurrentLocation['country'].'/'.$arrCurrentLocation['city'].'.json');
        //$url = urlencode();
        $str = file_get_contents($url);        
        $json = json_decode($str, true);    
        
        $forecastday = (isset($json['forecast']['simpleforecast']['forecastday']) && !isset($json['error'])) ? $json['forecast']['simpleforecast']['forecastday'] : array();

        /*================== Calendor Sections ============== */
        $events = $this->events->forUser2(Auth::user(), $month, $year);

        return view('welcome', [
            'view' => 'adminstrator',            
            'statistics' =>$statistics,
            'year' => $year,
            'day' => $day,
            'month' => $month,
            'forecastday'=>$forecastday,
            'location'=>$arrCurrentLocation['city'].', '.$arrCurrentLocation['country'],
            'giorniMese' => date('t', mktime(0, 0, 0, $month, $day, $year)),
            'nomiMesi' => $this->monthnames,
            'events' => $events,
            'enti' => $this->corporations->forUser(Auth::user()),
            'utenti' => DB::table('users')->get(),
            'tipo' => 1
        ]);
    }

    public function weatherautocomplete(Request $request){               
        $str = file_get_contents('http://autocomplete.wunderground.com/aq?query='.$request['query']);
        $json = json_decode($str, true);
        return $json;
    }

    public function getweatherdetails(Request $request) { 
        $arrdata = explode(", ", $request['location']);
        $url = str_replace(' ', '%20', 'http://api.wunderground.com/api/2d5fc4594633a8dc/forecast10day/q/'.$arrdata[1].'/'.$arrdata[0].'.json');

        $str = file_get_contents($url);        
        $json = json_decode($str, true);            
        $forecastday = isset($json['forecast']['simpleforecast']['forecastday']) ? $json['forecast']['simpleforecast']['forecastday'] : array();
        return view('dashboard.wheather', ['forecastday' =>$forecastday,'location'=>$request['location']]);        
    }


    public function statisticdata(Request $request)
    {        
       //$request->year = isset($request->year) ? $request->year : date('Y');
        if ($request->user()->id === 0 || $request->user()->dipartimento === 1 || $request->user()->dipartimento === 2) {

            $guadagno = []; $revenues = []; $expenses = [];
            //dd($expenses);
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

            return view('dashboard.statistics_ajax', [
                'statistics' =>$statistics,
                'year' => $request->year
            ]);

        } else
            return redirect('/unauthorized');
    }




    /*=============== Dashboard Statistics sections Start ============== */

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
    }
    public function calcolaGuadagno(&$guadagno, $revenues, $expenses)
    {       
        foreach($revenues as $key=>$val) {
            $guadagno[] = $val + $expenses[$key];
        }   
    }


    /*=============== Dashboard Statistics sections End ============== */


    /* ==================================== Profile section START ======================================== */

    public function mostraprofilo(Request $request) {
        $user = $request->user();        
        $ente = DB::table('corporations')
                ->where('id', $user->id_ente)
                ->first();
        $user_role = DB::table('ruolo_utente')
                ->where('ruolo_id', $user->dipartimento)
                ->first();
                
        $module = DB::table('modulo')
                        ->where('modulo_sub', null)
                        ->get();                    
        $permessi = array();

                if(isset($user->permessi) && !empty($user->permessi)){
                    $permessi = json_decode($user->permessi);
                }

        return view('profilo', [
            'utente' => $user,
            'ente' => $ente,
            'module' => $module,
            'permessi' => $permessi,
            'user_role' => $user_role,
            'link' => DB::table('link_profilo')
                    ->where('id_user', $user->id)
                    ->get()
        ]);
    }

    public function eliminalink(Request $request) {
        DB::table('link_profilo')
                ->where('id', $request->id)
                ->delete();
        return Redirect::back();
    }

    public function aggiornaimmagine(Request $request) {
        DB::enableQueryLog();
        // Aggiorno l'immagine memorizzandola con un nome univoco                   
      	    $validator = Validator::make($request->all(), [
                    'name' => 'required|max:20',                                        
                    /*'email' => 'required|max:255|unique:users,email,'.$request->login_user_id.',id',*/                    
                    'email' => 'required|max:255',                    
                    'sconto' => 'numeric',
                    'sconto_bonus' => 'numeric',
                    'rendita' => 'numeric',
                    'rendita_reseller' => 'numeric',
                    'password' => 'max:64',
                    'logo' => 'image|max:2000'                    
                ]);  
            
                if ($validator->fails()) {
                    return Redirect::back()
                        ->withInput()
                        ->withErrors($validator);
                }                

                $CheckemailExistt = DB::table('users')->where('email',$request->email)->where('id','!=',$request->login_user_id)->count();
                if($CheckemailExistt > 0){
                    return Redirect::back()
                        ->with('msg', '<div class="alert alert-warning"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Email already exist!</div>');
                }


                $oldDetails = DB::table('users')->where('id',$request->login_user_id)->first();
                /*$queries = DB::getQueryLog();
                $last_query = end($queries);
                print_r($last_query);
                print_r($oldDetails);
                exit;*/
                $nome = $oldDetails->logo;
                if ($request->logo != null) {
                    $nome = time() . uniqid() . '-' . '-ente';
                    Storage::put('images/' . $nome, file_get_contents($request->file('logo')->getRealPath()));
                }

                $vecchiapassword = (String)$oldDetails->password;                
                if($request->password!=null) {
                    $vecchiapassword = bcrypt($request->password);
                }


               DB::table('users')
                ->where('id', $request->login_user_id)
                ->update(array(
                'name' => $request->name,
                'email' => $request->email,                
                'password' => $vecchiapassword,
                'sconto' => (isset($request->sconto))? $request->sconto : $oldDetails->sconto,
                'sconto_bonus' => (isset($request->sconto_bonus))? $request->sconto_bonus : $oldDetails->sconto_bonus,
                'rendita' => (isset($request->rendita))? $request->rendita : $oldDetails->rendita,
                'rendita_reseller' => (isset($request->rendita_reseller))? $request->rendita_reseller : $oldDetails->rendita_reseller,
                'is_internal_profile' => (isset($request->is_internal_profile))? $request->is_internal_profile : $oldDetails->is_internal_profile,                
                'logo' => $nome
               ));                    
            return Redirect::back()
                        ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_profile_updated_successfully').'</div>');
    }
    public function aggiungilink(Request $request) {
        $validator = Validator::make($request->all(), [
                    'name' => 'required|max:150',
                    'url' => 'required|max:150',
                    'img' => 'required|image|2000',
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                            ->withInput()
                            ->withErrors($validator);
        }
        // Salvo il nuovo link
        $nome = time() . uniqid() . '-' . '-profilo';
        Storage::put(
                'images/' . $nome, file_get_contents($request->file('img')->getRealPath())
        );
        $id = DB::table('link_profilo')
                ->insert([
            'name' => $request->name,
            'url' => $request->url,
            'image' => $nome,
            'id_user' => $request->user()->id
        ]);

        return Redirect::back();
    }
    /* ==================================== Profile section END ======================================== */
}
