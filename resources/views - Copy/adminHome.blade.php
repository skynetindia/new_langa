<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<!-- Meta, title, CSS, favicons, etc. -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="{{url('favicon.png')}}">
<title>Admin LANGA</title>

<!-- Bootstrap -->
<link href="{{asset('vendors/bootstrap/dist/css/bootstrap_admin.min.css')}}" rel="stylesheet">
<!-- Font Awesome -->
<link href="{{asset('vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
<!-- Custom Theme Style -->
<link href="{{asset('build/css/custom_admin.min.css')}}" rel="stylesheet">

<!-- Font -->
<link rel="stylesheet" href="{{asset('public/css/stylesheet.css')}}">
</head>
<?php 
echo "dd";
exit;
$arrSettings = adminSettings();
print_r($arrSettings);
exit;
$logged = false; 

?>
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
      <div class="navbar nav_title"> <a href="{{url('/admin/')}}" class="site_title md"><img src="<?php echo (isset($arrSettings->adminlogo) && !empty($arrSettings->adminlogo)) ? asset('storage/app/images/logo/'.$arrSettings->adminlogo) :  asset('images/LOGO-Admin-LANGA.svg');?>" alt="admin Langa" class="img" > </a> <a href="{{url('/admin/')}}" class="site_title sm"><img src="{{asset('images/admin-logo.svg')}}" alt="admin Langa" class="img" > </a> </div>
      
      <!-- sidebar menu -->
      <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
          <ul class="nav side-menu">
            <li><a href="{{url('/admin')}}"><i class="fa fa-wrench"></i> Impostazioni globali</a> </li>
            <li><a><img src="{{asset('images/ADMIN_RUOLI-E-CAPACITA.svg')}}" alt="Tassonomie" class="menu-icon" > <span> Ruoli e capacità</span> <span class="fa fa-chevron-down"></span></a>
              <ul class="nav child_menu">
                <li><a href="{{url('/newutente')}}">Newutente</a></li>
                <li><a href="{{url('/admin/utenti')}}">Utenti</a></li>
                <li><a href="{{url('/utente-permessi')}}">Permessi</a></li>
              </ul>
            </li>
            <li><a href="{{url('/newenti')}}">Registered Enti</a> </li>
            <li>
            <a><img src="{{asset('images/ADMIN_TASSONOMIE.svg')}}" alt="Tassonomie" class="menu-icon" > <span> Tassonomie</span> <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a>Tipi e stati<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                  <?php /*<li><a>Enti<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      
                      <li><a href="{{url('admin/tassonomie/enti')}}">Enti</a> </li>
                    </ul>
                  </li>*/?>
                  <li><a href="{{url('admin/taxonomies/enti')}}">Enti</a> </li>
                  <li><a href="{{url('admin/taxonomies/estimates')}}">Preventivi</a> </li>
                  <li><a>Progetti<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{url('/admin/taxonomies/project')}}">Progetti</a> </li>
                      <li><a href="{{url('admin/taxonomies/processing')}}">Lavorazioni</a> </li>
                    </ul>
                  </li>
                  <li><a href="{{url('/admin/taxonomies/payments')}}">Pagamenti</a> </li>
                </ul>
              </li>
              <li>
              <a>Vendita<span class="fa fa-chevron-down"></span></a>
              <ul class="nav child_menu">
                <li class="sub_menu"><a href="{{url('/admin/tassonomie/pacchetti')}}">Pacchetti</a> </li>
                <li><a>Optional<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="{{url('/admin/taxonomies/optional')}}">Optional</a>
                    <li><a href="{{url('/show-provincie')}}">Indici Costo Vita</a> </li>
                  </ul>
                </li>
                </li>
                <li><a href="{{url('/admin/tassonomie/sconti')}}">Sconti</a> </li>
                <li><a href="{{url('/admin/tassonomie/scontibonus')}}">Sconti Bonus</a> </li>
                <li><a href="{{url('admin/tassonomie/dipartimenti')}}">Dipartimenti</a></li>
              </ul>
              </li>
            </ul>
            </li>
            <li><a><img src="{{asset('images/ADMIN_AVVISI.svg')}}" alt="Avvisi" class="menu-icon" > <span>Avvisi</span> <span class="fa fa-chevron-down"></span></a>
              <ul class="nav child_menu">
                <li><a href="{{url('/admin/shownotification')}}">Notifiche</a></li>
                <li><a>Alert<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="{{url('/admin/alert')}}">Alert</a></li>
                    <li><a href="{{url('/admin/alert/tipo')}}">Alert Tipo</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li><a href="{{url('/taxation')}}"><i class="fa fa-percent"></i> Taxation </a></li>
            <li><a href="{{url('/newsletter/add')}}"><i class="fa fa-newspaper-o"></i> Newsletter</a></li>
            <li><a href="{{url('/admin/quizpackage')}}"><img src="{{asset('images/ADMIN_QUIZ.svg')}}" alt="Quiz Pacchetto" class="menu-icon" > <span> Quiz Pacchetto</span> </a></li>
            <li><a href="{{url('/admin/language')}}"><i class="fa fa-gift"></i> Languages & Phases </a></li>
            <li><a href="{{url('/admin/menu')}}"><i class="fa fa-gift"></i> {{trans("messages.keyword_menu")}} </a></li>
            <li><a><i class="fa fa-user-times"></i> {{trans('messages.keyword_quiz')}} <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="{{url('/admin/quiz')}}">{{trans('messages.keyword_demo')}}</a></li>

                                    </ul>
                                </li>

          </ul>
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
                                        <li><a href="{{url('/profilo')}}"> {{trans("messages.keyword_profile")}}</a></li>
                                        <li>
                                            <a href="javascript:;">
                                                <span class="badge bg-red pull-right">{{trans("messages.keyword_admin")}}</span>
                                                <span>{{trans('messages.keyword_settings')}}</span>
                                            </a>
                                        <li><a href="javascript:;">{{trans('messages.keyword_help')}}</a></li>
                                        <li><a href="{{url('/logout')}}"><i class="fa fa-sign-out pull-right"></i> {{trans('messages.keyword_logout')}}</a></li>
                                    </ul>
          </li>
          <li role="presentation" class="dropdown"> <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-envelope-o"></i> <span class="badge bg-green">6</span> </a>
            <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
              <li> <a> <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span> <span> <span>John Smith</span> <span class="time">3 mins ago</span> </span> <span class="message"> Film festivals used to be do-or-die moments for movie makers. They were where... </span> </a> </li>
              <li>
                <div class="text-center"> <a> <strong>Vedi notifiche</strong> <i class="fa fa-angle-right"></i> </a> </div>
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
  </div>
  <!-- /top navigation --> 
  @endif 
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

<!-- jQuery --> 
<script src="{{asset('vendors/jquery/dist/jquery.min.js')}}"></script> 
<!-- Bootstrap --> 
<script src="{{asset('vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script> 

<!-- jQuery validation js --> 
<script src="{{ url('public/scripts/jquery.validate.min.js')}}"></script> 

<!-- Custom Theme Scripts --> 
<!-- <script src="{{asset('build/js/custom.min.js')}}"></script> --> 

<script src="{{asset('/build/js/custom.js')}}"></script>
</body>
</html>
