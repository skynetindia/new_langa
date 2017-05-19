@extends('layouts.app')

@section('content')
<style>
.selected {
	font-weight: bold;
	font-size: 16px;
}
th {
	cursor: pointer;
}
li label {
	padding-left: 10px;
}
.button {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 3px 15px;
    padding-bottom: 6px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    -webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.4s;
    cursor: pointer;
    border-radius: 4px;
}
.button1 { /* blue */
    background-color: white;
    color: black;
    border: 2px solid #337ab7;
}

.button1:hover {
    background-color: #337ab7;
    color: white;
}

.button4 { /* red */
    background-color: white;
    color: black;
    border: 2px solid #d9534f;
}

.button4:hover {
    background-color: #d9534f;
    color: white;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

<script src="{{asset('public/scripts/select2.full.min.js')}}"></script>
<script type="text/javascript" src="http://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="http://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="http://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />



<h1> {{ trans('messages.keyword_calendar') }}</h1>

<a class="btn btn-warning" style="color:#ffffff;text-decoration: none" onclick="aggiungiEvento()" title="{{ trans('messages.keyword_addnewevent') }} "><i class="fa fa-plus"></i></a><br>

<a id="miei" href="{{url('/calendario/0')}}" style="display:inline;">
<button class="button button1" type="button" name="miei" title="{{ trans('messages.keyword_eventfilter') }}" style="background-color:#337AB7;color:#ffffff"> {{ trans('messages.keyword_my') }} </button>
</a>
<a id="tutti" href="{{url('/calendario/1')}}" style="display:inline;">
<button class="button button4" type="button" name="tutti" title="{{ trans('messages.keyword_allevent') }} "> {{ trans('messages.keyword_all') }} </button>
</a>

<hr>



<style>
* {
    margin: 0;
}
.elimina {
	position: absolute;
	text-align:center;
	top: 50%;
	left:85%;
  	transform: translateY(-50%);
	text-decoration:none;
}
.geolocationbox {
	position: absolute;
	text-align:center;
	top: 50%;
	left:60%;
  	transform: translateY(-50%);
	text-decoration:none;
	width:20%;
}
.geolocationbutton {
	position: absolute;
	text-align:center;
	top: 50%;
	left:80%;
  	transform: translateY(-50%);
	text-decoration:none;	
}



.orario {
	font-weight: bold;
}
.striscia {
	padding: 8px;
	color: #fff;
	position: relative;
}
html, body {
    height: 100%;
}
.wrapper {
    min-height: 100%;
    height: auto !important;
    height: 100%;
}
#push {
    height: auto;
}
#con {
  border: none;
  height: 2px;
  width: 2px;
  float: left;	
}
.inline {
  display:inline;
  width:200px;
  height:200px;
  padding: 5px;
  margin: auto;
  border:2px solid white;
  background-color:#fffff7;
  -moz-border-radius:1px; /* Firefox */
  border-radius:1px;
 }
 #map, #map1 {
  height: 100%;
  height: 400px;
 }

      .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }
	  
      #pac-input {
        background-color: #FFF;
    z-index: 20;
    position: fixed;
    display: inline-block;
    float: left;
      }
.modal {
    z-index: 20; 
	padding-top:51px;
}
.modal-backdrop {
    z-index: 10;        
}
      #pac-input:focus {
        border-color: #4d90fe;
      }

      .pac-container {
        font-family: Roboto;
      }

      #type-selector, #type-selector1 {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;

      }

      #type-selector label, #type-selector1 label{
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;

	  }
	  #dove {
		  width:30%;
	  }
td
{
    max-width: 10px;
    max-height: 150px;
    overflow: hidden;
}
</style>

<div class="wrapper">
<div class="table-responsive">

	<table class="table table-striped table-bordered">

		<tr><td colspan="5">

		<?php

			if($month == 1) {

				$link1 = "/calendario/show/" . $tipo . "/day/0/month/12/year/" . ($year - 1);

				$link2 = "/calendario/show/" . $tipo . "/day/0/month/" . ($month+1) . "/year/" . $year;

			} else if($month == 12) {

				$link1 = "/calendario/show/" . $tipo . "/day/0/month/" . ($month-1) . "/year/" . $year;

				$link2 = "/calendario/show/" . $tipo . "/day/0/month/1/year/" . ($year + 1);

			} else {

				$link1 = "/calendario/show/" . $tipo . "/day/0/month/" . ($month-1) . "/year/" . $year;

				$link2 = "/calendario/show/" . $tipo . "/day/0/month/" . ($month+1) . "/year/" . $year;

			}
			
		?>

		<a href="{{ url($link1) }}"><span class="glyphicon glyphicon-chevron-left"></span>{{ $nomiMesi[$month-1] or $nomiMesi[12] }} </a>

		{{ $nomiMesi[$month] }} {{ $year }}

		<a href="{{ url($link2) }}"> {{ $nomiMesi[$month+1] or $nomiMesi[1] }}<span class="glyphicon glyphicon-chevron-right"></span></a></td></tr>

		<tr>
		@for ($i = 1; $i <= $giorniMese; $i++)

			<td class="day"<?php if($i == $day) echo " style='color:#fff;background: #f37f0d;'"; ?> onclick="mostraEventi(<?php echo $i; ?>)">

				{{ $i }}

				<br>

				<?php $giorno = strftime('%A', mktime(0, 0, 0, $month, $i, $year));
                if($giorno == "Monday")
					$giorno = trans('messages.keyword_mon');
				else if($giorno == "Tuesday")
					$giorno = trans('messages.keyword_tues');
				else if($giorno == "Wednesday")
					$giorno = trans('messages.keyword_wed');
				else if($giorno == "Thursday")
					$giorno = trans('messages.keyword_thur');
				else if($giorno == "Friday")
					$giorno = trans('messages.keyword_fri');
				else if($giorno == "Saturday")
					$giorno = trans('messages.keyword_sat');
				else if($giorno == "Sunday")
					$giorno = trans('messages.keyword_sun');
                echo $giorno;
				$elenco_eventi = [];
				
                ?>
                <hr>

				<table>
                	<tr style="color:#fff">
					@foreach ($events as $event)
						@if($year <= $event->annoFine)
                        	@if($month <= $event->meseFine)
                            	<?php 
									$utente = DB::table('users')
												->where('id', $event->user_id)
												->first();
									
									$colore = (isset($utente->color))?$utente->color:'#fff';
								?>
                            	@if($month == $event->mese)
                                	@if($i >= $event->giorno)
                                    	@if($event->mese == $event->meseFine)
                                        	@if($i <= $event->giornoFine)
                                    			<td style="background-color:<?php echo $colore; ?>"> • </td>
                                                <?php $event->color = $colore ?>
                                                <?php $event->utente = (isset($utente->name))?$utente->name:'' ?>
                                            @endif
                                        @else
                                        	<td style="background-color:<?php echo $colore; ?>"> • </td>
                                            <?php $event->color = $colore ?>
                                            <?php $event->utente = (isset($utente->name))?$utente->name:'' ?>
                                        @endif
                                    @endif
                                @elseif($month == $event->meseFine)
                                	@if($i <= $event->giornoFine)
                                    	<td style="background-color:<?php echo $colore; ?>"> • </td>
                                        <?php $event->color = $colore ?>
                                        <?php $event->utente = (isset($utente->name))?$utente->name:'' ?>
                                    @endif
                                @elseif($month > $event->mese && $month < $event->meseFine)
                                	<td style="background-color:<?php echo $colore; ?>"> • </td>
                                    <?php $event->color = $colore ?>
                                    <?php $event->utente = (isset($utente->name))?$utente->name:'' ?>
                                @endif
                            @endif
                        @endif
					@endforeach
                    </tr>
				</table>

			</td>

			@if ($i % 5 == 0)

				</tr><tr>

			@endif

		@endfor

		</tr>

	</table>

</div>

<div id="push" style="display:none">
    <div id="content"></div>
</div>
<div class="footer">
</div>

</div>

<!-- Add new event modal -->

<div class="modal fade" id="newEvent" role="dialog" aria-labelledby="modalTitle">

	<div class="modal-dialog modal-lg">

		<div class="modal-content">

			<div class="modal-header">

				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        		<h3 class="modal-title" id="modalTitle"> {{ trans('messages.keyword_newevent') }} </h3>

			</div>

			<div class="modal-body">

        		<!-- Start form to add a new event -->
        		<form action="{{ url('/calendario/add') }}" method="post">
        			{{ csrf_field() }}
                                @include('common.errors')
						<div class="col-md-12">
                         <div class="form-group col-md-10">
        				<label for="ente" class="control-label">{{ trans('messages.keyword_entity') }} </label>
						<select name="ente" id="ente" class="js-example-basic-single form-control" style="width:100%">
						@foreach($enti as $ente)
                                                @if(!empty(Session::get('error_code')) && Session::get('error_code') == 5)
                                                    <option selected value="{{$ente->id}}">{{$ente->id}} | {{$ente->nomeazienda}} | {{$ente->nomereferente}}</option>
                                                @else
						<option value="{{$ente->id}}">{{$ente->id}} | {{$ente->nomeazienda}} | {{$ente->nomereferente}}</option>
                                                @endif
						@endforeach
						</select><script type="text/javascript">
									$(".js-example-basic-single").select2();
								</script>
        			</div>
					<div class="form-group col-md-2">
						<a onclick="nuovoEnte()" class="btn btn-warning"> {{ trans('messages.keyword_addente') }} </a>
					</div>
                    </div>
           			<div class="col-md-12">
						<div class="col-md-5">                               
                        <div class="form-group">
                            <label for="titolo" class="control-label"> {{ trans('messages.keyword_object') }} </label>
                            <input value="{{ old('titolo') }}" type="text" name="titolo" id="titolo" class="form-control" placeholder="{{ trans('messages.keyword_appointmenttodiscuss') }} ">
                        </div>
    
                        <div class="form-group">        				
                            <input value="{{ old('dove') }}" type="text" name="dove" id="dove" class="form-control" placeholder="{{ trans('messages.keyword_appointmentaddress') }} ">                      
                        </div>                    
                        <div class="form-group">
                            <label for="dettagli" class="control-label"> {{ trans('messages.keyword_details') }} </label>
                            <textarea rows="4" name="dettagli" id="dettagli" class="form-control" placeholder="{{ trans('messages.keyword_generalinformation') }} ">{{ old('dettagli') }}</textarea>
                        </div>
                    	</div>
                    	<div class="col-md-7">
                    	<div id="type-selector1" class="controls1" size="50">
						  <input type="radio" name="type" id="changetype-all" checked="checked">
						  <label for="changetype-all"> {{ trans('messages.keyword_all') }} </label>
						  <input type="radio" name="type" id="changetype-establishment">
						  <label for="changetype-establishment"> {{ trans('messages.keyword_companies') }} </label>
						  <input type="radio" name="type" id="changetype-address">
						  <label for="changetype-address"> {{ trans('messages.keyword_addresses') }} </label>
						  <input type="radio" name="type" id="changetype-geocode">
						  <label for="changetype-geocode">{{ trans('messages.keyword_cap') }} </label>
                       </div>
                       
	                    <div id="map1"></div>
                        </div>	
    	               
                     </div>
                     <div class="col-md-12">
        			<fieldset>
        			<legend> {{ trans('messages.keyword_schedule') }} </legend>
					<div class="col-md-12">
						<div class="col-md-6">						
                             <h4> {{ trans('messages.keyword_schedule') }} </h4>                 
        				<label for="giorno" class="control-label"> {{ trans('messages.keyword_from') }} </label> 
        				<input value="{{ old('giorno') }}" type="text" name="giorno" id="giorno" class="form-control">
                                    <script>
                                    $("#giorno").daterangepicker({
									autoApply: true,
									timePicker: true,
									timePickerIncrement: 30,
									locale: {
										format: 'MM/DD/YYYY h:mm A'
									}
									});
                                    </script>
                                 </div>   
								<div class="col-md-6">
                                <h4>{{ trans('messages.keyword_notification') }}</h4>
                                <label for="notifica" class="checkbox-inline"> {{ trans('messages.keyword_sendnotification') }} 
                                <input type="checkbox" class="form-control input-check" name="notifica" id="notifica"></label>                                
                                 <label for="privato" class="checkbox-inline"> {{ trans('messages.keyword_private') }} 
                                <input type="checkbox" class="form-control input-check" name="privato" id="privato"></label><br>
                                	<br>
                                </div>
                                </div>

                                
                                
        			</fieldset>
                                        </div><br />

        			<div class="modal-footer">

        				<input type="submit" class="btn btn-warning" value="{{ trans('messages.keyword_submit') }} ">

      				</div>

        		</form>

        		<!-- End form to add a new event -->

      		</div>

      		

		</div>

	</div>

</div>

<!-- End new event modal -->

<!-- start new ente modal -->

<div class="modal fade" id="newEnte" tabindex="-1" role="dialog" aria-labelledby="modalTitle">

	<div class="modal-dialog modal-dialog modal-lg">

		<div class="modal-content">

			<div class="modal-header">

				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        		<h3 class="modal-title" id="modalTitle">Nuovo ente</h3>

			</div>

			<div class="modal-body">

        		<!-- Start form to add a new event -->

        		@include('common.errors')

				</form>

        		<form action="{{ url('/enti/store/') }}" method="post" id="nuovoente">

        			{{ csrf_field() }}

                                <input type="text" name="settore" style="display:none">

                                <input type="text" name="piva" style="display:none">

                                <input type="text" name="cf" style="display:none">

                                <input type="text" name="cellulareazienda" style="display:none">

                                <input type="text" name="privato" value="3" style="display:none">

                                <input type="text" name="fax" style="display:none">

                                <input type="text" name="iban" style="display:none">

                                <input type="text" name="noteenti" style="display:none">

        			<div class="form-group">

        				<label for="nomeazienda" class="control-label">Nome azienda <p style="color:#f37f0d;display:inline">(*)</p></label> 

        				<input value="{{ old('nomeazienda') }}" type="text" name="nomeazienda" id="nomeazienda" class="form-control">

        			</div>

					<div class="form-group">

        				<label for="nomereferente" class="control-label">Referente azienda <p style="color:#f37f0d;display:inline">(*)</p></label> 

        				<input value="{{ old('nomereferente') }}" type="text" name="nomereferente" id="nomereferente" class="form-control">

        			</div>

					<div class="form-group">

        				<label for="telefonoazienda" class="control-label">Telefono azienda <p style="color:#f37f0d;display:inline">(*)</p></label> 

        				<input value="{{ old('telefonoazienda') }}" type="text" name="telefonoazienda" id="telefonoazienda" class="form-control">

        			</div>

					<div class="form-group">

        				<label for="email" class="control-label">Email <p style="color:#f37f0d;display:inline">(*)</p></label> 

        				<input value="{{ old('email') }}" type="email" name="email" id="email" class="form-control">

        			</div>

					<div class="form-group">

                                            <label for="indirizzo" class="control-label">Indirizzo <p style="color:#f37f0d;display:inline">(*)</p></label> 

        				<input value="{{ old('indirizzo') }}" id="pac-input" name="indirizzo" class="controls" type="text"

							placeholder="{{ trans('messages.keyword_enteranaddress') }}    ">

						<div id="type-selector" class="controls">

						  <input type="radio" name="type" id="changetype-all" checked="checked">

						  <label for="changetype-all">All</label>



						  <input type="radio" name="type" id="changetype-establishment">

						  <label for="changetype-establishment">Aziende</label>



						  <input type="radio" name="type" id="changetype-address">

						  <label for="changetype-address">Indirizzi</label>



						  <input type="radio" name="type" id="changetype-geocode">

						  <label for="changetype-geocode">CAP</label>

                                                </div>

						

                                                </div>

						<div id="map"></div>

                                                <div class="form-group">

                                                    <br>  <label for="responsabilelanga">Responsabile LANGA <p style="color:#f37f0d;display:inline">(*)</p></label>

                                                <select title="Responsabile associato a questo ente" name="responsabilelanga" id="responsabilelanga" class="form-control" onchange="trovaTelefono()">

                                                        <option></option>

                                                        @for($i = 1; $i < count($utenti); $i++)

                                                        <option>{{ $utenti[$i]->name }}</option>

                                                        @endfor

                                                </select>

                                                    <br><label for="telefonoresponsabile">Telefono responsabile Langa <p style="color:#f37f0d;display:inline">(*)</p></label>

                                                <input value="{{ old('telefonoresponsabile') }}" class="form-control" type="text" name="telefonoresponsabile" id="telefonoresponsabile" placeholder="Telefono responsabile Langa"><br>

                                                <script>

                                                var cellulari = ["<?php

                                                        for($i=1;$i<count($utenti);$i++) {

                                                                if($i == count($utenti) - 1)

                                                                        echo $utenti[$i]->cellulare . "\"";

                                                                else

                                                                        echo $utenti[$i]->cellulare . "\",\"";

                                                        }

                                                ?>];

                                                var nomi = ["<?php

                                                        for($i=1;$i<count($utenti);$i++) {

                                                                if($i == count($utenti) - 1)

                                                                        echo $utenti[$i]->name . "\"";

                                                                else

                                                                        echo $utenti[$i]->name . "\",\"";

                                                        }

                                                ?>];



                                                function trovaTelefono() {

                                                        var k;

                                                        var nome = $( "#responsabilelanga option:selected" ).text();

                                                        console.log(nome);

                                                        for(var i = 0; i < <?php echo count($utenti)-1;?>;i++) {

                                                                if(nomi[i] == nome) {

                                                                        k = i;

                                                                        break;

                                                                }

                                                        }

                                                        $('#telefonoresponsabile').val(cellulari[k]);

                                                }

                                        </script>

                                    </div>

        			</div>

        			<div class="modal-footer">

        				<a onclick="aggiungiEnte()" class="btn btn-warning">Aggiungi</a>

      				</div>

        		</form>

        		<!-- End form to add a new ente -->

      		</div>

      		

		</div>

	</div>

</div>

<!-- end modal new ente -->





<!-- End of edit event modal --> 

<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>

<script>


function aggiungiEvento() {
  $( "#newEvent" ).modal();
	$('#newEvent').on('shown.bs.modal', function(){
	  initMap2();
    });
}

function aggiungiEnte() {
  $( "#nuovoente" ).submit();
}

function editEvent() {
  $( "#editEvent" ).submit();
}

@if(!empty(Session::get('error_code')) && Session::get('error_code') == 5)
$(function() {
    $('#newEvent').modal('show');
	$('#newEvent').on('shown.bs.modal', function(){
	  initMap2();
    });
});
@endif

@if(!empty(Session::get('error_code')) && Session::get('error_code') == 6)
$(function() {
     $('#newEvent').modal('show');
     $('#newEnte').modal('show');
     setTimeout(function() { google.maps.event.trigger(map, "resize") }, 1000);
	 $('#newEvent').on('shown.bs.modal', function(){
	  initMap2();
    });


});



@endif



function conferma(e) {

	var confirmation = confirm("Sei sicuro?") ;

    if (!confirmation)

        e.preventDefault() ;

	return confirmation ;

}

function nuovoEnte() {
	$('#newEnte').modal();
	setTimeout(function() { google.maps.event.trigger(map, "resize") }, 1000);
}

</script>

<script>

      // This example requires the Places library. Include the libraries=places

      // parameter when you first load the API. For example:

      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

	/*$('#newEvent').on('shown.bs.modal', function(){
		
	  initMap2();
    });*/


      function initMap() {

        var map = new google.maps.Map(document.getElementById('map'), {

          center: {lat: 44.8688, lng: 8.2195},

          zoom: 13

        });

        var input = /** @type {!HTMLInputElement} */(

            document.getElementById('pac-input'));



        var types = document.getElementById('type-selector');

        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);



        var autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.bindTo('bounds', map);

		var image = "{{asset('public/marker.png')}}";

        var infowindow = new google.maps.InfoWindow();

        var marker = new google.maps.Marker({

		  icon: image,

          map: map,

		  draggable: true,

		  animation: google.maps.Animation.DROP,

          anchorPoint: new google.maps.Point(0, -29)

        });



        autocomplete.addListener('place_changed', function() {

          infowindow.close();

          marker.setVisible(false);

          var place = autocomplete.getPlace();

          if (!place.geometry) {

            window.alert("Autocomplete's returned place contains no geometry");

            return;

          }



          // If the place has a geometry, then present it on a map.

          if (place.geometry.viewport) {

            map.fitBounds(place.geometry.viewport);

          } else {

            map.setCenter(place.geometry.location);

            map.setZoom(17);  // Why 17? Because it looks good.

          }

          marker.setIcon(/** @type {google.maps.Icon} */({

            

            size: new google.maps.Size(71, 71),

            origin: new google.maps.Point(0, 0),

            anchor: new google.maps.Point(17, 34),

            scaledSize: new google.maps.Size(35, 35)

          }));

          marker.setPosition(place.geometry.location);

          marker.setVisible(true);



          var address = '';

          if (place.address_components) {

            address = [

              (place.address_components[0] && place.address_components[0].short_name || ''),

              (place.address_components[1] && place.address_components[1].short_name || ''),

              (place.address_components[2] && place.address_components[2].short_name || '')

            ].join(' ');

          }



          infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);

          infowindow.open(map, marker);

        });



        // Sets a listener on a radio button to change the filter type on Places

        // Autocomplete.

        function setupClickListener(id, types) {

          var radioButton = document.getElementById(id);

          radioButton.addEventListener('click', function() {

            autocomplete.setTypes(types);

          });

        }



        setupClickListener('changetype-all', []);

        setupClickListener('changetype-address', ['address']);

        setupClickListener('changetype-establishment', ['establishment']);

        setupClickListener('changetype-geocode', ['geocode']);

      }
	//AIzaSyAL_rtMv03GNmWgYfQkcGPPOsQ43LGun-0
    </script>
    <script>
 function initMap2() {

        var map = new google.maps.Map(document.getElementById('map1'), {
          center: {lat: 44.8688, lng: 8.2195},
          zoom: 8
        });
      
        var input = /** @type {!HTMLInputElement} */(
            document.getElementById('dove'));
        var types = document.getElementById('type-selector1');
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);
		var image = "{{asset('public/marker.png')}}";
        var infowindow = new google.maps.InfoWindow();
        var marker = new google.maps.Marker({
		  icon: image,
          map: map,
		  draggable: true,
		  animation: google.maps.Animation.DROP,
          anchorPoint: new google.maps.Point(0, -29)
        });
        autocomplete.addListener('place_changed', function() {
          infowindow.close();
          marker.setVisible(false);
          var place = autocomplete.getPlace();
          if (!place.geometry) {
            window.alert("Autocomplete's returned place contains no geometry");
            return;
          }

          if (place.geometry.viewport) {

            map.fitBounds(place.geometry.viewport);

          } else {

            map.setCenter(place.geometry.location);

            map.setZoom(17);  // Why 17? Because it looks good.

          }

          marker.setIcon(/** @type {google.maps.Icon} */({

            

            size: new google.maps.Size(71, 71),

            origin: new google.maps.Point(0, 0),

            anchor: new google.maps.Point(17, 34),

            scaledSize: new google.maps.Size(35, 35)

          }));

          marker.setPosition(place.geometry.location);

          marker.setVisible(true);

          var address = '';
          if (place.address_components) {
            address = [
              (place.address_components[0] && place.address_components[0].short_name || ''),
              (place.address_components[1] && place.address_components[1].short_name || ''),
              (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
          }
          infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
          infowindow.open(map, marker);
        });


        function setupClickListener(id, types) {
          var radioButton = document.getElementById(id);

          radioButton.addEventListener('click', function() {

            autocomplete.setTypes(types);
          });
        }
        setupClickListener('changetype-all', []);
        setupClickListener('changetype-address', ['address']);
        setupClickListener('changetype-establishment', ['establishment']);
        setupClickListener('changetype-geocode', ['geocode']);
      }
	//AIzaSyAL_rtMv03GNmWgYfQkcGPPOsQ43LGun-0
    </script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjhyTxmz9i9mGwzB1xy6mvVYH46PD2ylE&libraries=places&callback=initMap" async defer></script>
   	<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjhyTxmz9i9mGwzB1xy6mvVYH46PD2ylE&libraries=places&callback=initMap2" async defer></script>-->
<script>
var eventi = <?php echo json_encode($events); ?>;
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

function mostraEventi(giorno) {
	$('#push').show();
	var content = $('#content');
	content.children().remove();
	eventiDaStampare = [];
	var year = <?php echo $year; ?>;
	var month = <?php echo $month; ?>;
	
	for(var i = 0; i < eventi.length; i++) {
		if(year <= eventi[i]["annoFine"]) {
			 if(month <= eventi[i]["meseFine"]) {
					if(month == eventi[i]["mese"]) {
						 if(giorno >= eventi[i]["giorno"]) {
							  if(eventi[i]["mese"] == eventi[i]["meseFine"]) {
									 if(giorno <= eventi[i]["giornoFine"]) {
											eventiDaStampare.push(eventi[i]);
						 			 }
						 	  } else {
									eventiDaStampare.push(eventi[i]);
						 	  }
						 }
					} else if(month == eventi[i]["meseFine"]) {
						  if(giorno <= eventi[i]["giornoFine"]) {
								eventiDaStampare.push(eventi[i]);
						   }
					} else if(month > eventi[i]["mese"] && month < eventi[i]["meseFine"]) {
						  eventiDaStampare.push(eventi[i]);
					}
			 }
		}
	}
	k = 0;
	
	for(var i = 0; i < eventiDaStampare.length; i++) {
		var link = document.createElement("a");
		link.href = "{{url('/calendario/edit/event/')}}" + '/' + eventiDaStampare[i]["id"];
		link.id = "mainlink";
		var striscia = document.createElement("p");
		striscia.style.backgroundColor = eventiDaStampare[i]["color"];
		striscia.className = "striscia";
		
		var orario = document.createElement("div");
		orario.className = "orario";
		var testoOrario = document.createTextNode(eventiDaStampare[i]["giorno"] + '/' + eventiDaStampare[i]["mese"] + ' - ' + eventiDaStampare[i]["giornoFine"] + '/' + eventiDaStampare[i]["meseFine"] + ' | ' + eventiDaStampare[i]["sh"] + ' - ' + eventiDaStampare[i]["eh"]);
		orario.appendChild(testoOrario);
		
		var ente = document.createElement("div");
		if(tipo == 0) {
			var testoEnte = document.createTextNode(eventiDaStampare[i]["ente"]);
			ente.appendChild(testoEnte);
		} else if(eventiDaStampare[i]["privato"] == 0) {
			var testoEnte = document.createTextNode(eventiDaStampare[i]["ente"]);
			ente.appendChild(testoEnte);
		}
		
		var titolo = document.createElement("div");
		if(tipo == 0) {
			var testoTitolo = document.createTextNode(eventiDaStampare[i]["titolo"]);
			titolo.appendChild(testoTitolo);
		} else if(eventiDaStampare[i]["privato"] == 0) {
			var testoTitolo = document.createTextNode(eventiDaStampare[i]["titolo"]);
			titolo.appendChild(testoTitolo);
		}
		
		var utente = document.createElement("div");
		var testoUtente = document.createTextNode(eventiDaStampare[i]["utente"]);
		utente.appendChild(testoUtente);
		
		var dove = document.createElement("div");
		var testoDove = document.createTextNode(eventiDaStampare[i]["dove"]);
		dove.appendChild(testoDove);
		
		/* geo Location form */
		var geolocationForm = document.createElement("form");
		geolocationForm.action = "";
		/* geo Location form button */
		var geolocationbutton = document.createElement("button");
		geolocationbutton.onclick = function(e) {e.preventDefault();};
		geolocationbutton.type = 'button';
		geolocationbutton.className = 'btn btn-warning geolocationbutton';
		geolocationbutton.innerHTML = 'Vai';
		
		var geolocationBox = document.createElement("input");
		geolocationBox.type='text';
		geolocationBox.id='geolocationPlaces';
		
		geolocationBox.className='geolocationbox form-control';
		geolocationBox.onclick = function(e) {e.preventDefault();};
		var elimina = document.createElement("a");
		elimina.href = "{{url('/calendario/delete/event/')}}" + '/' + eventiDaStampare[i]["id"];
		elimina.className="elimina";
		elimina.onclick = function(e) {check = confirm("{{ trans('messages.keyword_suredeleteevent') }} "); if(!check) e.preventDefault();};
		elimina.className = "btn btn-danger btn-sm elimina";
		var tastoElimina = document.createElement("span");
		tastoElimina.className = "fa fa-eraser";
		elimina.appendChild(tastoElimina);
		
		striscia.appendChild(orario);
		striscia.appendChild(ente);
		striscia.appendChild(dove);
		striscia.appendChild(titolo);
		striscia.appendChild(utente);
		striscia.appendChild(elimina);
		geolocationForm.appendChild(geolocationBox);
		geolocationForm.appendChild(geolocationbutton);
		
		striscia.appendChild(geolocationForm);

		link.appendChild(striscia);
		content.append(link);
		k++;
	}
	
	if(k == 0) {
		var el = document.createElement("h3");
		var testo = document.createTextNode("Nessun evento per questo Giorno");
		el.appendChild(testo);
		content.append(el);	
	}	
}
/*$("#mainlink a").click(function(e) {
   e.stopPropagation();
})*/
 	/*google.maps.event.addDomListener(window, 'load', function () {
            var places = new google.maps.places.Autocomplete(document.getElementById('geolocationPlaces'));
            google.maps.event.addListener(places, 'place_changed', function () {
                var place = places.getPlace();
                var address = place.formatted_address;
                var latitude = place.geometry.location.lat();
                var longitude = place.geometry.location.lng();
                var mesg = "Address: " + address;
                mesg += "\nLatitude: " + latitude;
                mesg += "\nLongitude: " + longitude;
                alert(mesg);
            });
        });*/
</script>

@endsection

