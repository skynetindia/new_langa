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
<script type="text/javascript">
    $('.color').colorPicker(); // that's it   
</script>
<?php //$lavorazioni = DB::table('lavorazioni')->where('departments_id', $departments->id)->get(); ?>
<fieldset>
  <div class="row">
    <form action="{{url('/admin/quizdemonew')}}" method="post" enctype="multipart/form-data">
      <div class="col-md-12">
        <legend>{{trans("messages.keyword_quiz")}}</legend>
      </div>
      <div class="space20"></div>
      {{ csrf_field() }}
      <div class="col-sm-4">
        <div class="form-group">
          <label>&nbsp; </label>
          <input type="text" required="required" class="form-control" name="name" id="name" value="{{old('name')}}" placeholder="{{trans("messages.keyword_name")}}">
        </div>
      </div>
      <div class="col-sm-4">
        <div class="form-group">
          <label>&nbsp;</label>
          <input type="url" class="form-control" required="required" name="url" value="{{old('url')}}" placeholder="{{trans("messages.keyword_url")}}">
        </div>
      </div>
      <div class="col-sm-4">
        <div class="form-group">
          <labe>
          {{trans("messages.keyword_highlighted_image")}}
          </label>
          <input type="file" class="form-control" id="immagine" name="immagine">
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
  <form action="{{url('/admin/quizdemoupdate')}}" method="post" enctype="multipart/form-data">
  <div class="table-responsive">
    <table class="table table-striped text-right">
    	<tr>
      @foreach($quizdemodettagli as $quizdemodettagli)
      <tr>
      <td>
            {{ csrf_field() }}
            <input type="hidden" name="id[]" value="{{$quizdemodettagli->id}}">
            <table class="table table-bordered">
            <tr>
                <td width="20%"><label>&nbsp; </label>
                  <input type="text" required="required" class="form-control" name="name[]" id="name" value="{{$quizdemodettagli->nome}}"></td>
                <td width="20%"><label> &nbsp; </label>
                  <input type="url" class="form-control" name="url[]" value="{{$quizdemodettagli->url}}"></td>
                <td width="20%"><label class="pull-left">{{trans("messages.keyword_highlighted_image")}}</label>
                  <input type="file" class="form-control" id="immagine" name="immagine[]"></td>
                  <td width="10%"><label class="pull-left">{{trans('messages.keyword_average_rating')}}</label>
                  <input type="text" class="form-control" id="rate" readonly value="{{$quizdemodettagli->tassomedio.'/'.$quizdemodettagli->tassototale }}"></td><?php
                    // ON ACTIVE THIS REMOVE HIDDEN COLOR INPUT TYPE
                    /* <div class="col-xs-6 col-sm-3">
                      <td><input type="text" class="form-control color no-alpha" name="color" value="{{$lavorazioni->color}}"></td>
                      </div> */
                ?><td width="15%"><div class="cst-btn-group">
                <input type="submit" class="btn btn-primary" value="{{trans('messages.keyword_save')}}">
                  <a onclick="conferma(event);" type="submit" href="{{url('/admin/quizdemodelete/id' . '/' . $quizdemodettagli->id)}}"  class="btn btn-danger">{{trans('messages.keyword_clear')}} </a>
                  </div>
                 </td>
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
  function conferma(e) {
      var confirmation = confirm("<?php echo trans('messages.keyword_are_you_sure?')?>");
      if (!confirmation)
          e.preventDefault();
      return confirmation;
  }
</script> 
<script type="text/javascript" src="{{asset('public/scripts/index.js')}}">
@endsection