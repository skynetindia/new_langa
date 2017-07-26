@extends('adminHome')
@section('page')

@include('common.errors') 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> 
<script type="text/javascript" src="{{asset('public/scripts/colors.js')}}"></script> 
<script type="text/javascript" src="{{asset('public/scripts/jqColorPicker.min.js')}}"></script> 
<script type="text/javascript">
     $('.color').colorPicker();
</script> 
<style>
	#please_wait_bg{ 
	background: rgba(0, 0, 0, 1) ;
    height: 100%;
    left: 0;
    position: fixed;
	display:none;
    top: 0;
    transition: all 0.3s ease 0s;
    width: 100%;
	opacity:0.6;
    z-index: 10;}
	
	#please_wait
	{
		position:absolute;
		z-index:1000;
		text-align:center;
		margin:0 auto;
		display:none;
		text-align:center;
		background-color:#FFFFFF;
		font-size:16px;
		vertical-align:middle;
		box-shadow:0px 0px 10px 1px #333;
		z-index:13;
		padding:50px 0;
		top: 50%;
    transform: translateX(-50%) translateY(-50%);

    height: auto;
    left: 50%;
    max-width: 630px;
    min-width: 320px;    width: 50%;
		
	}
	.height1{ background-color:#f2f2f2; min-height:110vh;}
</style>
<script type="text/javascript">
 
 $(document).ready(function() {

  $("#dipartimento").change(function(){

    if( $(this).val() == 1) {
        $("#sconto_section").hide();       
        $("#rendita").hide();
        $("#rendita_reseller").hide();
        $("#zone_section").hide();
    } 
    else if( $(this).val() == 3) {

        $("#sconto_section").hide();    
        $("#rendita").hide();
        $("#rendita_reseller").hide();
        $("#zone_section").hide();

    } else if( $(this).val() == 4) {

        $("#sconto_section").show();      
        if (!$('#profilazioneinterna').is(':checked')) {
          $("#rendita").show();
        }
        else {
          $("#rendita").hide(); 
        }
        $("#rendita_reseller").hide();
        $("#zone_section").show();

    } 
    else {
      $("#sconto_section").show(); 
        if (!$('#profilazioneinterna').is(':checked')) {
          $("#rendita").show();
        }
        else {
          $("#rendita").hide(); 
        }
      $("#rendita_reseller").show();
      $("#zone_section").show();
    }
  });

});

</script> 
@if(!empty(Session::get('msg'))) 
<script>

    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';

    document.write(msg);

    </script> 
@endif 
<script type="text/javascript">

        $(document).on("click", "#profilazioneinterna", function () {
            
            if ($(this).is(":unchecked")) {
                $("#rendita").show();
            } else {
                $("#rendita").hide();
            }
        });

    </script> 
 
 <div class="res-modify-utente"> 
   
@include('common.errors')
<h1>{{ isset($utente) ? trans('messages.keyword_edituser') : trans('messages.keyword_adduser') }} </h1>
<hr>

<!-- echo $utente->id -->

<?php $redirct=(isset($utente))? ("/".$utente->id):"";
   echo Form::open(array( 'url' => '/admin/update/utente' .$redirct, 'files' => true, 'id' => 'user_modification'));	
   ?>
{{ csrf_field() }} 

<!-- colonna a sinistra -->
<div class="col-md-12 col-sm-12 col-xs-12 text-right">
<div id="profilazione">
	<div class="form-group m_select lblshow">
  <input type="checkbox" id="profilazioneinterna" name="is_internal_profile" value="1" <?php if(isset($utente->is_internal_profile) && ($utente->is_internal_profile == '1')) { echo 'checked'; } ?>  />
   <label for="profilazioneinterna" > {{ trans('messages.keyword_internalprofile') }}? </label>
   </div>
</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-6">
    <div class="row">
    
<div class="col-md-6 col-sm-12 col-xs-12">
	<div class="form-group">
  <label for="name">{{ trans('messages.keyword_name') }} <span class="required">(*)</span></label>
  <input type="hidden" name="user_id" value=" <?php if(isset($utente->id)){ echo $utente->id; } ?>">
  <input value="<?php if(isset($utente->name)){ echo $utente->name; } ?>" class="form-control" type="text" name="name" id="name" placeholder="{{trans('messages.keyword_name')}}">
  </div>
</div>

<div class="col-md-6 col-sm-12 col-xs-12">
<div class="form-group">
  <label for="colore">{{ trans('messages.keyword_color') }}</label>
  <input value="<?php if(isset($utente->color)){ echo $utente->color; } ?>" class="form-control color no-alpha" type="text" name="colore" id="colore" placeholder="{{ trans('messages.keyword_color') }}">
</div>
</div>

<div class="col-md-6 col-sm-12 col-xs-12">
	<div class="form-group">
	    <label for="email">{{ trans('messages.keyword_email') }} <span class="required"> (*) </span></label>  
    	<input value="<?php if(isset($utente->email)){ echo $utente->email; } ?>" class="form-control" type="email" name="email" id="email" placeholder="{{ trans('messages.keyword_email') }}">
	 </div>
</div>

<div class="col-md-6 col-sm-12 col-xs-12">
	<div class="form-group">
	  <label for="password">{{ trans('messages.keyword_password') }}</label>
	  <input class="form-control" type="password" name="password" id="password" placeholder="{{ trans('messages.keyword_password') }}" >
	</div>
</div>


<div class="col-md-6 col-sm-12 col-xs-12">
	<div class="form-group">
   <label for="dipartimento">{{ trans('messages.keyword_profile') }} <span class="required">(*)</span></label>
  <select id="dipartimento" class="form-control" name="dipartimento">
    <option style="background-color:white" selected disabled>-- select --</option>      
         @foreach($ruolo as $ruolo)           
    <option  value="{{ $ruolo->ruolo_id }}" <?php echo (isset($utente->dipartimento) && $utente->dipartimento == $ruolo->ruolo_id) ? 'selected="selected"':'';?>>{{ ucwords(strtolower($ruolo->nome_ruolo)) }}</option>      
        @endforeach 
  </select>
</div>

  <div class="role" > </div>
  <script>
      
        $('#dipartimento').change(function() {

          var url = '<?php echo url('/admin/role/permission');?>';
          var fullurl = url+'/'+$(this).val();


          $.get( fullurl, function( data ) {
            var permessi = $( "#permissionview" ).html( data );  
            $("#oldpermissionview").remove();

              $('.reading').click(function () {   
                var $id = $(this).attr('id');
                $('.'+$id).prop('checked', this.checked);
              });

              $('.writing').click(function () {
                  var $id = $(this).attr('id');
                  $('.'+$id).prop('checked', this.checked);
             });

          //   $('.input_class_checkbox').each(function(){
          //       $(this).hide().after('<div class="class_checkbox" />');
          //     if($(this).hasClass('reading'))
          //     {
          //       $thisid=$(this).attr('id');
          //       $this=$("#"+$thisid);
          //       $(document).find($this).next().addClass('reading');
          //       $(document).find($this).next().attr('data-info',$thisid);
          //     }
              
          //     else 
          //     {
          //       if($(this).hasClass('writing'))
          //       {
          //         $thisid=$(this).attr('id');
          //         $this=$("#"+$thisid);
          //         $(document).find($this).next().addClass('writing');
          //         $(document).find($this).next().attr('data-info',$thisid);
                  
          //       }
          //       else
          //       {
          //         $class= $(this).attr("class");
          //         $cls=$class.split(' ');
          //         $(this).next().addClass($cls[0]);
          //       }
          //     }

          //   });

          //   $('.class_checkbox').on('click',function(){
          //       $(this).toggleClass('checked').prev().prop('checked',$(this).is('.checked'));
          //     if($(this).hasClass('writing') || $(this).hasClass('reading'))
          //     {
          //       $class=$(this).attr('data-info');
          //       $(document).find('.'+$class).toggleClass('checked');
          //     }
          //   }); 

          });

        });



      </script>
</div>


<div class="col-md-6 col-sm-12 col-xs-12">
	<div class="form-group m_select lblshow"> <div class="space35"></div>
	  	<input id="la-commerc" name="" value="" checked="" type="checkbox">
   		<label for="la-commerc"> Lavora in ambito commerciale? </label>
   </div>
</div>

<div class="col-md-6 col-sm-12 col-xs-12">
	<div id="sconto">
    <div class="form-group">
      <label for="sconto">{{ trans('messages.keyword_discount') }} <span class="required">(*)</span></label>
      <input value="<?php if(isset($utente->sconto)){ echo $utente->sconto; } ?>" class="form-control" type="text" name="sconto" id="sconto" placeholder="{{ trans('messages.keyword_discount') }}">
      </div>
    </div>
</div>

<div class="col-md-6 col-sm-12 col-xs-12">
	<div id="sconto_bonus">
     <div class="form-group">
      <label for="sconto_bonus">{{ trans('messages.keyword_discount') }} {{ trans('messages.keyword_bonus') }} <span class="required">(*)</span></label>
      <input value="<?php if(isset($utente->sconto_bonus)){ echo $utente->sconto_bonus; } ?>" class="form-control" type="text" name="sconto_bonus" id="sconto_bonus" placeholder="{{ trans('messages.keyword_discount') }} {{ trans('messages.keyword_bonus') }}">
    </div>
    </div>
</div>





<div class="col-md-6 col-sm-12 col-xs-12">
	<div class="form-group">
	    <label for="">% su tuoi preventivi confermati <span class="required"> (*) </span></label>  
    	<input value="" class="form-control" type="text" name="" id="" placeholder="">
	 </div>
</div>

<div class="col-md-6 col-sm-12 col-xs-12">
	<div class="form-group">
	  <label for="">Pagamento mensile (forfait)</label>
	  <input class="form-control" type="" name="" id="" placeholder="" >
	</div>
</div>




<!-- colonna centrale -->

  
      <script>      
    $('#aggiungiente').on("click", function() {
    var i = $("#hidden").val();

      $('#m_select').append("<div class='mb10'><select name='idente[]' class='form-control checkente"+i+"' id='id_ente"+i+"'><option style='background-color:white' selected disabled>-- select --</option><?php foreach ($enti as $enti_value) { ?><option value='<?php echo  $enti_value->id ?>'><?php echo ucwords(strtolower($enti_value->nomereferente)) ?></option><?php } ?></select><input id='checkente"+i+"' class='checkente' type='checkbox'><label for='checkente"+i+"'></label></div>");
      i++; 
     /* $('#m_select').append("<label class='checkente"+i+"'><select name='idente[]' class='form-control' id='id_ente'> <option selected style='background-color:white' disabled> -- select -- </option><?php foreach ($enti as $enti_value) { ?><option value='<?php echo  $enti_value->id ?>'><?php echo $enti_value->nomereferente ?></option><?php } ?></select><input id='checkente"+i+"' type='checkbox' class='checkente'></label>" );*/
        $('#hidden').val(i);

        });   $('#eliminaente').on("click", function() {

                  if($('#checkente0').prop('checked') == true) {
                      alert("Can not remove default ente");
                      $('#checkente0').attr('checked', false);                    

                  } else {

                     $(".checkente").each(function(){

                      var i = $("#hidden").val();

                        if($(this).prop('checked') == true) {

                          var newclass = $(this).prop('id');
                          $("."+newclass).remove();
                          $(this).remove(); 
                          $('label[for="'+newclass+'"]').remove();                         
                            i--;
                            $('#hidden').val(i);
                      }

                    });

                  }                 
              });

          </script>
  
<div class="col-md-6 col-sm-12 col-xs-12">
  <div class="form-group" id="rendita" <?php if(isset($utente->is_internal_profile) && ($utente->is_internal_profile == 1)) { echo 'style="display: none"';} ?> >
    <label for="rendita">{{ trans('messages.keyword_revenue') }}<span class="required"> (*) </span></label>
    <input value="<?php if(isset($utente->rendita)){ echo $utente->rendita; } ?>" class="form-control" type="text" name="rendita" id="rendita" placeholder="{{ trans('messages.keyword_revenue') }}">    
  </div>
  <div class="form-group" id="rendita_reseller" <?php echo (isset($utente->dipartimento) && ($utente->dipartimento == 1 || $utente->dipartimento == 3 || $utente->dipartimento == 4))?"style='display: none'":""; ?>>
    <label for="rendita_reseller"> {{ trans('messages.keyword_revenuereseller') }} <span class="required"> (*) </span> </label>
    <input value="<?php if(isset($utente->rendita_reseller)){ echo $utente->rendita_reseller; } ?>" class="form-control" type="text" name="rendita_reseller" id="rendita_reseller" placeholder="{{ trans('messages.keyword_revenuereseller') }}">    
  </div>


<!-- colonna a destra -->
</div>


<div class="col-md-6 col-sm-12 col-xs-12">
	<div class="form-group">
	  <label for="">Transalate</label>
	  <input class="form-control" name="" id="" placeholder="" type="">
	</div>
</div>


<div class="col-md-12 col-sm-12 col-xs-12">
	    <div class="form-group">
      <label for="id_ente"> {{ trans('messages.keyword_associate') }} <span class="required">(*)</span></label>
      <div class="row">
      <div class="col-md-9 col-sm-12 col-xs-12 m_select" id="m_select"><?php 
      if(isset($utente->id_ente))
      {
          $ente = explode(",", $utente->id_ente);          
          $i=0;
                
          foreach ($ente as $ente_value) { ?>
          <div class="mb10"><select name="idente[]" class="form-control checkente<?php echo $i;?>" id="id_ente">
                <option style="background-color:white" selected="" disabled="">-- select --</option>
               <?php foreach ($enti as $enti_value) { ?>
                    <option <?php if($enti_value->id == $ente_value){ echo 'selected'; } ?> value="<?php echo $enti_value->id ?>"><?php echo ucwords(strtolower($enti_value->nomereferente)) ?> </option>
                    <?php  }  ?>
              </select>          
              <input id="checkente<?php echo $i;?>" type="checkbox" class="checkente">
              <label for="checkente<?php echo $i;?>"></label></div>
               <?php $i++; ?>       
              <?php } ?>
            <input type="hidden" id="hidden" name="check" value="<?php echo $i; ?>">
            <?php 
      }
      else {
         $i=0;
        ?><div class=""><select name="idente[]" class="form-control checkente<?php echo $i;?>" id="id_ente">
              <option style="background-color:white" selected="" disabled="">-- select --</option><?php 
              foreach ($enti as $enti_value) { 
                  ?><option value="<?php echo $enti_value->id ?>"><?php echo ucwords(strtolower($enti_value->nomereferente)) ?> </option><?php  
                }
              ?></select>          
              <input id="checkente<?php echo $i;?>" type="checkbox" class="checkente">
              <label for="checkente<?php echo $i;?>"></label></div>
              <input type="hidden" id="hidden" name="check" value="1"><?php
    
      } 
    /*else {  
    
      $i=0;
      ?>
          <tr>
            <label class="checkente<?php echo $i;?>">
              <select name="idente[]" class="form-control" id="id_ente" style="width: 200px">
                <option style="background-color:white" selected disabled>-- select --</option>
                <?php foreach ($enti as $enti_value) { ?>
                <option value="<?php echo $enti_value->id ?>"> <?php echo $enti_value->nomereferente ?> </option>
                <?php  }  ?>
              </select>
              <input id="checkente<?php echo $i;?>" type="checkbox" class="checkente">
            </label>
            <?php $i++; ?>
          </tr>
          <input type="hidden" id="hidden" name="check" value="<?php echo $i; ?>">
    <?php } */?>
      </div>
        <div class="col-md-3 text-right space-res-btn-mselect"> 
          <a class="btn btn-warning" id="aggiungiente"><i class="fa fa-plus"></i></a> 
          <a class="btn btn-danger" id="eliminaente"><i class="fa fa-trash"></i></a>
        </div>  
        <div class="error-space"><label for="id_ente" generated="true" class="error"></label></div>
      </div>
      </div>

</div>


</div>
    </div>	
        
        <div class="col-xs-12 col-sm-12 col-md-6">
       <div id="map"></div>              
      <div id="please_wait_bg" onclick="showHide()">
</div>
        </div>

</div>


 <script>
                  
      $('#aggiungizone').on("click", function() {

      var i = $("#hiddenzone").val();

      $('#zone').append("<div class='mb10'><select name='zone[]' class='form-control checkzone"+i+"' id='zone'> <option selected style='background-color:white' disabled> -- select -- </option><?php foreach ($citta as $citta_value) { ?><option value='<?php echo  $citta_value->id_citta ?>'><?php echo ucwords(strtolower($citta_value->nome_citta)) ?></option><?php } ?></select><input id='checkzone"+i+"' type='checkbox' class='checkzone'><label for='checkzone"+i+"'></label></div>" );

        i++;
        $('#hiddenzone').val(i);

        });

        $('#eliminazone').on("click", function() {

            if($('#checkzone0').prop('checked') == true) {

              alert("Can not remove default zone");
              $('#checkzone0').attr('checked', false);

          } else {
                
              $(".checkzone").each(function(){

              var i = $("#hiddenzone").val();
              
                if($(this).prop('checked') == true) {

                  var newclass = $(this).prop('id');
                  $("."+newclass).remove(); 
                  $(this).remove();
                  
                    i--;
                    $('#hiddenzone').val(i);
              }

            });

          }                 
      });
	function showHide(){
	var el = document.getElementById("please_wait");
	var bg = document.getElementById("please_wait_bg");
    if( el && el.style.display == 'block')    
        el.style.display = 'none';
    else 
        el.style.display = 'block';
		
	if( bg && bg.style.display == 'block'){    
        bg.style.display = 'none';
		jQuery(window).unbind('scroll');
		  
	}
    else {
        bg.style.display = 'block';
		jQuery(window).scroll(function() { return false; });
	}
}
	  var circle;

      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 41.885977605235377, lng: 12.480394244191757},
          zoom: 6
        });
		//var infowindow = new google.maps.InfoWindow;
		var circle1 = new google.maps.Circle({
				center: new google.maps.LatLng(41.88597760523537, 12.480394244191757),
				map: map,
				radius: 65824.04444800339,          // IN METERS.
				fillColor: '#FF6600',
				fillOpacity: 0.3,
				strokeColor: "#FFF",
				strokeWeight: 0 ,
				       // DON'T SHOW CIRCLE BORDER.
			});
			
			
			
		//circle1.setMap(map);
        var drawingManager = new google.maps.drawing.DrawingManager({
          drawingMode: google.maps.drawing.OverlayType.CIRCLE,
          drawingControl: true,
          drawingControlOptions: {
            position: google.maps.ControlPosition.TOP_CENTER,
            drawingModes: ['marker', 'circle', 'polygon', 'polyline', 'rectangle']
          },
          markerOptions: {icon: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png'},
          circleOptions: {
            fillColor: '#FF6600',
            fillOpacity: 0.3,
            strokeWeight: 0,
            clickable: false,
            editable: false,
            zIndex: 1
          }
        });
        drawingManager.setMap(map);
		google.maps.event.addListener(drawingManager, 'circlecomplete', onCircleComplete);
		var geocoder = new google.maps.Geocoder;
		 
		
		
		function onCircleComplete(shape) {
			if (shape == null || (!(shape instanceof google.maps.Circle))) return;
	
			if (circle != null) {
				circle.setMap(null);
				circle = null;
			}
	
			circle = shape;
			console.log('radius', circle.getRadius());
			console.log('lat', circle.getCenter().lat());
			console.log('lng', circle.getCenter().lng());
			
			var latlng = {lat: circle.getCenter().lat(), lng: circle.getCenter().lng()};
			geocoder.geocode({'location': latlng}, function(results, status) {
			  if (status === 'OK') {
				if (results[1]) {
				  //map.setZoom(6);
				  /*var marker = new google.maps.Marker({
					position: latlng,
					center:latlng,
					map: map
				  });*/
					 var city = results[0].formatted_address;
					//alert(city);
					city = city.split(",");
					city = city[city.length - 2];
					//alert(city);
					city = city.split(" ");
					city = city[2];
					alert(city);
	
					if((typeof city === 'string' || city instanceof String) && isNaN(parseInt(city))) {
						jQuery("#city").val(city);
						showHide();
					}
				  
				} else {
				  window.alert('No results found');
				}
			  } else {
				window.alert('Geocoder failed due to: ' + status);
			  }
			});
			
			
		}
		google.maps.event.addDomListener(window, 'load', initMap);
		
      }
	  
    </script>
    <div id="permissionview"></div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPyPHd-CTp9Nh_Jqe1NwJiX6WKQYpVEtI&libraries=drawing&callback=initMap" async defer></script>
</div>
<div class="col-md-12 col-sm-12 col-xs-12" id="oldpermissionview"><?php
  echo "<table class='table table-striped table-bordered'>";
    echo "<tr>";
      echo "<th>";
        echo trans('messages.keyword_module');
      echo "</th> ";
      echo "<th>";
        echo  trans('messages.keyword_reading');
      echo "</th> ";
      echo "<th>";
        echo  trans('messages.keyword_writing');
      echo "</th> ";
    echo "</tr>";

    $i=0;
?>
  @if(isset($permessi))
  <?php

    foreach ($module as $module) {

      $submodule = DB::table('modulo')
            ->where('modulo_sub', $module->id)
            ->get();
      if($submodule) {

         echo "<tr>";
            echo "<td><b>";
            echo $module->modulo;
            echo "</td></b> <td>";
       ?>       
  <input type="checkbox" class="reading input_class_checkbox" id="lettura<?php echo $module->modulo.$i; ?>" name="lettura[]"  value="<?php echo $module->id.'|0|lettura';?>" 
       <?php echo (in_array($module->id.'|0|lettura', $permessi)) ? 'checked' :'';  ?>>
       <label for="lettura<?php echo $module->modulo.$i; ?>"></label>
  <?php
            echo "</td><td>"; ?>            
  <input type="checkbox" class="writing input_class_checkbox" id="scrittura<?php echo $module->modulo.$i; ?>"  name="scrittura[]"  value="<?php echo $module->id.'|0|scrittura';?>"<?php echo (in_array($module->id.'|0|scrittura', $permessi)) ? 'checked' :''; ?>>
  <label for="scrittura<?php echo $module->modulo.$i; ?>"></label>
  
  <!-- <div class="class_checkbox writing <?php //echo (in_array($module->id.'|0|scrittura', $permessi)) ? 'checked' :'';  ?> " data-info="scrittura<?php //echo $i; ?>"></div> -->
  
  <?php
        echo "</td></tr>";

        foreach ($submodule as $submodule) {

          echo "<tr>";

            echo "<td>";
            echo $submodule->modulo;
            echo "</td>";

            echo "<td>"; ?>            
  <input type="checkbox" class="lettura<?php echo $module->modulo.$i; ?> input_class_checkbox" id="lettura<?php echo $module->modulo.$submodule->modulo.$i; ?>" name="lettura[]" value="<?php echo $module->id.'|'.$submodule->id.'|lettura';?>"<?php echo (in_array($module->id.'|'.$submodule->id.'|lettura', $permessi)) ? 'checked' :''; ?> >
  <label for="lettura<?php echo $module->modulo.$submodule->modulo.$i; ?>"></label>
  
  <!-- <div class="class_checkbox lettura <?php //echo (in_array($module->id.'|0|lettura', $permessi)) ? 'checked' :'';  ?> " data-info="lettura<?php //echo $i; ?>"></div> -->
  
  <?php
            echo "</td>";

            echo "<td>"; ?>            
  <input type="checkbox" class="scrittura<?php echo $module->modulo.$i; ?> input_class_checkbox" id="scrittura<?php echo $module->modulo.$submodule->modulo.$i; ?>" name="scrittura[]" value="<?php echo $module->id.'|'.$submodule->id.'|scrittura';?>" <?php echo (in_array($module->id.'|'.$submodule->id.'|scrittura', $permessi)) ? 'checked' :''; ?> >
  <label for="scrittura<?php echo $module->modulo.$submodule->modulo.$i; ?>"></label>
  
  <!-- <div class="class_checkbox scrittura <?php //echo (in_array($module->id.'|0|scrittura', $permessi)) ? 'checked' :'';  ?> " data-info="scrittura<?php //echo $i; ?>"></div> -->
  
  <input type="hidden" id="hidden" name="checkhidden" value="<?php echo $i; ?>">
  <?php
            echo "</td>";

          echo "</tr>";
         
        } $i++;
      } else {

         echo "<tr>";
            echo "<td><b>";
            echo $module->modulo;
         echo "</td></b> ";

          echo "<td>"; ?>          
  <input type="checkbox" class="reading input_class_checkbox" id="lettura<?php echo $module->modulo.$i; ?>" name="lettura[]" value="<?php echo $module->id.'|0|lettura';?>" <?php echo (in_array($module->id.'|0|lettura', $permessi)) ? 'checked' :''; ?>>
  <label for="lettura<?php echo $module->modulo.$i; ?>"></label>
  
  <!-- <div class="class_checkbox reading <?php //echo (in_array($module->id.'|0|lettura', $permessi)) ? 'checked' :'';  ?> " data-info="lettura<?php //echo $i; ?>"></div> -->
  
  <?php
          echo "</td>";

          echo "<td>"; ?>
  <?php
          echo "</td>";

        echo "</tr>";
      }  
    }
  
  echo "</table>";
 ?>
  @else
  <?php  
    foreach ($module as $module) {

      $submodule = DB::table('modulo')
            ->where('modulo_sub', $module->id)
            ->get();

      if($submodule) {

         echo "<tr>";
            echo "<td><b>";
            echo $module->modulo;
            echo "</td></b> <td>";

       ?>       
  <input type="checkbox" class="reading input_class_checkbox" id="lettura<?php echo $module->modulo.$i; ?>" name="lettura[]" value="<?php echo $module->id.'|0|lettura';?>">
  <label for="lettura<?php echo $module->modulo.$i; ?>"></label>
  <?php
            echo "</td><td>"; ?>            
  <input type="checkbox" class="writing input_class_checkbox" id="scrittura<?php echo $module->modulo.$i; ?>"  name="scrittura[]"  value="<?php echo $module->id.'|0|scrittura';?>">
  <label for="scrittura<?php echo $module->modulo.$i; ?>"></label>
  <?php
        echo "</td></tr>";

        foreach ($submodule as $submodule) {

            echo "<tr>";

            echo "<td>";
            echo $submodule->modulo;
            echo "</td>";

            echo "<td>"; ?>
            
  <input type="checkbox" class="lettura<?php echo $module->modulo.$i; ?> input_class_checkbox" id="lettura<?php echo $module->modulo.$submodule->modulo.$i; ?>" name="lettura[]" value="<?php echo $module->id.'|'.$submodule->id.'|lettura';?>">
  <label for="lettura<?php echo $module->modulo.$submodule->modulo.$i; ?>"></label>
  <?php
            echo "</td>";

            echo "<td>"; ?>
            
  <input type="checkbox" class="scrittura<?php echo $module->modulo.$i; ?> input_class_checkbox" id="scrittura<?php echo $module->modulo.$submodule->modulo.$i; ?>" name="scrittura[]" value="<?php echo $module->id.'|'.$submodule->id.'|scrittura';?>">
  <label for="scrittura<?php echo $module->modulo.$submodule->modulo.$i; ?>"></label>
  <input type="hidden" id="hidden" name="checkhidden" value="<?php echo $i; ?>">
  <?php
            echo "</td>";

          echo "</tr>";
         
        } $i++;
      } else {

         echo "<tr>";
            echo "<td><b>";
            echo $module->modulo;
         echo "</td></b> ";

          echo "<td>"; ?>

  <input type="checkbox" class="reading input_class_checkbox" id="lettura<?php echo $module->modulo.$i; ?>" name="lettura[]" value="<?php echo $module->id.'|0|lettura';?>">
  <label for="lettura<?php echo $module->modulo.$i; ?>"></label>
  <?php
          echo "</td>";

          echo "<td>"; ?>
  <?php
          echo "</td>";

        echo "</tr>";
      }  
    }
  
  echo "</table>";
?>
  @endif </div>
<script type="text/javascript">
  
  $('.reading').click(function () {   
    var $id = $(this).attr('id');
    $('.'+$id).prop('checked', this.checked);
  });

  $('.writing').click(function () {
      var $id = $(this).attr('id');
      $('.'+$id).prop('checked', this.checked);
  });

// setTimeout(function(){

// $('.input_class_checkbox').each(function(){
//   if($(this).attr('checked') == true){
//     $(this).hide().after('<div class="class_checkbox checked" />');
//   }else{
//     $(this).hide().after('<div class="class_checkbox" />');
//   }

//   if($(this).hasClass('reading'))
//   {
//     $thisid=$(this).attr('id');
//     $this=$("#"+$thisid);
//     $(document).find($this).next().addClass('reading');
//     $(document).find($this).next().attr('data-info',$thisid);
//   }
  
//   else 
//   {
//     if($(this).hasClass('writing'))
//     {
//       $thisid=$(this).attr('id');
//       $this=$("#"+$thisid);
//       $(document).find($this).next().addClass('writing');
//       $(document).find($this).next().attr('data-info',$thisid);
      
//     }
//     else
//     {
//       $class= $(this).attr("class");
//       $cls=$class.split(' ');
//       $(this).next().addClass($cls[0]);
//     }
//   }

// });
// }, 200);

// $('.class_checkbox').on('click',function(){
//     $(this).toggleClass('checked').prev().prop('checked',$(this).is('.checked'));
//   if($(this).hasClass('writing') || $(this).hasClass('reading'))
//   {
//     $class=$(this).attr('data-info');
//     $(document).find('.'+$class).toggleClass('checked');
//   }
// });

</script> 
</script>
<div class="col-md-12 col-sm-12 col-xs-12" style="">
  <button type="submit" class="btn btn-warning"> 
  {{ trans('messages.keyword_save') }}</button>
  {!! link_to(URL::previous(), 'Cancel', ['class' => 'btn btn-danger']) !!} </div>
</form>

<script>

$('.ciao').on("click", function() {

    $(this).children()[0].click();

});

</script> 
<script type="text/javascript" src="{{asset('public/scripts/index.js')}}"></script> 
<script>
  $(document).ready(function() {
        // validate signup form on keyup and submit
        $("#user_modification").validate({

            rules: {
                name: {
                    required: true,
                    maxlength: 50
                },
                "idente[]":{
                   required: true,
                 },
                 "zone[]":{
                  required: true,
                 },
                 add_password: {
                    required: true,
                    minlength : 8,
                    maxlength: 16
                },
                email: {
                    required: true,
                    email: true,
                    maxlength: 64,
                },
                idente: {
                    required: true
                  
                },
                dipartimento: {
                    required: true                    
                },
                colore: {   
                    maxlength: 30                 
                },
                sconto: {
                    required: true,
                    digits: true
                },
                sconto_bonus: {
                    required: true,
                    digits: true
                },
                rendita: {
                    required: true,
                    digits: true
                },
                rendita_reseller: {
                    required: true,
                    digits: true
                },
                zone: {
                    required: true                    
                }
            },
            messages: {
                name: {
                    required: "<?php echo trans('messages.keyword_please_enter_a_name');?>",
                    maxlength: "<?php echo trans('messages.keyword_name_less_than_50_characters');?>"
                },
                "idente[]":{
                   required: "<?php echo trans('messages.keyword_please_select_a_associate_with_entity');?>",
                 },
                 "zone[]":{
                  required: "<?php echo trans('messages.keyword_please_enter_a_zone');?>",
                 },
                 add_password: {
                    required: "<?php echo trans('messages.keyword_please_enter_a_password');?>",
                    minlength : "<?php echo trans('messages.keyword_password_6_characters_long');?>",
                    maxlength: "<?php echo trans('messages.keyword_password_less_than_16_characters');?>"
                },
                email: {
                    required: "<?php echo trans('messages.keyword_please_enter_email_address');?>",
                    email: "<?php echo trans('messages.keyword_please_enter_valid_email_address');?>",
                    maxlength: "<?php echo trans('messages.keyword_email__less_than_64_characters');?>",
                },
                idente: {
                    required: "<?php echo trans('messages.keyword_please_select_an_entity');?>"                   
                },
                dipartimento: {
                    required: "<?php echo trans('messages.keyword_please_select_a_profiling');?>"
                },
                colore: {   
                    maxlength: "<?php echo trans('messages.keyword_colore_maximum_length_30_characters');?>"
                },
                sconto: {
                    required: "<?php echo trans('messages.keyword_please_enter_a_discount');?>",
                    digits: "<?php echo trans('messages.keyword_only_digits_allowed');?>"
                },
                sconto_bonus: {
                    required: "<?php echo trans('messages.keyword_please_enter_a_discount_bonus');?>",
                    digits: "{{ trans('messages.keyword_only_digits_allowed')}}"
                },
                rendita: {
                    required: "{{trans('messages.keyword_please_enter_a_revenue')}}",
                    digits: "{{ trans('messages.keyword_only_digits_allowed')}}"
                },
                rendita_reseller: {
                    required: "{{trans('messages.keyword_please_enter_a_revenue_of_reseller')}}",
                    digits: "{{ trans('messages.keyword_only_digits_allowed')}}"
                },
                zone: {
                   required: "{{trans('messages.keyword_please_enter_a_zone')}}"
                }
            }

        });

        $.validator.setDefaults({
        ignore: []
    });
}); 
        
</script> 
@endsection