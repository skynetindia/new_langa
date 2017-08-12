@extends('layouts.app')
@section('content')

<h1> {{ trans('messages.keyword_edit_cost') }}:  <strong> {{ $costo->oggetto }} </strong></h1>

@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif



<div class="row">
<div class="col-md-12"><button class="btn btn-info btn-lg" onclick="window.close();"> {{ trans('messages.keyword_back_to_statistics') }} </button></div>
<div class="col-md-12"><div class="height7"></div></div>
<div class="col-md-6">
    <form action="{{url('/costo/aggiorna') . '/' . $costo->id}}" method="post" name="cost" id="cost">
        {{ csrf_field() }}
             
             <div class="form-group">
             	<label>{{ trans('messages.keyword_object') }} : <span class="required">(*)</span> </label><input type="text" name="oggetto" value="{{$costo->oggetto}}" class="form-control"> 
             </div>
             <div class="form-group">
             	<label>{{ trans('messages.keyword_cost') }} : <span class="required">(*)</span></label> <input type="text" name="costo" value="{{$costo->costo}}" class="form-control">
             </div>
             <div class="form-group">
             	<label>{{ trans('messages.keyword_insertion_date') }} : <span class="required">(*)</span></label> <input type="text" id="datainserimento" name="datainserimento" value="{{$costo->datainserimento}}" class="form-control">
             </div>
             
              <div class="form-group">
             		<label>{{ trans('messages.keyword_entity') }} : </label> <select class="form-control" name="ente">
                  @foreach($enti as $ente)
                  	@if($costo->id_ente == $ente->id)
                  		<option selected value="{{$ente->id}}">{{$ente->id}} | {{$ente->nomeazienda}}</option>
                  	@else
                    	<option value="{{$ente->id}}">{{$ente->id}} | {{$ente->nomeazienda}}</option>
                    @endif
                  @endforeach
             </select>
             </div>
             
           <input type="submit" class="btn btn-warning" value="{{ trans('messages.keyword_save') }}">
    </form>
</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

<script type="text/javascript">

$(document).ready(function() {

  // validate add invoice form on keyup and submit
  $("#cost").validate({
    rules: {   
      oggetto: {
        required:true
      },
      costo: {
        required: true
      },
      datainserimento: {
          required: true
      }
    },
    messages: {
      oggetto: {
            required: "{{ trans('messages.keyword_enterobject') }}"
      },
      costo: {
          required: "{{ trans('messages.keyword_entercost') }}"
      },
      datainserimento: {
          required: "{{ trans('messages.keyword_enter_insert_date') }}"
      }
    }
  });

});

$('#datainserimento').datepicker();

</script>

@endsection