<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<!-- Meta, title, CSS, favicons, etc. -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="{{asset('favicon.png')}}">
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
</head>
<?php $logged = false; ?>
@if (!Auth::guest())
<?php $logged = true; ?>
<script type="text/javascript">
	var jsbaseurl = '<?php echo url('/');?>';
</script>
<body class="nav-md">
<div class="container body">
  <div class="main_container">
  <div class="col-md-3 left_col">
    <div class="left_col scroll-view">
      <div class="navbar nav_title"> <a href="{{url('/')}}" class="site_title md"><img src="{{asset('images/LOGO-Easy-LANGA.svg')}}" alt="Easy Langa" class="img" > </a>
      	<a href="{{url('/')}}" class="site_title sm"><img src="{{asset('images/easy-logo.svg')}}" alt="Easy Langa" class="img" > </a>
       </div>
      <br>
      
      <!-- sidebar menu -->
      <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section"> <br>
          <br>
          <br>
          <h3>Primario</h3>
          <ul class="nav side-menu">
            <li><a href="{{url('/')}}"><img src="{{asset('images/BACHECA.svg')}}" alt="Bacheca" class="menu-icon" > <span>Bacheca</span></a> </li>
            <li><a><img src="{{asset('images/ENTI.svg')}}" alt="Enti" class="menu-icon" > <span>Enti</span> <span class="fa fa-chevron-down"></span></a>
              <ul class="nav child_menu">
                <li><a href="{{url('/enti/myenti')}}">Miei</a></li>
                <li><a href="{{url('/enti')}}">Tutti</a></li>
              </ul>
            </li>
            <li><a><img src="{{asset('images/CALENDARIO.svg')}}" alt="Calendario" class="menu-icon" > <span>Calendario</span> <span class="fa fa-chevron-down"></span></a>
              <ul class="nav child_menu">
                <li><a href="{{url('/calendario/0')}}">Miei</a></li>
                <li><a href="{{url('/calendario/1')}}">Tutti</a></li>
              </ul>
            </li>
            <li><a><img src="{{asset('images/PREVENTIVI.svg')}}" alt="Preventivi" class="menu-icon" > <span>Preventivi</span> <span class="fa fa-chevron-down"></span></a>
              <ul class="nav child_menu">
                <li class="sub_menu"><a href="{{url('/estimates/my')}}">Miei</a> </li>
                <li><a href="{{url('/estimates')}}">Tutti</a> </li>
              </ul>
            </li>
            <li><a><img src="{{asset('images/PROGETTI.svg')}}" alt="Progetti" class="menu-icon" > <span> Progetti</span> <span class="fa fa-chevron-down"></span></a>
              <ul class="nav child_menu">
                <li><a href="{{url('/progetti/miei')}}">Miei</a></li>
                <li><a href="{{url('/progetti')}}">Tutti</a></li>
              </ul>
            </li>
            <li><a><img src="{{asset('images/CONTABILITA.svg')}}" alt="Contabilità" class="menu-icon" > <span>Contabilità</span> <span class="fa fa-chevron-down"></span></a>
              <ul class="nav child_menu">
                <li><a href="{{url('/pagamenti')}}"> Disposizioni</a>
                <li><a href="{{url('/pagamenti/tranche/elenco')}}">Fatture</a> </li>
                <li><a>Metodi<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="{{url('/pagamenti/coordinate')}}">Coordinate bancarie</a> </li>
                    <li><a href="{{url('/onworking')}}">PayPal <span class="label label-warning pull-right">In corso...</span></a> </li>
                  </ul>
                </li>
              </ul>
            </li>
            <li><a><img src="{{asset('images/MAILISTICA.svg')}}" alt="Mailistica" class="menu-icon" > <span>Mailistica</span> <span class="fa fa-chevron-down"></span></a>
              <ul class="nav child_menu">
                <li><a href="{{url('/onworking')}}">Ufficiale <span class="label label-warning pull-right">In corso...</span></a></li>
                <li><a href="{{url('/newsletter')}}">Newsletter</a></li>
              </ul>
            </li>
          </ul>
        </div>
        <div class="menu_section">
          <h3>Secondario</h3>
          <ul class="nav side-menu">
            <li><a><img src="{{asset('images/STATISTICHE.svg')}}" alt="Statistiche" class="menu-icon" > <span>Statistiche</span> <span class="fa fa-chevron-down"></span></a>
              <ul class="nav child_menu">
                <li><a href="{{url('/statistiche/economiche')}}">Economiche</a>
                <li><a href="{{url('/onworking')}}">Accessi <span class="label label-warning pull-right">In corso...</span></a> </li>
              </ul>
            </li>
            <li><a><img src="{{asset('images/INFO.svg')}}" alt="Info" class="menu-icon" > <span> Info</span> <span class="fa fa-chevron-down"></span></a>
              <ul class="nav child_menu">
                <li><a href="{{url('/contatti')}}">Contatti</a>
                <li><a href="{{url('/faq')}}">FAQ's</a>
                <li><a href="{{url('/changelog')}}">Versioni Easy</a>
                <li><a href="{{url('/onworking')}}">Acquisti <span class="label label-warning pull-right">In corso...</span></a> </li>
              </ul>
            </li>
            <li><a><img src="{{asset('images/MAPPE.svg')}}" alt="Mappe" class="menu-icon" > <span> Mappe</span> <span class="fa fa-chevron-down"></span></a>
              <ul class="nav child_menu">
                <div class="container-fluid col-md-12 side-menu-map">
                  <form action="http://maps.google.com/maps" onsubmit="punto()" method="get" target="new">
                    <div class="col-md-12">
                    <div class="form-group col-md-6">
                          <input class="form-control" type="text" name="saddr" placeholder="Da">
                        </div>
                        <div class="form-group  col-md-6">
                          <input class="form-control" type="text" name="daddr" placeholder="A">
                        </div>
                        <div class="form-group col-md-12">
                          <input type="hidden" id="prova" name="daddr">
                          <input class="form-control" type="submit" value="Go">
                        </div>
                    </div>
                  </form>
                </div>
              </ul>
            </li>
            
            <!-- change Segnalazioni href  -->
            
            <li><a href="{{url('/valutaci')}}"><img src="{{asset('images/SEGNALAZIONI.svg')}}" alt="Segnalazioni" class="menu-icon" > <span>Segnalazioni</span></a> </li>
          </ul>
        </div>
      </div>
      
      <!-- /sidebar menu --> 
      <script type="text/javascript">
        
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
      <div class="sidebar-footer hidden-small"> <a href="{{url('/')}}" data-toggle="tooltip" data-placement="top" title="Home"> <span class="fa fa-home" aria-hidden="true"> </span> </a> <a href="http://www.client.easy.langa.tv/" target=_"blank" data-toggle="tooltip" data-placement="top" title="Client LANGA"> <span class="fa fa-th-large" aria-hidden="true"></span> </a> <a href="http://www.reseller.easy.langa.tv/" target=_"blank" data-toggle="tooltip" data-placement="top" title="Reseller LANGA"> <span class="fa fa-th" aria-hidden="true"></span> </a> <a href="http://www.betaeasy.langa.tv/" target="_blank" data-toggle="tooltip" data-placement="top" title="Easy Beta"> β</span> </a>
        <hr>
        <a href="{{url('/profilo')}}" data-toggle="tooltip" data-placement="top" title="Profilo"> <span class="fa fa-user" aria-hidden="true"> </span>  </a> <a onclick="toggleFullScreen();" data-toggle="tooltip" data-placement="top" title="FullScreen"> <span class="fa fa-arrows-alt" aria-hidden="true"></span> </a> <a href="{{url('/cestino')}}" data-toggle="tooltip" data-placement="top" title="Cestino"> <span class="fa fa-trash" aria-hidden="true"></span> </a> <a href="{{url('/logout')}}" data-toggle="tooltip" data-placement="top" title="Logout"> <span class="fa fa-sign-out" aria-hidden="true"></span> </a> </div>
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
							->select('id_ente')
							->where('id', Auth::user()->id)
							->first();
					$logo = DB::table('corporations')
							->select('logo')
							->where('id', $idente->id_ente)
							->first();	
				  ?>
            <img src="http://easy.langa.tv/storage/app/images/<?php if(is_object($logo)) echo $logo->logo; ?>" id="immagineprofilo" alt="">@if (!Auth::guest()) {{Auth::user()->name}} @endif <span class=" fa fa-angle-down"></span> </a>
            <ul class="dropdown-menu dropdown-usermenu pull-right">
              <li><a href="{{url('/profilo')}}"><i class="fa fa fa-user pull-right"></i> Profilo</a></li>
              <li><a href="{{url('/faq')}}"><i class="fa fa-question pull-right"></i> Aiuto</a></li>
              <li> <a href="{{url('/admin')}}"> <span class="badge bg-red pull-right fa fa-lock pull-right">  admin </span> <span>Impostazioni</span> </a></li>
              <li><a href="{{url('/logout')}}"><i class="fa fa-sign-out pull-right"></i> Esci</a></li>
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

          for($i = 0; $i < count($notifiche) - 1; $i++) {
            for($k = $i + 1; $k < count($notifiche); $k++) {
              if(inSecondi($notifiche[$i]) < inSecondi($notifiche[$k])) {
                $tmp = $notifiche[$i];
                $notifiche[$i] = $notifiche[$k];
                $notifiche[$k] = $tmp;
              }
            }
          }


				?>
          <li role="presentation" class="dropdown"> <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-envelope-o"></i> <span class="badge bg-green">
            <?php if(Auth::user()->id === 0) echo '!'; else echo count($notifiche); ?>
            </span> </a>
            <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu" >
              <?php $count = 0; ?>
              <!-- notifiche layout --> 
              @foreach($notifiche as $notifica)
              <li> <a @if(Auth::user()->id !== 0) href="{{url('/notifiche/disdisci') . '/' . $notifica->id}}" @else href="{{url('/notifiche')}}" @endif onclick="return confirm('Sei sicuro di voler disdire questa notifica?')"> <span> <span>Hey, {{$notifica->nome}}</span> <span class="time">{{$notifica->datascadenza}}</span> </span> <span class="message">
                <?php if($notifica->target != null) echo $notifica->target; ?>
                <br>
                <?php if($notifica->id_ente != null) echo DB::table('corporations')
						  				->where('id', $notifica->id_ente)
										->first()->nomeazienda; ?>
                <br>
                {{$notifica->oggetto}} </span> </a> </li>
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
            </ul>
          </li>
           <li><?php
				$allLanguages = DB::table('languages')
							->select('*')
							->where('is_deleted', '0')
							->get();	
				?><select id="languageSwicher" class="form-control"><?php
					foreach($allLanguages as $langs){			
					  $value = session('locale');
						?><option value="<?php echo $langs->code; ?>" <?php if($value == $langs->code) { echo 'selected';}?>><?php echo $langs->original_name;?></option><?php 
					}
                 ?></select>
                </li>
        </ul>
      </nav>
    </div>
    <?php


        $userId = Auth::id();

        $notification = DB::table('inviare_avviso')
          ->join('alert', 'inviare_avviso.alert_id', '=', 'alert.alert_id')
          ->where('id_ente', $userId)
          ->where('conferma', '!=', 'LETTO')
          ->get();  
          ?>
    <div id="success_message"></div>
    <div class="col-md-6">
      <?php foreach ($notification as $notification) {  ?>
      <div class="alert alert-warning"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <h4>
          <div id="alert" class="comment" > {{ $notification->nome_alert }}
            <div id="comment"> {{ $notification->  messaggio }}
              <textarea id="messaggio" rows="4" cols="5"> </textarea>
              <input type="hidden" id="alert_id" name="" value="{{ $notification->alert_id  }}">
              <br>
              <br>
            </div>
            <div id="send">
              <button id="send" value="send"> Send </button>
            </div>
          </div>
        </h4>
      </div>
      <?php
          }
      ?>
    </div>
    <?php

        $notifica = DB::table('invia_notifica')
          ->where('user_id', $userId)
          ->get(); 

        foreach ($notifica as $notifica) {
          
          if(!empty($notifica->id_ente)) {

            $notifica = DB::table('invia_notifica')
                ->join('notifica', 'invia_notifica.notification_id', '=', 'notifica.id')
                ->where('user_id', $userId)
                ->where('invia_notifica.id_ente', '=', '')
                ->where('conferma', '!=', 'LETTO')
                ->get();

            foreach ($notifica as $notifica) {  ?>
    <div id="success_message"></div>
    <div class="col-md-6">
      <div class="alert alert-info"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <h4>
          <div id="notifica" class="comment" > {{ $notifica->notification_type }} <br>
            <br>
            <div id="g_comment"> {{ $notifica->notification_desc }} <br>
              <br>
              <textarea id="g_messaggio" rows="4" cols="5" > </textarea>
              <input type="hidden" id="notification_id" name="" value="{{ $notifica->id  }}">
              <br>
              <br>
            </div>
            <div id="notifica_send" >
              <button id="notifica_send" value="notifica_send"> Send </button>
            </div>
          </div>
        </h4>
      </div>
    </div>
    <?php

                }
          

          } else {

              $notifica = DB::table('invia_notifica')
                ->join('notifica', 'invia_notifica.notification_id', '=', 'notifica.id')
                ->where('user_id', $userId)
                ->where('invia_notifica.id_ente', '!=', '')
                ->where('conferma', '!=', 'LETTO')
                ->distinct()
                ->get();

              foreach ($notifica as $notifica) {  ?>
    <div class="col-md-6">
      <div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <h4>
          <div id="role_notifica" class="comment"> {{ $notifica->notification_type }} <br>
            <br>
            <div id="comment" > {{ $notifica->notification_desc }} <br>
              <br>
              <textarea id="messaggio" rows="4" cols="5" > </textarea>
              <input type="hidden" id="note_id" name="" value="{{ $notifica->id  }}">
              <br>
              <br>
            </div>
            <div id="note_send">
              <button id="note_send" value="note_send"> Send </button>
            </div>
          </div>
        </h4>
      </div>
    </div>
    <?php }
          }
      }
    ?>
  </div>
  <!-- /top navigation --> 
  @endif 
  <!-- Content -->
  <div class="right_col" role="main">
    <div class="row tile_count">
      <div class="container-fluid"> @yield('content') </div>
    </div>
  </div>
  <!-- /content --> 
  <!-- footer content -->
  <footer>
    <div class="pull-right">
      <p><small>2016 © Easy <strong>LANGA</strong> da e per <a href="http://www.langa.tv/"><strong>LANGA Group</strong></small><small><a href="http://easy.langa.tv/changelog"> versione 1.04</small></small></p>
      </a> </div>
    <div class="clearfix"></div>
    </div>
  </footer>
  <!-- /footer content --> 
</div>

<!-- jQuery --> 
<script src="{{asset('/vendors/jquery/dist/jquery.min.js')}}"></script> 
<!-- Bootstrap --> 
<script src="{{asset('/vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script> 

<!-- jQuery validation js --> 
<script src="{{ url('public/scripts/jquery.validate.min.js')}}"></script> 

<!-- Custom Theme Scripts --> 
<script src="{{asset('/build/js/custom.js')}}"></script> 
<script type="text/javascript">

      $(document).ready(function(){

            $('#alert').on('click', function(e) {  

                  $('#comment').css({
                      'display': 'block'
                  });
                  $('#send').css({
                      'display': 'block'
                  });

                  e.preventDefault();
                  var alert_id = $("#alert_id").val(); 

                  $.ajax({
                        type:'GET',
                          data: {
                                  'alert_id': alert_id
                                },
                          url: '{{ url('alert/user-read') }}',

                          success:function(data) {
                             // console.log(data);
                            //  $('#success_message').html(data);
                           
                            }

                        });

            $("#send").click(function(e){
       
              e.preventDefault();

              var messaggio = $("#messaggio").val(); 
              var alert_id = $("#alert_id").val(); 
              // var _token = $('input[name="_token"]').val();

              $.ajax({
                    type:'GET',
                      data: {
                              'messaggio': messaggio,
                              'alert_id': alert_id
                            },
                      url: '{{ url('alert/make-comment') }}',

                      success:function(data) {
                         console.log(data);
                        //  $('#success_message').html(data);
                          location.reload();
                        }

                    });

                });


            });

            $('#notifica').on('click', function(e) {  

                  $('#g_comment').css({
                      'display': 'block'
                  });
                  $('#notifica_send').css({
                      'display': 'block'
                  });

                  e.preventDefault();
                  var id = $("#notification_id").val(); 

                  $.ajax({
                        type:'GET',
                          data: {
                                  'id': id
                                },
                          url: '{{ url('notification/user-read') }}',

                          success:function(data) {
                             // console.log(data);
                            //  $('#success_message').html(data);
                           
                            }

                  });

            });

             $("#notifica_send").click(function(e){
         
              e.preventDefault();

              var messaggio = $("#g_messaggio").val(); 
              var id = $("#notification_id").val();
                 alert(messaggio);
              $.ajax({
                    type:'GET',
                      data: {
                              'messaggio': messaggio,
                              'id': id
                            },
                      url: '{{ url('notification/make-comment') }}',

                      success:function(data) {
                         console.log(data);
                        //  $('#success_message').html(data);
                          location.reload();
                        }

                    });

                });

             $('#role_notifica').on('click', function(e) {  

                  $('#comment').css({
                      'display': 'block'
                  });
                  $('#note_send').css({
                      'display': 'block'
                  });

                  e.preventDefault();
                  var id = $("#note_id").val(); 

                  $.ajax({
                        type:'GET',
                          data: {
                                  'id': id
                                },
                          url: '{{ url('note_role/user-read') }}',

                          success:function(data) {
                             // console.log(data);
                            //  $('#success_message').html(data);
                           
                            }

                  });

            });

             $("#note_send").click(function(e){
         
              e.preventDefault();

              var messaggio = $("#messaggio").val(); 
              var id = $("#note_id").val();
                 
              $.ajax({
                    type:'GET',
                      data: {
                              'messaggio': messaggio,
                              'id': id
                            },
                      url: '{{ url('note_role/make-comment') }}',

                      success:function(data) {
                         console.log(data);
                        //  $('#success_message').html(data);
                          location.reload();
                        }

                    });

                });

        });

    </script>
    
</body>
</html>
