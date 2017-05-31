@extends('layouts.app')

@section('content')
<html><head>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">

<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

<script src="{{asset('public/scripts/select2.full.min.js')}}"></script>

<script type="text/javascript" src="http://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<script type="text/javascript" src="http://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>


<link href="http://easy.langa.tv/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="http://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

<link rel="stylesheet" href="{{asset('public/css/select2.min.css')}}"> 

<!-- Custom Theme Style -->




</head>
<body>

<!-- Modify event modal -->
<!-- Start edit event modal -->
<div class="modal fade" id="editEvent" role="dialog" aria-labelledby="modalTitle">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
                 <button type="button" class="close" data-dismiss="modal">&times;</button>
             
            <h3 class="modal-title" id="modalTitle"> {{ trans('messages.keyword_editevent') }} </h3>
      </div>   
      <div class="modal-body">
          

            <!-- Start form to modify an event -->
            @include('common.errors')
            <form action="{{ url('/calendario/update/event/' . $event->id) }}" method="post" id="eventeditform" name="eventeditform">
              <!-- Start form to add a new event -->
              {{ csrf_field() }}
                                @include('common.errors')
                    <div class="row">
                    <div class="form-group col-md-10">
                <label for="ente" class="control-label">{{ trans('messages.keyword_entity') }} <span class="required">(*)</span></label>
            <select name="ente" id="ente" class="js-example-basic-single form-control">
          <option selected></option>
            @foreach($enti as $ente)
                            @if($ente->id == $event->id_ente)
                                <option selected value="{{$ente->id}}">{{$ente->nomeazienda}} | {{$ente->nomereferente}}</option>
                            @else
                <option value="{{$ente->id}}">{{$ente->nomeazienda}} | {{$ente->nomereferente}}</option>
                                                @endif
            @endforeach
          </select><script type="text/javascript">

                        $(".js-example-basic-single").select2();

                    </script>
            
                </div>

      </div>

            <div class="row">
                        <div class="col-md-5">                               
                        <div class="form-group">
                            <label for="titolo" class="control-label"> {{ trans('messages.keyword_object') }} <span class="required">(*)</span> </label>
                            <input value=" {{ $event->titolo }}" type="text" name="titolo" id="titolo" class="form-control" placeholder=" {{ trans('messages.keyword_appointmenttodiscuss') }} ">
                        </div>
    
                        <div class="form-group">
                            <label for="dettagli" class="control-label"> {{ trans('messages.keyword_details') }} <span class="required">(*)</span> </label>
                            <textarea rows="4" name="dettagli" id="dettagli" class="form-control" placeholder="{{ trans('messages.keyword_generalinformation') }}"> {{ $event->dettagli }}</textarea>
                        </div>
                        </div>
                        <div class="col-md-7">
                        <label>{{ trans('messages.keyword_appointmentaddress') }} <span class="required">(*)</span></label><br>
                            <input value="{{ $event->dove }}" id="dove" name="dove" class="controls" type="text" placeholder="{{ trans('messages.keyword_appointmentaddress') }}  (*)">

                        <div id="type-selector1" class="controls1" size="50">
                          <input type="radio" name="type" id="changetype-all" checked="checked">
                          <label for="changetype-all"> {{ trans('messages.keyword_all') }} </label>
                          <input type="radio" name="type" id="changetype-establishment">
                          <label for="changetype-establishment"> {{ trans('messages.keyword_companies') }} </label>
                          <input type="radio" name="type" id="changetype-address">
                          <label for="changetype-address"> {{ trans('messages.keyword_addresses') }} </label>
                          <input type="radio" name="type" id="changetype-geocode">
                          <label for="changetype-geocode"> {{ trans('messages.keyword_cap') }} </label>
                       </div>
                       
                         <div id="map1"></div>
                        </div>  
                       
                     </div>


                   <div class="row">
                    <fieldset>
                  	<!--  <legend> {{ trans('messages.keyword_schedule') }} </legend>-->
                  
                        <div class="col-md-6">                      
                             <h4> {{ trans('messages.keyword_schedule') }} </h4>                 
                        <label for="giorno" class="control-label"> {{ trans('messages.keyword_from') }} <span class="required">(*)</span> </label> 
                        <div class="input-group">
							  <span class="input-group-addon cal-addon" id="basic-addon1"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                       			 <input value="{{ old('giorno') }}" type="text" name="giorno" id="giorno" class="form-control">
                        </div>
                                    <script>
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
                                 </div>   
                                <div class="col-md-6">
                                <h4> {{ trans('messages.keyword_notification') }} </h4>
                                
                                    
                                    <div class="row">
                                    	<div class="col-md-6">
                                            <div class="caleder-notification">
                                            	<div class="switch">
                                                    <span> {{ trans('messages.keyword_sendnotification') }}</span>
                                                    <input type="checkbox" class="form-control input-check" name="notifica" id="notifica">
                                                    <label for="notifica" class="checkbox-inline"> </label>
                                                </div>    
                                    		</div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="caleder-notification">                  
												<div class="switch">                                            	
                                                    <span>{{ trans('messages.keyword_private') }}</span>
                                                    <input type="checkbox" class="form-control input-check" name="privato" id="privato">
                                                     <label for="privato" class="checkbox-inline"></label>
                                                 </div>    
                                        	</div>
                                        </div>    
                                    </div>        
                                    
                                    <br>
                                    
                                    
                                </div>
                                </div>
                            </fieldset>
                       
<div class="height20"></div>
                  

              <div class="modal-footer">
                <input type="submit" class="btn btn-warning" value=" {{ trans('messages.keyword_save&exit') }} ">
              </div>
            </form>
          </div>
          
    </div>
  </div>
</div>

 </script>

<!-- <script src="{{ asset('public/scripts/jquery.min.js') }}"></script> -->


<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjhyTxmz9i9mGwzB1xy6mvVYH46PD2ylE&libraries=places&callback=initMap" async defer></script> -->
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjhyTxmz9i9mGwzB1xy6mvVYH46PD2ylE&libraries=places" async defer></script> -->


      
<script>
function conferma(e) {
  var confirmation = confirm("Sei sicuro?") ;
    if (!confirmation)
        e.preventDefault();
  return confirmation ;
}
setTimeout(function(){
  $('#editEvent').modal('show');
    initMap2();
}, 100);

$('body').bind('click', function() {
  setTimeout(function(){
  $('#editEvent').modal('show');
    initMap2();
}, 1000);
});


</script>


<script>

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
        // setupClickListener('changetype-all', []);
        // setupClickListener('changetype-address', ['address']);
        // setupClickListener('changetype-establishment', ['establishment']);
        // setupClickListener('changetype-geocode', ['geocode']);
      }
    //AIzaSyAL_rtMv03GNmWgYfQkcGPPOsQ43LGun-0
    </script>

    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjhyTxmz9i9mGwzB1xy6mvVYH46PD2ylE&libraries=places&callback=initMap" async defer></script> -->

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjhyTxmz9i9mGwzB1xy6mvVYH46PD2ylE&libraries=places" async defer></script>



<script type="text/javascript">
$(document).ready(function() {
      $("#eventeditform").validate({            
            rules: {
                titolo: {
                    required: true
                },
                dettagli: {
                    required: true                    
                },
                giorno: {
                    required: true
                },
                ente: {
                    required: true
                },
                dove: {
                    required: true
                }
            },
            messages: {
                titolo: {
                    required: "{{trans('messages.keyword_enterobject')}}"
                },
                dettagli: {
                    required: "{{trans('messages.keyword_entergendetails')}}"
                },
                giorno: {
                    required: "{{trans('messages.keyword_selectgiorno')}}"
                },
                ente: {
                    required: "{{trans('messages.keyword_selectente')}}"
                },
                dove: {
                    required: "{{trans('messages.keyword_enterdove')}}"
                }
            }

        });
  });

</script>

</body>
</html>