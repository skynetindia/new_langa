<!DOCTYPE html>
<html lang="en">
<head><?php 
$arrSettings = adminSettings();
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<!-- Meta, title, CSS, favicons, etc. -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="shortcut icon" href="{{ (isset($arrSettings->frontfavicon) && !empty($arrSettings->frontfavicon)) ? asset('storage/app/images/logo/'.$arrSettings->frontfavicon) :  url('favicon.png')}} ">
<title>Easy LANGA</title>

<!-- Bootstrap -->
<link href="{{asset('/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
<!-- Font Awesome -->
<link href="{{asset('/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
<!-- Custom Theme Style -->
<link href="{{asset('/build/css/custom.min.css')}}" rel="stylesheet">
<!-- Font -->
<link rel="stylesheet" href="{{asset('public/css/stylesheet.css')}}">
<!-- Select2 Css -->
<link rel="stylesheet" href="{{asset('public/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('public/js/datepicker/css/datepicker.css')}}">

</head>
<body class="<?php if(!Auth::guest()){ echo "nav-md";}?>">
<div class="container <?php if(!Auth::guest()){ echo "body";} else{echo 'register-wrap';}?>">
<?php $logged = false; ?>
@if (!Auth::guest())
<?php $logged = true; ?>
<script type="text/javascript">
	var jsbaseurl = '<?php echo url('/');?>';
</script>

  <div class="main_container">
  <div class="col-md-3 left_col">
    <div class="left_col scroll-view">
      <div class="navbar nav_title"> <a href="{{url('/')}}" class="site_title md"><img src="<?php echo(isset($arrSettings->frontlogo) && !empty($arrSettings->frontlogo))?asset('storage/app/images/logo/'.$arrSettings->frontlogo):asset('images/LOGO_Easy_LANGA_without_contour.svg');?>" class="easy_fron_logo img" alt="Easy Langa"/> </a>
      	<a href="{{url('/')}}" class="site_title sm"><img src="{{asset('images/easy-logo.svg')}}" alt="Easy Langa" class="img" > </a>
       </div>       
      <br>      
      <!-- sidebar menu -->
      <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">
      <br><br><br><h3>{{trans('messages.keyword_primary')}}</h3>
      <ul class="nav side-menu">
      <li><a href="{{url('/')}}"><img src="{{url('images/BACHECA.svg')}}" alt="Bacheca" class="menu-icon"> {{trans('messages.keyword_dashboard')}}</a>
      </li><?php
        $module = DB::table('modulo')->where('modulo_sub', null)->where('type', 1)->orderBy('frontpriority')->orderBy('id')->get();
        foreach ($module as $module) {
          $modulo = ucfirst(strtolower($module->modulo));
          $submodule = DB::table('modulo')->where('modulo_sub', $module->id)->get();          
          if($submodule->isEmpty() && !checkpermission($module->id, 0, 'lettura')){
            continue;
          }
          if( $module->modulo == "STATISTICHE"){ 
            ?><br><h3>{{trans('messages.keyword_secondary')}}</h3><br><?php 
          }
        if($submodule->isEmpty()){           
          if ( $module->modulo == "MAPPE" ) {
            $whereid = explode(',',Auth::user()->id_ente);
		        $enti_partecipanti = DB::table('enti_partecipanti')->leftJoin('users', 'enti_partecipanti.id_user', '=', 'users.id')
                ->where('enti_partecipanti.id_user', Auth::user()->id)                
                ->groupBy('id_user')->get()->toArray();
            if(isset($enti_partecipanti[0]) && ($enti_partecipanti[0] != '' || $enti_partecipanti != '')){
              $entiids = [];
              foreach ($enti_partecipanti as $value) {
                  $entiids[] = $value->id_ente;
              }
              //$entiids = implode(',', $entiids);
              $whereid = array_merge($entiids,$whereid);
            }
          DB::enableQueryLog();
           $arrEntiwhere = array('is_deleted'=>'0','users.is_delete'=>'0','corporations.is_approvato'=>1);   
           $enti = DB::table('corporations')
            ->join('users', 'corporations.user_id', '=', 'users.id')            
            ->select('corporations.*')
            ->where($arrEntiwhere)
            ->where(function ($query) use ($whereid)  {                
                $query->whereIn('corporations.id', $whereid)
                      ->orWhere('corporations.user_id', Auth::user()->id);
            })            
            ->orderBy('corporations.id', 'desc')
            ->get();
            $queries = DB::getQueryLog();
            $last_query = end($queries);
            //print_r($last_query);
            $arrCurrentLocations = getLocationInfoByIp();
            $currentlocation = isset($arrCurrentLocations['city']) ? $arrCurrentLocations['city'] : "";
            $currentlocation .= isset($arrCurrentLocations['country']) ? ", ".$arrCurrentLocations['country'] : "";
          ?>
         <li>
         <a><img src="{{asset('storage/app/images/'.$module->image)}}" class="menu-icon" >{{ trans('messages.'.$module->phase_key) }}
            <span class="fa fa-chevron-down"></span>
          </a> 
            <ul class="nav child_menu mapmenu">
                <div class="container-fluid col-md-12" style="background:#113c6f;color:#ffffff">
                      <form action="http://maps.google.com/maps" onsubmit="punto()" method="get" target="new">
                          <div>
                            <div class="menu_map">
                              <div class="col-md-12">
                                  <br><br><input class="form-control" onkeyup="changetextlocationval()" style="color:#000000;max-width:250px;display:inline;" type="text" name="saddrhd" id="saddrhd" placeholder="{{ trans('messages.keyword_from') }}">
                                  <input type="hidden" name="saddr" id="saddr" value="{{$currentlocation}}">
                              </div>
                              <br>
                                <div class="col-md-12">
                                  <br>
                                  <select name="daddr" id="mapfromaddress" class="form-control" >
                                   @foreach($enti as $entekey=>$ente)
                                      @if($ente->indirizzo != "")
                                       <option value="{{$ente->indirizzo}}">{{ $ente->id.' | '.$ente->nomeazienda}}</option>
                                     @endif
                                    @endforeach
                                 </select>
                                </div>
                              <div class="col-md-12">
                                  <input style="display:inline" type="hidden" id="prova" name="daddr1">
                                  <br><input style="display:inline;background:#f37f0d; color:#ffffff;" class="form-control" type="submit" value="{{ trans('messages.keyword_go') }}"><br><br><br>
                              </div>
                          </div>
                      </div>
                  </form>     
              </div>
              </ul>
            </li><?php 
            } 
            else { 
              ?><li><a href="<?php if(isset($module->modulo_link)) { echo url("$module->modulo_link"); } ?>"> <img src="{{asset('storage/app/images/'.$module->image)}}" class="menu-icon" > {{ trans('messages.'.$module->phase_key) }}</a></li><?php 
              } 
            } 
            else {  
              ?><li><a><img src="{{asset('storage/app/images/'.$module->image)}}" class="menu-icon">{{trans('messages.'.$module->phase_key)}}<span class="fa fa-chevron-down"></span></a>                                            
              <ul class="nav child_menu"><?php
              if ($submodule) {
                foreach ($submodule as $submodule) {
                  if(!checkpermission($module->id, $submodule->id, 'lettura')) {
                    continue;
                  }              
                  $subsubmodule = DB::table('modulo')->where('modulo_sub', $submodule->id)->get();              
                  if ($subsubmodule->isEmpty()) { 
                    ?><li><a href="{{url("$submodule->modulo_link")}}">{{ trans('messages.'.$submodule->phase_key) }}</a></li><?php
                  }
                  else {
                    ?><li><a <?php if(!empty($submodule->modulo_link)) { ?> href="<?php echo url("$submodule->modulo_link"); ?>" <?php } ?> >{{ trans('messages.'.$submodule->phase_key) }} <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu"><?php
                      foreach ($subsubmodule as $subsubmodule1) {
                         ?><li><a href="{{url("$subsubmodule1->modulo_link")}}">{{trans('messages.'.$subsubmodule1->phase_key)}}</a></li><?php
                      }
                    ?></ul></li><?php
                  }
              }
               ?></ul>
            </li><?php
            }
        }
      }
    ?></ul></div><?php 
  $request = parse_url($_SERVER['REQUEST_URI']);
  $path = ($_SERVER['HTTP_HOST'] == 'localhost') ? rtrim(str_replace('/betaeasy/', '', $request["path"]), '/') : $request["path"]; 
  
  $c = explode('/',$path);
		$last = explode('/', end($c));		
		
		$path = preg_replace('/[0-9]+/', '', $path);
		$quizkey = trim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $path), '/');
  
  $result = rtrim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $quizkey), '/');
 $result=trim($result,'/');
  $comic = DB::table('quiz_comic')->where('url', $result)->first();
  if(isset($comic)){
    $language_transalation = DB::table('language_transalation')->where('language_key', $comic->lang_key)->first();
  }


    $menulink = trim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $path), '/');       
    if(!empty($menulink)){
      $moduldetails = DB::select('select * from modulo where TRIM(BOTH "/" FROM modulo_link) = :link', ['link' => $menulink]);          
      if(count($moduldetails) > 0){
        $arrwheret = array('code'=>$value = session('locale'),'language_key'=>$moduldetails[0]->tutorial_lang_key);
        $language_transalationmenu = DB::table('language_transalation')->where($arrwheret)->first();
      }
    }    
/*?>
@if(count($moduldetails) > 0 && $moduldetails[0]->avatar_image != "")
<div class="clearfix"></div>
<div class="quiz-footer-svg" onClick="avataranimation(this);">
  <div class="quiz-tips"><h1><?php echo (isset($moduldetails[0]->phase_key)) ? trans('messages.'.$moduldetails[0]->phase_key) : ''; ?> </h1><p> <?php echo (isset($language_transalationmenu->language_value)) ? $language_transalationmenu->language_value : ''; ?> </p></div>
  <div class="footer-svg">
    <img src="<?php echo (isset($moduldetails[0]->avatar_image) && $moduldetails[0]->avatar_image != "") ? url('/storage/app/images/modulavtar/'.$moduldetails[0]->avatar_image) : '' ?>" alt="Quiz"> 
  </div>
</div>

@elseif($path=='quiz')
*/
if (strpos($path, 'quiz') !== false) {?>
<div class="quiz-footer-svg" onClick="avataranimation(this);">
  <div class="quiz-tips"><h1><?php echo (isset($comic->title)) ? $comic->title : ''; ?> </h1><p> <?php echo (isset($language_transalation->language_value)) ? $language_transalation->language_value : ''; ?> </p></div>
  <div class="footer-svg">
    <img src="<?php echo (isset($comic->image)) ? url('/storage/app/images/quiz/'.$comic->image) : '' ?>" alt="Quiz"> 
  </div>
</div>
<?php }
 /*@endif*/?>
<script>
function avataranimation($this){
	if($this.classList.contains('show'))
	{
		$this.classList.remove('show');
	}
	else
	{
		$this.classList.add('show');
	}
}
</script>

    </div>

      <!-- /sidebar menu -->


      <script type="text/javascript">                                  
        function changetextlocationval(){
          $("#saddr").val($("#saddrhd").val());    
        }
            function toggleFullScreen() {
              if ((document.fullScreenElement && document.fullScreenElement !== null) ||    
               (!document.mozFullScreen && !document.webkitIsFullScreen)) {
                if (document.documentElement.requestFullScreen) {  
                  document.documentElement.requestFullScreen();  
                } else if (document.documentElement.mozRequestFullScreen) {  
                  document.documentElement.mozRequestFullScreen();  
                } else if (document.documentElement.webkitRequestFullScreen) {  
                  document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);  
                }  
              } else {  
                if (document.cancelFullScreen) {  
                  document.cancelFullScreen();  
                } else if (document.mozCancelFullScreen) {  
                  document.mozCancelFullScreen();  
                } else if (document.webkitCancelFullScreen) {  
                  document.webkitCancelFullScreen();  
                }  
              }  
            }


            </script>
      <!-- /menu footer buttons -->
      <div class="sidebar-footer hidden-small">
      

       <a href="{{url('/')}}" data-toggle="tooltip" data-placement="top" title="Home"> <span class="fa fa-home" aria-hidden="true"> </span> </a> <a href="{{url('/valutaci')}}" data-toggle="tooltip" data-placement="top" title="Valutaci!"> <span class="fa fa-th-large" aria-hidden="true"></span> </a> <a href="{{url('/tickets')}}" data-toggle="tooltip" data-placement="top" title="Tickets"> <span class="fa fa-th" aria-hidden="true"></span> </a> <a href="http://www.betaeasy.langa.tv/" target="_blank" data-toggle="tooltip" data-placement="top" title="Easy Beta"><span> β</span> </a>
        <hr>
        <a href="{{url('/profilo')}}" data-toggle="tooltip" data-placement="top" title="Profilo"> <span class="fa fa-user" aria-hidden="true"> </span>  </a> <a onclick="toggleFullScreen();" data-toggle="tooltip" data-placement="top" title="FullScreen"> <span class="fa fa-arrows-alt" aria-hidden="true"></span> </a> <a href="{{url('/trash')}}" data-toggle="tooltip" data-placement="top" title="Cestino"> <span class="fa fa-trash" aria-hidden="true"></span> </a> <a href="{{url('/logout')}}" data-toggle="tooltip" data-placement="top" title="Logout"> <span class="fa fa-sign-out" aria-hidden="true"></span> </a> </div>
      <!-- /menu footer buttons --> 
    </div>
  </div>
  <!-- top navigation -->
  <div class="top_nav">
    <div class="nav_menu">
      <nav class="" role="navigation">
        <div class="nav toggle"> <a id="menu_toggle"><i class="fa fa-bars"></i></a> </div>
        <ul class="nav navbar-nav navbar-right">
          <li class=""> <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <?php
				 	 $logo;

					$idente = DB::table('users')
							->select('id_ente','logo')
							->where('id', Auth::user()->id)
							->first();
					$logo = DB::table('corporations')
							->select('logo')
							->where('id', $idente->id_ente)
							->first();	
				  ?>
            <img src="{{ url('/storage/app/images').'/'}}<?php if(isset($idente->logo)) echo $idente->logo; ?>" id="immagineprofilo" alt="">@if (!Auth::guest()) {{Auth::user()->name}} @endif <span class=" fa fa-angle-down"></span> </a>
            <ul class="dropdown-menu dropdown-usermenu pull-right">
              <li><a href="{{url('/profilo')}}"><i class="fa fa fa-user pull-right"></i> {{trans('messages.keyword_profile')}}</a></li> 
              <li><a href="{{url('/faq')}}"><i class="fa fa-question pull-right"></i> {{trans('messages.keyword_help')}}</a></li>
              @if(Auth::user()->id == 0)
              <li> <a href="{{url('/admin')}}"> <span class="badge bg-red pull-right fa fa-rocket pull-right">  BACKEND</span> <span>{{trans('messages.keyword_settings')}}</span> </a></li>
              @endif
              <li><a href="{{url('/logout')}}"><i class="fa fa-sign-out pull-right"></i> {{trans('messages.keyword_logout')}}</a></li>
            </ul>
          </li>
          <?php
					function salvaNotifica($evento) {
						$notifica = DB::table('notifiche')
							->insertGetId([
								'oggetto' => $evento->titolo,
								'user_id' => Auth::user()->id,
								'cancellata' => 0,
								'nome' => 'hai un evento!',
								'datascadenza' => $evento->giorno . '/' . $evento->mese . '/' . $evento->anno . ' alle ' . $evento->sh,
								'target' => '<i class="fa fa-calendar"></i>  ' . $evento->id_ente,
								'id_ente' => $evento->id_ente,
							]);
						DB::table('events')
								->where('id', $evento->id)
								->update(array(
									'id_notifica' => $notifica
								));	
					}
					function salvaNotificaPrev($evento) {
						$notifica = DB::table('notifiche')
							->insertGetId([
								'oggetto' => $evento->oggetto,
								'user_id' => Auth::user()->id,
								'cancellata' => 0,
								'nome' => 'scad. preventivo!',
								'datascadenza' => $evento->valenza,
								'target' => '<i class="fa fa-file-text"></i>  ' . ':' . $evento->id . '/' . $evento->anno,
								'id_ente' => $evento->idente
							]);
						DB::table('quotes')
								->where('id', $evento->id)
								->update(array(
									'id_notifica' => $notifica
								));	
					}
					function salvaNotificaLav($evento) {
						$progetto = DB::table('projects')
										->where('id', $evento->id_progetto)
										->first();
						$notifica = DB::table('notifiche')
							->insertGetId([
								'oggetto' => $evento->nome,
								'user_id' => Auth::user()->id,
								'cancellata' => 0,
								'nome' => 'scad. lavorazione!',
								'datascadenza' => $evento->scadenza . ' ' . $evento->alle,
								'target' => '<i class="fa fa-briefcase"></i>  ' . '::' . $progetto->id . '/' . substr($progetto->datainizio, -2),
								'id_ente' => $progetto->id_ente
							]);
						DB::table('progetti_lavorazioni')
								->where('id', $evento->id)
								->update(array(
									'id_notifica' => $notifica
								));	
					}
					function salvaNotificaDisposizione($evento) {
						$quadro = DB::table('accountings')
									->where('id', $evento->id_disposizione)
									->first();
                  dd($quadro);
						$notifica = DB::table('notifiche')
							->insertGetId([
								'oggetto' => $quadro->nomeprogetto,
								'user_id' => Auth::user()->id,
								'cancellata' => 0,
								'nome' => '#scad. disposizione!',
								'datascadenza' => $evento->datascadenza,
								'target' => '<i class="fa fa-usd"></i>  ' . $evento->idfattura,
								'id_ente' => $evento->A
							]);
						DB::table('tranche')
								->where('id', $evento->id)
								->update(array(
									'id_notifica' => $notifica
								));	
					}
					function salvaNotificaConversazione($evento) {
						$notifica = DB::table('notifiche')
							->insertGetId([
								'oggetto' => $evento->appunti,
								'user_id' => Auth::user()->id,
								'cancellata' => 0,
								'nome' => 'ricontattare!',
								'datascadenza' => $evento->ricontattare,
								'target' => '<i class="fa fa-phone"></i>  ' . $evento->id_ente,
								'id_ente' => $evento->id_ente
							]);
						DB::table('messages')
								->where('id', $evento->id)
								->update(array(
									'id_notifica' => $notifica
								));	
					}
			
					function salvaNotificaServizio($evento) {
						$progetto = DB::table('projects')
							->where('id', $evento->id_progetto)
							->first();
						$notifica = DB::table('notifiche')
							->insertGetId([
								'oggetto' => $evento->nome,
								'user_id' => Auth::user()->id,
								'cancellata' => 0,
								'nome' => 'scad. servizio!',
								'datascadenza' => $evento->scadenza,
								'target' => '<i class="fa fa-clock-o"></i>  ' . '::' . $progetto->id . '/' . substr($progetto->datainizio, -2),
								'id_ente' => $progetto->id_ente
							]);
						DB::table('progetti_noteprivate')
								->where('id', $evento->id)
								->update(array(
									'id_notifica' => $notifica
								));	
					}

						$eventi = DB::table('events')
									->where([
										'user_id' => Auth::user()->id,
										'id_notifica' => 0
									])
									->get();
						$preventivi = DB::table('quotes')
									->where([
										'user_id' => Auth::user()->id,
										'id_notifica' => 0
									])
									->get();
						$progetti = DB::table('progetti_lavorazioni')
									->where([
										'user_id' => Auth::user()->id,
										'id_notifica' => 0
									])
									->get();
						$disposizioni = DB::table('tranche')
									->where([
										'user_id' => Auth::user()->id,
										'id_notifica' => 0
									])
									->get();
									
						$messaggi = DB::table('messages')
							->where([
								'id_notifica' => 0
							])->get();
							
						$servizi = DB::table('progetti_noteprivate')
							->where([
								'id_notifica' => 0
							])->get();
						$msg_return = array();
						foreach($messaggi as $msg) {
							$ente = DB::table('corporations')
								->where('id', $msg->id_ente)
								->first();
							if($ente->user_id == Auth::user()->id)
								$msg_return[] = $msg;	
						}
						$servizi_return = array();
						foreach($servizi as $ser) {
							$progetto = DB::table('projects')
								->where('id', $ser->id_progetto)
								->first();
							if($progetto) {
								if($progetto->id_ente) {
									$ente = DB::table('corporations')
										->where('id', $progetto->id_ente)
										->first();
									if($ente->user_id == Auth::user()->id)
										$servizi_return[] = $ser;	
								}
							}
							
							
						}
					if(Auth::user()->id != 0)  {
						foreach($eventi as $evento) {
							if($evento->anno == date('Y') && $evento->mese == date('n') && ($evento->giorno - date('j') == 1)) {
								salvaNotifica($evento);
							} else if($evento->anno == date('Y') && $evento->mese == date('n') + 1 && $evento->giorno == 1 && (date('t') - date('j') == 0)) {
								salvaNotifica($evento);
							} else if($evento->anno <= date('Y') && $evento->mese <= date('n') && $evento->giorno <= date('j')) {
								salvaNotifica($evento);	
							}
						}
						foreach($preventivi as $evento) {
							$giorno = substr($evento->valenza, 0 , 2);
							$mese = substr($evento->valenza, 3 , 2);
							$anno = substr($evento->valenza, 6, 4);
							if($anno == date('Y') && $mese == date('n') && ($giorno - date('j') <= 3)) {
								salvaNotificaPrev($evento);
							} else if($anno == date('Y') && $mese == date('n') + 1 && $giorno == 1 && (date('t') - date('j') == 2)) {
								salvaNotificaPrev($evento);
							} else if($anno <= date('Y') && $mese <= date('n') && $giorno <= date('j')) {
								salvaNotificaPrev($evento);	
							}
						}
						foreach($progetti as $evento) {
							$giorno = substr($evento->scadenza, 0 , 2);
							$mese = substr($evento->scadenza, 3 , 2);
							$anno = substr($evento->scadenza, 6, 4);
							if($anno == date('Y') && $mese == date('n') && ($giorno - date('j') == 1)) {
								salvaNotificaLav($evento);
							} else if($anno == date('Y') && $mese == date('n') + 1 && $giorno == 1 && (date('t') - date('j') == 0)) {
								salvaNotificaLav($evento);
							} else if($anno <= date('Y') && $mese <= date('n') && $giorno <= date('j')) {
								salvaNotificaLav($evento);	
							} 
						}
						foreach($disposizioni as $evento) {
							$giorno = substr($evento->datascadenza, 0 , 2);
							$mese = substr($evento->datascadenza, 3 , 2);
							$anno = substr($evento->datascadenza, 6, 4);
							if($anno == date('Y') && $mese == date('n') && ($giorno - date('j') <= 3)) {
								salvaNotificaDisposizione($evento);
							} else if($anno == date('Y') && $mese == date('n') + 1 && $giorno == 1 && (date('t') - date('j') == 2)) {
								salvaNotificaDisposizione($evento);
							} else if($anno <= date('Y') && $mese <= date('n') && $giorno <= date('j')) {
								salvaNotificaDisposizione($evento);	
							}
						}
						
						foreach($msg_return as $evento) {
							if($evento->ricontattare) {
								$giorno = substr($evento->ricontattare, 0 , 2);
								$mese = substr($evento->ricontattare, 3 , 2);
								$anno = substr($evento->ricontattare, 6, 4);
								if($anno == date('Y') && $mese == date('n') && ($giorno - date('j') == 1)) {
									salvaNotificaConversazione($evento);
								} else if($anno == date('Y') && $mese == date('n') + 1 && $giorno == 1 && (date('t') - date('j') == 0)) {
									salvaNotificaConversazione($evento);
								} else if($anno <= date('Y') && $mese <= date('n') && $giorno <= date('j')) {
									salvaNotificaConversazione($evento);	
								}
							}
						}
						function modulo($x) {
							if($x<0)
								return -$x;
							return $x;	
						}
						foreach($servizi_return as $evento) {
							if($evento->scadenza) {
								$giorno = substr($evento->scadenza, 0 , 2);
								$mese = substr($evento->scadenza, 3 , 2);
								$anno = substr($evento->scadenza, 6, 4);
								if($anno == date('Y') && $mese == date('n') && ($giorno - date('j') <= 20)) {
									salvaNotificaServizio($evento);
								} else if($anno == date('Y') && $mese == date('n') + 1 && modulo($giorno - date('j') <= 20)) {
									salvaNotificaServizio($evento);
								} else if($anno <= date('Y') && $mese <= date('n') && $giorno <= date('j')) {
									salvaNotificaServizio($evento);	
								}
							}
						}
						
					}
					
					if(Auth::user()->id === 0)  {
						$notifiche = DB::table('notifiche')
									->where([
									'cancellata' => 0])
									->get();
					} else {
						$notifiche = DB::table('notifiche')
									->where([
									'user_id' => Auth::user()->id,
									'cancellata' => 0])
									->get();
					}

          // Ordine per data
          function inSecondi($a) {
            // Aggiungo uno 0 se il giorno o il mese non ce lha
            $arr = explode('/', $a->datascadenza);
            $giorno = $arr[0];
            $mese = $arr[1];
            $anno = substr($arr[2], 0, 4);

            return mktime(0, 0, 0, $mese, $giorno, $anno);
          }

         /* for($i = 0; $i < count($notifiche) - 1; $i++) {
            for($k = $i + 1; $k < count($notifiche); $k++) {
              if(inSecondi($notifiche[$i]) < inSecondi($notifiche[$k])) {
                $tmp = $notifiche[$i];
                $notifiche[$i] = $notifiche[$k];
                $notifiche[$k] = $tmp;
              }
            }
          }*/

		?>

		<?php  

			$userId = Auth::user()->id;

			$notifications = DB::table('invia_notifica')
	          ->leftjoin('notifica', 'invia_notifica.notification_id', '=', 'notifica.id')
	          ->select(DB::raw('invia_notifica.*, notifica.id as noti_id, notifica.notification_type, notifica.notification_desc'))
	          ->where('invia_notifica.user_id', $userId)
            ->where('notifica.notification_type', '!=',"")
	          ->where('invia_notifica.is_enabled', 0)
	          ->where('invia_notifica.is_deleted', 0)
	          ->orderBy('invia_notifica.data_lettura', 'desc')	         
	          ->get();
            /*DB::enableQueryLog();
            $queries = DB::getQueryLog();
            $last_query = end($queries);
            print_r($last_query);*/

	        $alerts = DB::table('inviare_avviso')
	          ->leftjoin('alert', 'inviare_avviso.alert_id', '=', 'alert.alert_id')
	          ->select(DB::raw('inviare_avviso.*, alert.alert_id as alrt_id, alert.nome_alert, alert.messaggio'))
	          ->where('user_id', $userId)
	          ->where('is_enabled', 0)
	          ->where('is_deleted', 0)
	          ->where('alert.is_system_info', '1')
	          ->orderBy('data_lettura', 'asc')	         
	          ->get();  
		?>


		<li role="presentation" class="dropdown"> <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false"> 
    	<i class="fa fa-envelope-o"></i><?php
        if((count($notifications)) > 0){
          ?><span class="badge bg-green"><?php /*if(Auth::user()->id === 0) echo '!'; else echo count($notifications); */
          echo count($notifications);
        ?></span><?php } ?></a>
       <div id="menu1" class="dropdown-menu list-unstyled msg_list notification-header <?php echo (count($notifications) <= 0) ? 'emptynotifications' : '';?>">      	
              @if(count($notifications) > 0)
              <div class="chkbox-blk">            
                <div class="chkbox"><input type="checkbox" id="notifi1"><label for="notifi1"> notifi1 </label></div>
        		    <div class="info"><input type="text" id="find-noti" /></div>
              </div>
              @else
                <div>{{trans('messages.keyword_no_record_found')}}</div>
              @endif
	    	    
	    	<div id="replace-noti"><?php 
        $i = 1; ?>
			   @foreach($notifications as $notification)
			     <?php 
	            $date = $notification->created_at; 
	            $date = date_format(new DateTime($date), 'd-m-Y H:i:s'); 
	          ?>	
			   <div class="chkbox-blk">
            <div class="chkbox"><input class="checkgrp" type="checkbox" onclick="setclass(<?php echo $notification->id; ?>);" value="<?php echo $notification->id; ?>" id="notifi2<?php echo $i; ?>">
			       <label for="notifi2<?php echo $i; ?>"> notifi2 </label>
			       </div>
            <div class="info">
    	  		 <a href="{{url('/notifiche/delete') . '/' . $notification->id}}" onclick="return confirm('{{ trans('messages.keyword_sure_to_disable_notification')}}?')">
          		<span> {{$notification->notification_type}} </span>
          		<span class="time"> {{ $date }} </span>
          		<div class="message"> {{$notification->notification_desc}} </div>
                </a>
	           </div>
			    </div>
			<?php $i++; ?>
          	@endforeach	 
            <?php 
            /*
          	@foreach($alerts as $alert)
			     <?php 
	            $date = $alert->created_at; 
	            $date = date_format(new DateTime($date), 'D-m-Y H:i:s'); 
	          ?>	
      			<div class="chkbox-blk" >
                  <div class="chkbox"><input class="alertcheckgrp" type="checkbox" onclick="alertdisable(<?php echo $alert->id; ?>);" value="<?php echo $alert->id; ?>" id="alert2<?php echo $i; ?>">
      				<label for="alert2<?php echo $i; ?>"> notifi2 </label>
      			</div>
      			<div class="info">
          	  		<a href="{{url('/alert/delete') . '/' . $alert->id}}" onclick="return confirm('{{ trans('messages.keyword_sure_to_disable_notification')}}?')">
                		<span> {{$alert->nome_alert}} </span>
                		<span class="time"> {{ $date }} </span>
                		<div class="message"> {{$alert->messaggio}} </div>
                      </a>
      	         </div>
      			</div>
			      <?php $i++; ?>
          	@endforeach	   
            */?>
          	</div>
            <div class="btn-blk">
                <button class="btn btn-submit" id="disabled"> 
                {{ trans('messages.keyword_hide')}} </button>
		            <button class="btn btn-cancel" id="view-all">
		            {{ trans('messages.keyword_see_table')}}
		            </button>
		        </div>
		    </div>

           <?php /* <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu" >
              <?php $count = 0; ?>
              <!-- notifiche layout --> 
              @foreach($notifications as $notification)
              <li> <a href="{{url('/notifiche/delete') . '/' . $notification->id}}"  onclick="return confirm('Sei sicuro di voler disdire questa notifica?')"> <span> <span>Hey, {{$notification->notification_type}}</span> <span class="time">{{$notification->created_at}}</span> </span> <span class="message">
       

                {{$notification->notification_desc}} </span> </a> </li>


              <?php $count++; ?>
              @endforeach
              @if($count == 0)
              <li> 
                <!-- /notifiche-->
                <div class="text-center"> <strong>Nessuna notifica</strong> </div>
              </li>
              @endif
              <li> 
                <!-- /notifiche-->
                <div class="text-center"> <a href="{{url('/notifiche')}}"> <strong>Vedi altre notifiche...</strong> <i class="fa fa-angle-right"></i> </a> </div>
              </li>
            </ul>*/?>
          </li>

          <li><?php
          $valueCode = session('locale');
				$allLanguages = DB::table('languages')
							->select('*')
							->where('is_deleted', '0')
							->get();	
      $currentLanguages = DB::table('languages')
              ->select('*')
              ->where('code', $valueCode)
              ->first();  
        
				?><div class='selectBox'>
            <span class='selected'>{{$currentLanguages->original_name}}</span>
            <span class='selectArrow'><img src="{{url('storage/app/images/languageicon/').'/'.$currentLanguages->icon}}" height="30" width="30"></span>
            <div class="selectOptions">
            @foreach($allLanguages as $langs)
              <span class="selectOption" value="{{$langs->code}}">{{$langs->original_name}} <img src="{{url('storage/app/images/languageicon/').'/'.$langs->icon}}" height="30" width="30"></span>
             @endforeach 
            </div>
          </div>
        <?php /*<select id="languageSwicher" class="form-control"><?php
					foreach($allLanguages as $langs){			
					  $value = session('locale');
						?><option value="<?php echo $langs->code; ?>" <?php if($valueCode == $langs->code) { echo 'selected';}?>><?php echo $langs->original_name;?></option><?php 
					}
                 ?></select>*/?>
                </li>
        </ul>
      </nav>
    </div>
  
  </div>

  <!-- /top navigation --> 
  @endif 


  <!-- Content -->

  <!-- Content -->

  <div class="right_col" role="main">

  	<div class="row alert-div">
  		
  	<?php

        $userId = Auth::id(); $today = date("Y-m-d");
        $alert = DB::table('inviare_avviso')
          ->join('alert', 'inviare_avviso.alert_id', '=', 'alert.alert_id')
          ->leftjoin('alert_tipo', 'alert.tipo_alert', '=', 'alert_tipo.id_tipo')
          ->select('inviare_avviso.*','alert.*','alert_tipo.color')
          ->where('user_id', $userId)->where('is_deleted', 0)
          ->where('alert.created_at', '=', $today)->groupBy('alert.alert_id')
          ->where('alert.is_system_info', '1')
          ->get(); 

        $i = 1; 
    ?>
       
  <?php foreach ($alert as $alert) {  ?>

  		<div class="col-md-6 col-sm-12 col-xs-12 main_class_alert"> 

  			<button data-id="alert_comment<?php echo $i; ?>" id="myclose<?php echo $i; ?>" type="button" class="close alert_close" aria-label="Close" onclick="myalertclose(this.id, <?php echo $i; ?>)"> 
				<span aria-hidden="true">&times;</span>
			</button>

	  		<div data-value="alert_comment<?php echo $i; ?>" class="myalert" id="myalert<?php echo $i; ?>" onclick="myalert(this.id, <?php echo $i; ?>)">

	          	<div class="alert" style="background-color: {{$alert->color}}">
					<div class="alert-heading">	<b style="font-size: 16px;"> {{ $alert->nome_alert }} </b></div>
                 <div class="clearfix"></div>
              <div id="alert_comment<?php echo $i; ?>" class="alert_comment" style="display: none;font-weight: bold;"> 
                <p>
                  {{ $alert->messaggio }}  
                </p>                  
                <textarea class="form-control alert_msg_textbox" id="alert_messaggio<?php echo $i; ?>" rows="4" cols="5" style="color: black"><?php if(isset($alert->comment)){ echo $alert->comment; } ?></textarea> 
                <input type="hidden" class="alert_id" id="alert_id<?php echo $i; ?>" name="" value="{{ $alert->alert_id  }}">
                <input type="hidden" id="user_id" name="" value="{{ $userId  }}">
                <input type="hidden" id="user_alert_id" name="" value="{{ $alert->id  }}">
                
               
              <div class="alert-btn text-right">  <button class="btn btn-warning" id="alert_send<?php echo $i; ?>" value="send" >
                Send
                </button></div>

          

       		</div>
            
            <div class="clearfix"></div>
                    
				</div>		

			</div>

            

        </div>

  <?php $i++; } ?>

    </div>

    <!-- Notification -->

    <div class="row notification-div">
    	
    <?php
		$userId = Auth::id(); $today = date("Y-m-d");
		$notifications = DB::table('invia_notifica')
          ->leftjoin('notifica', 'invia_notifica.notification_id', '=', 'notifica.id')
          ->select(DB::raw('invia_notifica.*, notifica.id as noti_id, notifica.notification_type, notifica.notification_desc, notifica.created_at'))
          ->where('user_id', $userId)->where('is_deleted', 0)
          ->where('notifica.created_at', '=', $today)
          ->groupBy('notification_id')    
          ->get(); 

       	$i = 1; ?>

       	
 		<?php /* foreach ($notifications as $notification) { ?>

		<div class="col-md-6 main_class_notification">

			<button data-id="rolenote_comment<?php echo $i; ?>" type="button" class="close notification_close" aria-label="Close" onclick="mynotificationclose(this.id, <?php echo $i; ?>)">
				<span aria-hidden="true">&times;</span>
			</button>

 			<div data-value="rolenote_comment<?php echo $i; ?>" id="myrolenote<?php echo $i; ?>" onclick="mynotification(this.id, <?php echo $i; ?>)">

	      		<div class="alert alert-<?php if($notification->id_ente != null) { ?>danger <?php  } else { ?>info <?php } ?> " >
					<b style="font-size: 16px;"> {{ $notification->notification_type }} </b>
				</div>

			</div>

			<div class="alert-<?php if($notification->id_ente != null) { ?>danger <?php  } else { ?>info <?php } ?>"  >
      
            	<div class="rolenote_comment" id="rolenote_comment<?php echo $i; ?>" style="display: none;font-weight: bold;"> 

                <p style="text-indent:40px;">
                  {{ $notification->notification_desc }}  
                </p>
                  
                <textarea class="form-control rolenote_messaggio" id="rolenote_messaggio<?php echo $i; ?>" rows="4" cols="5" style="color: black"><?php if(isset($notification->comment)){ echo $notification->comment; } ?></textarea> 

                <input type="hidden" class="notification_id" id="notification_id<?php echo $i; ?>" name="" value="{{ $notification->noti_id  }}">
                <input type="hidden" id="user_id" name="" value="{{ $userId  }}">
                
                <br>
                <button class="noti_send" id="noti_send<?php echo $i; ?>" value="send" style="color: black">
                Send
                </button>

            	</div>

        	</div>

      	</div>

  <?php $i++; } */?>

    </div><?php 
    	$request = parse_url($_SERVER['REQUEST_URI']);
		$path = ($_SERVER['HTTP_HOST'] == 'localhost') ? rtrim(str_replace('/betaeasy/', '', $request["path"]), '/') : $request["path"];		
		//$result = trim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $path), '/');		
		$c = explode('/',$path);
		$last = explode('/', end($c));		

		$path = preg_replace('/[0-9]+/', '', $path);
		$result = trim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $path), '/');							

		$arrPageurl = array('enti/myenti','enti','enti/add','enti/modify/corporation','pagamenti','pagamenti/mostra/accounting','pagamenti/tranche/modifica','pagamenti/tranche/add','pagamenti/tranche/elenco','pagamenti/coordinate');
		$class = (in_array($result, $arrPageurl)) ? 'left_breadcrumbs' : '';
    ?>
    <div class="front_breadcrumbs {{$class}}"><?php echo getbreadcrumbs(); ?></div>
    <div class="row tile_count">
      <div class="container-fluid"> @yield('content') </div>
    </div>
  </div>

  <!-- /content --> 
  <!-- footer content -->
  <footer>
    <div class="pull-right">
      <p align="right"><small><a href="http://www.langa.tv/" target="_blank"><strong>Marketing with Method</strong> by LANGA Group</a><br>2017 © Easy <strong>LANGA 2.01</strong><br></small></p>
     </div>
    <div class="clearfix"></div>
   <!-- </div>-->
  </footer>
  <!-- /footer content --> 
</div>
</div>

<!-- jQuery --> 
<script src="{{asset('/vendors/jquery/dist/jquery.min.js')}}"></script> 
<!-- Bootstrap --> 
<script src="{{asset('/vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script> 
<script src="{{asset('public/js/datepicker/js/bootstrap-datepicker.js')}}"></script> 

<!-- jQuery validation js --> 
<script src="{{ url('public/scripts/jquery.validate.min.js')}}"></script> 

<script type="text/javascript" src="{{asset('public/scripts/cropper.js')}}"></script>

<script type="text/javascript" src="{{asset('public/scripts/cropper_main.js')}}"></script>

<!-- Custom Theme Scripts --> 
<script src="{{asset('/build/js/custom.js')}}"></script> 
<script src="{{asset('public/scripts/select2.full.min.js')}}"></script>
<script type="text/javascript">
  $('.notification-header').click(function(e) {
      e.stopPropagation();
  });
  $(".alert_msg_textbox").click(function( event ) {
    event.stopPropagation();
    // Do something
  }); 
    $("#mapfromaddress").select2({dropdownParent: $('.menu_map')});                                                              
		function setclass(i) {		
			var arr_id = [];
			$(".checkgrp:checked").each(function() {
			    arr_id.push($(this).val());
			});
			$('#disabled').on('click', function(e) { 		 
				$.ajax({
	              	type:'GET',
	              	data: { 'arr_id': arr_id },
	              	url: '{{ url('notification-disabled') }}',
	                success:function(data) {              
	              		location.reload();
	                }
            	});	
			});
		}

		function alertdisable(i) {		

			var arr_id = [];
			$(".alertcheckgrp:checked").each(function() {
			    arr_id.push($(this).val());
			});
			
			$('#disabled').on('click', function(e) { 		 
				$.ajax({
	              	type:'GET',
	              	data: { 'arr_id': arr_id },
	              	url: '{{ url('alert-disabled') }}',
	                success:function(data) {            
	              		location.reload();
	                }
            	});	
			});
		}

		$( "#find-noti" ).keyup(function() {
			var find = $("#find-noti").val();	
      if(find.length > 1){
  			$.ajax({
            type:'GET',
            data: { 'find': find },
            url: '{{ url('notification-json') }}',
            success:function(data) {
             /* console.log(data);
              alert(JSON.stringify(data));*/
               $('#replace-noti').html(data);                     
            }
        });
      }
		});	

    	var path_url = "<?php echo url('/notifiche'); ?>";
		$('#view-all').on('click', function(e) { 		 
			window.location.replace(path_url);			
		});
		
		function myalert(id, i){

			$this = $("#"+id);
			$data = $this.data("value");          	
          	$('#'+$data).toggle();

  	        var alert_id = $("#alert_id"+i).val();
            var user_id = $("#user_id").val();
            $.ajax({

              type:'GET',
              data: { 'alert_id': alert_id, 'user_id': user_id },
              url: '{{ url('alert/user-read') }}',              
              success:function(data) { }

            });

            $("#alert_send"+i).click(function(e){

            	var messaggio = $("#alert_messaggio"+i).val(); 
            	var alert_id = $("#alert_id"+i).val();
            	var user_id = $("#user_id").val();
              var user_alert_id = $("#user_alert_id").val();
              
	            $.ajax({
	              type:'GET',
	              data: { 'messaggio': messaggio, 'alert_id': alert_id, 'user_id': user_id,'user_alert_id':user_alert_id },
	              url: '{{ url('alert/make-comment') }}',
	              success:function(data) {
	                location.reload();	
	              }
	            });
            });
      	}

      	function myalertclose(id, i){
			$this = $("#"+id);
			$data = $this.data("id");

			var alert_id = $("#alert_id"+i).val();
            var user_id = $("#user_id").val();
			
		    $.ajax({
		      type:'GET',
		      data: { 'alert_id': alert_id, 'user_id': user_id },
		      url: '{{ url('alert/userdelete') }}',
		      success:function(data) {
		        location.reload();
		      }
		    });
		}

      	function mynotification(id, i){

      		$this = $("#"+id);
			$data = $this.data("value");          	
          	$('#'+$data).toggle();

  	        var notification_id = $("#notification_id"+i).val(); 
            var user_id = $("#user_id").val();

            $.ajax({
              type:'GET',
              data: { 'notification_id': notification_id, 'user_id': user_id },
              url: '{{ url('notification/user-read') }}',              
              success:function(data) { }
            });

            $("#noti_send"+i).click(function(e){

            	var messaggio = $("#rolenote_messaggio"+i).val(); 
            	var notification_id = $("#notification_id"+i).val();
            	var user_id = $("#user_id").val();

	            $.ajax({
		            type:'GET',
		            data: { 'messaggio': messaggio, 'notification_id': notification_id,
		                      'user_id': user_id },
              		url: '{{ url('notification/make-comment') }}',
	              	success:function(data) {
	                	location.reload();
	              	}
	            });
            });
      	}

  		function mynotificationclose(id, i){
			$this = $("#"+id);
			$data = $this.data("id");

			var notification_id = $("#notification_id"+i).val(); 
            var user_id = $("#user_id").val();
			
		    $.ajax({
              type:'GET',
              data: { 'notification_id': notification_id, 'user_id': user_id },
              url: '{{ url('notification/userdelete') }}',
              success:function(data) {
                location.reload();
              }
            });
		}

	  	function strcap(str){
	    	var pieces = str.toLowerCase().split(" ");
		    for ( var i = 0; i < pieces.length; i++ )		    {
		        var j = pieces[i].charAt(0).toUpperCase();
		        pieces[i] = j + pieces[i].substr(1);
		    }
		    return pieces.join(" ");		}
			$(window).load(function()
			{
				var height=$('.right_col').height();
				$('#sidebar-menu ').height(height);
			});
    </script>
     <script type='text/javascript'>
      $(document).ready(function() {
        var currentlang = '<?php echo session('locale'); ?>';
        languageSelectBoxes(currentlang);
        /* This section is used to hide he parent menu that no child menu */
        $(".child_menu").each(function() {
          if($(this).find('li').length == 0 && !$(this).hasClass('mapmenu')){
              $(this).parent('li').remove();
          }
        });
        //alert($(".child_menu").length);
      });            
    </script>
    @include('common.languagesjs')

</body>
</html>