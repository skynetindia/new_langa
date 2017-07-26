<div class="cale">
@foreach ($events as $event)
    <?php 
            $utente = DB::table('users')
            ->where('id', $event->user_id)
            ->first();                                  
            $colore = (isset($utente->color))?$utente->color:'#666';
            $event->color = $colore;
            $event->utente = (isset($utente->name))?$utente->name:'' ;?>                    
    @endforeach          
    <div id='calendar'></div>    
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

function removeAllChildren(theParent){
    // Create the Range object
    var rangeObj = new Range();
    // Select all of theParent's children
    rangeObj.selectNodeContents(theParent);
    // Delete everything that is selected
    rangeObj.deleteContents();
}

function changetextlocationval(id){
  $("#geolocationshdAddress_"+id).val($("#geolocationPlaces_"+id).val());    
}
</script>
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
function detailsAllother(selectdate,selectedid){ 
   $('#push').show();
    /* Estimates  */
    $.each(estimates, function( key, value) {
        var new_date = moment(value.valenza, "DD-MM-YYYY").add('days', 10);
        new_date = moment(new_date).format('DD-MM-YYYY');
                 
        //finelavori 
        if(selectdate == new_date) {
            var selectedEventStye = "";
            if(selectedid == value.id){
                selectedEventStye = 'border: 3px solid #337ab7';
            }
            if(value.color == ""){
                value.color='#ff851b';
            }
            
            var detailHtml = '<div style="background-color: '+value.color+';'+selectedEventStye+'" class="striscia"><a href="{{url('/estimates/modify/quote/')}}/'+value.id+'" id="mainlink"><div class="orario">Quote :'+value.id+'/'+value.anno+'</div><div>'+value.oggetto+'</div><div>{{trans('messages.keyword_valenza')}} : '+value.valenza+'</div><div>{{trans('messages.keyword_end_date_works')}} : '+value.finelavori+'</div></a></div>'; 
            $('#content').find('h3').remove();
            $('#content').append(detailHtml);
        }     
    });

    /* Projects */
    $.each(projects, function( key, value) {
        var new_date = moment(value.datafine, "DD-MM-YYYY").add('days', 0);
         new_date = moment(new_date).format('DD-MM-YYYY');                 
        //finelavori 
        if(selectdate == new_date) {
            var selectedEventStye = "";
            if(selectedid == value.id){
                selectedEventStye = 'border: 3px solid #337ab7';
            }
            if(value.color == ""){
                value.color='#ff851b';
            }
            var proyear = value.datainizio;
            proyear = proyear.slice(-2);            
            var detailHtml = '<div style="background-color: '+value.color+';'+selectedEventStye+'" class="striscia"><a href="{{url('/progetti/modify/project/')}}/'+value.id+'" id="mainlink"><div class="orario">Project :'+value.id+'/'+proyear+'</div><div>'+value.nomeprogetto+'</div><div>{{trans('messages.keyword_starttime')}} : '+value.datainizio+'</div><div>{{trans('messages.keyword_endtime')}} : '+value.datafine+'</div></a></div>'; 
            $('#content').find('h3').remove();
            $('#content').append(detailHtml);
        }     
    });
    
    /* Projects */
    $.each(invoices, function( key, value) {
        var new_date = moment(value.datascadenza, "DD-MM-YYYY").add('days', 0);
        new_date = moment(new_date).format('DD-MM-YYYY');                 
        
        if(selectdate == new_date) {
            var selectedEventStye = "";
            if(selectedid == value.id){
                selectedEventStye = 'border: 3px solid #337ab7';
            }
            if(value.color == ""){
                value.color='#ff851b';
            }
            var invyear = value.datascadenza;
            invyear = invyear.slice(-2);            
            var detailHtml = '<div style="background-color: '+value.color+';'+selectedEventStye+'" class="striscia"><a href="{{url('/pagamenti/tranche/modifica/')}}/'+value.id+'" id="mainlink"><div class="orario">Invoice :'+value.idfattura+'</div><div>{{trans('messages.keyword_on_the_base')}} : '+value.base+'</div><div>{{trans('messages.keyword_issue_of_the')}} : '+value.emissione+'</div><div>{{trans('messages.keyword_expiry_date_invoice')}} : '+value.datascadenza+'</div></a></div>'; 
            $('#content').find('h3').remove();
            $('#content').append(detailHtml);
        }     
    });

    
    /* var psconsole = $('#content');
         $('html, body').animate({
                        scrollTop: psconsole.offset().top
                    }, 1000);*/

}
function showevents(selectdate,eventid){
    $('#content').html("");
    $.each(eventi, function( key, value) {
        var startday = value.giorno;
        var startmonth = value.mese;
        var endday = value.giornoFine;
        var endmonth = value.meseFine;
        var startyear = value.anno;
        var endyear = value.annoFine;

        var starttime = value.sh
        var endtime = value.eh

        var stardate = startday+'-'+startmonth+'-'+startyear;
        var enddate = endday+'-'+endmonth+'-'+endyear;

        var stardate = moment(stardate, "DD-MM-YYYY");
        var enddate = moment(enddate, "DD-MM-YYYY");

        var arrselected = selectdate.split("-");
        var selecteddate = arrselected[0]+'-'+arrselected[1]+'-'+arrselected[2];
        var selecteddate = moment(selecteddate, "DD-MM-YYYY");
        
        
       var fDate,lDate,cDate;
        fDate = Date.parse(stardate);
        lDate = Date.parse(enddate);
        cDate = Date.parse(selecteddate);

       if((cDate <= lDate && cDate >= fDate)) {            
        if(value.utente == ""){
            value.utente = '-';
        }        
        var confms = "return confirm('{{trans('messages.keyword_suredeleteevent')}}')";
        var selectedEventStye = "";
        if(eventid == value.id){
            selectedEventStye = 'border: 3px solid #337ab7';
        }
        if(value.color == ""){
            value.color='#ff851b';
        }
        var Htmldetails = '<div style="background-color: '+value.color+';'+selectedEventStye+'" id="event_detail_list_'+value.id+'" class="striscia"><a href="{{url('calendario/edit/event')}}/'+value.id+'" id="mainlink"><div class="orario">'+startday+'/'+startmonth+' - '+endday+'/'+endmonth+' | '+starttime+' - '+endtime+'</div><div>'+value.ente+'</div><div>'+value.dove+'</div><div>'+value.titolo+'</div><div>'+value.utente+'</div></a><a href="{{url('calendario/delete/event/')}}/'+value.id+'" onclick="'+confms+'" class="btn btn-danger btn-sm elimina"><span class="fa fa-trash"></span></a><form action="http://maps.google.com/maps" method="get" target="new" id="frm'+value.id+'"><input id="geolocationPlaces_'+value.id+'" class="geolocationbox form-control" onkeyup="changetextlocationval('+value.id+')" type="text"><input name="saddr" value="{{$currentlocation}}" id="geolocationshdAddress_'+value.id+'" type="hidden"><input name="daddr" value="'+value.dove+'" id="geolocationEventAddress" type="hidden"><button type="submit" class="btn btn-warning geolocationbutton">Go</button></form></div>';

        /*var Htmldetails = '<a href="{{url('calendario/edit/event')}}/'+value.id+'" id="mainlink"><div id="innerdetaildiv_'+value.id+'" style="background-color: '+value.color+'" class="striscia"><div class="orario">'+startday+'/'+startmonth+' - '+endday+'/'+endmonth+' | '+starttime+' - '+endtime+'</div><div>'+value.ente+'</div><div>'+value.dove+'</div><div>'+value.titolo+'</div><div>'+value.utente+'</div></div></a>';
        
        var innerdetails = '<a href="{{url('calendario/delete/event/')}}/'+value.id+'" class="btn btn-danger btn-sm elimina"><span class="fa fa-trash"></span></a><form action="http://maps.google.com/maps" method="get" target="new" id="frm'+value.id+'"><input id="geolocationPlaces_'+value.id+'" class="geolocationbox form-control" onkeyup="changetextlocationval('+value.id+')" type="text"><input name="saddr" value="{{$currentlocation}}" id="geolocationshdAddress_'+value.id+'" type="hidden"><input name="daddr" value="'+value.dove+'" id="geolocationEventAddress" type="hidden"><button type="submit" class="btn btn-warning geolocationbutton">Go</button></form>';*/

            //$('#content').find('h3').remove();
            $('#content').append(Htmldetails);
            //$('#innerdetaildiv_'+value.id+'').append(innerdetails);

            
        }     
    });

    //geolocationBox.onclick = function(e) {e.preventDefault();};
    //elimina.onclick = function(e) {check = confirm("{{ trans('messages.keyword_suredeleteevent') }} "); if(!check) e.preventDefault();};
    var psconsole = $('#scrollfucs');
    $('html, body').animate({
                        scrollTop: psconsole.offset().top
                    }, 1000);
}
/*$( "a" ).click(function( event ) {
  event.preventDefault();
  $( "<div>" )
    .append( "default " + event.type + " prevented" )
    .appendTo( "#log" );
});*/
$(".geolocationbox").click( function(e){
     e.stopPropagation();
            e.preventDefault();               
});
</script>


