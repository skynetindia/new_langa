@extends('adminHome')
@section('page')
<h1>{{trans('messages.keyword_processing')}}</h1><hr>
@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif
@include('common.errors')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript" src="{{asset('public/scripts/colors.js')}}"></script>
<script type="text/javascript" src="{{asset('public/scripts/jqColorPicker.min.js')}}"></script>
<script type="text/javascript">	
         $('.color').colorPicker(); // that's it   
</script>
@foreach($departments as $departments)
	<?php $lavorazioni = DB::table('lavorazioni')->where('departments_id', $departments->id)->get(); ?>
<fieldset class="top-up-wrap">
<form action="{{url('/admin/taxonomies/addprocessing')}}" method="post">
	<div class="row">
		<div class="col-md-8">
    		<legend>{{$departments->nomedipartimento}}</legend>
    	</div>
    	<div class="col-md-4">
        <div class="form-group">
    		<input class="form-control color no-alpha" value="#f37f0d" name="color" />
    	</div>
    	</div>
    </div>
    
<h4>{{trans('messages.keyword_add_type')}}</h4>
    {{ csrf_field() }}
    <input type="hidden" name="departments_id" id="departments_id" value="{{$departments->id}}" />
    <div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<input type="text" class="form-control" required="required" name="name" placeholder="{{trans('messages.keyword_name')}}">
		</div>
	</div>
	<div class="col-md-8">
		<div class="form-group">
			<input type="text" class="form-control" name="description" placeholder="{{trans('messages.keyword_description')}}"><br> 
		</div>
	</div>	
	<div class="col-md-12 text-right">
		<input type="submit" class="btn btn-primary" value="{{trans('messages.keyword_add')}}">
	</div>
	</div>
</form>
<h4>{{trans('messages.keyword_edit_types')}}</h4>
<div class="table-responsive">
		<table class="table table-striped table-bordered top-up text-right">
	@foreach($lavorazioni as $lavorazioni)		    	
		<tr>
		<td><form action="{{url('/admin/taxonomies/updateprocessing')}}" method="post">        
		{{ csrf_field() }}
        <input type="hidden" name="departments_id" id="departments_id" value="{{$departments->id}}" />
		<input type="hidden" name="id" value="{{$lavorazioni->id}}">
		<table class="table sub-table">
              <tr>
                <td width="20%" class="text-left"><label>{{trans('messages.keyword_processing_name')}}</label>
                  <input type="text" required="required" class="form-control" name="name" id="name" value="{{$lavorazioni->nome}}"></td>
                <td class="text-left"><label>{{trans('messages.keyword_description')}}</label>
                  <input type="text" class="form-control" name="description" value="{{$lavorazioni->description}}">
                  <input type="hidden" name="color" value="{{$lavorazioni->color}}" />
                  <?php 
			// ON ACTIVE THIS REMOVE HIDDEN COLOR INPUT TYPE
			/*<div class="col-xs-6 col-sm-3">
				<td><input type="text" class="form-control color no-alpha" name="color" value="{{$lavorazioni->color}}"></td>
			</div>*/?></td>
                <td width="15%">
                <div class="space20"></div>
                <input type="submit" class="btn btn-primary" value="{{trans('messages.keyword_save')}}">
                  <a onclick="conferma(event);" type="submit" href="{{url('/admin/taxonomies/deleteprocessing/id' . '/' . $lavorazioni->id)}}" class="btn btn-danger">{{trans('messages.keyword_clear')}}</a></td>
              </tr>
            </table>			
	</form></td>
	</tr>    
	@endforeach
	</table>
	</div>	
</form>
</fieldset>
<div class="space40"></div>
	@endforeach
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