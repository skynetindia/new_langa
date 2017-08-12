@extends('adminHome')
@section('page')
@include('common.errors')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript" src="{{asset('public/scripts/colors.js')}}"></script>
<script type="text/javascript" src="{{asset('public/scripts/jqColorPicker.min.js')}}"></script>
<script type="text/javascript">
     $('.color').colorPicker();
</script>
<script type="text/javascript"> 
 $(document).ready(function() {
  $("#dipartimento").change(function(){
    if( $(this).val() == 'AMMINISTRAZIONE') {
        $("#sconto_section").hide();       
        $("#rendita").hide();
        $("#rendita_reseller").hide();
        $("#zone").hide();
    } else if( $(this).val() == 'TECNICO') {
        $("#sconto_section").hide();    
        $("#rendita").hide();
        $("#rendita_reseller").hide();
        $("#zone").hide();
    } else if( $(this).val() == 'RESELLER') {
        $("#sconto_section").show();      
        $("#rendita").show();
        $("#rendita_reseller").hide();
        $("#zone").show();
    } else {
      $("#sconto_section").show(); 
      $("#rendita").show();
      $("#rendita_reseller").show();
      $("#zone").show();
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
@include('common.errors')   
  <h1><?php echo (isset($action) && $action == 'add') ? trans('messages.keyword_add_package') : trans('messages.keyword_editpack');?></h1><hr><?php 
  /*if(isset($pacchetto[0]->id)){*/
  if(isset($pacchetto_data[0]->id)){
	$id= $pacchetto_data[0]->id;
  	echo Form::open(array('url' => '/admin/save/quizpackage' . "/$id", 'files' => true, 'id' => 'package_modification')); 
  }
  else {
	  echo Form::open(array('url' => '/admin/save/quizpackage', 'files' => true, 'id' => 'package_modification')); 
  }
  ?>
    {{ csrf_field() }}
    <!-- colonna a sinistra -->  
   <div class="col-md-6">
    <div class="form-group">
      <label for="name">{{trans('messages.keyword_package_name')}} <span class="required">(*)</span></label>
      <input value="{{ isset($pacchetto_data[0]->nome_pacchetto) ? $pacchetto_data[0]->nome_pacchetto : "" }}" class="form-control" type="text" name="nome_pacchetto" id="nome_pacchetto" placeholder="{{trans('messages.keyword_package_name')}}">
    </div>  
    <div class="form-group">                
      <label for="colore">{{trans('messages.keyword_total_pages')}} <p style="color:#f37f0d;display:inline">(*)</p></label>
      <input value="{{ isset($pacchetto_data[0]->pagine_totali) ? $pacchetto_data[0]->pagine_totali : ""}}" class="form-control no-alpha" type="text" name="pagine_totali" id="pagine_totali" placeholder="{{trans('messages.keyword_total_pages')}}"><br>    
    </div>
    </div>
    <!-- colonna centrale -->
      <div class="col-md-6">           
          <div class="form-group">
            <label for="colore">{{trans('messages.keyword_package_price')}}<p style="color:#f37f0d;display:inline">(*)</p></label>
 	   <input value="{{ isset($pacchetto_data[0]->prezzo_pacchetto) ? $pacchetto_data[0]->prezzo_pacchetto : ""}}" class="form-control no-alpha" type="text" name="prezzo_pacchetto" id="prezzo_pacchetto" placeholder="{{trans('messages.keyword_package_price')}}">
     </div>     
    <div class="form-group">      
 	     <label for="email">{{trans('messages.keyword_per_price_page')}} </label><p style="color:#f37f0d;display:inline"> (*) </p></label>
    	  <input value="{{isset($pacchetto_data[0]->per_pagina_prezzo) ? $pacchetto_data[0]->per_pagina_prezzo : ""}}" class="form-control no-alpha" type="text" name="per_pagina_prezzo" id="per_pagina_prezzo" placeholder="{{trans('messages.keyword_per_price_page')}}">
       </div>
      </div>
    <!-- colonna a destra -->    
	 <div class="col-md-12">
		<button type="submit" class="btn btn-warning">{{trans('messages.keyword_save')}}</button>
    <div class="space50"> </div>
	</div>
  <div class="footer-svg">
    <img src="{{asset('images/ADMIN_TASSONOMIE-footer.svg')}}" alt="tassonomie">
  </div>
    <?php echo Form::close(); ?>  
<script>
$('.ciao').on("click", function() {
    $(this).children()[0].click();
});
$(document).ready(function() {
        // validate signup form on keyup and submit
        $("#package_modification").validate({
            rules: {
                nome_pacchetto: {
                    required: true,
                    maxlength: 35
                },
                pagine_totali: {
					         required: true,
                   digits:true                    
                },
                prezzo_pacchetto: {
                    required: true,                    
                    maxlength: 10,
                    number:true
                },
                per_pagina_prezzo: {
                    required: true,   
                    maxlength: 10,
                    number:true                 
                }
            },
            messages: {
                nome_pacchetto: {
                    required: "<?php echo trans('messages.keyword_enter_the_package_name');?>",
                    maxlength: "<?php echo trans('messages.keyword_the_package_name_must_be_less_than_35_characters');?>"
                },
                pagine_totali: {
					         required: "<?php echo trans('messages.keyword_enter_total_pages');?>",
                   digits:"<?php echo trans('messages.keyword_please_enter_valid_pages')?>"                    
                },
                prezzo_pacchetto: {
                    required: "<?php echo trans('messages.keyword_enter_the_price_of_the_package');?>",                    
                    maxlength: "<?php echo trans('messages.keyword_the_price_must_be_less_than_10_characters');?>",
                    number:"<?php echo trans('messages.keyword_please_enter_valid_price')?>"
                },
                per_pagina_prezzo: {
                    required: "<?php echo trans('messages.keyword_enter_the_price_per_page');?>",   
                    maxlength: "<?php echo trans('messages.keyword_the_price_per_page_must_be_less_than_10_characters');?>",
                    number:"<?php echo trans('messages.keyword_please_enter_valid_price')?>"                 
                }
            }
        });
	  });
</script>
<script type="text/javascript" src="{{asset('public/scripts/index.js')}}">
@endsection