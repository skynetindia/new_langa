<div class="cale">
@if(count($events) > 0)
@foreach ($events as $key => $event)
    <?php 
            $utente = DB::table('users')
            ->where('id', $event->user_id)
            ->first();                                  
            $colore = (isset($utente->color))?$utente->color:'#666';
            $event->color = $colore;
            $event->utente = (isset($utente->name))?$utente->name:'' ;?>                    
    @endforeach      
@endif    
    <div id='calendar'></div>    
    <?php $arrCurrentLocations = getLocationInfoByIp();
    $currentlocation = isset($arrCurrentLocations['city']) ? $arrCurrentLocations['city'] : "";
    $currentlocation .= isset($arrCurrentLocations['country']) ? ", ".$arrCurrentLocations['country'] : "";?>
<?php
    //echo json_encode($projects);
    // exit;
    ?>        
    <?php $arrCurrentLocations = getLocationInfoByIp();
    $currentlocation = isset($arrCurrentLocations['city']) ? $arrCurrentLocations['city'] : "";
    $currentlocation .= isset($arrCurrentLocations['country']) ? ", ".$arrCurrentLocations['country'] : "";?>
<?php
    //echo json_encode($projects);
    // exit;
    ?>
<script>
var eventi = <?php echo json_encode($events); ?>;
var estimates = <?php echo json_encode($estimates); ?>;
var projects = <?php echo json_encode($projects); ?>;
var invoices = <?php echo json_encode($invoices); ?>;
var eventiDaStampare = [];
var tipo = <?php echo $tipo; ?>;
</script>

<script src="{{asset('public/js/calander/lib/moment.min.js')}}"></script>
<script src="{{asset('public/js/calander/fullcalendar.min.js')}}"></script>
<script>
jq223 = jQuery.noConflict(false);
    jq223(document).ready(function() {  
        jq223('#calendar').fullCalendar({
            header: {
                left: 'prevYear,prev, today,next,nextYear',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listWeek'
            },
            defaultDate: "<?php echo date('Y-m-d',time())?>",
            editable: true,
            navLinks: false, // can click day/week names to navigate views
            eventLimit: true, // allow "more" link when too many events
            events: {
                url: "{{url('/calendario/json/'.$tipo)}}",
                error: function() {
                    jq223('#script-warning').show();
                }
            },
            loading: function(bool) {               
                jq223('#loading').toggle(bool);
            },
            eventRender: function (events, element) {
                element.attr('href', 'javascript:void(0);');
                element.click(function() {            
                    /*mostraEventi(moment(events.start).format('D'));*/
                    showevents(moment(events.start).format('DD-MM-YYYY'),events.id);                                                                
                    detailsAllother(moment(events.start).format('DD-MM-YYYY'),events.id);
                });
            },
            dayClick: function(date, events, view) {                
                var selecteddate = moment(date).format('MM/DD/YYYY h:mm A');                                
                aggiungiEvento(selecteddate)
               /* if (jsEvent.target.classList.contains('fc-bgevent')) {
                    alert('Click Background Event Area');
                }*/
            }
        });
        
    });

/* Details display for estimates,project, invoice */
$ = jQuery.noConflict(false);
 var psconsole = $('#content');
 $(".geolocationbox").click( function(e){
     e.stopPropagation();
            e.preventDefault();               
    });

</script>


