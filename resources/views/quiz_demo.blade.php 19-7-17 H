@extends('adminHome')
@section('page')
<h1>{{trans("messages.keyword_demo")}}</h1><hr>
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
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/additional-methods.min.js"></script>

<script type="text/javascript">
    $('.color').colorPicker(); // that's it   
</script>
<?php //$lavorazioni = DB::table('lavorazioni')->where('departments_id', $departments->id)->get(); ?>
<fieldset>
  <div class="row quiz-top-section">
    <form action="{{url('/admin/quizdemonew')}}" method="post" name="quizdemoadd" id="quizdemoadd" enctype="multipart/form-data">
      <div class="col-md-12">
        <legend>{{trans("messages.keyword_quiz")}}</legend>
      </div>
      <div class="space20"></div>
      {{ csrf_field() }}
      <div class="col-sm-4">
        <div class="form-group">
          <label>&nbsp; </label>
          <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}" placeholder="{{trans("messages.keyword_name")}}">
        </div>
      </div>
      <div class="col-sm-4">
        <div class="form-group">
          <label>&nbsp;</label>
          <input type="url" class="form-control" name="url" value="{{old('url')}}" placeholder="{{trans("messages.keyword_url")}}">
        </div>
      </div>
      <div class="col-sm-4">
      <div class="row">
        <div class="col-md-10">
          <div class="form-group">
            <label>{{trans("messages.keyword_highlighted_image")}}</label>
            <input type="file" class="form-control" id="immagine" name="immagine">
            <label for="immagine" generated="true" class="error none" id="immagine_validatio_msg"></label>          
          </div>
          </div>
        <div class="col-md-2 immaginepreview" id="immaginepreview"></div>
      </div>
      </div>
      <div class="col-md-12 text-right">
        <div class="form-group">
          <input type="submit" class="btn btn-primary" value="{{trans("messages.keyword_add")}}">
        </div>
      </div>
    </form>
  </div>
  @if(count($quizdemodettagli) > 0)
  <h4>{{trans("messages.keyword_edit_types")}}</h4>
  <div class="row alltaxationeditparts quiz-edit-type">
  <div class="col-md-6">
  <div class="form-group m_select lblshow">
    <input id="chktasentitypeall" name="chktasentitypeall" value="1" type="checkbox">
     <label for="chktasentitypeall"> Select All </label>
  </div>
  </div>
  <div class="col-md-6 text-right">
    <input type="button" onclick="AllTaxonomiesAction('update')" class="btn btn-warning" value="{{trans('messages.keyword_save_selected')}}">
    <input type="button" onclick="AllTaxonomiesAction('delete')" class="btn btn-danger" value="{{trans('messages.keyword_delete_selected')}}">
  </div>
  </div>
  <form action="{{url('/admin/quizdemoupdate')}}" name="quizdemoedit" id="quizdemoedit" method="post" enctype="multipart/form-data" class="quiz-form">
  <input type="hidden" id="actiontype" name="action" value="update">
  <div class="table-responsive">
    <table class="table table-striped text-right checkbox-tbl">
    	<tr>
      @foreach($quizdemodettagli as $quizdemodettagli)
      <tr>
      <td>
            {{ csrf_field() }}
            <input type="hidden" name="id[]" value="{{$quizdemodettagli->id}}">
            <table class="table table-bordered">
            <tr><td width="5%">
                <input type="checkbox" class="form-control chktasentitype" name="chktasentitype[{{$quizdemodettagli->id}}]" id="chktasentitype_{{$quizdemodettagli->id}}" value="{{$quizdemodettagli->id}}">
                <label for="chktasentitype_{{$quizdemodettagli->id}}"></label></td>

                <td width="20%"> <!--<label>&nbsp; </label>-->
                  <input type="text" class="form-control" name="name[{{$quizdemodettagli->id}}]" id="name" value="{{$quizdemodettagli->nome}}"></td>
                <td width="20%"> <!-- <label> &nbsp; </label>-->
                  <input type="url" class="form-control" name="url[{{$quizdemodettagli->id}}]" value="{{$quizdemodettagli->url}}"></td>
                <td width="20%">
                  <div class="row">
                    <div class="col-md-10">
                    <!--  <label class="pull-left">{{trans("messages.keyword_highlighted_image")}}</label>-->
                      <input type="file" class="form-control editimage" val="{{$quizdemodettagli->id}}" id="immagine_{{$quizdemodettagli->id}}" name="immagine[{{$quizdemodettagli->id}}]">
                       <label for="immagine_{{$quizdemodettagli->id}}" generated="true" class="error none" id="immagine_validatio_msg_{{$quizdemodettagli->id}}"></label>          
                    </div>
                    <div class="col-md-2 immaginepreview" id="immaginepreview_{{$quizdemodettagli->id}}">
                      <div class="img-border-preview"><?php if(isset($quizdemodettagli->immagine) && !empty($quizdemodettagli->immagine)) { ?> <img src="{{url('/storage/app/images/quizdemo/').'/'.$quizdemodettagli->immagine}}" height="100" width="100" class="img-responsive"><?php } ?> </div></div>
                  </div>
                  </td>
                  <td width="10%"> <!--<label class="pull-left">{{trans('messages.keyword_average_rating')}}</label>-->
                  <input type="text" class="form-control" id="rate" readonly value="{{$quizdemodettagli->tassomedio.'/'.$quizdemodettagli->tassototale }}"></td><?php
                    // ON ACTIVE THIS REMOVE HIDDEN COLOR INPUT TYPE
                    /* <div class="col-xs-6 col-sm-3">
                      <td><input type="text" class="form-control color no-alpha" name="color" value="{{$lavorazioni->color}}"></td>
                      </div> */
                      /*
                ?><td width="15%"><div class="cst-btn-group">
                <input type="submit" class="btn btn-warning" value="{{trans('messages.keyword_save')}}">
                  <a onclick="conferma(event);" type="submit" href="{{url('/admin/quizdemodelete/id' . '/' . $quizdemodettagli->id)}}"  class="btn btn-danger">{{trans('messages.keyword_clear')}} </a>
                  </div>
                 </td>*/?>

                 <td width="10%"><input type="button" onclick="SingleTaxonomiesAction('{{$quizdemodettagli->id}}','update')" class="btn btn-warning" value="{{trans('messages.keyword_save')}}">
                  <a onclick="conferma(event);" type="button" href="javascript:SingleTaxonomiesAction('{{$quizdemodettagli->id}}','delete')" class="btn btn-danger"> {{trans('messages.keyword_delete_label')}}</a></td>
             </tr>
           </table>          
          </td>
      </tr>
      @endforeach
    </table>
  </div>
  </form>
  @endif
</fieldset>
<div class="footer-svg">
    <img src="{{url('/images/ADMIN_QUIZ-footer.svg')}}" alt="quiz">
</div>
<script>

function readURL(input,viewid) {
if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $('#'+viewid).html(' <div class="img-border-preview"> <img height="100" width="100" class="img-responsive" src="'+e.target.result+'"/></div>');
        /*$('#logopreview').attr('src', e.target.result);*/
    }
    reader.readAsDataURL(input.files[0]);
    }
}

$("#immagine").change(function(){ 
  var ext = $(this).val().split('.').pop().toLowerCase();
  var filessize = this.files[0].size/1024/1024;/*2 MB*/   
  if(($.inArray(ext, ['gif','png','jpg','jpeg','svg']) == -1) || (filessize > 2)) {
    $(this).val("");
    $("#immagine_validatio_msg").show();
    $("#immagine_validatio_msg").html("{{ trans('messages.keyword_please_upload_a_valid__image') }}");      
  }
  else {
    $("#immagine_validatio_msg").html("");      
    readURL(this,'immaginepreview');  
  }
});

$(".editimage").change(function(){ 
  var ext = $(this).val().split('.').pop().toLowerCase();
  var ids = $(this).attr('val');
  var filessize = this.files[0].size/1024/1024;/*2 MB*/   
  if(($.inArray(ext, ['gif','png','jpg','jpeg','svg']) == -1) || (filessize > 2)) {
    $(this).val("");
    $("#immagine_validatio_msg_"+ids).show();
    $("#immagine_validatio_msg_"+ids).html("{{ trans('messages.keyword_please_upload_a_valid__image') }}");      
  }
  else {
    $("#immagine_validatio_msg_"+ids).html("");      
    readURL(this,'immaginepreview_'+ids);  
  }
});



  function conferma(e) {
      var confirmation = confirm("<?php echo trans('messages.keyword_are_you_sure?')?>");
      if (!confirmation)
          e.preventDefault();
      return confirmation;
  }
  $(document).ready(function() {
    $.validator.addMethod('minImageWidth', function(value, element, minWidth) {
    return ($(element).data('imageWidth') || 0) > minWidth;
    }, function(minWidth, element) {
    var imageWidth = $(element).data('imageWidth');
  return (imageWidth)
      ? ("Your image's width must be greater than " + minWidth + "px")
      : "Selected file is not an image.";
});
// validate add alert type form on keyup and submit
        $("#quizdemoadd").validate({            
            rules: {
                name: {
                    required: true,
                },
                url:{
                  url:true
                }                
            },
            messages: {
                name: {
                    required: "{{trans('messages.keyword_please_enter_a_type_name')}}"
                },
                url:{
                  url:"{{trans('messages.keyword_please_enter_a_type_name')}}"
                }
            }
        });

        // validate edit alert type form on keyup and submit
        $("#quizdemoedit").validate({            
            rules: {
                "name[]": {
                    required: true,
                },
                "url[]": {
                  url:true
                }
            },
            messages: {
                "name[]": {
                    required: "{{trans('messages.keyword_please_enter_a_type_name')}}"
                },
                "url[]":{
                  url:"{{trans('messages.keyword_please_enter_a_type_name')}}"
                }
            }
        });
    });

$("#chktasentitypeall").click(function () {
     $('.chktasentitype').not(this).prop('checked', this.checked);
     addremoveclass();
 });
  $(".chktasentitype").click(function () {        
    addremoveclass();
 });
function SingleTaxonomiesAction(id,action) {
  $("#chktasentitype_"+id).prop('checked', true);
  $("#actiontype").val(action);
  $( "#quizdemoedit").submit();
}
function AllTaxonomiesAction(action) {
if ($("#quizdemoedit input:checkbox:checked").length > 0) {    
  if(action == 'delete'){
    var confirmation = confirm("<?php echo trans('messages.keyword_are_you_sure?');?>") ;
    if (!confirmation) {
      return false;
    }        
  }
  $("#actiontype").val(action);
  $( "#quizdemoedit").submit();  
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
<script type="text/javascript" src="{{asset('public/scripts/index.js')}}">
@endsection