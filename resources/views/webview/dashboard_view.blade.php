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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="{{ asset('public/js/chart/chart-bundle.js') }}"></script>
<script src="{{ asset('public/js/chart/chart.js') }}"></script>
<link rel="stylesheet" href="{{ asset('public/js/bootstrap-table/table.css') }}">
<script src="{{ asset('public/js/bootstrap-table/table.js') }}"></script>
<script src="{{asset('public/scripts/select2.full.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('public/js/daterangepicker/daterangepicker.css') }}" />
<link href="{{asset('public/js/calander/fullcalendar.min.css')}}" rel='stylesheet' />
<link href="{{asset('public/js/calander/fullcalendar.print.min.css')}}" rel='stylesheet' media='print' />
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js"></script>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/themes/base/jquery-ui.css" type="text/css" rel="stylesheet">
<?php //$activewidgets = getWidgets();?>

    <!--<link rel="stylesheet" type="text/css" href="{{ asset('public/js/daterangepicker/daterangepicker.css') }}" />-->    
    <?php /*======================= LEFT SIDE GRAPHS AND OTHER START ===================================== */?>
    @if($type == 'statistics' && ($userid == 0 || $userprofiletype === 'Administration' || $userprofiletype === 'Supperadmin'))
    <div class="bg-white">      
      <div class="statistics" id="statistics">
          @include('dashboard.statistics_ajax')
      </div>
    </div>
    @endif
    @if($type == 'statistics' && ($userprofiletype === 'Commercial' || $userprofiletype === 'Reseller'))
    <div class="bg-white">      
      <div class="statistics" id="statistics">
          @include('dashboard.commercial_statistics_ajax')
      </div>
    </div>
    @endif    
    @if($type == 'resellerlogin' && ($userprofiletype === 'Commercial'))
    <div class="bg-white">
        <div class="preventiviti">
        <h4><strong>{{ trans('messages.keyword_login_reseller') }} </strong></h4><hr>
            @include('dashboard.reseller_login_chart')
        </div>
    </div>
    @endif        
    @if($type == 'statistics' && ($userprofiletype === 'Technician'))
    <div class="bg-white">                    
        <h4><strong>{{trans('messages.keyword_statistics')}}</strong></h4><hr>
        <div class="statistics" id="statistics">
          @include('dashboard.technician_statistics_ajax')
        </div>
    </div>
    @endif
    @if($type == 'projectsCustomer' && ($userprofiletype === 'Customer' || $userprofiletype === 'Client'))
    <?php $projects = $projectsCustomer; ?>
    <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="set-height-lft-bacheca-user">
              <div class="bg-white">                    
                    <h4><strong>{{trans('messages.keyword_your_responsible_langa')}}</strong></h4><hr>
                    <div class="statistics client-statistics" id="responsabilelanga">
                        <div class="">
                            @foreach($responsabilelanga as $key => $val)
                            <div class="col-md-8">
                                <div class="btn-group">        
                                    <p><strong>{{$val->name}}</strong></p>
                                    <p>{{trans('messages.keyword_telephone_company')}} : {{$val->cellulare}}</p>
                                    <p>Mobile : {{$val->cellulare}}</p>
                                    <p>Email : {{$val->email}}</p>
                                </div>
                            </div>    
                             @if(isset($val->logo) && $val->logo != "")
                                <div class="col-md-4">
                                <div class="text-center">
                                <div class="btn-group">
                                    <img src="{{url('storage/app/images/'.$val->logo)}}" height="100" width="100" />        
                                    </div>
                                </div>            
                                </div>
                            @endif                        
                            @endforeach
                        </div> <div class="clearfix"></div>
                    </div>
                </div>
                <!-- ================================ Statisctic section start ========================== -->
            </div>
        </div>    
         <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="set-height-right-bacheca-user">
               <!-- ================================ Statisctic section start ========================== -->
                <div class="bg-white">                    
                    <h4><strong>{{trans('messages.keyword_projects')}}</strong></h4><hr>
                  <div class="statistics" id="statistics">
                      @include('dashboard.client_projects_ajax')
                    </div>
                </div>
            </div>
        </div>            
    @endif
    @if($type == 'projectReseller' && ($userprofiletype === 'Reseller'))
    <?php $project = $projectReseller;?>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="set-height-lft-bacheca-user">
            <div class="bg-white">                    
                    <h4><strong>{{trans('messages.keyword_your_responsible_langa')}}</strong></h4><hr>
                    <div class="statistics client-statistics" id="responsabilelanga">
                      <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            @foreach($responsabilelanga as $key => $val)
                            <div class="col-md-8">
                                <div class="btn-group">        
                                <p><strong>{{$val->name}}</strong></p>
                                <p>{{trans('messages.keyword_telephone_company')}} : {{$val->cellulare}}</p>
                                <p>Mobile : {{$val->cellulare}}</p>
                                <p>Email : {{$val->email}}</p>
                                </div>                                
                            </div>                
                            @if(isset($val->logo) && $val->logo != "")
                                <div class="col-md-4">
                               <div class="text-center"> <div class="btn-group">
                                    <img src="{{url('storage/app/images/'.$val->logo)}}" height="100" width="100" />        
                                    </div></div>
                                </div>            
                            @endif
                            @endforeach
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="set-height-lft-bacheca-user">
                  <div class="bg-white chart-box-dash">                    
                      <h4><strong>{{trans('messages.keyword_projects')}}</strong></h4><hr>
                      <div class="statistics" id="Projectcharts">
                          @include('dashboard.reseller_projects_ajax')
                      </div>
                  </div>
              </div>                
            </div>
    @endif   
    
    <?php /*======================= LEFT SIDE GRAPHS AND OTHER END ===================================== */?>

    <?php /*======================= LEFT BOTTOM TEXT DEADLINE ===================================== */?>
    @if($type == 'taxdeadline' && ($userid == 0 || $userprofiletype === 'Administration' || $userprofiletype === 'Supperadmin'))
    <div class="bg-white">
      <div class="preventiviti">
        <h4><strong>{{ trans('messages.keyword_tax_deadlines') }}</strong></h4><hr>
          @include('dashboard.statistics_cost_ajax')
        </div>
    </div>              
    @endif 
    @if($type == 'pendingquote' && ($userprofiletype === 'Commercial'))
    <div class="bg-white">
        <div class="preventiviti">
        <h4><strong>{{ trans('messages.keyword_pending_confirmation') }} </strong></h4><hr>
             @include('dashboard.statistics_cost_ajax')
        </div>
    </div>
    @endif
    @if($type == 'pendingquote' && ($userprofiletype === 'Reseller'))
    <div class="bg-white">
        <div class="preventiviti">
        <h4><strong>{{ trans('messages.keyword_pending_confirmation') }} </strong></h4><hr>
             @include('dashboard.statistics_cost_ajax')
        </div>
    </div>
    @endif
    @if($type == 'confirmquote' && ($userprofiletype === 'Technician'))
    <div class="bg-white">
        <div class="preventiviti">
        <h4><strong>{{ trans('messages.keyword_pending_confirmation') }} </strong></h4><hr>
             @include('dashboard.statistics_cost_ajax')
        </div>
    </div>
    @endif
    
    <?php /*============================= Right Side Active Widget Start ===================================== */?>
    @if($type == 'entity')
    <div class="bg-white">
        <h4><strong> {{ trans('messages.keyword_entity') }}</strong></h4><hr>
        <div class="widget-quotes">
            @include('dashboard.entity_ajax')
        </div>
    </div>
    @endif
    @if($type == 'calendor')
    <div class="bg-white">
        <h4><strong> {{ trans('messages.keyword_calendar') }}</strong></h4><hr>
        <div class="widget-quotes" id="calendar_ajax"><!-- widget -->
            @include('dashboard.calendar')
        </div>
    </div>
    @endif
    @if($type == 'quote')
    <div class="bg-white">
        <h4><strong> {{ trans('messages.keyword_quotes') }}</strong></h4><hr>
        <div class="widget-quotes">
          @include('dashboard.quotes_ajax')
        </div>
    </div>
    @endif
    @if($type == 'project')
    <div class="bg-white">
        <h4><strong> {{ trans('messages.keyword_projects') }}</strong></h4><hr>
        <div class="widget-quotes">
            @include('dashboard.project_ajax')
        </div>
    </div>
    @endif
    @if($type == 'invoice')
     <div class="bg-white">
        <h4><strong> {{ trans('messages.keyword_invoices') }}</strong></h4><hr>
        <div class="widget-quotes">
            @include('dashboard.invoice_ajax')
        </div>
     </div>
    @endif
    <?php /*============================= Right Side Active Widget END ===================================== */?>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script type="text/javascript" src="{{ asset('public/scripts/moment.js') }}"></script>
  <script type="text/javascript" src="{{ asset('public/scripts/daterangepicker.js') }}"></script>
<script>
var $jp = jQuery.noConflict();
$jp(document).ready(function() {

// init
var containerWidth = $jp("#resize-width").width();
if($jp(window).width()>991){
    $jp("#left-resize").resizable({
      handles: 'e',
      maxWidth: containerWidth-320,
      minWidth: 320,
      resize: function(event, ui){
          var currentWidth = ui.size.width;
          // alert(currentWidth);
          // this accounts for padding in the panels + 
          // borders, you could calculate this using jQuery
          var padding = 40; 
          
          // this accounts for some lag in the ui.size value, if you take this away 
          // you'll get some instable behaviour
          $jp(this).width(currentWidth-padding);
          console.log(currentWidth,'width');
		      console.log(containerWidth - (currentWidth + padding),'left');
          // set the content panel width
          $jp("#right-resize").width(containerWidth - (currentWidth + padding));
		      //alert($jp("#right-resize").width(containerWidth - currentWidth - padding));            
      }
	});
}
});
</script>
<script>
function aggiungiEvento(selecteddate) {    
  $( "#newEvent" ).modal();
    $('#newEvent').on('shown.bs.modal', function(){
      initMap2();             
      if (typeof selecteddate != 'undefined'){        
        $("#giorno").val(selecteddate+' - '+selecteddate);
      }
    });
}

</script>
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
 
