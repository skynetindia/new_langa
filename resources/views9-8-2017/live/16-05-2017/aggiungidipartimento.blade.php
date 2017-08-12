@extends('adminHome')

@section('page')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<h1>Aggiungi dipartimento</h1><hr>

@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif
@include('common.errors')
<?php echo Form::open(array('url' => '/admin/tassonomie/dipartimenti/store', 'files' => true)) ?>
	{{ csrf_field() }}
	<!-- colonna a sinistra -->
	<div class="col-md-4">
		<label for="nomedipartimento">Nome dipartimento <span class="required">(*)</span></label>
		<input value="{{ old('nomedipartimento') }}" class="form-control" type="text" name="nomedipartimento" id="nomedipartimento" placeholder="Nome dipartimento"><br>
		<label for="piva">Partita iva</label>
		<input value="{{ old('piva') }}" class="form-control" type="text" name="piva" id="piva" placeholder="Partita iva"><br>
		<label for="cellulareazienda">Telefono dipartimento</label>
		<input value="{{ old('cellulareazienda') }}" class="form-control" type="text" name="cellularedipartimento" id="cellulareazienda" placeholder="Telefono opzionale"><br>
		<label for="iban">IBAN</label>
		<input value="{{ old('iban') }}" class="form-control" type="text" name="iban" id="iban" placeholder="IBAN azienda"><br>
		<br>
		
	</div>
	<!-- colonna centrale -->
	<div class="col-md-4">
		<label for="nomereferente">Responsabile dipartimento <span class="required">(*)</span></label>
		<select title="Responsabile associato a questo ente" name="nomereferente" id="nomereferente" class="form-control" onchange="trovaTelefono()">
			<option></option>
			@for($i = 1; $i < count($utenti); $i++)
			<option>{{ $utenti[$i]->name }}</option>
			@endfor
                </select><br>
		<label for="cf">Codice fiscale</label>
		<input value="{{ old('cf') }}" class="form-control" type="text" name="cf" id="cf" placeholder="Codice fiscale"><br>
		<label for="fax">Fax</label>
		<input value="{{ old('fax') }}" class="form-control" type="text" name="fax" id="fax" placeholder="Fax"><br>
                <label for="logo">Logo</label>
		<?php echo Form::file('logo', ['class' => 'form-control']); ?><br>
	</div>
	<!-- colonna a destra -->
	<div class="col-md-4">
		<datalist id="settori"></datalist>
		<label for="settore">Settore</label>
		<input value="{{ old('settore') }}" list="settori" class="form-control" type="text" id="settore" name="settore" placeholder="Cerca un settore..."><br>
		<label for="telefonodipartimento">Telefono responsabile dipartimento</label>
		<input value="{{ old('telefonodipartimento') }}" class="form-control" type="text" name="telefonodipartimento" id="telefonodipartimento" placeholder="Telefono dipartimento"><br>
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
		<label for="email">Email primaria <span class="required">(*)</span></label>
		<input value="{{ old('email') }}" class="form-control" type="email" name="email" id="email" placeholder="Email di notifica"><br>
		<label for="emailsecondaria">Email secondaria</label>
		<input value="{{ old('emailsecondaria') }}" class="form-control" type="email" name="emailsecondaria" id="emailsecondaria" placeholder="Email opzionale"><br>

	</div>
	<div class="col-md-12">
    <label>Indirizzo <span class="required">(*)</span></label><br>
	 <input value="{{ old('indirizzo') }}" id="pac-input" name="indirizzo" class="controls" type="text"
        placeholder="Inserisci un indirizzo (*)">
    <div id="type-selector" class="controls">
      <input type="radio" name="type" id="changetype-all" checked="checked">
      <label for="changetype-all">Tutti</label>

      <input type="radio" name="type" id="changetype-establishment">
      <label for="changetype-establishment">Aziende</label>

      <input type="radio" name="type" id="changetype-address">
      <label for="changetype-address">Indirizzi</label>

      <input type="radio" name="type" id="changetype-geocode">
      <label for="changetype-geocode">CAP</label>
    </div>
	
    <div id="map"></div>
    <div class="space10"></div>
	</div>
	<div class="col-md-12">
    <div class="form-group">
	<label for="noteenti" >Note enti</label>
	<textarea title="Note pubbliche per promemoria e info altri utenti" class="form-control" rows="7" name="noteenti" id="noteenti" placeholder="Note enti">{{ old('noteenti') }}</textarea><br>
	</div>
    </div>

	<div class="col-xs-12">
		
		<button type="submit" class="btn btn-warning">Salva</button>
        <div class="space50"></div>
	</div>
<?php echo Form::close(); ?>  
<div class="footer-svg add-deparment-page">
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

	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAL_rtMv03GNmWgYfQkcGPPOsQ43LGun-0&libraries=places&callback=initMap"
        async defer></script>
        
@endsection