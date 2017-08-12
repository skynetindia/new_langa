<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/scripts/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/scripts/daterangepicker.js') }}"></script>
<script src="{{ asset('public/js/chart/chart-bundle.js') }}"></script>
<script src="{{ asset('public/js/chart/chart.js') }}"></script>
<link rel="stylesheet" href="{{ asset('public/js/bootstrap-table/table.css') }}">
<script src="{{ asset('public/js/bootstrap-table/table.js') }}"></script>

<link rel="stylesheet" href="{{asset('public/scripts/jquery-ui.css')}}">
<script src="{{asset('public/scripts/jquery-ui.min.js')}}"></script>
<script src="{{asset('public/scripts/select2.full.min.js')}}"></script>



<link rel="stylesheet" type="text/css" href="{{ asset('public/js/daterangepicker/daterangepicker.css') }}" />
<link href="{{asset('public/js/calander/fullcalendar.min.css')}}" rel='stylesheet' />
<link href="{{asset('public/js/calander/fullcalendar.print.min.css')}}" rel='stylesheet' media='print' />

<?php $activewidgets = getWidgets();?>
<!--<link rel="stylesheet" type="text/css" href="{{ asset('public/js/daterangepicker/daterangepicker.css') }}" />-->

<div class="main-dashbord-bacheca-user">	
    <div class="row">
		<div class="col-md-6 col-sm-12 col-xs-12">
        	<div class="set-height-lft-bacheca-user">
            	<!-- ================================ Wearther Section ========================== -->
                <?php /*<div class="bg-white">
                    <h4><strong>Weather</strong></h4><hr>
                	<div class="wheather" id="wheather">
                        @include('dashboard.wheather')                    	
                    </div>
                </div>*/?>
                <!-- ================================ Statisctic section start ========================== -->
                <div class="bg-white">
                    <h4><strong>{{trans('messages.keyword_statistics')}}</strong></h4><hr>
                	<div class="statistics" id="statistics">
                    	@include('dashboard.statistics_ajax')
                    </div>
                </div>
                <!-- ================================ Statisctic section start ========================== -->
                <!-- ================================ Statisctic Economics section  ========================== -->
                <div class="bg-white">
                	<div class="preventiviti">
                    <h4><strong> {{ trans('messages.keyword_quotes') }} {{ trans('messages.keyword_confirmed') }} </strong></h4><hr>
                    	@include('dashboard.statistics_cost_ajax')
                    </div>
                </div>                
            </div>
        </div>        
        <div class="col-md-6 col-sm-12 col-xs-12">
        	<div class="set-height-right-bacheca-user">            
                <!-- ================================ Calendar section  ========================== -->
            	<div class="bg-white" style="<?php echo (in_array('2',$activewidgets)) ? 'display:block' : 'display:none'; ?>">
                    <h4><strong> {{ trans('messages.keyword_calendar') }}</strong><a onclick="return widgetupdate('delete','2')" class="pull-right"><i class="fa fa-times" aria-hidden="true"></i></a></h4><hr>
                	<div class="widget-quotes widget-quotes-without-scroll" id="calendar_ajax"><!-- widget -->
                    	@include('dashboard.calendar')
                    </div>
                </div>
                <!-- ================================ Quotes section  ========================== -->
                <div class="bg-white" style="<?php echo (in_array('3',$activewidgets)) ? 'display:block' : 'display:none'; ?>">
                    <h4><strong> {{ trans('messages.keyword_quotes') }}</strong><a onclick="return widgetupdate('delete','3')" class="pull-right"><i class="fa fa-times" aria-hidden="true"></i></a></h4><hr>
                	<div class="widget-quotes">
                    	@include('dashboard.quotes_ajax')
                    </div>
                </div>
                <!-- ================================ Entity section  ========================== -->
                <div class="bg-white" style="<?php echo (in_array('1',$activewidgets)) ? 'display:block' : 'display:none'; ?>">
                    <h4><strong> {{ trans('messages.keyword_entity') }}</strong><a onclick="return widgetupdate('delete','1')" class="pull-right"><i class="fa fa-times" aria-hidden="true"></i></a></h4><hr>
                    <div class="widget-quotes">
                        @include('dashboard.entity_ajax')
                    </div>
                </div>
                <!-- ================================ Project section  ========================== -->
                <div class="bg-white" style="<?php echo (in_array('4',$activewidgets)) ? 'display:block' : 'display:none'; ?>">
                    <h4><strong> {{ trans('messages.keyword_projects') }}</strong><a onclick="return widgetupdate('delete','4')" class="pull-right"><i class="fa fa-times" aria-hidden="true"></i></a></h4><hr>
                    <div class="widget-quotes">
                        @include('dashboard.project_ajax')
                    </div>
                </div>
                <!-- ================================ Invoice Section  ========================== -->
                <div class="bg-white" style="<?php echo (in_array('21',$activewidgets)) ? 'display:block' : 'display:none'; ?>">
                    <h4><strong> {{ trans('messages.keyword_invoices') }}</strong><a onclick="return widgetupdate('delete','21')" class="pull-right"><i class="fa fa-times" aria-hidden="true"></i></a></h4><hr>
                    <div class="widget-quotes">
                        @include('dashboard.invoice_ajax')
                    </div>
                </div>
                @include('dashboard.drag_drop')                            
            </div>
        </div>        
    </div>        
</div>
<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>
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

$("#giorno").daterangepicker({
                                    autoApply: true,
                                    timePicker: true,
                                    drops:"up",
                                    timePickerIncrement: 30,
                                    locale: {
                                        format: 'MM/DD/YYYY h:mm A'
                                    }
                                    });
</script>
 
