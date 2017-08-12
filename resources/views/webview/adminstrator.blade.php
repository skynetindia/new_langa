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
    @if($type == 'statistics')
    <div class="bg-white">      
      <div class="statistics" id="statistics">
          @include('webview.statistics_ajax')
      </div>
    </div>
    @endif
    <div class="bg-white">
        <h4><strong> {{ trans('messages.keyword_entity') }}</strong><a onclick="return widgetupdate('delete','1')" class="pull-right"><i class="fa fa-times" aria-hidden="true"></i></a></h4><hr>
        <div class="widget-quotes">
            @include('dashboard.entity_ajax')
        </div>
    </div>
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
 
