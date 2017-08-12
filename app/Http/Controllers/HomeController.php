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

/*class Cestino {

    public $id;
    public $tipo;
    public $nome;

}*/

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     *
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
          ->join('corporations', 'invia_notifica.id_ente', '=', 'corporations.id')
          ->select(DB::raw('invia_notifica.*, notifica.id as noti_id, notifica.notification_type, notifica.notification_desc, corporations.nomeazienda as entityName,corporations.id as entityID'))
          ->where('invia_notifica.user_id', $userId)
          ->orderBy('invia_notifica.id', 'desc')      
          /*->where('invia_notifica.is_deleted', 0)*/
          ->get();

        $notifications_json = [];
        foreach ($notifications as $value) {
            $value->type = $value->id.'_n';
            $value->id_ente = $value->entityID." | ".$value->entityName;
            $value->data_lettura = ($value->data_lettura != "0000-00-00 00:00:00") ? $value->data_lettura : "-";
            $value->comment = ($value->comment != "") ? $value->comment : $value->notification_type; 
            $notifications_json[] = $value;
        }

        /*$alerts = DB::table('inviare_avviso')
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
        $notifications_json = array_merge($notifications_json, $alerts_json);*/
        
        return json_encode($notifications_json);
    }

    public function cancellanotifica(Request $request) {
        DB::table('invia_notifica')
           ->where('id', $request->id)
           ->update(array(
                'is_deleted' => 1
        ));
        return Redirect::back()
            ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans("messages.keyword_deletesuccessmsg").'!</div>');    
    }
		
    public function deletealert(Request $request) {

        DB::table('inviare_avviso')
           ->where('id', $request->id)
           ->update(array(
                'is_deleted' => 1
        ));

        return Redirect::back()
            ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans("messages.keyword_deletesuccessmsg").'!</div>');
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
    public function reporterrors(Request $request) {
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
            // Except the screen with a unique namespace
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
                 $m->to('developer7@skynettechnologies.com')->cc('developer7@skynettechnologies.com')->subject("{{trans('messages.keyword_easy_language_assessment')}}");
               /* $m->to('gestione.langa@gmail.com')->cc('easy@langa.tv')->subject('VALUTAZIONE IN EASY LANGA');*/
            });
            return Redirect::back()
                ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_error_notification_messages_saven').'</div>');
        } else {
            Mail::send('errors.bug', ['user' => $request->user(), 'url' => $request->posizione, 'errore' => $request->errore, 'screen' => $url], function ($m) use ($user) {
                $m->from($user->email, 'Errore');
                //$m->to('gestione.langa@gmail.com')->cc('easy@langa.tv')->subject('ERRORE IN EASY LANGA');
                $m->to('developer7@skynettechnologies.com')->cc('developer7@skynettechnologies.com')->subject("{{trans('messages.keyword_errore_in_easy_langa')}}");
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

    /* Update the widgets that show on dashboards */
    public function widgetupdate(Request $request) {        
        $wherecount = array('user_type'=>Auth::user()->dipartimento,'module_id'=>$request->module_id);
        $count = DB::table('dashboard_widgets')->where($wherecount)->count();
        if($count == 0 && $request->action=='add'){
            $id = DB::table('dashboard_widgets')->insert([
            'module_id' => $request->module_id,
            'user_type' => Auth::user()->dipartimento,
            'user_id' => Auth::user()->id,
            'date' => date('Y-m-d')
        ]);
        $response = ($id) ? 'success' : 'fail';
        $msg = ($id) ? '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans("messages.keyword_addsuccessmsg").'!</div>' : '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Add not successfully!</div>' ;
        }
        elseif($request->action == 'delete') {
           $deleted = DB::table('dashboard_widgets')->where(['module_id'=> $request->module_id,'user_type' => Auth::user()->dipartimento,'user_id' => Auth::user()->id])->delete();
           $response = ($deleted) ? 'success' : 'fail';
           $msg = ($deleted) ? '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans("messages.keyword_deletesuccessmsg").'!</div>' : '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Delete not successfully!</div>' ;
        }
        /*DB::table('dashboard_widgets')->where('id', $request->id)->update(array('is_deleted' => 1));
        return Redirect::back()->with('msg', $msg);*/
        return $response;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {                 
        /*return view('onworking');*/
        $Querytype = DB::table('ruolo_utente')->where('ruolo_id', Auth::user()->dipartimento)->first();
        $type = isset($Querytype->nome_ruolo) ? $Querytype->nome_ruolo : "";
        // print_r($type);
        // exit;
        if (Auth::user()->id === 0 || $type === 'Administration') {
            return $this->adminstrator();        
        }
        elseif($type === 'Commercial') { /* Commercial */            
            return $this->commercial();             
        }
        elseif($type === 'Technician') { /* Technician */
            return $this->technician();
        }
        elseif($type === 'Reseller') { /* Reseller */        
            return $this->reseller($request); 
        }
        elseif($type === 'Customer') { /* Client */                    
            return $this->customer($request); 
        }
        else { /* Client and other profiles */
            return $this->otherprofile($request);
        }
    }

    /* this is used for temparary in dashboard */
    public function temp(Request $request) {                
        /* return view('onworking'); */
        $Querytype = DB::table('ruolo_utente')->where('ruolo_id', Auth::user()->dipartimento)->first();
        $type = isset($Querytype->nome_ruolo) ? $Querytype->nome_ruolo : "";
        // print_r($type);
        // exit;
        if (Auth::user()->id === 0 || $type === 'Administration') {
            return $this->adminstrator();        
        }
        elseif($type === 'Commerical') { /* Commercial */
            return $this->commercial(); 
        }
        elseif($type === 'Technician') { /* Technician */
            return $this->technician();
        }
        elseif($type === 'Reseller') { /* Reseller */        
            return $this->reseller($request); 
        }
        elseif($type === 'Client' || $type === 'Customer') { /* Client */                    
            return $this->customer($request); 
        }
    }

    public function getmediafiles(Request $request){  
        DB::enableQueryLog();
        /*$query = "SELECT * FROM media_files WHERE master_id=$request->quote_id and master_type='0'";*/
        //$query = "SELECT * FROM media_files WHERE `media_files`.`master_type` IN('1','6') order by id desc";
        /*$query = "select `media_files`.* from `media_files` where `media_files`.`master_id` IN(select id from projects where is_deleted = 0) and ( `media_files`.`master_type` IN('1','6')) order by id desc";*/
        $userid = Auth::user()->id;
        $userprofileid = Auth::user()->dipartimento;

        if ($userid === 0 || $userprofileid === '0') {            
            $query = "select `media_files`.* from `media_files` where (`media_files`.`master_id` IN(select id from projects where is_deleted = 0) and `media_files`.`master_type`='1') or (`media_files`.`master_type` = '6') order by id desc";
            $quotefiles = DB::select($query);               
        }
        else {  
            $query = "select `media_files`.* from `media_files` where (`media_files`.`master_id` IN(select id from projects where is_deleted = 0 and `projects`.`user_id` = $userid) and `media_files`.`master_type`='1') or (`media_files`.`master_id` = $userid and `media_files`.`master_type` = '6') order by id desc";
        }
        $userprofileid = $request->user()->dipartimento;
        $userid = $request->user()->id;
        $Querytype = DB::table('ruolo_utente')->where('ruolo_id', $userprofileid)->first();
        $type = isset($Querytype->nome_ruolo) ? $Querytype->nome_ruolo : "";
            
        if(isset($request->term) && $request->term != "") {
            $where = ($request->user()->id === 0 || $userprofileid === '0') ? "" : " AND find_in_set('$userprofileid',type) <> 0";
            /*$query = "SELECT * FROM media_files WHERE master_id=$request->quote_id and master_type='0' $where  AND (title LIKE '%$request->term%' OR  description LIKE '%$request->term%')";*/    
              $query = "select `media_files`.* from `media_files` where `media_files`.`master_id` IN(select id from projects where is_deleted = 0 and `projects`.`user_id` = $userid) and (`media_files`.`master_type` IN('1','6')) order by id desc";
            
            /*$query = "select `media_files`.* from `media_files` 
                        inner join `projects` on `media_files`.`master_id` = `projects`.`id` where (`quotes`.`is_deleted` = 0 and `media_files`.`master_type` IN('1','6')) and (`projects`.`user_id` = '$userid') and (`media_files`.title LIKE '%$request->term%' OR `media_files`.description LIKE '%$request->term%') $where";*/

           /* $query = "select `media_files`.* from `media_files` inner join `projects` on `media_files`.`master_id` = `projects`.`id` where (`projects`.`is_deleted` = 0 and `media_files`.`master_type` = 1) and (`projects`.`user_id` = '$userid') and (`media_files`.title LIKE '%$request->term%' OR  `media_files`.description LIKE '%$request->term%') $where
                    union ALL
                    (select `media_files`.* from `media_files` inner join `quotes` on `media_files`.`master_id` = `quotes`.`id` where (`quotes`.`is_deleted` = 0 and `media_files`.`master_type` = 0) and (`quotes`.`user_id` = '$userid' or `quotes`.`idutente` = '$userid') and (`media_files`.title LIKE '%$request->term%' OR `media_files`.description LIKE '%$request->term%') $where)
                    union ALL
                    (select `media_files`.* from `media_files` inner join `tranche` on `media_files`.`master_id` = `tranche`.`id` where (`tranche`.`is_deleted` = 0 and `media_files`.`master_type` = 3) and (`tranche`.`user_id` = '$userid') and (`media_files`.title LIKE '%$request->term%' OR `media_files`.description LIKE '%$request->term%') $where)";*/

            //$query = "SELECT * FROM media_files WHERE  (title LIKE '%$request->term%' OR  description LIKE '%$request->term%') $where";
        }
        /*else if(isset($request->code) && $request->code != "") {
           $query = "SELECT * FROM media_files WHERE `media_files`.`master_type` IN('0','1','6') AND code=$request->code";            
        }*/         
        $updateData = DB::select($query);        
        
        foreach($updateData as $prev) {
            $arrFolder[0]='quote';
            $arrFolder[1]='projects';
            $arrFolder[3]='invoice';
            $arrFolder[4]='quiz';
            $arrFolder[5]='user';
            $arrFolder[6]='dashboard';
            $imagPath = url('/storage/app/images/'.$arrFolder[$prev->master_type].'/'.$prev->name);
            $downloadlink = url('/storage/app/images/'.$arrFolder[$prev->master_type].'/'.$prev->name);
            
            $filename = $prev->name;            
            $arrcurrentextension = explode(".", $filename);
            $extention = end($arrcurrentextension);                            
            $arrextension['docx'] = 'docx-file.jpg';
            $arrextension['pdf'] = 'pdf-file.jpg';
            $arrextension['xlsx'] = 'excel.jpg';
            if(isset($arrextension[$extention])){
                continue;
                $imagPath = url('/storage/app/images/default/'.$arrextension[$extention]);          
            }

            $titleDescriptions = (!empty($prev->title)) ? '<hr><strong>'.$prev->title.'</strong><p>'.$prev->description.'</p>' : "";            
            if($prev->master_type=='6' && $prev->master_id==Auth::user()->id){
                $html = '<tr class="quoteFile_'.$prev->id.'"><td><img src="'.$imagPath.'" height="100" width="100"><a href="'.$downloadlink.'" class="btn btn-info pull-right"  download><i class="fa fa-download"></i></a><a class="btn btn-success pull-right"  onclick="sociallinks('.$prev->id.')"><i class="fa fa-share-alt"></i></a><a class="btn btn-danger pull-right" style="text-decoration: none; color:#fff" onclick="deleteQuoteFile('.$prev->id.')"><i class="fa fa-trash"></i></a>'.$titleDescriptions.'</td></tr>';
            }
            else {
            $html = '<tr class="quoteFile_'.$prev->id.'"><td><img src="'.$imagPath.'" height="100" width="100"><a href="'.$downloadlink.'" class="btn btn-info pull-right"  download><i class="fa fa-download"></i></a><a class="btn btn-success pull-right"  onclick="sociallinks('.$prev->id.')"><i class="fa fa-share-alt"></i></a>'.$titleDescriptions.'</td></tr>';
            }

            $html .='<tr class="quoteFile_'.$prev->id.'"><td>';
           /* $utente_file = DB::table('ruolo_utente')->select('*')->where('is_delete', 0)->where('nome_ruolo','!=','SupperAdmin')->get();                            
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
            }*/
            echo $html .='</td></tr>';
        }
        exit;           
    }
    
    public function uploadmedia(Request $request){
        Storage::put('images/dashboard/' . $request->file('file')->getClientOriginalName(), file_get_contents($request->file('file')->getRealPath()));
        $nome = $request->file('file')->getClientOriginalName();            
            DB::table('media_files')->insert([
            'name' => $nome,
            'code' => $request->code,
            'type'=>$request->user()->dipartimento,
            'master_id'=>$request->user()->id,
            'master_type'=>'6',
            'date_time'=>time()
        ]);                           
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

        /*================== Calendor Sections Start ============== */        
        //$eventi = "";$estimates="";$projects="";$invoices="";
        $type = 0; 
        $this->calendorDetails($eventi,$estimates,$projects,$invoices,$month,$day,$year,$type);
        
        /*================== Calendor Sections End ============== */
        return view('dashboard', [
            'view' => 'adminstrator',            
            'statistics' =>$statistics,
            'year' => $year,
            'day' => $day,
            'month' => $month,
            'forecastday'=>$forecastday,
            'location'=>$arrCurrentLocation['city'].', '.$arrCurrentLocation['country'],
            'giorniMese' => date('t', mktime(0, 0, 0, $month, $day, $year)),
            'nomiMesi' => $this->monthnames,
            'events' => $eventi,
            'enti' => $this->corporations->forUser(Auth::user()),
            'utenti' => DB::table('users')->get(),
            'tipo' => $type,            
            'estimates' => $estimates,
            'projects' => $projects,
            'invoices' => $invoices
        ]);
    }

    public function calendorDetails(&$eventi,&$estimates,&$projects,&$invoices,$month,$day,$year,$type){
    
        if($month == date('n') && $day == 0 && $year == date('Y'))
            $day = date('j');

        if(Auth::user()->id==0 || $type==1)
            $eventi=DB::table('events')->orderBy('mese', 'asc')->get();
        else if($type==0)
            $eventi=DB::table('events')->where('user_id', Auth::user()->id)->orderBy('mese', 'asc')->get();
        
        
        $estimates = array();
        $projects = array();
        $invoices = array();
        /* === Estimates Details === */
        if(Auth::user()->id == 0 && $type==2) {
            $estimates = DB::table('quotes')
            ->leftJoin('users', 'users.id', '=', 'quotes.user_id')
            ->select('users.color as color','users.name','quotes.*')
            ->where('quotes.is_deleted', 0)->where('users.is_delete',0)->get();                                           
        }
        else if($type==2) {            
            $userid = Auth::user()->id;
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
        }

        /* === Project Details === */
        if($type==2){
            $projectwhere['is_deleted'] = 0;
            $projectwhere['users.is_delete'] = 0;
            if(Auth::user()->id != 0) {
                $projectwhere['projects.user_id'] = Auth::user()->id;
            }
            $projects = DB::table('projects')
                ->join('users', 'projects.user_id', '=', 'users.id')
                ->select(DB::raw('projects.*, users.id as uid, users.is_delete, users.color'))
                ->where('datafine','!=','')                
                ->where($projectwhere)
                ->orderBy('projects.id', 'asc')
                ->get();

            /* Invoice Details */
            $invoicewhere['users.is_delete'] = 0;
            if(Auth::user()->id != 0) {
                $invoicewhere['tranche.user_id']=Auth::user()->id;            
            }
            $invoices = DB::table('tranche')
                    ->join('users', 'tranche.user_id','=','users.id')
                    ->select(DB::raw('tranche.*, users.id as uid, users.is_delete, users.color'))                
                    ->where($invoicewhere)
                    ->get();  
        }    
    }

    /* Get the Calenor using ajax */
    public function getCalendarAjax(Request $request){        
        $request->type = isset($request->type) ? $request->type : 0;        
        $day = date('j');
        $month = date('n');
        $year = date('Y');

        $this->calendorDetails($eventi,$estimates,$projects,$invoices,$month,$day,$year,$request->type);              

        /*================== Calendor Sections End ============== */
        return view('dashboard.calendar_ajax', [
            'year' => $year,
            'day' => $day,
            'month' => $month,                                                
            'events' => $eventi,
            'enti' => $this->corporations->forUser(Auth::user()),
            'utenti' => DB::table('users')->get(),
            'tipo' => $request->type,            
            'estimates' => $estimates,
            'projects' => $projects,
            'invoices' => $invoices
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

    /* This function is used to get the data for adminstartor/commercials */
    public function statisticdata(Request $request)
    {        
       //$request->year = isset($request->year) ? $request->year : date('Y');
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

        if ($request->user()->id === 0 || $request->user()->dipartimento === 1) {

            $guadagno = []; $revenues = []; $expenses = [];
            //dd($expenses);
            $this->compexpense($expenses, $request->year);
            $this->compRevenue($revenues, $request->year);
            $this->calcolaGuadagno($guadagno, $revenues, $expenses);
            
            
            $statistics = array('month' => $monthName, 'revenue' => $revenues, 'expense' => $expenses, 'earn' => $guadagno);
            return view('dashboard.statistics_ajax', [
                'statistics' =>$statistics,
                'year' => $request->year
            ]);
        } 
        else if($request->user()->dipartimento === 2) {
             $notconfirm = []; $pendingconfirm = []; $confirm = [];
            //dd($expenses);
            $this->confirm($confirm, $request->year);
            $this->pendingConfirm($pendingconfirm, $request->year);
            $this->notConfirm($notconfirm, $pendingconfirm, $confirm,$request->year);  
            $statistics = array('month' => $monthName, 'pendingconfirm' => $pendingconfirm, 'confirm' => $confirm, 'notconfirm' => $notconfirm);                   
            return view('dashboard.commercial_statistics_ajax', [
                'statistics' =>$statistics,
                'year' => $request->year
            ]);  
        }
        // else {
        //     return redirect('/unauthorized');
        // }
    }  


 /* This function is used to get the data for adminstartor/commercials FILTER BY DATE */
    public function statistic_date(Request $request)
    {        
       //$request->year = isset($request->year) ? $request->year : date('Y');
        $monthName['01'] = trans("messages.keyword_january");
        $monthName['02'] = trans("messages.keyword_february");
        $monthName['03'] = trans("messages.keyword_march");
        $monthName['04'] = trans("messages.keyword_april");
        $monthName['05'] = trans("messages.keyword_may");
        $monthName['06'] = trans("messages.keyword_june");
        $monthName['07'] = trans("messages.keyword_july");
        $monthName['08'] = trans("messages.keyword_august");
        $monthName['09'] = trans("messages.keyword_september");
        $monthName['10'] = trans("messages.keyword_october");
        $monthName['11'] = trans("messages.keyword_november");
        $monthName['12'] = trans("messages.keyword_december");        
        
        $year = isset($request->year) ? $request->year : '0';
        $startDate = isset($request->startDate) ? $request->startDate : '0';
        $endDate = isset($request->endDate) ? $request->endDate : '0';
        /*$month= date("F",$time);*/
        $startyear = ($startDate != '0') ? date("Y",strtotime($startDate)) : '0';
        $endyear = ($endDate != '0') ? date("Y",strtotime($endDate)) : '0';
        $arrmonth = array();  
        if($year == '0' && $startDate != '0' && $endDate !='0') {              
            $idate = date("Ym", strtotime($startDate));
            while($idate <= date("Ym", strtotime($endDate))) {
                /*echo $idate."\n";*/                
                $arrmonth[] = $monthName[substr($idate, -2)];
                if(substr($idate, 4, 2) == "12"){
                    $idate = (date("Y", strtotime($idate."01")) + 1)."01";
                }
                else {
                    $idate++;
                }
            }               
        }
        else {
            $arrmonth = array_values($monthName);            
        }        

        if ($request->user()->id === 0 || $request->user()->dipartimento === 1) {
            $guadagno = []; $revenues = []; $expenses = [];
            //dd($expenses);
            $this->compexpense($expenses, $request->year);
            $this->compRevenue($revenues, $request->year);
            $this->calcolaGuadagno($guadagno, $revenues, $expenses);
            $statistics = array('month' => $arrmonth, 'revenue' => $revenues, 'expense' => $expenses, 'earn' => $guadagno);
            return view('dashboard.statistics_ajax', [
                'statistics' =>$statistics,
                'year' => $request->year,
                'startDate'=>$startDate,
                'endDate'=>$endDate
            ]);
        } 
        else if($request->user()->dipartimento === 2 || $request->user()->dipartimento === 4) {
             $notconfirm = []; $pendingconfirm = []; $confirm = [];
            //dd($expenses);
            $this->confirm($confirm, $year,$startDate, $endDate);
            $this->pendingConfirm($pendingconfirm, $year,$startDate, $endDate);
            $this->notConfirm($notconfirm, $pendingconfirm, $confirm,$year,$startDate, $endDate);  
            $totalYear = (date("Y", strtotime($endDate)) - date("Y", strtotime($startDate)));
            if($totalYear > 2){
                $iyear = date("Y", strtotime($startDate));
                 while($iyear <= date("Y", strtotime($endDate))) {
                    /*echo $idate."\n";*/                
                    $arryear[] = $iyear;
                    $iyear++;                
                }
               $arrmonth=$arryear;
            }            

            $statistics = array('month' => $arrmonth, 'pendingconfirm' => $pendingconfirm, 'confirm' => $confirm, 'notconfirm' => $notconfirm);      
            return view('dashboard.commercial_statistics_ajax', [
                'statistics' =>$statistics,
                'year' => ($year=='0') ? $startyear : $year,
                'startDate'=> $startDate,
                'endDate'=> $endDate
            ]);  
        }
        else {
            return redirect('/unauthorized');
        }
    }



    /*=============== Adminstrator Dashboard Statistics sections Start ============== */
    public function compexpense(&$expenses, $year) {
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
        $timestamp = strtotime('1-'.$i.'-'.$year);
        $revenue = DB::table('tranche')
        ->Join('users', 'users.id', '=', 'tranche.user_id')
        ->selectRaw("sum(imponibile) as cost,dipartimento ")
        ->where('privato', 0)
        /*->where('dipartimento', 2)*/
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
    public function calcolaGuadagno(&$guadagno, $revenues, $expenses) {       
        foreach($revenues as $key=>$val) {
            $guadagno[] = $val + $expenses[$key];
        }   
    }
    /*=============== Adminstrator Dashboard Statistics sections End ============== */
    

    /*=============== Commercial Dashboard Sections Start ============== */

    public function commercial() {
        $day = date('j');
        $month = date('n');
        $year = date('Y');
        $arrCurrentLocation = getLocationInfoByIp();

        /*=============== Statistics sections ============== */            
            $notconfirm = []; $pendingconfirm = []; $confirm = [];
            
            $this->confirm($confirm, $year);            
            $this->pendingConfirm($pendingconfirm, $year);            
            $this->notConfirm($notconfirm, $pendingconfirm, $confirm,$year);            
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
        $statistics = array('month' => $monthName, 'pendingconfirm' => $pendingconfirm, 'confirm' => $confirm, 'notconfirm' => $notconfirm);
        /* ===================== Weather section =========================== */     
        $url = str_replace(' ', '%20', 'http://api.wunderground.com/api/2d5fc4594633a8dc/forecast10day/q/'.$arrCurrentLocation['country'].'/'.$arrCurrentLocation['city'].'.json');
        //$url = urlencode();
        $str = file_get_contents($url);        
        $json = json_decode($str, true);    
        
        $forecastday = (isset($json['forecast']['simpleforecast']['forecastday']) && !isset($json['error'])) ? $json['forecast']['simpleforecast']['forecastday'] : array();

        /* ================== Calendor Sections ============== */               
        //$eventi = "";$estimates="";$projects="";$invoices="";
        $type = 0;
        $this->calendorDetails($eventi,$estimates,$projects,$invoices,$month,$day,$year,$type);              
        /*================== Calendor Sections End ============== */

        /*============================ Reseller Login Details ===================== */
        $usertype = DB::table('ruolo_utente')->where('nome_ruolo', 'Reseller')->orwhere('nome_ruolo', 'Reseller')->first();
        $resellerdetails  = DB::table('users')->where(['dipartimento'=>$usertype->ruolo_id,'is_delete'=>0])->get();
        
        return view('dashboard',[
            'view' => 'commercial',            
            'statistics' =>$statistics,
            'year' => $year,
            'day' => $day,
            'month' => $month,
            'forecastday'=>$forecastday,
            'location'=>$arrCurrentLocation['city'].', '.$arrCurrentLocation['country'],
            'giorniMese' => date('t', mktime(0, 0, 0, $month, $day, $year)),
            'nomiMesi' => $this->monthnames,
            'events' => $eventi,
            'enti' => $this->corporations->forUser(Auth::user()),
            'utenti' => DB::table('users')->get(),
            'tipo' => 0,            
            'estimates' => $estimates,
            'projects' => $projects,
            'invoices' => $invoices,
            'resellerdetails'=>$resellerdetails
        ]);
    }

    public function getjsonreseller(){
        $usertype = DB::table('ruolo_utente')->where('nome_ruolo', 'Reseller')->orwhere('nome_ruolo', 'Reseller')->first();
        $resellerdetails  = DB::table('users')->where(['dipartimento'=>$usertype->ruolo_id,'is_delete'=>0])->get();
        $arrrdetails = array();
        foreach($resellerdetails as $key => $val){
            $val->city = $val->city." ".$val->state;
            $arrrdetails[] = $val; 
        }
        return json_encode($arrrdetails);
    }

    public function confirm(&$confirm, $year, $startDate = '0', $endDate ='0') {        
        $startMonth =  1;
        $endMonth = 12;
        
        if($year == '0' && $startDate != '0' && $endDate !='0') {
            
            $startMonth = date("m",strtotime($startDate));
            $endMonth = date("m",strtotime($endDate));                       
            $startYear = date("Y",strtotime($startDate));
            $endYear = date("Y",strtotime($endDate));
            $totalmonth = (($endYear - $startYear) * 12) + ($endMonth - $startMonth);
            /*$endMonth = ($totalmonth > 12) ? $totalmonth : 12;
            $startMonth = ($totalmonth > 12) ? $startMonth : 1;*/
        }
        else {

             $startYear = $year;
             $endYear = $year;
        }

        $totalYear = ($endYear - $startYear);

        for($y = $startYear; $y <= $endYear; $y++) {

            $endmonth = ($y == $endYear) ? $endMonth : 12;
            $startmonth = ($y == $startYear) ? $startMonth : 01;

            /* Get the Year wise data */
            if($totalYear > 2){                           
                    /*$timestamp = ($year != 0) ? strtotime('1-'.$i.'-'.$year) : strtotime('1-'.$i.'-'.$y);            
                    $timestamp =   
                    $last_day = date('01-01-Y', strtotime('-1-'.$y));
                    $last_day = date('31-12-Y', strtotime('1-1-'.$y));*/
                    
                    $arrbetween = array(date('Y-01-01',strtotime('1-1-'.$y)),date('Y-12-31',strtotime('1-1-'.$y))); 

                    DB::connection()->enableQueryLog();
                    $preventivi = DB::table('quotes')
                    ->selectRaw("sum(quotes.totale) as confirmamount")
                    ->join('statipreventivi', 'quotes.id', '=', 'statipreventivi.id_preventivo')
                    ->join('statiemotivipreventivi', 'statiemotivipreventivi.id', '=', 'statipreventivi.id_tipo')
                    ->where(function($query) {
                        $query->where('quotes.user_id', '=', Auth::user()->id)
                            ->orWhere('quotes.idutente', '=', Auth::user()->id);
                    })->where('statiemotivipreventivi.id', '6')
                    ->whereBetween('statipreventivi.created_at',$arrbetween)
                    ->where('quotes.is_deleted', 0)->first();                  
                    
                   /* $queries = DB::getQueryLog();
                    $last_query = end($queries);
                    print_r($last_query);                
                    exit;*/

                    $confirm[] =  ($preventivi->confirmamount!=null)?$preventivi->confirmamount:0;               
            }
            else {
                for($i = $startmonth; $i <= $endmonth; $i++) {
                    /*if($i < 10)
                        $i = '0' . $i;*/                
                    $timestamp = ($year != 0) ? strtotime('1-'.$i.'-'.$year) : strtotime('1-'.$i.'-'.$y);            
                    $arrbetween = array(date('Y-m-01',$timestamp),date('Y-m-t',$timestamp)); 

                    DB::connection()->enableQueryLog();
                    $preventivi = DB::table('quotes')
                    ->selectRaw("sum(quotes.totale) as confirmamount")
                    ->join('statipreventivi', 'quotes.id', '=', 'statipreventivi.id_preventivo')
                    ->join('statiemotivipreventivi', 'statiemotivipreventivi.id', '=', 'statipreventivi.id_tipo')
                    ->where(function($query) {
                        $query->where('quotes.user_id', '=', Auth::user()->id)
                            ->orWhere('quotes.idutente', '=', Auth::user()->id);
                    })->where('statiemotivipreventivi.id', '6')
                    ->whereBetween('statipreventivi.created_at',$arrbetween)
                    ->where('quotes.is_deleted', 0)->first();          
                    // $query = DB::getQueryLog();
                    // $lastQuery = end($query);
        
                    // dd($preventivi);
                   /* $queries = DB::getQueryLog();
                    $last_query = end($queries);
                    print_r($last_query);                
                    exit;*/
                    $confirm[] =  ($preventivi->confirmamount!=null)?$preventivi->confirmamount:0;
                }
            }
        }
    }
    public function pendingConfirm(&$pendingconfirm, $year, $startDate = '0', $endDate ='0')
    {
        $startMonth =  1;
        $endMonth = 12;
        if($year == '0' && $startDate != '0' && $endDate !='0') {
              $startMonth = date("m",strtotime($startDate));
              $endMonth = date("m",strtotime($endDate));
              $startYear = date("Y",strtotime($startDate));
              $endYear = date("Y",strtotime($endDate));
              $totalmonth = (($endYear - $startYear) * 12) + ($endMonth - $startMonth);
              /*$endMonth = ($totalmonth > 12) ? $totalmonth : 12;
              $startMonth = ($totalmonth > 12) ? $startMonth : 1;*/
        } 
        else {
             $startYear = $year;
             $endYear = $year;
        }  
        $totalYear = ($endYear - $startYear);  

        for($y = $startYear; $y <= $endYear; $y++) {
            $endmonth = ($y == $endYear) ? $endMonth : 12;                         
            $startmonth = ($y == $startYear) ? $startMonth : 01;  
            if($totalYear > 2){                                                                  
                    $arrbetween = array(date('Y-01-01',strtotime('1-1-'.$y)),date('Y-12-31',strtotime('1-1-'.$y))); 

                    DB::connection()->enableQueryLog();
                    $preventivi = DB::table('quotes')
                    ->selectRaw("sum(quotes.totale) as confirmamount")
                    ->join('statipreventivi', 'quotes.id', '=', 'statipreventivi.id_preventivo')
                    ->join('statiemotivipreventivi', 'statiemotivipreventivi.id', '=', 'statipreventivi.id_tipo')
                    ->where(function($query) {
                        $query->where('quotes.user_id', '=', Auth::user()->id)
                            ->orWhere('quotes.idutente', '=', Auth::user()->id);
                    })->where('statiemotivipreventivi.id', '9')
                    ->whereBetween('statipreventivi.created_at',$arrbetween)
                    ->where('quotes.is_deleted', 0)->first();                  
                     /*$queries = DB::getQueryLog();
                        $last_query = end($queries);
                        print_r($last_query);                
                        exit;*/
                    $pendingconfirm[] =  ($preventivi->confirmamount!=null)?$preventivi->confirmamount:0;                
            }
            else {
                for($i = $startmonth; $i <= $endmonth; $i++) {
                    /*if($i < 10)
                        $i = '0' . $i;
                    $timestamp=strtotime('1-'.$i.'-'.$year);
                     $arrbetween = ($year != 0) ? array(date('Y-m-01',$timestamp),date('Y-m-t',$timestamp)) : array(date('Y-m-d',strtotime($startDate)),date('Y-m-d',strtotime($endDate)));   */
                    $timestamp = ($year != 0) ? strtotime('1-'.$i.'-'.$year) : strtotime('1-'.$i.'-'.$y);            
                    $arrbetween = array(date('Y-m-01',$timestamp),date('Y-m-t',$timestamp)); 

                    DB::connection()->enableQueryLog();
                    $preventivi = DB::table('quotes')
                    ->selectRaw("sum(quotes.totale) as confirmamount")
                    ->join('statipreventivi', 'quotes.id', '=', 'statipreventivi.id_preventivo')
                    ->join('statiemotivipreventivi', 'statiemotivipreventivi.id', '=', 'statipreventivi.id_tipo')
                    ->where(function($query) {
                        $query->where('quotes.user_id', '=', Auth::user()->id)
                            ->orWhere('quotes.idutente', '=', Auth::user()->id);
                    })->where('statiemotivipreventivi.id', '9')
                    ->whereBetween('statipreventivi.created_at',$arrbetween)
                    ->where('quotes.is_deleted', 0)->first();                  
                     /*$queries = DB::getQueryLog();
                        $last_query = end($queries);
                        print_r($last_query);                
                        exit;*/
                    $pendingconfirm[] =  ($preventivi->confirmamount!=null)?$preventivi->confirmamount:0;
                }


            } 
        }       
    }
    public function notConfirm(&$notconfirm, $pendingconfirm, $confirm,$year, $startDate = '0', $endDate ='0') {               
        DB::connection()->enableQueryLog();
        $startMonth =  1;
        $endMonth = 12;
        if($year == '0' && $startDate != '0' && $endDate !='0') {
              $startMonth = date("m",strtotime($startDate));
              $endMonth = date("m",strtotime($endDate));
              $startYear = date("Y",strtotime($startDate));
              $endYear = date("Y",strtotime($endDate));
              $totalmonth = (($endYear - $startYear) * 12) + ($endMonth - $startMonth);
              /*$endMonth = ($totalmonth > 12) ? $totalmonth : 12;
              $startMonth = ($totalmonth > 12) ? $startMonth : 1;*/
        }  
        else {
             $startYear = $year;
             $endYear = $year;
        }    
        $totalYear = ($endYear - $startYear);  
         for($y = $startYear; $y <= $endYear; $y++) {
            $endmonth = ($y == $endYear) ? $endMonth : 12;                         
            $startmonth = ($y == $startYear) ? $startMonth : 01;                        
             if($totalYear > 2){                                                 
                $arrbetween = array(date('Y-01-01',strtotime('1-1-'.$y)),date('Y-12-31',strtotime('1-1-'.$y)));            
                DB::connection()->enableQueryLog();
                $preventivi = DB::table('quotes')
                ->selectRaw("sum(quotes.totale) as confirmamount")
                ->join('statipreventivi', 'quotes.id', '=', 'statipreventivi.id_preventivo')
                ->join('statiemotivipreventivi', 'statiemotivipreventivi.id', '=', 'statipreventivi.id_tipo')
                ->where(function($query) {
                    $query->where('quotes.user_id', '=', Auth::user()->id)
                        ->orWhere('quotes.idutente', '=', Auth::user()->id);
                })->where('statiemotivipreventivi.id', '8')
                ->whereBetween('statipreventivi.created_at',$arrbetween)
                ->where('quotes.is_deleted', 0)->first();                  
                 /*$queries = DB::getQueryLog();
                    $last_query = end($queries);
                    print_r($last_query);                
                    exit;*/
                $notconfirm[] =  ($preventivi->confirmamount!=null)?$preventivi->confirmamount:0;              
          }
          else {
            for($i = $startmonth; $i <= $endmonth; $i++) {
       
            /*if($i < 10)
                $i = '0' . $i;
            $timestamp=strtotime('1-'.$i.'-'.$year);
             $arrbetween = ($year != 0) ? array(date('Y-m-01',$timestamp),date('Y-m-t',$timestamp)) : array(date('Y-m-d',strtotime($startDate)),date('Y-m-d',strtotime($endDate)));   */
             $timestamp = ($year != 0) ? strtotime('1-'.$i.'-'.$year) : strtotime('1-'.$i.'-'.$y);            
             $arrbetween = array(date('Y-m-01',$timestamp),date('Y-m-t',$timestamp)); 
           

            DB::connection()->enableQueryLog();
            $preventivi = DB::table('quotes')
            ->selectRaw("sum(quotes.totale) as confirmamount")
            ->join('statipreventivi', 'quotes.id', '=', 'statipreventivi.id_preventivo')
            ->join('statiemotivipreventivi', 'statiemotivipreventivi.id', '=', 'statipreventivi.id_tipo')
            ->where(function($query) {
                $query->where('quotes.user_id', '=', Auth::user()->id)
                    ->orWhere('quotes.idutente', '=', Auth::user()->id);
            })->where('statiemotivipreventivi.id', '8')
            ->whereBetween('statipreventivi.created_at',$arrbetween)
            ->where('quotes.is_deleted', 0)->first();                  
             /*$queries = DB::getQueryLog();
                $last_query = end($queries);
                print_r($last_query);                
                exit;*/
            $notconfirm[] =  ($preventivi->confirmamount!=null)?$preventivi->confirmamount:0;
          }
          }
        }        
    }
    /*=============== Commercial Dashboard sections End ============== */

    /*=============== Technician Dashboard Sections Start ============== */
    public function technician() {
		DB::connection()->enableQueryLog();
        $day = date('j');
        $month = date('n');
        $year = date('Y');
        $arrCurrentLocation = getLocationInfoByIp();

        /* ===================== Weather section =========================== */     
        $url = str_replace(' ', '%20', 'http://api.wunderground.com/api/2d5fc4594633a8dc/forecast10day/q/'.$arrCurrentLocation['country'].'/'.$arrCurrentLocation['city'].'.json');
        
        $str = file_get_contents($url);        
        $json = json_decode($str, true);    
        
       $forecastday = (isset($json['forecast']['simpleforecast']['forecastday']) && !isset($json['error'])) ? $json['forecast']['simpleforecast']['forecastday'] : array();

        $arrWhere = array('user_id'=>Auth::user()->id,'is_deleted'=>0);
        $project = DB::table('projects')->where($arrWhere)->where('statoemotivo','!=','12')->where('progresso','!=','100')->where('statoemotivo','!=','FINE PROGETTO')->orWhere('statoemotivo',null)->get();		
			/*$queries = DB::getQueryLog();
            $last_query = end($queries);
			echo "dd";
            print_r($last_query);
            exit;*/
			
        $arrchartdetails = array();
        if(!$project->isEmpty()){

            foreach($project as $keyp => $valp){

            $quote = DB::table('quotes')->where('id', $valp->id_preventivo)->first();

            $dipartimento= (isset($quote->dipartimento) && !empty($quote->dipartimento)) ? $quote->dipartimento : '1';

            // DB::connection()->enableQueryLog();
            //$processing = DB::table('lavorazioni')->where('departments_id', $dipartimento)->get();
            $arrchartdetails[] = DB::select("select `lavorazioni`.*, AVG(`progetti_lavorazioni`.`completamento`) as `completedPercentage` from `lavorazioni` left join `progetti_lavorazioni` on `lavorazioni`.`id` = `progetti_lavorazioni`.`completato` AND `progetti_lavorazioni`.`id_progetto` = $valp->id WHERE `lavorazioni`.`departments_id`=$dipartimento GROUP BY id ORDER BY completedPercentage DESC");
            
           /*$arrchartdetails[] = DB::select("select `oggettostato`.*, `progetti_lavorazioni`.`completamento` as `completedPercentage` from `oggettostato` left join `progetti_lavorazioni` on `oggettostato`.`id` = `progetti_lavorazioni`.`completato` AND `progetti_lavorazioni`.`id_progetto` = $valp->id");*/
            }

        } else {

            $dept = Auth::user()->dipartimento;
            $processing = DB::table('lavorazioni')->where('departments_id', $dept)->get();
            foreach ($processing as $value) {
                $value->completedPercentage = 0;
                $arrchartdetails[] = $value;
            }
            $arrchartdetails = array($arrchartdetails);
        }		

        /* ================== Calendor Sections ============== */
        //$eventi = "";$estimates="";$projects="";$invoices="";
        
        $type = 0;
        $this->calendorDetails($eventi,$estimates,$projects,$invoices,$month,$day,$year,$type); 
        
        /*================== Calendor Sections End ============== */        

        return view('dashboard',[
            'view' => 'technician',            
            'chartdetails' =>$arrchartdetails,
            'year' => $year,
            'day' => $day,
            'month' => $month,
            'forecastday'=>$forecastday,
            'location'=>$arrCurrentLocation['city'].', '.$arrCurrentLocation['country'],
            'giorniMese' => date('t', mktime(0, 0, 0, $month, $day, $year)),
            'nomiMesi' => $this->monthnames,
            'events' => $eventi,
            'enti' => $this->corporations->forUser(Auth::user()),
            'utenti' => DB::table('users')->get(),
            'tipo' =>  0,            
            'estimates' => $estimates,
            'projects' => $projects,
            'invoices' => $invoices,
        ]);
    }
  /*=============== Technician Dashboard Sections End ============== */


    /*=============== Customer Dashboard Sections Start ============== */
    public function customer(Request $request) {
        $day = date('j');
        $month = date('n');
        $year = date('Y');
        $arrCurrentLocation = getLocationInfoByIp();

        /* ===================== Weather section =========================== */     
        $url = str_replace(' ', '%20', 'http://api.wunderground.com/api/2d5fc4594633a8dc/forecast10day/q/'.$arrCurrentLocation['country'].'/'.$arrCurrentLocation['city'].'.json');
        //$url = urlencode();
        $str = file_get_contents($url);        
        $json = json_decode($str, true);    
        
        $forecastday = (isset($json['forecast']['simpleforecast']['forecastday']) && !isset($json['error'])) ? $json['forecast']['simpleforecast']['forecastday'] : array();

        DB::enableQueryLog();
        
        $partecipanti = DB::table('progetti_partecipanti')
            ->select('id_progetto')
            ->where('id_user', Auth::user()->id)
            ->get();

        $projects = DB::table('projects')
            ->join('users', 'projects.user_id', '=', 'users.id')
            ->select('projects.*')
            ->whereIn('projects.id', json_decode(json_encode($partecipanti), true))
            ->orWhere('projects.user_id', Auth::user()->id)
            ->where('users.is_delete', '=', 0)
            ->where('projects.statoemotivo','!=','12')
            ->where('projects.progresso','!=','100')
            ->where('projects.statoemotivo','!=','FINE PROGETTO')
            ->paginate(2);
        /*$arrWhere = array('user_id'=>Auth::user()->id,'is_deleted'=>0);        
        $projects = DB::table('projects')->where($arrWhere)->where('statoemotivo','!=','12')->where('progresso','!=','100')->where('statoemotivo','!=','FINE PROGETTO')->paginate(2);*/
        
        $arrchartdetails = array();
        $arrProjectdetails = array();
        foreach($projects as $keyp => $valp) {            
            $quote = DB::table('quotes')->where('id', $valp->id_preventivo)->first();
            $dipartimento= (isset($quote->dipartimento) && !empty($quote->dipartimento)) ? $quote->dipartimento : '1';
            /*$processing = DB::table('lavorazioni')->where('departments_id', $dipartimento)->get();*/

           //$arrProjectdetails[$valp->id] = $valp;
           /*$arrchartdetails[$valp->id] = DB::select("select `oggettostato`.*, `progetti_lavorazioni`.`completamento` as `completedPercentage` from `oggettostato` left join `progetti_lavorazioni` on `oggettostato`.`id` = `progetti_lavorazioni`.`completato` AND `progetti_lavorazioni`.`id_progetto` = $valp->id");*/

           $arrchartdetails[$valp->id] = DB::select("select `lavorazioni`.*, AVG(`progetti_lavorazioni`.`completamento`) as `completedPercentage` from `lavorazioni` left join `progetti_lavorazioni` on `lavorazioni`.`id` = `progetti_lavorazioni`.`completato` AND `progetti_lavorazioni`.`id_progetto` = $valp->id WHERE `lavorazioni`.`departments_id`=$dipartimento GROUP BY id ORDER BY completedPercentage DESC");
        } 		

        $whereid = explode(',',Auth::user()->id_ente);
        $responsabilelangaEntity = DB::table('corporations')->whereIn('id', $whereid)->get();
        $arrresponsibleid = array();
        foreach($responsabilelangaEntity as $rkey => $rval){
            if($rval->responsiblelang_id != ""){
             array_push($arrresponsibleid, $rval->responsiblelang_id);               
            }            
        }
        $arrresponsibleid = implode(',',$arrresponsibleid);
        $arrresponsibleid = explode(',',$arrresponsibleid);
        
        $responsabilelanga = DB::table('users')->whereIn('id', $arrresponsibleid)->get();                    

         if ($request->ajax()) {
            return view('dashboard.client_projects_ajax', [
            'view' => 'clients',            
            'chartdetails' =>$arrchartdetails,
            'projects' =>$projects,
            'enti' => $this->corporations->forUser(Auth::user()),
            'utenti' => DB::table('users')->get(),
            'tipo' => 1
            ])->render();  
        }          
        return view('dashboard',[
            'view' => 'clients',            
            'chartdetails' =>$arrchartdetails,
            'projects' =>$projects,
            'year' => $year,
            'day' => $day,
            'month' => $month,
            'forecastday'=>$forecastday,
            'location'=>$arrCurrentLocation['city'].', '.$arrCurrentLocation['country'],
            'giorniMese' => date('t', mktime(0, 0, 0, $month, $day, $year)),
            'nomiMesi' => $this->monthnames,            
            'enti' => $this->corporations->forUser(Auth::user()),
            'utenti' => DB::table('users')->get(),
            'responsabilelanga'=>$responsabilelanga,
            'tipo' => 1
        ]);
    }
    /*=============== Customer Dashboard Sections End ============== */

    
    /*=============== Other Profile Dashboard Sections Start ============== */
    public function otherprofile(Request $request) {
        $day = date('j');
        $month = date('n');
        $year = date('Y');
        $arrCurrentLocation = getLocationInfoByIp();

        /* ===================== Weather section =========================== */     
        $url = str_replace(' ', '%20', 'http://api.wunderground.com/api/2d5fc4594633a8dc/forecast10day/q/'.$arrCurrentLocation['country'].'/'.$arrCurrentLocation['city'].'.json');
        //$url = urlencode();
        $str = file_get_contents($url);        
        $json = json_decode($str, true);            
        $forecastday = (isset($json['forecast']['simpleforecast']['forecastday']) && !isset($json['error'])) ? $json['forecast']['simpleforecast']['forecastday'] : array();
        DB::enableQueryLog();        
        $partecipanti = DB::table('progetti_partecipanti')
            ->select('id_progetto')
            ->where('id_user', Auth::user()->id)
            ->get();

        $projects = DB::table('projects')
            ->join('users', 'projects.user_id', '=', 'users.id')
            ->select('projects.*')
            ->whereIn('projects.id', json_decode(json_encode($partecipanti), true))
            ->orWhere('projects.user_id', Auth::user()->id)
            ->where('users.is_delete', '=', 0)
            ->where('projects.statoemotivo','!=','12')
            ->where('projects.progresso','!=','100')
            ->where('projects.statoemotivo','!=','FINE PROGETTO')
            ->paginate(2);
        /*$arrWhere = array('user_id'=>Auth::user()->id,'is_deleted'=>0);        
        $projects = DB::table('projects')->where($arrWhere)->where('statoemotivo','!=','12')->where('progresso','!=','100')->where('statoemotivo','!=','FINE PROGETTO')->paginate(2);*/
        
        $arrchartdetails = array();
        $arrProjectdetails = array();
        foreach($projects as $keyp => $valp) {            
            $quote = DB::table('quotes')->where('id', $valp->id_preventivo)->first();
            $dipartimento= (isset($quote->dipartimento) && !empty($quote->dipartimento)) ? $quote->dipartimento : '1';
            /*$processing = DB::table('lavorazioni')->where('departments_id', $dipartimento)->get();*/

           //$arrProjectdetails[$valp->id] = $valp;
           /*$arrchartdetails[$valp->id] = DB::select("select `oggettostato`.*, `progetti_lavorazioni`.`completamento` as `completedPercentage` from `oggettostato` left join `progetti_lavorazioni` on `oggettostato`.`id` = `progetti_lavorazioni`.`completato` AND `progetti_lavorazioni`.`id_progetto` = $valp->id");*/

           $arrchartdetails[$valp->id] = DB::select("select `lavorazioni`.*, AVG(`progetti_lavorazioni`.`completamento`) as `completedPercentage` from `lavorazioni` left join `progetti_lavorazioni` on `lavorazioni`.`id` = `progetti_lavorazioni`.`completato` AND `progetti_lavorazioni`.`id_progetto` = $valp->id WHERE `lavorazioni`.`departments_id`=$dipartimento GROUP BY id ORDER BY completedPercentage DESC");
        }       

        $whereid = explode(',',Auth::user()->id_ente);
        $responsabilelangaEntity = DB::table('corporations')->whereIn('id', $whereid)->get();
        $arrresponsibleid = array();
        foreach($responsabilelangaEntity as $rkey => $rval){
            if($rval->responsiblelang_id != ""){
             array_push($arrresponsibleid, $rval->responsiblelang_id);               
            }            
        }
        $arrresponsibleid = implode(',',$arrresponsibleid);
        $arrresponsibleid = explode(',',$arrresponsibleid);
        
        $responsabilelanga = DB::table('users')->whereIn('id', $arrresponsibleid)->get();                    

         if ($request->ajax()) {
            return view('dashboard.client_projects_ajax', [
            'view' => 'clients',            
            'chartdetails' =>$arrchartdetails,
            'projects' =>$projects,
            'enti' => $this->corporations->forUser(Auth::user()),
            'utenti' => DB::table('users')->get(),
            'tipo' => 1
            ])->render();  
        }          
        return view('dashboard',[
            'view' => 'otherprofile',            
            'chartdetails' =>$arrchartdetails,
            'projects' =>$projects,
            'year' => $year,
            'day' => $day,
            'month' => $month,
            'forecastday'=>$forecastday,
            'location'=>$arrCurrentLocation['city'].', '.$arrCurrentLocation['country'],
            'giorniMese' => date('t', mktime(0, 0, 0, $month, $day, $year)),
            'nomiMesi' => $this->monthnames,            
            'enti' => $this->corporations->forUser(Auth::user()),
            'utenti' => DB::table('users')->get(),
            'responsabilelanga'=>$responsabilelanga,
            'departments'=> DB::table('departments')->get(),
            'tipo' => 1
        ]);
    }
    public function getdepartmentpackage(Request $request){
        $packagedetails = DB::table('pack')->where('departments_id',$request->departmentid)->get();
        $html = "";
        foreach ($packagedetails as $key => $value) {
            $imageurl = url('storage/app/images/'.$value->icon);
            $html.='<div class="wrap-shot" onclick="fun_package('.$value->id.')">
                            <div class="icon-shot"><img src="'.$imageurl.'" alt="Video Shooting" class="img-responsive"></div>
                            <div class="video-shot-content">
                                <h3>'.$value->code.'</h3>
                                <p>'.$value->label.'</p>
                                <p>'.nl2br($value->description).'</p>
                                <input type="hidden" class="hidden-package" value="'.$value->id.'">
                            </div>
                        </div>';
        }
        return $html;        
    }
    /*=============== Other Profile Dashboard Sections End ============== */

    /*=============== Reseller Dashboard Sections Start ============== */
    public function reseller(Request $request) {
        $day = date('j');
        $month = date('n');
        $year = date('Y');
        $arrCurrentLocation = getLocationInfoByIp();

        /*=============== Statistics sections ============== */            
            $notconfirm = []; $pendingconfirm = []; $confirm = [];
            //dd($expenses);
            $this->confirm($confirm, $year);
            $this->pendingConfirm($pendingconfirm, $year);
            $this->notConfirm($notconfirm, $pendingconfirm, $confirm,$year);            
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
        $statistics = array('month' => $monthName, 'pendingconfirm' => $pendingconfirm, 'confirm' => $confirm, 'notconfirm' => $notconfirm);
        /* ===================== Weather section =========================== */     
        $url = str_replace(' ', '%20', 'http://api.wunderground.com/api/2d5fc4594633a8dc/forecast10day/q/'.$arrCurrentLocation['country'].'/'.$arrCurrentLocation['city'].'.json');
        //$url = urlencode();
        $str = file_get_contents($url);        
        $json = json_decode($str, true);    
        
        $forecastday = (isset($json['forecast']['simpleforecast']['forecastday']) && !isset($json['error'])) ? $json['forecast']['simpleforecast']['forecastday'] : array();

        $partecipanti = DB::table('progetti_partecipanti')
            ->select('id_progetto')
            ->where('id_user', Auth::user()->id)
            ->get();

            $project = DB::table('projects')
                ->join('users', 'projects.user_id', '=', 'users.id')
                ->select('projects.*')
                ->whereIn('projects.id', json_decode(json_encode($partecipanti), true))
                ->orWhere('projects.user_id', Auth::user()->id)
                ->where('users.is_delete', '=', 0)
                ->where('projects.statoemotivo','!=','12')->where('projects.progresso','!=','100')->where('projects.statoemotivo','!=','FINE PROGETTO')->paginate(2);

        /*$arrWhere = array('user_id'=>Auth::user()->id,'is_deleted'=>0);        
        $project = DB::table('projects')->where($arrWhere)->where('statoemotivo','!=','12')->where('progresso','!=','100')->where('statoemotivo','!=','FINE PROGETTO')->paginate(2);*/
        
        $arrchartdetails = array();
        $arrProjectdetails = array();
        foreach($project as $keyp => $valp) {            
            $quote = DB::table('quotes')->where('id', $valp->id_preventivo)->first();
            $dipartimento= (isset($quote->dipartimento) && !empty($quote->dipartimento)) ? $quote->dipartimento : '1';
           
           $arrchartdetails[$valp->id] = DB::select("select `lavorazioni`.*, AVG(`progetti_lavorazioni`.`completamento`) as `completedPercentage` from `lavorazioni` left join `progetti_lavorazioni` on `lavorazioni`.`id` = `progetti_lavorazioni`.`completato` AND `progetti_lavorazioni`.`id_progetto` = $valp->id WHERE `lavorazioni`.`departments_id`=$dipartimento GROUP BY id ORDER BY completedPercentage DESC");
        } 

        /* ================== Calendor Sections ============== */               
        //$eventi = "";$estimates="";$projects="";$invoices="";
        $type = 0;
        $this->calendorDetails($eventi,$estimates,$projects,$invoices,$month,$day,$year,$type);              
        /*================== Calendor Sections End ============== */                
        $whereid = explode(',',Auth::user()->id_ente);
        $responsabilelanga = DB::table('corporations')->whereIn('id', $whereid)->get();

        $whereid = explode(',',Auth::user()->id_ente);
        $responsabilelangaEntity = DB::table('corporations')->whereIn('id', $whereid)->get();

        //exit;
        $arrresponsibleid = array();
        foreach($responsabilelangaEntity as $rkey => $rval){
            if($rval->responsiblelang_id != ""){
             array_push($arrresponsibleid, $rval->responsiblelang_id);               
            }            
        }
        $arrresponsibleid = implode(',',$arrresponsibleid);
        $arrresponsibleid = explode(',',$arrresponsibleid);
        $responsabilelanga = DB::table('users')->whereIn('id', $arrresponsibleid)->get();                            

        if ($request->ajax()) {
            return view('dashboard.reseller_projects_ajax', [
            'view' => 'reseller',            
            'chartdetails' =>$arrchartdetails,
            'project' =>$project,
            'enti' => $this->corporations->forUser(Auth::user()),
            'utenti' => DB::table('users')->get(),
            'tipo' => 1
            ])->render();  
        }    

        return view('dashboard',[
            'view' => 'reseller',            
            'statistics' =>$statistics,
            'year' => $year,
            'day' => $day,
            'month' => $month,
            'forecastday'=>$forecastday,
            'location'=>$arrCurrentLocation['city'].', '.$arrCurrentLocation['country'],
            'giorniMese' => date('t', mktime(0, 0, 0, $month, $day, $year)),
            'nomiMesi' => $this->monthnames,
            'events' => $eventi,
            'enti' => $this->corporations->forUser(Auth::user()),
            'utenti' => DB::table('users')->get(),
            'responsabilelanga'=>$responsabilelanga,
            'tipo' => 0,            
            'estimates' => $estimates,
            'projects' => $project,
            'invoices' => $invoices,
            'chartdetails' =>$arrchartdetails,
            'project' =>$project,
        ]);
    }
    /* =============== Reseller Dashboard Sections End ============== */


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

    /* ======================= Ticket Functions ============================= */

    public function tickets(Request $request) {
        return view('myticket');
    }

    public function getticketsjson(Request $request) {

        $ticket_problem = DB::select("SELECT * FROM ticket_problem WHERE (user_id = ".$request->user()->id." OR participants_id LIKE '%".$request->user()->id ."%') AND (is_deleted = 0)");
    
        $tickets = [];

        $modules = DB::table('modulo')->get();
        
        foreach ($ticket_problem as $value) {  

            foreach ($modules as $module) {

                if($module->id == $value->module_id){
                    $value->module_id = $module->modulo;
                }
            }

            if($value->ticket_status == 1){
                $value->ticket_status = trans('messages.keyword_open');
            } else if($value->ticket_status == 0){
                $value->ticket_status = trans('messages.keyword_close');
            }

            $value->created_at = date('d-m-Y H:i:s', strtotime($value->created_at));
            if($value->updated_at == '0000-00-00 00:00:00') {
                $value->updated_at = '-';
            } else{
                $value->updated_at = date('d-m-Y H:i:s', strtotime($value->updated_at));
            }

            $tickets[] = $value;
        }
    
        return json_encode($tickets);
    }

    public function problemstore(Request $request) {

        $random_number = mt_rand(100000, 999999);
        $rand_ticket = '#tic'.$random_number;
        $user_id = $request->user()->id;
        $users[] = '';

        if($request->module_id == 1){

            $entity = DB::table('corporations')
                ->where('user_id', $user_id)
                ->first();

            if(isset($entity)){
                $users = DB::table('enti_partecipanti')
                ->leftJoin('users', 'enti_partecipanti.id_user', '=', 'users.id')
                ->where('enti_partecipanti.id_ente', $entity->id)
                ->where('users.dipartimento', 2)
                ->groupBy('id_user')->get()->toArray();

            } else {

                $user=DB::table('users')->where('id', $user_id)->first();
            
                if(isset($user)){
                    $users = DB::table('enti_partecipanti')
                    ->leftJoin('users', 'enti_partecipanti.id_user', '=', 'users.id')
                    ->where('enti_partecipanti.id_ente', $user->id_ente)
                    ->where('users.dipartimento', 2)
                    ->groupBy('id_user')->get()->toArray();
                }
            }
            if(!$users){ $users[] = ''; } 
        }

        if($request->module_id == 3){

            $quote = DB::table('quotes')
                ->where('idente', '!=', null)
                ->where('user_id', $user_id)->first();

            if(isset($quote)){
                $users = DB::table('enti_partecipanti')
                ->leftJoin('users', 'enti_partecipanti.id_user', '=', 'users.id')
                ->where('enti_partecipanti.id_ente', $quote->idente)
                ->where('users.dipartimento', 2)
                ->groupBy('id_user')->get()->toArray();
            }
        } 
        
        if($request->module_id == 4){

            $project = DB::table('projects')
                ->where('user_id', $user_id)
                ->where('id_ente', '!=', null)
                ->first();

            if(isset($project)){
                $users = DB::table('enti_partecipanti')
                ->leftJoin('users', 'enti_partecipanti.id_user', '=', 'users.id')
                ->where('enti_partecipanti.id_ente', $project->id_ente)
                ->where('users.dipartimento', 3)
                ->groupBy('id_user')->get()->toArray();
            }
        } 

        if($request->module_id == 5){

            $invoice = DB::table('tranche')
                ->where('user_id', $user_id)
                ->where('A', '!=', null)
                ->first();

            if(isset($invoice)){
                $users = DB::table('enti_partecipanti')
                ->leftJoin('users', 'enti_partecipanti.id_user', '=', 'users.id')
                ->where('enti_partecipanti.id_ente', $invoice->A)
                ->where('users.dipartimento', 1)
                ->groupBy('id_user')->get()->toArray();
            }
        }
        
        if($users[0] != '' || $users == ''){
            $user_ids = [];
            foreach ($users as $value) {
                $user_ids[] = $value->id;
            }
            $user_ids = implode(',', $user_ids);
        }   

        if (isset($request->file)) {

            Storage::put('images/problems/' . $request->file('file')->getClientOriginalName(), file_get_contents($request->file('file')->getRealPath()));
            $file = $request->file('file')->getClientOriginalName();  
        }

        $true = DB::table('ticket_problem')->insert([
            'problem' => isset($request->problem) ? $request->problem:'',
            'path' => isset($request->page) ? $request->page : '',
            'image' => isset($file) ? $file : '',
            'random_tid' => $rand_ticket,
            'user_id' => $user_id,
            'module_id' => $request->module_id,
            'participants_id'=> isset($user_ids) ? $user_ids : 0,
            'ticket_status' => 1,
            'is_deleted' => 0
        ]);

        // if($true && $users[0] != ''){
        //     mail send to participants
        //     foreach ($users as $value) {
        //         $email = $value->email;
        //         Mail::send('layouts.ticket_mail', ['user' => $users, 'email' => $email], function ($m) use ($users, $email) {
        //             $m->from('easy@langa.tv', 'Easy LANGA');            
        //             $m->to($email)->subject('Test Report Ticket');
        //         });
        //     }
        // }
        
        // mail send to login user.
        // $user_email = $request->user()->email;
        // Mail::send('layouts.ticket_mail', ['email' => $user_email], function ($m) use ($user_email) {
        //     $m->from('easy@langa.tv', 'Easy LANGA');            
        //     $m->to($user_email)->subject('Test Report Ticket');
        // });

        // mail send to admin.
        // $admin = DB::table('users')->where('id', 0)->first();
        // $admin_email = $admin->email;        
        // Mail::send('layouts.ticket_mail', ['email' => $admin_email], function ($m) use ($admin_email) {
        //     $m->from('easy@langa.tv', 'Easy LANGA');            
        //     $m->to($admin_email)->subject('Test Report Ticket');
        // });
        
        return Redirect::back()->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_problem_send_successfully').'</div>');
    }

    public function ticketmodify(Request $request) {
      
        $id = '#tic'.$request->id;
        return view('modifyticket',[
            'ticket_problem' => DB::table('ticket_problem')->where('random_tid', $id)->first(),
            'ticket_reply' => DB::table('ticket_reply')->where('problem_id', $id)->get(),
            ]);
    }   

    public function ticketdelete(Request $request) {
        
        $ticid = "#tic".$request->id;

        DB::table('ticket_problem')
            ->where('random_tid', $ticid)
            ->update(['is_deleted' => 1]);

        return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_deletesuccessmsg').' </div>');
    }   

    public function storereply(Request $request) {
        
        $id = DB::table('ticket_reply')->insertGetId([
            'problem_id' => $request->ticketid,
            'reply' => isset($request->message) ? $request->message :'',
            'image' => isset($request->image) ? $request->image : '',
            'user_id' => $request->user()->id,
        ]);

        if($id){

            $time = time();
            $date = date("Y-m-d H:i:s", $time);

            DB::table('ticket_problem')->where('random_tid', $request->ticketid)->update([
                'updated_at' => $date]);
        }

        $last_reply = DB::table('ticket_reply')->where('id',$id)->first();

        return json_encode($last_reply);
    }   

    public function ticketupdate(Request $request) {

        $status = DB::table('ticket_problem')
        ->where('random_tid', $request->ticketid)
        ->update(['ticket_status' => $request->status]);

        return $status;
    }   
}
