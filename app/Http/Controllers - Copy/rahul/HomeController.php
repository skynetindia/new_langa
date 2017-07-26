<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Mail;
use App\Repositories\CorporationRepository;
use Redirect;
use Validator;
use DB;
use Storage;

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
    public function __construct(CorporationRepository $corporations) {
        $this->middleware('auth');
        $this->corporations = $corporations;
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
          ->get();

        $notifications_json = [];
        foreach ($notifications as $value) {
            $value->type = $value->id.'_n';
            $notifications_json[] = $value;
        }

        $alerts = DB::table('inviare_avviso')
            ->leftjoin('alert', 'inviare_avviso.alert_id', '=', 'alert.alert_id')
            ->select(DB::raw('inviare_avviso.*, alert.alert_id as alrt_id, alert.nome_alert, alert.messaggio'))
            ->where('user_id', $userId)
            ->where('is_deleted', 0)        
            ->get();  

        $alerts_json = [];
        foreach ($alerts as $value) {
            $value->type = $value->id.'_a';
            $alerts_json[] = $value;
        }          

        $notifications_json = array_merge($notifications_json, $alerts_json);
        
        return json_encode($notifications_json);
    }

    public function cancellanotifica(Request $request) {

        return $request->id;
        DB::table('invia_notifica')
           ->where('id', $request->id)
           ->update(array(
                'is_deleted' => 1
        ));

        return Redirect::back()
            ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans("messages.keyword_deletesuccessmsg?").'!</div>');
    }

    public function deletealert(Request $request) {

        DB::table('inviare_avviso')
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

    public function segnalazionerrore(Request $request) {
        $user = $request->user();
        if ($request->screen != null) {
            // Salvo lo screen con un nome unico
            $nome = time() . uniqid() . '-' . '-screen';
            Storage::put(
                    'images/' . $nome, file_get_contents($request->file('screen')->getRealPath())
            );

            $url = url('/storage/app/images') . '/' . $nome;
        } else
            $url = null;
        if (isset($request->love)) {
            Mail::send('layouts.emailringraziamento', ['user' => $request->user(), 'love' => $request->love, 'screen' => $url], function ($m) use ($user) {
                $m->from($user->email, 'Valutazione');
                $m->to('gestione.langa@gmail.com')->cc('easy@langa.tv')->subject('VALUTAZIONE IN EASY LANGA');
            });
            return Redirect::back()
                            ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Grazie per aver valutato Easy, ricordati che senza il tuo supporto Easy non sarebbe quello che è ora</h4></div>');
        } else {
            Mail::send('errors.bug', ['user' => $request->user(), 'url' => $request->posizione, 'errore' => $request->errore, 'screen' => $url], function ($m) use ($user) {
                $m->from($user->email, 'Errore');
                $m->to('gestione.langa@gmail.com')->cc('easy@langa.tv')->subject('ERRORE IN EASY LANGA');
            });
            return Redirect::back()
                            ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Grazie per aver segnalato questo errore, scusaci per il disagio</h4></div>');
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
        return redirect('/');
    }

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
