<div class="container body">
<?php $logged = false; ?>
<?php $logged = true; ?>
  <div class="main_container">
  <div class="col-md-3 left_col">
    <div class="left_col scroll-view">
      <div class="navbar nav_title"> <a href="{{url('/')}}" class="site_title md"><img src="<?php echo url($frontlogo)?>" class="easy_fron_logo" alt="Easy Langa" class="img" style="display:block; width:3.50cm; height:auto;"> </a>
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
        $module = DB::table('modulo')
          ->where('modulo_sub', null)
          ->where('type', 1)
          ->orderBy('frontpriority')
          ->orderBy('id')
          ->get();

        foreach ($module as $module) {
          $modulo = ucfirst(strtolower($module->modulo));
          $submodule = DB::table('modulo')
            ->where('modulo_sub', $module->id)
            ->get();
        
          if( $module->modulo == "STATISTICHE"){ ?>
            <br>
            <h3>{{trans('messages.keyword_secondary')}}</h3>
            <br>

          <?php }

      if($submodule->isEmpty()){  ?>
         <?php if ( $module->modulo == "MAPPE" ) { ?>
         <li>
         <a><img src="{{asset('storage/app/images/'.$module->image)}}" class="menu-icon" >{{ trans('messages.'.$module->phase_key) }}
            <span class="fa fa-chevron-down"></span>
          </a> 
            <ul class="nav child_menu">
                <div class="container-fluid col-md-12" style="background:#2A3F54;color:#ffffff">
                      <form action="http://maps.google.com/maps" onsubmit="punto()" method="get" target="new">
                          <div>
                            <div class="col-md-12">
                              <div class="col-md-6">
                                  <br><br><input style="display:inline" class="form-control" style="color:#000000;max-width:250px;" type="text" name="saddr" placeholder="Da">
                              </div>
                              <br>
                              <div class="col-md-6">
                                  <br><input style="display:inline" class="form-control" style="color:#000000;max-width:250px;" type="text" name="daddr" placeholder="A">
                              </div>
                              <div class="col-md-12">
                                  <input style="display:inline" type="hidden" id="prova" name="daddr">
                                  <br><input style="display:inline;background:#f37f0d; color:#ffffff;" class="form-control" type="submit" value="Go"><br><br><br>
                              </div>
                          </div>
                      </div>
                  </form>     
              </div>
              </ul>
            </li>

          <?php } else {  ?>
             <li><a href="<?php if(isset($module->modulo_link)) { echo url("$module->modulo_link"); } ?>"> <img src="{{asset('storage/app/images/'.$module->image)}}" class="menu-icon" > 
            {{ trans('messages.'.$module->phase_key) }} <?php } ?>
          </a> </li>       

        <?php  } else {  ?>  

        <li>
          <a ><img src="{{asset('storage/app/images/'.$module->image)}}" class="menu-icon" > {{ trans('messages.'.$module->phase_key) }} 
            <span class="fa fa-chevron-down"></span>
          </a>                                  
          
          <ul class="nav child_menu">
    <?php
          if ($submodule) {
            foreach ($submodule as $submodule) {

              $subsubmodule = DB::table('modulo')
                ->where('modulo_sub', $submodule->id)
                ->get();
              
          if ($subsubmodule->isEmpty()) { 
    ?>    
          <li><a href="{{url("$submodule->modulo_link")}}">{{ trans('messages.'.$submodule->phase_key) }}</a></li>
    <?php
          }

          else {
    ?>
            <li><a <?php if(!empty($submodule->modulo_link)) { ?> href="<?php echo url("$submodule->modulo_link"); ?>" <?php } ?> >{{ trans('messages.'.$submodule->phase_key) }} <span class="fa fa-chevron-down"> </span> </a>
              <ul class="nav child_menu">
    <?php
            foreach ($subsubmodule as $subsubmodule1) {
    ?>
            <li>
            <a href="{{url("$subsubmodule1->modulo_link")}}">{{ trans('messages.'.$subsubmodule1->phase_key) }} </a>
            </li>

    <?php
           }
    ?>
              </ul>    
            </li>
    <?php
            }
        }
    ?> 
              </ul>
            </li>
    <?php
            }
        }

      }
    ?>
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
      <div class="sidebar-footer hidden-small"> <a href="{{url('/')}}" data-toggle="tooltip" data-placement="top" title="Home"> <span class="fa fa-home" aria-hidden="true"> </span> </a> <a href="http://www.client.easy.langa.tv/" target=_"blank" data-toggle="tooltip" data-placement="top" title="Client LANGA"> <span class="fa fa-th-large" aria-hidden="true"></span> </a> <a href="http://www.reseller.easy.langa.tv/" target=_"blank" data-toggle="tooltip" data-placement="top" title="Reseller LANGA"> <span class="fa fa-th" aria-hidden="true"></span> </a> <a href="http://www.betaeasy.langa.tv/" target="_blank" data-toggle="tooltip" data-placement="top" title="Easy Beta"><span> β</span> </a>
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
              <li> <a href="{{url('/admin')}}"> <span class="badge bg-red pull-right fa fa-lock pull-right">  admin </span> <span>{{trans('messages.keyword_settings')}}</span> </a></li>
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

    ?>

    <?php  

      $userId = Auth::id();

      $notifications = DB::table('invia_notifica')
            ->leftjoin('notifica', 'invia_notifica.notification_id', '=', 'notifica.id')
            ->select(DB::raw('invia_notifica.*, notifica.id as noti_id, notifica.notification_type, notifica.notification_desc'))
            ->where('user_id', $userId)
            ->where('is_enabled', 0)
            ->where('is_deleted', 0)
            ->orderBy('data_lettura', 'asc')           
            ->get();

          $alerts = DB::table('inviare_avviso')
            ->leftjoin('alert', 'inviare_avviso.alert_id', '=', 'alert.alert_id')
            ->select(DB::raw('inviare_avviso.*, alert.alert_id as alrt_id, alert.nome_alert, alert.messaggio'))
            ->where('user_id', $userId)
            ->where('is_enabled', 0)
            ->where('is_deleted', 0)
            ->orderBy('data_lettura', 'asc')           
            ->get();  
    ?>


    <li role="presentation" class="dropdown"> <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false"> 

      <i class="fa fa-envelope-o"></i> <span class="badge bg-green">
            
        <?php if(Auth::user()->id === 0) echo '!'; else echo count($notifications); ?>
        </span> </a>

       <div id="menu1" class="dropdown-menu list-unstyled msg_list notification-header">        

            <div class="chkbox-blk">
            
                <div class="chkbox"><input type="checkbox" id="notifi1">
          <label for="notifi1"> notifi1 </label>
        </div>

            <div class="info"><input type="text" id="find-noti" /></div>
        </div>

        <div id="replace-noti">

        <?php $i = 1; ?>

      @foreach($notifications as $notification)
        <?php 
              $date = $notification->created_at; 
              $date = date_format(new DateTime($date), 'D-m-Y H:i:s'); 
            ?>  

      <div class="chkbox-blk" >

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
  
  </div>
  <!-- /top navigation --> 
  


  <!-- Content -->

  <div class="right_col" role="main">

    <div class="row alert-div">
      
    <?php

        $userId = Auth::id(); $today = date("Y-m-d");
        $alert = DB::table('inviare_avviso')
          ->join('alert', 'inviare_avviso.alert_id', '=', 'alert.alert_id')
          ->where('user_id', $userId)->where('is_deleted', 0)
          ->where('alert.created_at', '=', $today)->groupBy('alert.alert_id')
          ->get(); 

        $i = 1; 
    ?>
       
  <?php foreach ($alert as $alert) {  ?>

      <div class="col-md-6 main_class_alert"> 

        <button data-id="alert_comment<?php echo $i; ?>" id="myclose<?php echo $i; ?>" type="button" class="close alert_close" aria-label="Close" onclick="myalertclose(this.id, <?php echo $i; ?>)"> 
        <span aria-hidden="true">&times;</span>
      </button>

        <div data-value="alert_comment<?php echo $i; ?>" class="myalert" id="myalert<?php echo $i; ?>" onclick="myalert(this.id, <?php echo $i; ?>)">

              <div class="alert alert-warning">
          <b style="font-size: 16px;"> {{ $alert->nome_alert }} </b>
        </div>    

      </div>

            <div  class="alert-warning comment" >            

              <div id="alert_comment<?php echo $i; ?>" class="alert_comment" style="display: none;font-weight: bold;"> 

                <p style="text-indent:40px;">
                  {{ $alert->messaggio }}  
                </p>
                  
                <textarea class="form-control" id="alert_messaggio<?php echo $i; ?>" rows="4" cols="5" style="color: black"><?php if(isset($alert->comment)){ echo $alert->comment; } ?></textarea> 

                <input type="hidden" class="alert_id" id="alert_id<?php echo $i; ?>" name="" value="{{ $alert->alert_id  }}">
                <input type="hidden" id="user_id" name="" value="{{ $userId  }}">
                
                <br>
                <button id="alert_send<?php echo $i; ?>" value="send" style="color: black">
                Send
                </button>

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

        
    <?php foreach ($notifications as $notification) { ?>

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

  <?php $i++; } ?>

    </div><?php ?>

    <div class="row tile_count">
      <div class="container-fluid"> 
      <div class="col-md-12" style="min-height: 600px;"><br></div>
      <!-- @yield('content')--> </div>
    </div>
  </div>

  <!-- /content --> 
  <!-- footer content -->
  <footer>
    <div class="pull-right">
      <p><small>2016 © Easy <strong>LANGA</strong> da e per <a href="http://www.langa.tv/"><strong>LANGA Group</strong></a></small><small><a href="http://easy.langa.tv/changelog"> versione 1.04  </a></small></p>
     </div>
    <div class="clearfix"></div>
   <!-- </div>-->
  </footer>
  <!-- /footer content --> 
</div>
</div>