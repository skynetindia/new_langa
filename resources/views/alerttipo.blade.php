@extends('adminHome')

@section('page')
<h1> {{ trans('messages.keyword_tipoalert') }}  </h1><hr>
@include('common.errors')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript" src="{{asset('public/scripts/colors.js')}}"></script>
<script type="text/javascript" src="{{asset('public/scripts/jqColorPicker.min.js')}}"></script>
<script type="text/javascript">	
         $('.color').colorPicker(); // that's it   
</script>
@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif
<fieldset>
<legend> {{ trans('messages.keyword_types') }} </legend>

<?php /*<h4>{{ trans('messages.keyword_addtype') }} </h4>*/?>
<form action="{{url('/alert/add/tipo')}}" method="post" name="alerttipo" id="alerttipo">
    {{ csrf_field() }}
    <div class="row">
    	<div class="col-md-12">
    		<h4>{{ trans('messages.keyword_addtype') }}<label> <span class="required">(*)</span></label></h4>
    	</div>    
	<div class="col-md-4"> 		
		<div class="form-group">
		<input type="text" class="form-control" id="nome_tipo" name="nome_tipo" placeholder="{{ trans('messages.keyword_name') }} ">
		</div>
	</div>
	<div class="col-md-4">	
		<div class="form-group">		
		<input type="text" class="form-control" id="desc_tipo" name="desc_tipo" placeholder="{{ trans('messages.keyword_description') }} ">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">	
		<input class="form-control color no-alpha" value="#f37f0d" name="color" placeholder="{{ trans('messages.keyword_color') }}" id="color" />
		</div>
	</div>
	<div class="text-right">
		<input type="submit" class="btn btn-primary" value="{{ trans('messages.keyword_add') }}">
	</div>
	</div>
</form>
<h4>{{ trans('messages.keyword_modifytype') }} </h4>
<div class="table-responsive">
	<form action="{{url('/admin/update/tipo')}}" method="post" id="modifyalerttipo" name="modifyalerttipo">
	<table class="table table-striped table-bordered text-right">		
	@foreach($alert_tipo as $type)		
		<tr>
		<td>		
		{{ csrf_field() }}
		<input type="hidden" name="id_tipo[]" value="{{$type->id_tipo}}">
		<table class="table sub-table">
			<tr>
				<td><input type="text" class="form-control" name="nome_tipo[]" id="nome_tipo" value="{{$type->nome_tipo}}" placeholder="{{ trans('messages.keyword_name') }}"></td>
				<td><input type="text" class="form-control" name="desc_tipo[]" value="{{$type->desc_tipo}}" placeholder="{{ trans('messages.keyword_description') }}"></td>
				<td><input type="text" class="form-control color no-alpha" name="color[]" value="{{$type->color}}" placeholder="{{ trans('messages.keyword_color') }}"></td>
				<td><input type="submit" class="btn btn-primary" value="{{ trans('messages.keyword_save') }}">
				<a  onclick="conferma(event);" type="submit" href="{{url('/admin/delete/tipo' . '/' . $type->id_tipo)}}" class="btn danger"><button type="button" class="btn btn-danger">{{ trans('messages.keyword_clear') }}</button></a></td>
			</tr>
		</table>	
		</td>
	</tr>	
	@endforeach	
	</table>
	</form>
	</div>	
</fieldset>
<div class="footer-svg">
	<img src="{{asset('images/ADMIN_AVVISI-footer.svg')}}" alt="avvisi">
</div>
<script>
	function conferma(e) {
	var confirmation = confirm("{{ trans('messages.keyword_sure') }}?") ;
    if (!confirmation)
        e.preventDefault();
	return confirmation ;
}
</script>
<script type="text/javascript" src="{{asset('public/scripts/index.js')}}">
@endsection