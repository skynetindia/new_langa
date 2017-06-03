@extends('adminHome')
@section('page')
<h1>{{trans('messages.keyword_taxonomies_estimates')}}</h1><hr>
@include('common.errors')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript" src="{{asset('public/scripts/colors.js')}}"></script>
<script type="text/javascript" src="{{asset('public/scripts/jqColorPicker.min.js')}}"></script>
<script type="text/javascript">
     $('.color').colorPicker();
</script>
@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif
<fieldset>
<legend>{{trans('messages.keyword_emotional_state')}}</legend>
<form action="{{url('/admin/taxonomies/addestimates')}}" method="post" id="frmemotionalest">
    {{ csrf_field() }}
    <div class="row">
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
	</div>
</form>

<h4>{{trans('messages.keyword_edit_emotional_state_quote')}}</h4>
<form action="{{url('/admin/taxonomies/updateestimates')}}" method="post" id="frmemotionalestEdit">
<div class="table-responsive">
		<table class="table table-striped table-bordered text-right">
	@foreach($estimates_stats as $estimatestype)
	<tr>
        <td>
            {{ csrf_field() }}
            <input type="hidden" name="id[]" value="{{$estimatestype->id}}">
            <table class="table sub-table">
              <tr>
                <td><input type="text" class="form-control" name="name[]" id="name" value="{{$estimatestype->name}}"></td>
                <td><input type="text" class="form-control" name="description[]" value="{{$estimatestype->description}}"></td>
                <td><input type="text" class="form-control color no-alpha" name="color[]" value="{{$estimatestype->color}}"></td>
                <td><input type="submit" class="btn btn-primary" value="{{trans('messages.keyword_save')}}">
                  <a  onclick="conferma(event);" type="submit" href="{{url('/admin/taxonomies/statiestimate/delete/id' . '/' . $estimatestype->id)}}" class="btn btn-danger">{{trans('messages.keyword_clear')}}</a></td>
              </tr>
            </table>
        </td>
      </tr>    	
	@endforeach
	</table>
	</div>
</form>
  <script type="text/javascript">
         $(document).ready(function() {
           $("#frmemotionalestEdit").validate({            
                      rules: {
                          "name[]": {
                              required: true,
                          }
                      },
                      messages: {
                          "name[]": {
                              required: "{{trans('messages.keyword_please_enter_a_name')}}"
                          }
                      }
                  });
          });
          </script>
</fieldset>
<script>
function conferma(e) {
	var confirmation = confirm("<?php echo trans('messages.keyword_are_you_sure?');?>") ;
    if (!confirmation)
        e.preventDefault();
	return confirmation ;
}
</script>
<script type="text/javascript" src="{{asset('public/scripts/index.js')}}"></script>
<script type="text/javascript">
 $(document).ready(function() {
   $("#frmemotionalest").validate({            
              rules: {
                  name: {
                      required: true,
                  }
              },
              messages: {
                  name: {
                      required: "{{trans('messages.keyword_please_enter_a_name')}}"
                  }
              }
          });   
   
  });
</script>
@endsection