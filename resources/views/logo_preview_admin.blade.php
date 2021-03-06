<div class="container body">
  <div class="main_container">
  <div class="col-md-3 left_col">
    <div class="left_col scroll-view">
      <div class="navbar nav_title"> <a href="{{url('/admin/')}}" class="site_title"><img src="<?php echo url($adminlogo)?>" alt="admin Langa" class="img" > </a> <a href="{{url('/admin/')}}" class="site_title sm"><img src="{{asset('images/admin-logo.svg')}}" alt="admin Langa" class="img" > </a> </div>
      
      <!-- sidebar menu -->
      <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

      <div class="menu_section">
      
      <ul class="nav side-menu">

        <li><a href="{{url('/admin')}}"><i class="fa fa-wrench"></i> {{trans('messages.keyword_globalsettings')}} </a>
        </li><?php
        $module = DB::table('modulo')
          ->where('modulo_sub', null)
          ->where('type', 2)
          ->orderBy('backpriority')
          ->orderBy('id')
          ->get();

        foreach ($module as $module) {

          $modulo = ucfirst(strtolower($module->modulo));

          $submodule = DB::table('modulo')
            ->where('modulo_sub', $module->id)
            ->get();
          
          if($submodule->isEmpty()){  ?>

          <li><a <?php if(isset($module->modulo_link)) { ?> href="<?php echo url("$module->modulo_link"); ?>" <?php } ?>> <img src="{{asset('storage/app/images/'.$module->image)}}"  class="menu-icon">{{ trans('messages.'.$module->phase_key) }}</a></li>

        <?php  } else { ?>  

        <li>
        
          <a> <img src="{{asset('storage/app/images/'.$module->image)}}" class="menu-icon" > 

           <span> {{ trans('messages.'.$module->phase_key) }} </span> <span class="fa fa-chevron-down"></span></a>
                              
          <ul class="nav child_menu">
    <?php
          if ($submodule) {

            foreach ($submodule as $submodule) {

              $subsubmodule = DB::table('modulo')
                ->where('modulo_sub', $submodule->id)
                ->get();

          if ($subsubmodule->isEmpty()) { 
          ?><li><a href="{{url("$submodule->modulo_link")}}">{{ trans('messages.'.$submodule->phase_key) }}</a></li><?php
          }

          else {
          ?><li><a <?php if(!empty($submodule->modulo_link)) { ?> href="<?php echo url("$submodule->modulo_link"); ?>" <?php } ?> >
             <span>{{ trans('messages.'.$submodule->phase_key) }} </span>

            <span class="fa fa-chevron-down"></span>             

           </a>
              <ul class="nav child_menu">
    <?php
            foreach ($subsubmodule as $subsubmodule1) {
    ?>          
                <?php $nextmodule = DB::table('modulo')
                      ->where('modulo_sub', $subsubmodule1->id)
                      ->get();

                      if ($nextmodule->isEmpty()) {  ?>

                     <li>
                      <a href="{{url("$subsubmodule1->modulo_link")}}">{{ trans('messages.'.$subsubmodule1->phase_key) }}</a>
                      </li>

                <?php } else { ?>
                        
                       <li>
                          <a <?php if(!empty($subsubmodule1->modulo_link)) { ?> href="<?php echo url("$subsubmodule1->modulo_link"); ?>" <?php } ?> >
                           <span>{{ trans('messages.'.$subsubmodule1->phase_key) }} </span>
                            <span class="fa fa-chevron-down"></span>           
                          </a>
                        
                        <ul class="nav child_menu"><?php 
                        foreach ($nextmodule as $nextmodule) { 
                          ?><li>
                          <a href="{{url("$nextmodule->modulo_link")}}">{{ trans('messages.'.$nextmodule->phase_key) }} </a>
                        </li><?php 
                        } 
                        ?></ul>
                        
                        </li>

                <?php } ?>
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
        
            function requestFullScreen() {
                var el = document.documentElement
    , rfs = // for newer Webkit and Firefox
           el.requestFullScreen
        || el.webkitRequestFullScreen
        || el.mozRequestFullScreen
        || el.msRequestFullscreen;
      if(typeof rfs!="undefined" && rfs){
        rfs.call(el);
      } else if(typeof window.ActiveXObject!="undefined"){
        // for Internet Explorer
        var wscript = new ActiveXObject("WScript.Shell");
        if (wscript!=null) {
           wscript.SendKeys("{F11}");
        }
}}

            </script> 
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
                                        <li><a href="{{url('/profilo')}}"><i class="fa fa fa-user pull-right"></i> {{trans("messages.keyword_profile")}}</a></li>
                                        <li><a href="javascript:;"><i class="fa fa-question pull-right"></i>{{trans('messages.keyword_help')}}</a></li>
                                        <li class="admin_back_to_site"><a href="{{url('/')}}">{{trans('messages.keyword_back_to_site')}}</a></li>
                                        <li><a href="{{url('/logout')}}"><i class="fa fa-sign-out pull-right"></i> {{trans('messages.keyword_logout')}}</a></li>
                                    </ul>
          </li>

        <?php  

          $userId = Auth::id();

          $notifications = DB::table('invia_notifica')
                ->leftjoin('notifica', 'invia_notifica.notification_id', '=', 'notifica.id')
                ->select(DB::raw('invia_notifica.*, notifica.id as noti_id, notifica.notification_type, notifica.notification_desc'))
                ->where('user_id', $userId)
                ->orderBy('data_lettura', 'asc')           
                ->get(); 
        ?>


          <li role="presentation" class="dropdown"> <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-envelope-o"></i> <span class="badge bg-green">

          <?php if(Auth::user()->id === 0) echo '!'; else echo count($notifications); ?>
          </span> </a>

          <div id="menu1" class="dropdown-menu list-unstyled msg_list notification-header">

         

            <div class="chkbox-blk">
                <div class="chkbox"><input type="checkbox" id="notifi1">
          <label for="notifi1"> notifi1 </label>
        </div>

            <div class="info"><input type="text"/></div>
        </div>

        <div class="chkbox-blk">

                <div class="chkbox"><input type="checkbox" id="notifi2">
          <label for="notifi2"> notifi2 </label>
        </div>

        @foreach($notifications as $notification)
          <?php 
            $date = $notification->created_at; 
            $date = date_format(new DateTime($date), 'D-m-Y H:i:s'); 
          ?>
          <div class="info">
          <a href="{{url('/notifiche/delete') . '/' . $notification->id}}" onclick="return confirm('{{ trans('messages.keyword_sure_to_disable_notification')}}?')">
            <span> {{$notification->notification_type}} </span>
            <span class="time"> {{ $date }} </span>
            <div class="message"> {{$notification->notification_desc}} </div>
              </a>
         </div>

                 @endforeach

        </div>

            <div class="btn-blk">
                <button class="btn btn-submit">Submit</button>
            <button class="btn btn-cancel">Cancel</button>

        </div>

        </div>
           
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
    <div class="row tile_count">
      <div class="col-md-12"> @yield('page') </div>
    </div>
  </div>
  <!-- /content --> 
  <!-- footer content -->
  <footer>
    <div class="pull-right"> 2016 © Easy <strong>LANGA</strong> created by <a href="http://langa.tv" target="_blank"><strong>LANGA</strong></a> </div>
    <div class="clearfix"></div>
    </div>
  </footer>
  <!-- /footer content --> 
</div>