@extends('adminHome')

@section('page')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<h1>{{trans("messages.keyword_modify_department")}}</h1><hr>
@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif
@include('common.errors')
<div class="container-fluid col-md-12">
  <div> </div>
</div>
<div class="row">
  <div class="col-md-6"> <img src="{{url('/storage/app/images/').'/'.$dipartimento->logo}}" class="option-image">
    <h1 class="option-heading"> {{trans("messages.keyword_code")}}: {{$dipartimento->id}}</h1>
  </div>
</div>

<?php echo Form::open(array('url' => '/admin/tassonomie/dipartimenti/update/department/' . $dipartimento->id, 'files' => true)) ?>
	{{ csrf_field() }}
	<!-- colonna a sinistra -->
    
    <div class="row">
    
	<div class="col-md-4 col-sm-12 col-xs-12">
		<label for="nomedipartimento">{{trans('messages.keyword_department_name')}}<span class="required">(*)</span></label>
		<input value="{{ $dipartimento->nomedipartimento }}" class="form-control" type="text" name="nomedipartimento" id="nomedipartimento" placeholder="{{trans('messages.keyword_department_name')}}"><br>
		<label for="piva">{{trans('messages.keyword_vat_number')}}</label>
		<input value="{{ $dipartimento->piva }}" class="form-control" type="text" name="piva" id="piva" placeholder="{{trans('messages.keyword_vat_number')}}"><br>
		<label for="cellulareazienda">{{trans('messages.keyword_phone_department')}}</label>
		<input value="{{ $dipartimento->cellularedipartimento }}" class="form-control" type="text" name="cellularedipartimento" id="cellulareazienda" placeholder="{{trans('messages.keyword_phone_department')}}"><br>
		<label for="iban">{{trans('messages.keyword_iban')}}</label>
		<input value="{{ $dipartimento->iban }}" class="form-control" type="text" name="iban" id="iban" placeholder="{{trans('messages.keyword_iban_company')}}"><br>
		<br>
		
	</div>
	
	<div class="col-md-4 col-sm-12 col-xs-12">
		<label for="nomereferente">{{trans('messages.keyword_head_of_department')}} <span class="required">(*)</span></label>
		<select title="Responsabile associato a questo ente" name="nomereferente" id="nomereferente" class="form-control" onchange="trovaTelefono()">
			<option></option>
			@for($i = 1; $i < count($utenti); $i++)
                        @if($utenti[$i]->name == $dipartimento->nomereferente)
                            <option selected>{{  ucwords(strtolower($dipartimento->nomereferente)) }}</option>
                        @else
                             <option>{{  ucwords(strtolower($utenti[$i]->name)) }}</option>
                        @endif
			@endfor
                </select><br>
		<label for="cf">{{trans('messages.keyword_fiscal_code')}}</label>
		<input value="{{ $dipartimento->cf }}" class="form-control" type="text" name="cf" id="cf" placeholder="{{trans('messages.keyword_fiscal_code')}}"><br>
		<label for="fax">{{trans('messages.keyword_fax')}}</label>
		<input value="{{ $dipartimento->fax }}" class="form-control" type="text" name="fax" id="fax" placeholder="{{trans('messages.keyword_fax')}}"><br>
                <label for="logo">{{trans('messages.keyword_logo')}}</label>
		<?php echo Form::file('logo', ['class' => 'form-control']); ?><br>
	</div>
	<!-- colonna a destra -->
	<div class="col-md-4 col-sm-12 col-xs-12">
		<datalist id="settori"></datalist>
		<label for="settore">{{trans('messages.keyword_sector')}}</label>
		<input value="{{ $dipartimento->settore }}" list="settori" class="form-control" type="text" id="settore" name="settore" placeholder="{{trans('messages.keyword_search_industry')}}"><br>
		<label for="telefonodipartimento">{{trans('messages.keyword_telephone_department_manager')}}</label>
		<input value="{{ $dipartimento->telefonodipartimento }}" class="form-control" type="text" name="telefonodipartimento" id="telefonodipartimento" placeholder="{{trans('messages.keyword_telephone_department_manager')}}"><br>
		<script>
                    var $j = jQuery.noConflict();
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
			var nome = $( "#nomereferente option:selected" ).text();
			console.log(nome);
			for(var i = 0; i < <?php echo count($utenti)-1;?>;i++) {
				if(nomi[i] == nome) {
					k = i;
					break;
				}
			}
			$('#telefonodipartimento').val(cellulari[k]);
		}
		</script>
		<label for="email">{{trans('messages.keyword_primary_email')}} <span class="required">(*)</span></label>
		<input value="{{ $dipartimento->email }}" class="form-control" type="email" name="email" id="email" placeholder="{{trans('messages.keyword_notification_email')}}"><br>
		<label for="emailsecondaria">{{trans('messages.keyword_secondary_email')}}</label>
		<input value="{{ $dipartimento->emailsecondaria }}" class="form-control" type="email" name="emailsecondaria" id="emailsecondaria" placeholder="{{trans('messages.keyword_optional_email')}}"><br>

	</div>
	<div class="col-md-12 col-sm-12 col-xs-12"><strong>{{trans('messages.keyword_address')}} <span class="required">(*)</span></strong><br>
	 <input value="{{ $dipartimento->indirizzo }}" id="pac-input" name="indirizzo" class="controls" type="text"
        placeholder="{{trans('messages.keyword_enteranaddress')}}">
    <div id="type-selector" class="controls">
      <input type="radio" name="type" id="changetype-all" checked="checked">
      <label for="changetype-all">{{trans('messages.keyword_all')}}</label>

      <input type="radio" name="type" id="changetype-establishment">
      <label for="changetype-establishment">{{trans('messages.keyword_companies')}}</label>

      <input type="radio" name="type" id="changetype-address">
      <label for="changetype-address">{{trans('messages.keyword_addresses')}}</label>

      <input type="radio" name="type" id="changetype-geocode">
      <label for="changetype-geocode">{{trans('messages.keyword_postal_code')}}</label>
    </div>
	
    <div id="map"></div>
	</div>
  <div class="space10"></div>
	<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="form-group">
	<label for="noteenti" >{{trans('messages.keyword_entries_note')}}</label>
	<textarea title="{{trans('messages.keyword_public_note')}}" class="form-control" rows="7" name="noteenti" id="noteenti" placeholder="{{trans('messages.keyword_entries_note')}}">{{ $dipartimento->noteenti }}</textarea><br>
	</div>
  </div>

	<div class="col-md-12 col-sm-12 col-xs-12">		
		<button type="submit" class="btn btn-warning">{{trans('messages.keyword_save')}} </button>
    <div class="space50"> </div>
	</div>
    </div>
<?php echo Form::close(); ?>  
<div class="footer-svg">
  <img src="{{asset('images/ADMIN_TASSONOMIE-footer.svg')}}" alt="tassonomie">
</div>
<script>

function punto() {
	$j('#prova').val($('#pac-input').val());
}
$j('.ciao').on("click", function() {
	$(this).children()[0].click();
});
// Carica i settori nel datalist dal file.json
var datalist = document.getElementById("settori");
var xhr = new XMLHttpRequest();
xhr.onreadystatechange = function(response) {
	if (xhr.readyState === 4 && xhr.status === 200) {
		var json = JSON.parse(xhr.responseText);
		json.forEach(function(item) {
			var option = document.createElement('option');
			option.value = item;
			datalist.appendChild(option);
		});
    }
}
xhr.open('GET', "{{ asset('public/json/settori.json') }}", true);
xhr.send();

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

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
    </script>
    <!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjhyTxmz9i9mGwzB1xy6mvVYH46PD2ylE&libraries=places&callback=initMap" async defer></script>-->
    <!--	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAL_rtMv03GNmWgYfQkcGPPOsQ43LGun-0&libraries=places&callback=initMap"
        async defer></script>-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPyPHd-CTp9Nh_Jqe1NwJiX6WKQYpVEtI&libraries=places&callback=initMap" async defer></script>
        
@endsection