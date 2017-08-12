@extends('adminHome')
@section('page')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<h1>{{trans('messages.keyword_add_optional')}}</h1><hr>
@if(!empty(Session::get('msg')))
<script>
var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
document.write(msg);
</script>
@endif
@include('common.errors')
<?php echo Form::open(array('url' => '/admin/taxonomies/optional/store', 'files' => true, 'id' => 'frmoptional')) ?>
{{ csrf_field() }}
<div class="row addoptional">
<div class="col-md-12 text-right">
    <div class="quiz-check"> <span>{{trans("messages.keyword_classic")}}?</span>
      <div class="switch">
        <input value="1" <?php if(isset($optional->is_classic) && $optional->is_classic=='1'){ echo 'checked';}?> class="" type="checkbox" name="classic" id="classic">
        <label for="classic"></label>
      </div>&nbsp;

      <span>{{trans("messages.keyword_quiz")}}?</span>
      <div class="switch">
        <input value="1" <?php if(isset($optional->escludi_da_quiz) && $optional->escludi_da_quiz=='1'){ echo 'checked';}?> class="" type="checkbox" name="escludi_da_quiz" id="escludi_da_quiz">
        <label for="escludi_da_quiz"></label>
      </div>
      <!-- <input value="1" <?php //if(isset($optional->escludi_da_quiz) && $optional->escludi_da_quiz=='1'){ echo 'checked';}?> class="" type="checkbox" name="escludi_da_quiz" id="escludi_da_quiz">--> 
    </div>
  </div><br><br>
<?php /*<div class="col-md-12 text-right">
    <div class="quiz-check">
       <span>{{trans("messages.keyword_exclude_from_quiz?_(even)")}}</span><div class="switch"><input value="1" <?php if(isset($optional->escludi_da_quiz) && $optional->escludi_da_quiz=='1'){ echo 'checked';}?> class="" type="checkbox" name="escludi_da_quiz" id="escludi_da_quiz"><label for="escludi_da_quiz"></label></div>
    </div>
    </div>*/?>
<div class="col-md-4 col-sm-12 col-xs-12">
    <label for="code">{{trans('messages.keyword_short_name')}}<span class="required">(*)</span></label>
    <input value="{{ old('code') }}" class="form-control" type="text" name="code" id="code" placeholder="{{trans('messages.keyword_short_name')}}"><br>
     <label for="frequeny">{{trans('messages.keyword_frequency')}} <span class="required">(*)</span></label>
    <select name="frequenza" class="form-control">
        @foreach($frequenze as $frequenza)
        @if($frequenza->id == old('code'))
        <option selected value="{{$frequenza->id}}">{{$frequenza->rinnovo.' Days'}}</option>
        @else
        <option value="{{$frequenza->id}}">{{$frequenza->rinnovo.' Days'}}</option>
        @endif
        @endforeach
    </select><br>
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <label for="logo">{{trans('messages.keyword_logo')}}</label>
            <?php echo Form::file('logo', ['class' => 'form-control','id'=>'logo']); ?>
             <label for="logo" generated="true" class="error none" id="logo_validatio_msg"></label>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12">
            <label for="immagine">{{trans("messages.keyword_image")}}</label>
            <?php echo Form::file('immagine', ['class' => 'form-control','id'=>'immagine']); ?>
            <label for="immagine" generated="true" class="error none" id="immagine_validatio_msg"></label>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12">
             <div class="form-group logopreview" id="logopreview"> 
                <div class="img-border-preview" style="<?php echo (isset($optional->icon)) ? 'display:block' :'display:none';?>"><?php if(isset($optional->icon)) { ?> <img src="{{url('/storage/app/images/').'/'.$optional->icon}}" height="100" width="100" class="img-responsive" ><?php } ?>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12">
             <div class="form-group logopreview" id="immaginepreview"> 
                <div class="img-border-preview" style="<?php echo (isset($optional->immagine)) ? 'display:block' :'display:none';?>"><?php if(isset($optional->immagine)) { ?> <img src="{{url('/storage/app/images/').'/'.$optional->immagine}}" height="100" width="100" class="img-responsive" ><?php } ?>
                </div>
            </div>
        </div>
    </div>
   <br>
</div>	
<!-- colonna centrale -->
<div class="col-md-4 col-sm-12 col-xs-12">
    <label for="description">{{trans("messages.keyword_description")}} </label>
    <textarea class="form-control" name="description" id="description" rows="5" placeholder="{{trans("messages.keyword_description")}} ">{{ old('description') }}</textarea><br />
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <label for="price">{{trans('messages.keyword_base_price_list')}} (€)</label>
            <input value="{{ old('price') }}" class="form-control" type="text" name="price" id="price" placeholder="{{trans('messages.keyword_base_price_list')}}">
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12">
            <label for="price">{{trans("messages.keyword_discount_reseller_discount")}} (%)</label>
            <input value="{{ old('sconto_reseller') }}" class="form-control" type="text" name="sconto_reseller" id="sconto_reseller" placeholder="{{trans("messages.keyword_discount_reseller_discount")}}">
        </div>
    </div>
<?php /* <label for="label">Nome <p style="color:#f37f0d;display:inline">(*)</p></label>
  <input value="{{ $optional->label }}" class="form-control" type="text" name="label" id="label" placeholder="Nome"><br> */ ?>         
</div>
<div class="col-md-4 col-sm-12 col-xs-12">
    <label for="description">{{trans('messages.keyword_description_quiz')}} </label>
    <textarea class="form-control" name="description_quize" id="description_quize" rows="5" placeholder="{{trans('messages.keyword_description_quiz')}}">{{ old('description_quize') }}</textarea><br />
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <label for="department">{{trans("messages.keyword_department")}} <span class="required">(*)</span></label>
            <select name="department" class="form-control">      
                @foreach($dipartimenti as $dipartimento)
                @if($dipartimento->id == old('dipartimento'))
                <option selected value="{{$dipartimento->id}}">{{ ucwords(strtolower($dipartimento->nomedipartimento)) }}</option>
                @else
                <option value="{{$dipartimento->id}}">{{ ucwords(strtolower($dipartimento->nomedipartimento)) }}</option>
                @endif
                @endforeach
            </select>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12">
            <label for="processing">{{trans('messages.keyword_processing')}} </label>
            <select name="lavorazione" class="form-control">
                <option value="0">{{trans('messages.keyword_select_processing')}}</option>
                @foreach($lavorazioni as $lavorazioni)
                @if($lavorazioni->id == old('lavorazione'))
                <option selected value="{{$lavorazioni->id}}">{{ ucwords(strtolower($lavorazioni->nome)) }}</option>
                @else
                <option value="{{$lavorazioni->id}}">{{ ucwords(strtolower($lavorazioni->nome)) }}</option>
                @endif
                @endforeach
            </select>
        </div>
    </div>
</div>	
<div class="col-xs-12 col-sm-12 col-xs-12">     
    <button type="submit" class="btn btn-warning">{{trans('messages.keyword_save')}}</button>
</div>
</div>

<div class="footer-svg">
    <img src="{{asset('images/ADMIN_TASSONOMIE-footer.svg')}}" alt="tassonomie">
</div>
<?php echo Form::close(); ?>  
<script>
    $(document).ready(function () {
        $.validator.addMethod('filesize', function (value, element, param) {
            return this.optional(element) || ((element.files[0].size / 1024 / 1024).toFixed(2) <= param)
        }, '<?php echo trans("messages.keyword_file_size_must_be_less_than_{0}") ?>');

        // validate signup form on keyup and submit
        $("#frmoptional").validate({
            rules: {
                code: {
                    required: true,
                    maxlength: 35
                },
                frequenza: {
                    required: true
                },
                dipartimento: {
                    required: true
                },
                logo: {
                    filesize: 2
                },
                immagine: {
                    filesize: 2
                }
            },
            messages: {
                code: {
                    required: "<?php echo trans("messages.keyword_enter_a_short_name") ?>",
                    maxlength: "<?php echo trans("messages.keyword_statements_less_then_35") ?>"

                },
                frequenza: {
                    required: "<?php echo trans("messages.keyword_select_a_frequency") ?>"
                },
                dipartimento: {
                    required: "<?php echo trans("messages.keyword_select_a_department") ?>"

                },
                logo: {
                    filesize: "<?php echo trans("messages.keyword_file_size_less_than_2_mb")?>"
                    
                },
                immagine: {
                    filesize: "<?php echo trans("messages.keyword_file_size_less_than_2_mb") ?>"
                    
                }
            }
        });
    });
    function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#logopreview').html(' <div class="img-border-preview" style="display:block;"> <img height="100" width="100" src="'+e.target.result+'"></div>');
            /*$('#logopreview').attr('src', e.target.result);*/
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$("#logo").change(function(){ 
    var ext = $(this).val().split('.').pop().toLowerCase();
    var filessize = this.files[0].size/1024/1024;/*MB*/     
    if(($.inArray(ext, ['gif','png','jpg','jpeg','svg']) == -1) || (filessize > 2)) {
        $(this).val("");
        $("#logo_validatio_msg").show();
        $("#logo_validatio_msg").html("{{ trans('messages.keyword_please_upload_a_valid__image') }}");      
    }
    else {
        $("#logo_validatio_msg").html("");      
        readURL(this);  
    }
});


function readURLimage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#immaginepreview').html(' <div class="img-border-preview" style="display:block;"> <img height="100" width="100" src="'+e.target.result+'"></div>');
            /*$('#logopreview').attr('src', e.target.result);*/
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$("#immagine").change(function() { 
    var ext = $(this).val().split('.').pop().toLowerCase();
    var filessize = this.files[0].size/1024/1024;/*MB*/     
    if(($.inArray(ext, ['gif','png','jpg','jpeg','svg']) == -1) || (filessize > 2)) {
        $(this).val("");
        $("#immagine_validatio_msg").show();
        $("#immagine_validatio_msg").html("{{ trans('messages.keyword_please_upload_a_valid__image') }}");      
    }
    else {
        $("#immagine_validatio_msg").html("");      
        readURLimage(this);  
    }
});

</script>

@endsection