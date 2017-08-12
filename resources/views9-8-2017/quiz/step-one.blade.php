@extends('layouts.app')
@section('content')
@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif
@include('common.errors')
<style type="text/css">
  .img-border-preview {
    border: 1px solid #f37f0d;
    min-height: 64px;
}
</style>

<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="{{asset('public/scripts/select2.full.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.62/jquery.inputmask.bundle.js"></script>

 <!-- CSS required for STEP Wizard  -->
 
  <!-- HTML Structure -->

<div class="row quiz-wizard">
<div class="col-md-12 col-sm-12 col-xs-12">
    <h1> {{ trans('messages.keyword_quiz') }} </h1>
    <div class="wizard wizard-step-line">
      <div class="wizard-inner">
        <div class="connecting-line"></div>
        <ul class="nav nav-tabs">
          <li role="presentation" class="top0 active"> <a href="#" title="Step 1"> <span class="round-tab"> <img src="{{ asset('images/folder.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_enter_data') }} </span> </a> </li>
          <li role="presentation" class="top0 disabled"> <a href="#" title="Step 2"> <span class="round-tab"> <img src="{{ asset('images/star.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_currency_demo') }} </span> </a> </li>
          <li role="presentation" class="top0 disabled"> <a href="#" title="Step 3"> <span class="round-tab"> <img src="{{ asset('images/edit.png') }}"> </span> <span class="tab-name">{{ trans('messages.keyword_colors__layouts') }} </span> </a> </li>
          <li role="presentation" class="top0 disabled"> <a href="#" title="Complete"> <span class="round-tab"> <img src="{{ asset('images/list.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_optional') }} </span> </a> </li>
          <li role="presentation" class="top0 disabled"> <a href="#" title="Complete"> <span class="round-tab"> <img src="{{ asset('images/media.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_media') }} </span> </a> </li>
          
          <li role="presentation" class="top0 disabled"> <a href="#" title="Complete"> <span class="round-tab"> <img src="{{ asset('images/flag.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_media') }} </span> </a> </li>
          
        </ul>
      </div>
      </div>
	<div class="wizard">
      <div id="success_message"></div>

      <div class="step-content">
        <div class="step-pane">
        <div class="col-md-6 col-sm-12 col-xs-12">
          <form role="form" name="step_one" id="step_one" class="text-center register-for-quiz-form" method="post" enctype="multipart/form-data">

          {{ csrf_field() }}
            <div class="form-group">
              <label for="usr"> {{ trans('messages.keyword_company_name') }}<span class="required"> (*) </span></label>
              <!-- <div class = "input-group"> -->
                <input type = "text" class = "form-control" name="nome_azienda" id="nome_azienda" placeholder="{{ trans('messages.keyword_enter_company_name') }} ">
                <span class = "input-group-addon" id="exist" style="display: none;"><a href="#" id="link" onclick="return confirm('{{ trans('messages.keyword_sure_exsting_entity') }} ?');"></a> {{ trans('messages.keyword_existing_entity') }} ? </span>
                <div id="confirm" class="none"> 
                {{ trans('messages.keyword_do_you_want') }}  
                  <a id="oldente" href="Javascript:void(0);"><b> {{ trans('messages.keyword_old') }}</b> </a> {{ trans('messages.keyword_or') }} 
                  <a id="newente"href="Javascript:void(0);"><b> 
                  {{ trans('messages.keyword_new') }}</b> </a>
                </div>
                 <!-- </div> -->
                 
                <span id="span_azienda" style="display: none;"> {{ trans('messages.keyword_company_name_required') }}  </span>
            </div>
            <div class="form-group">
              <label for="ref-name"> {{ trans('messages.keyword_refname') }} <span class="required"> (*) </span> </label>
              <input type="text" class="form-control" id="ref_name" name="ref_name" placeholder=" {{ trans('messages.keyword_enter_reference_name') }} ">
            </div>
            <span id="span_referente" style="display: none;"> {{ trans('messages.keyword_reference_name_required') }} </span>

            <div class="form-group" >
              <datalist id="settori"></datalist>
              <label for="sel1"> {{ trans('messages.keyword_commodity_sector') }}  <span class="required">(*)</span> </label>
              <?php $arrsettori = json_decode(file_get_contents(url('public/json/settori.json'))); ?>
              <select id="settore_merceologico" name="settore_merceologico" name="settore_merceologico" class="commodity_sector form-control">
              <option style="background-color:white" value="" selected="" disabled="">-- {{ trans('messages.keyword_please_select_a_sector') }} --</option>
              @foreach($arrsettori as $key => $val)             
                <option value="{{$val}}">{{$val}}</option>            
              @endforeach
              </select>
              <div id="targeted"></div>
               <?php /*<input value="" list="settori" class="form-control" type="text" id="settore_merceologico" name="settore_merceologico" placeholder=" {{ trans('messages.keyword_search_industry') }} ">*/?>
            </div>
            <span id="span_settore" style="display: none;"> {{ trans('messages.keyword_commodity_sector_required') }} </span>
            
            <div class="form-group">
              <label for="vatno"> {{ trans('messages.keyword_vat_number') }} : <span class="required">(*) </span></label>
              <input type="text" class="form-control" name="vat" id="vat" placeholder="{{ trans('messages.keyword_enter_the_vat') }} ">
            </div>
            <span id="span_vat" class="none"> {{ trans('messages.keyword_vat_required') }}  </span>

          <!--  <div class="form-group">
              <label for="Indirizzo"> {{ trans('messages.keyword_address') }} : <span class="required">(*)</span> </label>
              <input type="text" class="form-control" name="indirizzo" id="indirizzo" placeholder="{{ trans('messages.keyword_enter_address') }} ">
            </div>
            <span id="span_indirizzo" class="none"> {{ trans('messages.keyword_address_required') }}  </span>-->

            <?php $states = DB::table('stato')->select('id_stato', 'nome_stato')->get(); ?>

        <!--    <div class="form-group">
              <label for="state"> 
              {{ trans('messages.keyword_state') }} : 
              <span class="required">(*)</span> </label>
              <select id="state" class="form-control" name="state">
                  <option style="background-color:white" selected disabled value="">
                  -- {{ trans('messages.keyword_selectstate') }} --
                  </option>
                  @foreach($states as $state)
                      <option value="{{ $state->id_stato }}"> {{ ucwords(strtolower($state->nome_stato)) }}  </option>
                  @endforeach                    
                </select>
            </div>
            <span id="span_state" class="none"> {{ trans('messages.keyword_state_required') }}  </span> -->

       <!--      <div class="form-group">
                <label for="city"> 
                {{ trans('messages.keyword_city') }} 
                <span class="required">(*)</span> </label>
                    <select id="city" class="form-control " name="city">
                        <option style="background-color:white" selected disabled value="">
                        -- {{ trans('messages.keyword_selectcity') }} --
                        </option>
                    </select>
            </div>   
            <span id="span_city" class="none"> 
            {{ trans('messages.keyword_city_required') }}
            </span>  -->

            <div class="form-group">
              <label for="Telefono"> {{ trans('messages.keyword_phone') }} : <span class="required"> (*) </span> </label>
              <input type="text" name="telefono" class="form-control" id="telefono" placeholder=" {{ trans('messages.keyword_enter_phone') }} ">
            </div>
            <span id="span_telefono" class="none"> {{ trans('messages.keyword_phone_required') }}  </span>

            <div class="form-group">
              <label for="email"> {{ trans('messages.keyword_email') }}: <span class="required"> (*) </span> </label>
              <input type="email" name="email" class="form-control" id="email" placeholder=" {{ trans('messages.keyword_enter_email') }} " pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$">
            </div>
            <span id="span_email" class="none"> {{ trans('messages.keyword_valid_email_required') }}  </span><p id="demo"></p>

         
         
 <!--          <div class="form-group">
            <div class="row">
              <div class="col-md-12 quiz-file-upload">
                  <label for="Logo">Logo</label>
                  <input class="form-control" id="logo" name="logo" type="file">
                    <div class="col-md-2 logopreview" id="logopreview"> 
                  <div class="img-border-preview"></div>
                </div>  
                </div>
                            
            </div>    
          </div>
          <span id="span_logo" class="none">
            {{ trans('messages.keyword_please_upload_a_valid__image') }} 
          </span>
	 -->
        
       <!-- <div class="form-group">
            <div class="row">
              <div class="col-md-10 col-sm-12 col-xs-12 quiz-file-upload">
                  <label for="Logo">{{ trans('messages.keyword_image') }} </label>
                  	<div class="form-control-txt">
                    <label for="logo">{{ trans('messages.keyword_browse') }}...</label>
                  	<input class="form-control" id="logo" name="logo" type="file">
                  	</div>
                  </div>   
                    <div class="col-md-2 col-sm-12 col-xs-12 logopreview" id="logopreview"> 
                  <div class="img-border-preview" style="display:block;"><img src="http://betaeasy.langa.tv/storage/app/images/mancalogo.jpg" class="img-responsive" height="100" width="100"></div>
                </div>  
             
                            
            </div>    
          </div>
          <span id="span_logo" class="none">
            {{ trans('messages.keyword_please_upload_a_valid__image') }} 
          </span>-->
        

			  
          </form>
        </div>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12">
       	 <div class="">
            <div class="">
            	<label>{{trans('messages.keyword_address')}} <span class="required"> (*) </span> &nbsp; &nbsp;  &nbsp;  <span id="span_indirizzo" style="color: red;" class="none"> {{ trans('messages.keyword_address_required') }}  </span>
                </label>
            </div>
             <input value="" id="pac-input" name="indirizzo" class="controls required-input" type="text" placeholder="{{trans('messages.keyword_enter_an_address')}} (*)">
           
            <div id="type-selector" class="controls">
              <input type="radio" name="type" id="changetype-all" checked="checked">
              <label for="changetype-all">{{trans('messages.keyword_all')}}</label>
        
              <input type="radio" name="type" id="changetype-establishment">
              <label for="changetype-establishment">{{trans('messages.keyword_company')}}</label>
        
              <input type="radio" name="type" id="changetype-address">
              <label for="changetype-address">{{trans('messages.keyword_addresses')}}</label>
        
              <input type="radio" name="type" id="changetype-geocode">
              <label for="changetype-geocode">{{trans('messages.keyword_postal_code')}}</label>
        </div>
	
        <div id="map"></div>
        </div></div>
        
        
        
          <div class="clearfix"></div>
            <div class="step-footer">
              <div class="dots"> <span class="dot active"> </span> 
              <span class="dot"> </span> <span class="dot"> </span> 
              <span class="dot"> </span> <span class="dot"> </span> 
              <span class="dot"> </span>
                <div class="page">1/7</div>
              </div>
              <ul class="list-inline">
                <li><a class="prev-step" id="prev_stepone"> {{ trans('messages.keyword_back') }} </a></li>
                <li><a href="#" class="next-step" id="step-one"> {{ trans('messages.keyword_next') }} </a> </li>
              </ul>
              
              <div class="quiz-btn-save">
 
  <?php if(isset($payment_status->payment_status) && $payment_status->payment_status == 1) { ?>
 	
	 <button id="firm" class="btn btn-default">
    	{{ trans('messages.keyword_firm') }}
  	</button>
  
   <script type="text/javascript">
    $('.main_container').addClass('disabled');
    </script>
   <?php } ?>
  <?php if(isset($payment_status->payment_status) && $payment_status->payment_status == 2) { ?>

  <button id="down_payment" class="btn btn-default">
    {{ trans('messages.keyword_pay_down') }} 
  </button>
 
   <script type="text/javascript">
    $('.main_container').addClass('disabled');
    </script>
  <?php } ?>
</div>
            </div>
        
      </div>
    </div>

  </div>

<?php 
  $request = parse_url($_SERVER['REQUEST_URI']);
  $path = ($_SERVER['HTTP_HOST'] == 'localhost') ? rtrim(str_replace('/easylanganew/', '', $request["path"]), '/') : $request["path"]; 
  $result = rtrim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $path), '/');
  $result=trim($result,'/');
  $comic = DB::table('quiz_comic')->where('url', $result)->first();
  if(isset($comic)){
    $language_transalation = DB::table('language_transalation')->where('language_key', $comic->lang_key)->first();
  }
?>



  
</div>



<script>
      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // &lt;script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&amp;libraries=places"&gt;

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

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPyPHd-CTp9Nh_Jqe1NwJiX6WKQYpVEtI&amp;libraries=places&amp;callback=initMap" async="" defer=""></script>



<script>
$('#logo').change(function() {
  var i = $(this).prev('label').clone();
  var file = $('#logo')[0].files[0].name;
  $(this).prev('label').text(file);
});
</script>

  <!-- JQeury code required for STEP wizard -->

<script type="text/javascript">   
    $(".commodity_sector").select2({
  dropdownParent: $('#targeted')
});
</script>

<script>

  $("#firm").click(function(e){
    var quizid = $("#quizid").val();
    var seekString = "/quiz";
    currenrUrl = window.location.href;
    var idx = currenrUrl.indexOf(seekString);
    if (idx !== -1) {
      var url = currenrUrl.substring(0, idx + seekString.length);
    }
    var quizid = $("#quizid").val();
    currenrUrl = document.location = url+"/stepseven/"+quizid;
  });

  $("#down_payment").click(function(e){
    var quizid = $("#quizid").val();
    var seekString = "/quiz";
    currenrUrl = window.location.href;
    var idx = currenrUrl.indexOf(seekString);
    if (idx !== -1) {
      var url = currenrUrl.substring(0, idx + seekString.length);
    }
    var quizid = $("#quizid").val();
    currenrUrl = document.location = url+"/stepseven/"+quizid;
  });

   $('select[name="state"]').on('change', function() {

      var stateID = $(this).val();
      if(stateID) {

          $.ajax({
              url: '{{ url('/cities/') }}'+ '/' + stateID,
              type: "GET",
              dataType: "json",
              success:function(data) {
                  $('select[name="city"]').empty();
                   $('select[name="city"]').append('<option style="background-color:white" selected disabled>-- {{ trans('messages.keyword_selectcity') }} --</option>');
                  $.each(data, function(key, value) {
                      $('select[name="city"]').append('<option value="'+ key +'">'+ value +'</option>');
                  });
              }
          });

      }else{
          $('select[name="city"]').empty();
      }
  });

  function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $('#logopreview').html(' <div class="img-border-preview"> <img height="100" width="100" src="'+e.target.result+'"></div>');
    }
    reader.readAsDataURL(input.files[0]);
    }
  }

  $("#logo").change(function(){ 

    var ext = $(this).val().split('.').pop().toLowerCase();
    var filessize = this.files[0].size/1024/1024;/*MB*/  

    if($.inArray(ext, ['gif','png','jpg','jpeg','svg']) == -1 || (filessize > 2)) {      
      $(this).val("");      
      $("#span_logo").css("display", "block");    
      $("#span_logo").css("color", "red");
    }
    else {      
      $("#span_logo").html("");      
      readURL(this);  
    }
  });
   var phones = [{ "mask": "(###) ###-####"}, { "mask": "(###) ###-##############"}];
    $('#telefono').inputmask({ 
        mask: phones, 
        greedy: false, 
        definitions: { '#': { validator: "[0-9]", cardinality: 1}} });
		
   $(document).ready(function () {

   $('#nome_azienda').on('keyup',function(){

    var company_name = $("#nome_azienda").val(); 
	  var newvalue=$("#ref_name").val(); 
    var _token = $('input[name="_token"]').val();    
  	
		$.ajax({        
			type:'POST',
			data: { 'company_name': company_name, '_token' : _token },
			url: '{{ url('check/entity') }}',
			success:function(data) { 
	
				if(data == 'true'){                  
					$("#exist").css("display", "none");
					$("#confirm").css("display", "none");
					$("#ref_name").val(''); $("#vat").val('');
					$("#settore_merceologico").val('');                
					$("#pac-input").val(''); 
         			$("#telefono").val('');               
					$("#email").val('');   
				} else {
					$("#exist").css("display", "block");
					$("#exist").css("color", "red");
					$("#confirm").css("display", "block");
					$("#confirm").css("color", "blue");
					data=$.parseJSON(data);
					$("#ref_name").val(data.nomereferente);
					$("#settore_merceologico").val(data.settore);
					$("#vat").val(data.piva);
					$("#pac-input").val(data.indirizzo);
					$("#telefono").val(data.telefonoazienda);
					$("#email").val(data.email);             
				}                
			}
		});
	

    });

    $('#prev_stepone').click(function() {
      history.back();
    });

    $("#oldente").click(function(){
        
        var nome_azienda = $("#nome_azienda").val();
        var _token = $('input[name="_token"]').val();

        $.ajax({

          type:'POST',
          data: {
                  'nome_azienda': nome_azienda,
                  '_token' : _token
                },

          url: '{{ url('oldente') }}',
          success:function(data) {            
            // console.log(data);
            document.location = "steptwo/" + data;           
          }

        });

    });

    $("#newente").click(function(){
      
      var nome_azienda = $("#nome_azienda").val(); 
      var ref_name = $("#ref_name").val();
      var settore_merceologico = $("#settore_merceologico").val();
      var vat = $("#vat").val();
      var indirizzo = $("#pac-input").val();
      var telefono = $("#telefono").val(); 
      var email = $("#email").val();
      var _token = $('input[name="_token"]').val();

      $.ajax({
        type:'POST',
        data: {
                'nome_azienda': nome_azienda,
                'ref_name':ref_name,
                'settore_merceologico': settore_merceologico,
                'indirizzo': indirizzo,
                'vat': vat,
                'telefono':telefono,
                'email': email,
                '_token' : _token
              },
        url: '{{ url('newente') }}',

        success:function(data) {
          document.location = "steptwo/" + data;
        }

      });

    });  

    $("#step-one").click(function(e){
        
        var nome_azienda = document.getElementById("nome_azienda");        
        var ref_name = document.getElementById("ref_name");
        var settore_merceologico = document.getElementById("settore_merceologico");
        var indirizzo = document.getElementById("pac-input");
        /*var state = document.getElementById("state");
        var city = document.getElementById("city");*/
        var telefono = document.getElementById("telefono");
        var email = document.getElementById("email");
        var vat = document.getElementById("vat");                
        
        if (nome_azienda.value == '') {            
            document.getElementById("span_azienda").style.display = "inline-block";
            document.getElementById("span_azienda").style.color = "red"; 
            document.getElementById("span_referente").style.display = "none";
            document.getElementById("span_settore").style.display = "none";
            document.getElementById("span_vat").style.display = "none";
            document.getElementById("span_indirizzo").style.display = "none";
            //document.getElementById("span_state").style.display = "none";
            //document.getElementById("span_city").style.display = "none";
            document.getElementById("span_telefono").style.display = "none";
            document.getElementById("span_email").style.display = "none";
            nome_azienda.focus();        
            return false;

        } else if (ref_name.value == '') {
            document.getElementById("span_referente").style.display = "block";
            document.getElementById("span_referente").style.color = "red";
            document.getElementById("span_azienda").style.display = "none";
            document.getElementById("span_settore").style.display = "none";
            document.getElementById("span_vat").style.display = "none";
            document.getElementById("span_indirizzo").style.display = "none";
            //document.getElementById("span_state").style.display = "none";
            //document.getElementById("span_city").style.display = "none";
            document.getElementById("span_telefono").style.display = "none";
            document.getElementById("span_email").style.display = "none";
            ref_name.focus();
            return false;
        } else if (settore_merceologico.value == '') {           
            document.getElementById("span_settore").style.display = "block";
            document.getElementById("span_settore").style.color = "red";
            document.getElementById("span_referente").style.display = "none";
            document.getElementById("span_azienda").style.display = "none";
            document.getElementById("span_vat").style.display = "none";
            document.getElementById("span_indirizzo").style.display = "none";
            //document.getElementById("span_state").style.display = "none";
            //document.getElementById("span_city").style.display = "none";
            document.getElementById("span_telefono").style.display = "none";
            document.getElementById("span_email").style.display = "none";

            settore_merceologico.focus();
            return false;
        }  else if (vat.value == '') {
            document.getElementById("span_vat").style.display = "block";
            document.getElementById("span_vat").style.color = "red";
            document.getElementById("span_settore").style.display = "none";
            document.getElementById("span_referente").style.display = "none";
            document.getElementById("span_azienda").style.display = "none";
            document.getElementById("span_indirizzo").style.display = "none";
            //document.getElementById("span_state").style.display = "none";
            //document.getElementById("span_city").style.display = "none";
            document.getElementById("span_telefono").style.display = "none";
            document.getElementById("span_email").style.display = "none";
            vat.focus();
            return false;

        } else if (indirizzo.value == '') {
            document.getElementById("span_indirizzo").style.display = "block";
            document.getElementById("span_indirizzo").style.color = "red";
            document.getElementById("span_vat").style.display = "none";
            document.getElementById("span_settore").style.display = "none";
            document.getElementById("span_referente").style.display = "none";
            document.getElementById("span_azienda").style.display = "none";
            //document.getElementById("span_state").style.display = "none";
            //document.getElementById("span_city").style.display = "none";
            document.getElementById("span_telefono").style.display = "none";
            document.getElementById("span_email").style.display = "none";
            indirizzo.focus();
            return false;

       } /*else if (state.value == '') {
            document.getElementById("span_state").style.display = "block";
            document.getElementById("span_state").style.color = "red";
            document.getElementById("span_indirizzo").style.display = "none";
            document.getElementById("span_settore").style.display = "none";
            document.getElementById("span_vat").style.display = "none";
            document.getElementById("span_referente").style.display = "none";
            document.getElementById("span_azienda").style.display = "none";
            document.getElementById("span_city").style.display = "none";
            document.getElementById("span_telefono").style.display = "none";
            document.getElementById("span_email").style.display = "none";
            state.focus();
            return false;

        } else if (city.value == '' || city.value == '-- select city --') {
            document.getElementById("span_city").style.display = "block";
            document.getElementById("span_city").style.color = "red";
            document.getElementById("span_state").style.display = "none";
            document.getElementById("span_indirizzo").style.display = "none";
            document.getElementById("span_settore").style.display = "none";
            document.getElementById("span_vat").style.display = "none";
            document.getElementById("span_referente").style.display = "none";
            document.getElementById("span_azienda").style.display = "none";
            document.getElementById("span_telefono").style.display = "none";
            document.getElementById("span_email").style.display = "none";
            city.focus();
            return false;
        }*/ else if (telefono.value == '') {
            document.getElementById("span_telefono").style.display = "block";
            document.getElementById("span_telefono").style.color = "red";
            //document.getElementById("span_city").style.display = "none";
            document.getElementById("span_settore").style.display = "none";
            document.getElementById("span_referente").style.display = "none";
            document.getElementById("span_azienda").style.display = "none";
            document.getElementById("span_vat").style.display = "none";
            document.getElementById("span_indirizzo").style.display = "none";
            //document.getElementById("span_state").style.display = "none";
            //document.getElementById("span_city").style.color = "none";
            document.getElementById("span_email").style.display = "none";
            telefono.focus();           
            return false;
        } else if (email.value == '') {
            document.getElementById("span_email").style.display = "block";
            document.getElementById("span_email").style.color = "red";
            document.getElementById("span_telefono").style.display = "none";
            document.getElementById("span_settore").style.display = "none";
            document.getElementById("span_vat").style.display = "none";
            document.getElementById("span_referente").style.display = "none";
            document.getElementById("span_azienda").style.display = "none";
            document.getElementById("span_indirizzo").style.display = "none";
            //document.getElementById("span_state").style.display = "none";
            //document.getElementById("span_city").style.display = "none";
            document.getElementById("span_telefono").style.display = "none";
            email.focus();         
            return false;
        } else {
          document.getElementById("span_email").style.display = "none";
        }

        var mob = /^[1-9]{1}[0-9]{9}$/;
        /*if (mob.test(telefono.value) == false) {
            alert("{{ trans('messages.keyword_mobile_number_range') }} ");
            telefono.focus();
            return false;
        }*/
        
        var email = email.value;
        var atpos = email.indexOf("@");
        var dotpos = email.lastIndexOf(".");
        if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length){
          alert(" {{ trans('messages.keyword_valid_email_required') }} ");
          email.focus();
          return false;
        } 

          e.preventDefault();
          var nome_azienda = $("#nome_azienda").val(); 
          var ref_name = $("#ref_name").val();
          var settore_merceologico = $("#settore_merceologico").val();
          var vat = $("#vat").val();
          var indirizzo = $("#pac-input").val(); 
          var state = $("#state").val(); 
          var city = $("#city").val(); 
          var telefono = $("#telefono").val(); 
          var email = $("#email").val();
          // var logo = $("#logo").val();
         // var file =  $('#logo').val().split('\\').pop();          
          var _token = $('input[name="_token"]').val();

          //var formData = new FormData(this);
          var formdata = new FormData($("#step_one")[0]);

          //var file = $('#logo').files[0];
          //formdata.append("image", file);          
          formdata.append("_token", _token);
          formdata.append("indirizzo", indirizzo);                              
          //console.log(formData);

          $.ajax({
            type:'POST',
            data: {'_token': '{{ csrf_token() }}', 'nome_azienda':nome_azienda },
            url: '{{ url('stepone/checkpayment') }}',
            success:function(data) {
              console.log(data);
              if(data == 1) {
                  $("#firm").css("display", "block");
              }
              if(data == 2){
                  $("#down_payment").css("display", "block");
              }
            }
          });
     
          $.ajax({            
            url: '{{ url('storeStepone') }}',
            type:'POST',
            data: formdata,
            processData: false,
            contentType: false,
            /*data: {
                    'nome_azienda': nome_azienda,
                    'ref_name':ref_name,
                    'settore_merceologico': settore_merceologico,
                    'vat': vat,
                    'indirizzo': indirizzo,
                    'state': state,
                    'city': city,
                    'telefono':telefono,
                    'email': email,
                    'filename': file,
                    '_token' : _token,
                    // formData,
                  },
            // contentType:false,
            // cache: false,
            // processData:false,*/              
            success:function(data) {                        
               if(data == 'false') {                  
                  $("#exist").css("display", "block");
                  $("#exist").css("color", "red");
                  $("#confirm").css("display", "block");
                  $("#confirm").css("color", "blue");
               } else {       
                  //alert(data);
                  console.log(data);                   
                  document.location = "steptwo/" + data;               
               }             
            }
        });

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

    //Initialize tooltips
    $('.nav-tabs > li a[title]').tooltip();
    
    //Wizard
    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

        var $target = $(e.target);
    
        if ($target.parent().hasClass('disabled')) {
            return false;
        }
    });

    $(".next-step").click(function (e) {

        var $active = $('.wizard .nav-tabs li.active');
        $active.next().removeClass('disabled');
        nextTab($active);

    });
    $(".prev-step").click(function (e) {

        var $active = $('.wizard .nav-tabs li.active');
        prevTab($active);

    });
});

function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
}
  
  </script>




@endsection