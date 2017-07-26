@extends('layouts.app')

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<h1>{{trans('messages.keyword_optional_edit')}}</h1><hr>
<style>
    table tr td {
        text-align:left;

    }
    .table-editable {
        position: relative;
    }
    .table-editable .glyphicon {
        font-size: 20px;
    }

    .table-remove {
        color: #700;
        cursor: pointer;
    }
    .table-remove:hover {
        color: #f00;
    }

    .table-up, .table-down {
        color: #007;
        cursor: pointer;
    }
    .table-up:hover, .table-down:hover {
        color: #00f;
    }

    .table-add {
        color: #070;
        cursor: pointer;
        position: absolute;
        top: 8px;
        right: 0;
    }
    .table-add:hover {
        color: #0b0;
    }

    #map {
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
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
    }

    #pac-input:focus {
        border-color: #4d90fe;
    }

    .pac-container {
        font-family: Roboto;
    }

    #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
    }

    #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
    }
</style>
@if(!empty(Session::get('msg')))
<script>
var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
document.write(msg);
</script>
@endif
@include('common.errors')
<?php echo Form::open(array('url' => '/admin/taxonomies/update/optional/' . $optional->id, 'files' => true, 'id' => 'frmoptional')) ?>
{{ csrf_field() }}

<div class="container-fluid col-md-12">
    <div style="display:inline">
        <img src="{{url('/storage/app/images/').'/'.$optional->icon}}" style="max-width:100px; max-height:100px;display:inline"></img><h1 style="display:inline">  {{trans("messages.keyword_code")}}: {{$optional->id}}</h1>
        <div class="pull-right">
            {{trans("messages.keyword_exclude_from_quiz?_(even)")}} <input value="1" <?php if (isset($optional->escludi_da_quiz) && $optional->escludi_da_quiz == '1') {
    echo 'checked';
} ?> class="" type="checkbox" name="escludi_da_quiz" id="escludi_da_quiz">
        </div><hr>
    </div>

</div>

<div class="col-md-4">
    <label for="code">{{trans('messages.keyword_short_name')}} <p style="color:#f37f0d;display:inline">(*)</p></label>
    <input value="{{ $optional->code }}" class="form-control" type="text" name="code" id="code" placeholder="{{trans('messages.keyword_short_name')}}"><br>
    <label for="logo">{{trans('messages.keyword_logo')}}</label>
    <?php echo Form::file('logo', ['class' => 'form-control']); ?>
    <label for="immagine">{{trans("messages.keyword_image")}}</label>
<?php echo Form::file('immagine', ['class' => 'form-control']); ?><br>
    <label for="frequeny">{{trans('messages.keyword_frequency')}} <p style="color:#f37f0d;display:inline">(*)</p></label>
    <select name="frequenza" class="form-control">
        @foreach($frequenze as $frequenza)
        @if($frequenza->id == $optional->frequenza)
        <option selected value="{{$frequenza->id}}">{{$frequenza->nome}}</option>
        @else
        <option value="{{$frequenza->id}}">{{$frequenza->nome}}</option>
        @endif
        @endforeach
    </select><br>
</div>
<!-- colonna centrale -->
<div class="col-md-4">
    <label for="description">{{trans("messages.keyword_description")}} </label>
    <textarea class="form-control" name="description" id="description" rows="5" placeholder="Descrizione">{{ $optional->description }}</textarea><br />

    <label for="price">{{trans('messages.keyword_base_price_list')}} (€)</label>
    <input value="{{ $optional->price }}" class="form-control" type="text" name="price" id="price" placeholder="Prezzo listino base"><br>
    <label for="price">{{trans("messages.keyword_discount_reseller_discount")}} (%)</label>
    <input value="{{ $optional->sconto_reseller }}" class="form-control" type="text" name="sconto_reseller" id="sconto_reseller" placeholder="{{trans("messages.keyword_discount_reseller_discount")}}"><br>
<?php /* <label for="label">Nome <p style="color:#f37f0d;display:inline">(*)</p></label>
  <input value="{{ $optional->label }}" class="form-control" type="text" name="label" id="label" placeholder="Nome"><br> */ ?>

</div>

<div class="col-md-4">
    <label for="description">{{trans('messages.keyword_description_quiz')}} </label>
    <textarea class="form-control" name="description_quize" id="description_quize" rows="5" placeholder="{{trans('messages.keyword_description_quiz')}}">{{ $optional->description_quize }}</textarea><br />
    <label for="dipartimento">{{trans("messages.keyword_department")}} <p style="color:#f37f0d;display:inline">(*)</p></label>
    <select name="dipartimento" class="form-control">      
        @foreach($dipartimenti as $dipartimento)
        @if($dipartimento->id == $optional->dipartimento)
        <option selected value="{{$dipartimento->id}}">{{$dipartimento->nomedipartimento}}</option>
        @else
        <option value="{{$dipartimento->id}}">{{$dipartimento->nomedipartimento}}</option>
        @endif
        @endforeach
    </select>
    <label for="processing">{{trans('messages.keyword_processing')}} </label>
    <select name="lavorazione" class="form-control">
        <option value="0">Seleziona Lavorazione</option>
        @foreach($lavorazioni as $lavorazioni)
        @if($lavorazioni->id == $optional->lavorazione)
        <option selected value="{{$lavorazioni->id}}">{{$lavorazioni->nome}}</option>
        @else
        <option value="{{$lavorazioni->id}}">{{$lavorazioni->nome}}</option>
        @endif
        @endforeach
    </select><br>
</div>
<div class="col-xs-6" style="padding-top:10px;padding-bottom:10px;">		
    <button type="submit" class="btn btn-primary">{{trans('messages.keyword_save')}}</button>
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