@extends('adminHome')
@section('page')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<h1>{{trans('messages.keyword_optional_edit')}}</h1>
<hr>
@if(!empty(Session::get('msg')))
<script>
var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
document.write(msg);
</script>
@endif
@include('common.errors')
<?php echo Form::open(array('url' => '/admin/taxonomies/update/optional/' . $optional->id, 'files' => true, 'id' => 'frmoptional')) ?>
{{ csrf_field() }}

<div class="row">
  <div class="col-md-6"> <img src="{{ asset('storage/app/images/'.$optional->icon) }}" class="option-image"></img>
    <h1 class="option-heading"> {{trans("messages.keyword_code")}}: {{$optional->id}}</h1>
  </div>
  <div class="col-md-6 text-right top-quiz">
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
  </div>
</div>
<hr>
<div class="col-md-4">
	<div class="form-group">
    <label for="code">{{trans('messages.keyword_short_name')}} <span class="required">(*)</span></label>
    <input value="{{ $optional->code }}" class="form-control" type="text" name="code" id="code" placeholder="{{trans('messages.keyword_short_name')}}">
    </div>
    <div class="row">
        <div class="col-md-6">
        	<div class="form-group"><label for="logo">{{trans('messages.keyword_logo')}}</label>
	        <?php echo Form::file('logo', ['class' => 'form-control']); ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group"><label for="immagine">{{trans("messages.keyword_image")}}</label>
            <?php echo Form::file('immagine', ['class' => 'form-control']); ?>
            </div>
        </div>
    </div>
    <div class="form-group">
    <label for="frequeny">{{trans('messages.keyword_frequency')}} <span class="required">(*)</span></label>
    <select name="frequenza" class="form-control">
        @foreach($frequenze as $frequenza)
        @if($frequenza->id == $optional->frequenza)
        <option selected value="{{$frequenza->id}}">{{$frequenza->rinnovo.' Days'}}</option>
        @else
        <option value="{{$frequenza->id}}">{{$frequenza->rinnovo.' Days'}}</option>
        @endif
        @endforeach
    </select>
    </div>
</div>
<!-- colonna centrale -->
<div class="col-md-4">
	<div class="form-group">
    <label for="description">{{trans("messages.keyword_description")}} </label>
    <textarea class="form-control" name="description" id="description" rows="5" placeholder="Descrizione">{{ $optional->description }}</textarea>
    </div>
    <div class="row">
        <div class="col-md-6">
           <div class="form-group"> <label for="price">{{trans('messages.keyword_base_price_list')}} (€)</label>
            <input value="{{ $optional->price }}" class="form-control" type="text" name="price" id="price" placeholder="Prezzo listino base"></div>
        </div>
        <div class="col-md-6">
           <div class="form-group"> <label for="price">{{trans("messages.keyword_discount_reseller_discount")}} (%)</label>
            <input value="{{ $optional->sconto_reseller }}" class="form-control" type="text" name="sconto_reseller" id="sconto_reseller" placeholder="{{trans("messages.keyword_discount_reseller_discount")}}">	</div>
        </div>
    </div>
<?php /* <label for="label">Nome <p style="color:#f37f0d;display:inline">(*)</p></label>
  <input value="{{ $optional->label }}" class="form-control" type="text" name="label" id="label" placeholder="Nome"><br> */ ?>

</div>

<div class="col-md-4">
	<div class="form-group">
    <label for="description">{{trans('messages.keyword_description_quiz')}} </label>
    <textarea class="form-control" name="description_quize" id="description_quize" rows="5" placeholder="{{trans('messages.keyword_description_quiz')}}">{{ $optional->description_quize }}</textarea>
    </div>
    
    <div class="row">
    <div class="col-md-6">
    	<div class="form-group">
        <label for="dipartimento">{{trans("messages.keyword_department")}} <span class="required">(*)</span></label>
        <select name="dipartimento" class="form-control">      
            @foreach($dipartimenti as $dipartimento)
            @if($dipartimento->id == $optional->dipartimento)
            <option selected value="{{$dipartimento->id}}">{{ ucwords(strtolower($dipartimento->nomedipartimento)) }}</option>
            @else
            <option value="{{$dipartimento->id}}">{{ ucwords(strtolower($dipartimento->nomedipartimento)) }}</option>
            @endif
            @endforeach
        </select>
        </div>
    </div>
    <div class="col-md-6">
    	<div class="form-group">
        <label for="processing">{{trans('messages.keyword_processing')}} </label>
        <select name="lavorazione" class="form-control">
            <option value="0">Seleziona Lavorazione</option>
            @foreach($lavorazioni as $lavorazioni)
            @if($lavorazioni->id == $optional->lavorazione)
            <option selected value="{{$lavorazioni->id}}">{{ ucwords(strtolower($lavorazioni->nome)) }}</option>
            @else
            <option value="{{$lavorazioni->id}}">{{ ucwords(strtolower($lavorazioni->nome)) }}</option>
            @endif
            @endforeach
        </select>
        </div>
    </div>
    </div>
</div>
<div class="col-xs-12">
  <button type="submit" class="btn btn-warning">{{trans('messages.keyword_save')}}</button>
  <div class="space40"></div>
</div>
<div class="footer-svg">
    <img src="{{asset('images/ADMIN_TASSONOMIE-footer.svg')}}" alt="tassonomie">
</div>
<?php echo Form::close(); ?>  
<script>
    $(document).ready(function () {
        $.validator.addMethod('filesize', function (value, element, param) {
            var size = (element.files[0].size / 1024 / 1024).toFixed(2);
            return this.optional(element) || (size <= param)
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
                    filesize: "<?php echo trans("messages.keyword_file_size_less_than_2_mb") ?>"

                },
                immagine: {
                    filesize: "<?php echo trans("messages.keyword_file_size_less_than_2_mb") ?>"

                }

            }
        });
    });
</script>
@endsection