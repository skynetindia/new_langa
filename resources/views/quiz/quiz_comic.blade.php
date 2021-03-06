@extends('adminHome')
@section('page')

<div class="res-tassonomie-enti">
<h1>{{trans('messages.keyword_comic')}}</h1><hr>
@include('common.errors')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif

<fieldset>
<div class="quiz-comic">
<legend> {{ trans('messages.keyword_types') }} </legend>

<h4>{{ trans('messages.keyword_add_type')}}</h4>
<form action="{{url('/quiz/comic/add')}}" method="post" id="comicadd" name="comicadd" enctype="multipart/form-data">
    {{ csrf_field() }}
	<div class="row">
    <div class="col-md-3 col-sm-12 col-xs-12">
		<div class="form-group">
			<input type="text" class="form-control" name="title" placeholder="{{trans('messages.keyword_title')}}">
		</div>
	</div>
	<div class="col-md-3 col-sm-12 col-xs-12">
		<div class="form-group">
			<input type="text" class="form-control" name="description" placeholder="{{trans('messages.keyword_description')}}">
		</div>
	</div>
  <div class="col-md-3 col-sm-12 col-xs-12">
    <div class="form-group">
      <input type="text" class="form-control" name="url" placeholder="{{trans('messages.keyword_url')}}">
    </div>
  </div>
	<div class="col-md-3 col-sm-12 col-xs-12">
		<div class="form-group">
			<input type="file" class="form-control" value="" name="image" />
		</div>
	</div>
    </div>
	<div class="text-right res-left">
		<input type="submit" class="btn btn-primary" value="{{trans('messages.keyword_add')}}">    
	</div>
</form>

<h4>{{trans('messages.keyword_edit_types')}}</h4>
<div class="row alltaxationeditparts">
  <div class="col-md-6">
  <div class="form-group m_select lblshow">
    <input id="chktasentitypeall" name="chktasentitypeall" value="1" type="checkbox">
     <label for="chktasentitypeall"> {{trans('messages.keyword_select_all')}} </label>
  </div>
  </div>
  <div class="col-md-6 text-right">
    <input type="button" onclick="AllTaxonomiesAction('update')" class="btn btn-warning" value="{{trans('messages.keyword_save_selected')}}">
    <input type="button" onclick="AllTaxonomiesAction('delete')" class="btn btn-danger" value="{{trans('messages.keyword_delete_selected')}}">
  </div>
</div>
  <!-- This forms used to edit/delete both actions  -->  
<form action="{{url('/quiz/comic/update')}}" method="post" id="comicupdate" name="comicupdate" enctype="multipart/form-data">
<input type="hidden" id="actiontype" name="action" value="update">



<div class="table-responsive">
    <table class="table table-striped table-bordered text-right checkbox-tbl">
      @foreach($quiz_comics as $quiz_comic)
      <tr>
        <td>
            {{ csrf_field() }}
            <input type="hidden" name="id[]" value="{{$quiz_comic->id}}"> 
            <table class="table sub-table">
              <tr>
                <td>

                <input type="checkbox" class="form-control comic" name="comic[{{$quiz_comic->id}}]" id="comic_{{$quiz_comic->id}}" value="{{$quiz_comic->id}}">

                <label for="comic_{{$quiz_comic->id}}"></label></td>
                <td><input type="text" class="form-control" name="title[{{$quiz_comic->id}}]" id="title" value="{{$quiz_comic->title}}"></td>

                <td><input type="text" class="form-control" name="description[{{$quiz_comic->id}}]" value="{{$quiz_comic->description}}"></td>

                <td><input type="text" class="form-control" name="url[{{$quiz_comic->id}}]" value="{{$quiz_comic->url}}"></td>

                <td><input type="file" class="form-control" name="image[{{$quiz_comic->id}}]" value="{{$quiz_comic->image}}"></td>

                <td><img src="{{ url('/storage/app/images/quiz/'.$quiz_comic->image) }}" height="100" width="100" class="img-responsive" alt="image not exists"></td>

                <td><input type="button" onclick="SingleTaxonomiesAction('{{$quiz_comic->id}}','update')" class="btn btn-warning" value="{{trans('messages.keyword_save')}}">

                <a onclick="conferma(event);" type="button" href="javascript:SingleTaxonomiesAction('{{$quiz_comic->id}}','delete')" class="btn btn-danger"> {{trans('messages.keyword_delete_label')}}</a></td>

              </tr>
            </table>                    
          </td>
      </tr>
      @endforeach
    </table>
  </div>
</form>
</div>

<script type="text/javascript">

$(document).ready(function() {

  $("#comicadd").validate({          
      rules: {
          "title": {
              required: true,
          },
          "description": {
              required: true,
          },
          "url": {
              required: true,
          }
      },
      messages: {
          "title": {
              required: " {{trans('messages.keyword_please_enter_a_title')}}"
          },
          "description": {
              required: " {{trans('messages.keyword_please_enter_a_description')}}"
          },
          "url": {
              required: " {{trans('messages.keyword_please_enter_a_url')}}"
          }
      }
    });

  $("#comicupdate").validate({          
      rules: {
          "title[]": {
              required: true,
          },
          "description[]": {
              required: true,
          }
      },
      messages: {
          "title[]": {
              required: " {{trans('messages.keyword_please_enter_a_title')}}"
          },
          "description[]": {
              required: " {{trans('messages.keyword_please_enter_a_description')}}"
          }
      }
    });

});


$("#chktasentitypeall").click(function () {
   $('.comic').not(this).prop('checked', this.checked);
   addremoveclass();
});

$(".comic").click(function () {        
  addremoveclass();
});

function SingleTaxonomiesAction(id,action) {
  $("#comic_"+id).prop('checked', true);
  $("#actiontype").val(action);
  $( "#comicupdate" ).submit();
}

function AllTaxonomiesAction(action) {
if ($("#comicupdate input:checkbox:checked").length > 0) {    
  if(action == 'delete'){
    var confirmation = confirm("<?php echo trans('messages.keyword_are_you_sure?');?>") ;
    if (!confirmation) {
      return false;
    }        
  }
  $("#actiontype").val(action);
  $( "#comicupdate").submit();  
 }
 else {
    alert("{{trans('messages.keyword_select_at_least_one_record')}}");
 }
}

function addremoveclass(){
  $(".table input[type=checkbox]").each(function() {
    if(false == $(this).prop("checked")) { 
        $(this).closest("tr").removeClass("selected");
     }
     else {
          $(this).closest("tr").addClass("selected");
    } 
  });
}

</script>

</div>
<script>

	function conferma(e) {
	var confirmation = confirm("<?php echo trans('messages.keyword_are_you_sure?');?>") ;
    if (!confirmation)
        e.preventDefault();
	return confirmation ;
}
</script>
@endsection