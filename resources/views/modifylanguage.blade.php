@extends('adminHome')
@section('page')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript" src="{{asset('public/scripts/colors.js')}}"></script>
<script type="text/javascript" src="{{asset('public/scripts/jqColorPicker.min.js')}}"></script>
<script type="text/javascript">
     $('.color').colorPicker();
</script>

<script type="text/javascript">
 
 $(document).ready(function() {
  $("#dipartimento").change(function(){
    if( $(this).val() == 1) {
        $("#sconto_section").hide();       
        $("#rendita").hide();
        $("#rendita_reseller").hide();
        $("#zone").hide();
    } else if( $(this).val() == 3) {
        $("#sconto_section").hide();    
        $("#rendita").hide();
        $("#rendita_reseller").hide();
        $("#zone").hide();
    } else if( $(this).val() == 4) {
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
    <script type="text/javascript">
        $(document).on("click", "#profilazioneinterna", function () {
            
            if ($(this).is(":unchecked")) {
                $("#rendita").show();
            } else {
                $("#rendita").hide();
            }
        });
    </script>
@include('common.errors')
  <h1>Modifica language</h1><hr>
  <?php 
  if(isset($language) && !empty($language)){
  	echo Form::open(array('url' => '/admin/update/language' . "/$language->id", 'files' => true, 'id' => 'frmLanguage'));
  }
  else {
   	echo Form::open(array('url' => '/admin/update/language', 'files' => true, 'id' => 'frmLanguage'));
  }
   ?>
    {{ csrf_field() }}
    <!-- colonna a sinistra -->
    <div class="row">
   <div class="col-md-5">
   <div class="form-group">
    <label for="name">{{trans('messages.keyword_name')}} <span class="required">(*)</span></label>
    <input type="hidden" name="language_id" value="{{ isset($language->id) ? $language->id : '' }}">
    <input value="{{ isset($language->name) ? $language->name : old('name') }}" class="form-control" maxlength="50" type="text" name="name" id="name" placeholder="{{trans('messages.keyword_name')}}">
    </div>
    <div class="form-group">
    <label for="colore">{{trans('messages.keyword_original_name')}}</label>
    <input value="{{isset($language->original_name) ? $language->original_name : old('original_name')}}" maxlength="50" class="form-control no-alpha" type="text" name="original_name" id="original_name" placeholder="{{trans('messages.keyword_original_name')}}">
	</div>
    </div>
     <div class="col-md-5">
     <div class="form-group">
    <label for="name">{{trans('messages.keyword_code')}} <span class="required">(*)</span></label>
    <input value="{{ isset($language->code) ? $language->code : old('code') }}" class="form-control" maxlength="3" type="text" name="code" id="code" placeholder="{{trans('messages.keyword_code')}}">
    </div>
    <div class="form-group">
    <label for="colore">{{trans('messages.keyword_icon')}}</label>
    <?php echo Form::file('icon', ['class' => 'form-control']); ?>
    </div>
    </div>
     <div class="col-md-2">
      <label> &nbsp; </label>
     <div class="form-group form-inline chkselect">
        <input type="checkbox" name="is_default" id="is_default" value="1" <?php if(isset($language->is_default) && $language->is_default == '1'){ echo 'checked';} ?> class="form-control no-alpha" />
        <label for="is_default">{{trans('messages.keyword_is_default')}}?</label>
     </div>
     </div>
    <!-- colonna centrale -->

<script type="text/javascript">  
  $('.reading').click(function () {    
       // $('#sublettura').prop('checked', this.checked); 
        var $id = $(this).attr('id');
        $('.'+$id).prop('checked', this.checked);
   });
  $('.writing').click(function () {    
       var $id = $(this).attr('id');
        $('.'+$id).prop('checked', this.checked);
   });
   $(document).ready(function() {

        // validate signup form on keyup and submit
        $("#frmLanguage").validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 50
                },
                code: {
                    required: true,
					minlength : 2,
                    maxlength: 3
                }
            },
            messages: {
                name: {
                    required: "{{trans('mesages.keyword_please_enter_a_language_name')}}",
                    maxlength: "{{trans('messages.keyword_language_name_less_than_50_characters')}}"
                },
                code: {
                    required: "{{trans('messages.keyword_please_enter_a_code')}}",
					minlength : "{{trans('messages.keyword_code_must_2_characters_long')}}",
                    maxlength: "{{trans('messages.keyword_code_must_3_characters_long')}}"
                }
            }
        });
        $.validator.setDefaults({
        	ignore: []
    	});
   });

</script>
	<div class="col-md-12">
    <div class="space10"></div>
		<button type="submit" class="btn btn-warning">Salva</button>
    {!! link_to(URL::previous(), 'Cancel', ['class' => 'btn btn-danger']) !!}
    <div class="space30"></div>
	</div>
    <?php echo Form::close(); ?>  
<script>
$('.ciao').on("click", function() {
    $(this).children()[0].click();
});
</script>
<script type="text/javascript" src="{{asset('public/scripts/index.js')}}">
@endsection