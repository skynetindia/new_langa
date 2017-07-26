@extends('adminHome')
@section('page')
<h1>{{trans('messages.keyword_taxonomy_entities')}}</h1><hr>
@include('common.errors')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript" src="{{asset('public/scripts/colors.js')}}"></script>
<script type="text/javascript" src="{{asset('public/scripts/jqColorPicker.min.js')}}"></script>
<script type="text/javascript">	
         $('.color').colorPicker(); // that's it   
</script>
<fieldset>
<legend style="padding-left:10px;color:#fff;background-color: #999">{{ trans('messages.keyword_type')}}</legend>
<h4>{{ trans('messages.keyword_add_type')}}</h4>
<form action="{{url('/admin/tassonomie/new')}}" method="post">
    {{ csrf_field() }}
	<div class="col-md-4">
		<input type="text" class="form-control" name="name" placeholder="{{trans('messages.keyword_name')}}"><br> 
	</div>
	<div class="col-md-4">
		<input type="text" class="form-control" name="description" placeholder="{{trans('messages.keyword_description')}}"><br> 
	</div>
	<div class="col-md-4">
		<input class="form-control color no-alpha" value="#f37f0d" name="color" /><br>
	</div>
	<div style="text-align:right">
		<input type="submit" class="btn btn-primary" value="{{trans('messages.keyword_add')}}">
	</div>
</form>
<h4>{{trans('messages.keyword_edit_types')}}</h4>
<div class="table-responsive">
		<table class="table table-striped table-bordered" style="text-align:right">
	@foreach($type as $types)		
		<tr>
		<form action="{{url('/admin/tassonomie/update')}}" method="post">
		{{ csrf_field() }}
		<input type="hidden" name="id" value="{{$types->id}}">
		<div class="form-group">
			<div class="col-xs-6 col-sm-3">
				<td><input type="text" class="form-control" name="name" id="name" value="{{$types->name}}"> </td>
			</div>
			<div class="col-xs-6 col-sm-3">
				<td><input type="text" class="form-control" name="description" value="{{$types->description}}"></td>
			</div>
			<div class="col-xs-6 col-sm-3">
				<td><input type="text" class="form-control color no-alpha" name="color" value="{{$types->color}}"></td>
			</div>
			<div class="col-xs-6 col-sm-3">
				<td><input type="submit" class="btn btn-primary" value="{{trans('messages.keyword_save')}}">
				<a  onclick="conferma(event);" type="submit" href="{{url('/admin/tassonomie/delete/id' . '/' . $types->id)}}" class="btn danger"><button type="button" class="btn btn-danger">{{ trans('messages.keyword_clear')}}</button></a></td>
			</div>	
		</div>		
	</form>
	</tr>	
	@endforeach
	</table>
	</div>	
</form>
</fieldset>

<fieldset>
<legend style="padding-left:10px;color:#fff;background-color: #999">{{trans('messages.keyword_emotional_state')}}</legend>
<form action="{{url('/admin/tassonomie/nuovostatoemotivo')}}" method="post">
    {{ csrf_field() }}
	<div class="col-md-4">
		<input type="text" class="form-control" name="name" placeholder="{{trans('messages.keyword_name')}}"><br> 
	</div>
	<div class="col-md-4">
		<input type="text" class="form-control" name="description" placeholder="{{trans('messages.keyword_description')}}"><br> 
	</div>
	<div class="col-md-4">
		<input class="form-control color no-alpha" value="#f37f0d" name="color" /><br>
	</div>
	<div style="text-align:right">
		<input type="submit" class="btn btn-primary" value="{{trans('messages.keyword_add')}}">
	</div>
</form>
<h4>{{trans('messages.keyword_edit_emotional_state')}}</h4>
<div class="table-responsive">
		<table class="table table-striped table-bordered" style="text-align:right">
	@foreach($emotional_states_types as $emostatetye)		
		<tr>
		<form action="{{url('/admin/tassonomie/aggiornastatiemotivi')}}" method="post">
		{{ csrf_field() }}
		<input type="hidden" name="id" value="{{$emostatetye->id}}">
		<div class="form-group">
			<div class="col-xs-6 col-sm-3">
				<td><input type="text" class="form-control" name="name" id="name" value="{{$emostatetye->name}}"> </td>
			</div>
			<div class="col-xs-6 col-sm-3">
				<td><input type="text" class="form-control" name="description" value="{{$emostatetye->description}}"></td>
			</div>
			<div class="col-xs-6 col-sm-3">
				<td><input type="text" class="form-control color no-alpha" name="color" value="{{$emostatetye->color}}"></td>
			</div>
			<div class="col-xs-6 col-sm-3">
				<td><input type="submit" class="btn btn-primary" value="{{trans('messages.keyword_save')}}">
				<a  onclick="conferma(event);" type="submit" href="{{url('/admin/tassonomie/statiemotivi/delete/id' . '/' . $emostatetye->id)}}" class="btn danger"><button type="button" class="btn btn-danger">{{ trans('messages.keyword_clear')}}</button></a></td>
			</div>	
		</div>		
	</form>
	</tr>	
	@endforeach
	</table>
	</div>	
</form>
</fieldset>
<script>
	function conferma(e) {
	var confirmation = confirm("<?php echo trans('messages.keyword_are_you_sure?');?>") ;
    if (!confirmation)
        e.preventDefault();
	return confirmation ;
}
</script>
<script type="text/javascript" src="{{asset('public/scripts/index.js')}}">
@endsection