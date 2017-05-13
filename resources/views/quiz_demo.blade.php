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
    <form action="{{url('/admin/quizdemonew')}}" method="post" enctype="multipart/form-data">
        <div class="col-md-12">
            <legend style="padding-left:10px;color:#fff;background-color: #999;">{{trans("messages.keyword_quiz")}}</legend>
        </div>
        <br />
        {{ csrf_field() }}
        <div class="col-sm-4">
            <td width="20%"><label class="pull-left"><br></label><input type="text" required="required" class="form-control" name="name" id="name" value="" placeholder="{{trans("messages.keyword_name")}}"> </td>
                           </div>
                           <div class="col-sm-4">
                   <td><label class="pull-left"><br></label><input type="url" class="form-control" name="url" placeholder="{{trans("messages.keyword_url")}}"></td>
    </div>
    <div class="col-sm-4">
        <td><label class="pull-left">{{trans("messages.keyword_highlighted_image")}}</label><input type="file" class="form-control" id="immagine" name="immagine"></td>
    </div>           
                      <div style                          ="text-align:right">
                          <input type="submit" class="btn btn-primary" value="{{trans("messages.keyword_add")}}">
                                                </div>
                                      </form>
                                       @if(count($quizdemodettagli) > 0)
                          <h4>{{trans("messages.keyword_edit_types")}}</h4>
                          <div class="table-responsive">
                              <table class="table                                                       table-striped table-bordered" style="text-align:righ t">
	@foreach($quizdemodettagli as $quizdemodettagli)		
                                                          <div class="row">
                                                          <tr>
                                                          <form action="{{url('/admin/quizdemoupdate')}}" method="post" enctype="multipart/form-data">        
                                                              {{ csrf_field() }}
                                                              <input type="hidden" name="id" value="{{$quizdemodettagli->id}}">
                                                              <div class="form-group">
                                                                  <div class="col-xs-6 col-sm-3">
                                                                      <td width="20%"><label class="pull-left"> <br></label><input type="text" required="required" class="form-control" name="name" id="name" value="{{$quizdemodettagli->nome}}"> </td>
                                                                  </div>
                                                                  <div class="col-xs-6 col-sm-3">
                                                                      <td width="20%"><label class="pull-left"><br></label><input type="text" class="form-control" name="url" value="{{$quizdemodettagli->url}}"></td>
                                                                  </div>
                                                                  <div class="col-xs-6 col-sm-3">
                                                                      <td width="20%"><label class="pull-left">{{trans("messages.keyword_highlighted_image")}}</label><input type="file" class="form-control" id="immagine" name="immagine"></td>
                                                                  </div>           
                                                                  <div class="col-xs-6 col-sm-3">
                                                                      <td width="10%"><label class="pull-left">{{trans('messages.keyword_average_rating')}}</label><input type="text" class="form-control" id="rate" readonly="readonly" value="{{$quizdemodettagli->tassomedio.'/'.$quizdemodettagli->tassototale }}"></td>
                                                                  </div>           

                                                                  <?php
                                                                  // ON ACTIVE THIS REMOVE HIDDEN COLOR INPUT TYPE
                                                                  /* <div class="col-xs-6 col-sm-3">
                                                                    <td><input type="text" class="form-control color no-alpha" name="color" value="{{$lavorazioni->color}}"></td>
                                                                    </div> */
                                                                  ?>		
                                                                  <div class="col-xs-6 col-sm-3">
                                                                      <td width="15%"><input type="submit" class="btn btn-primary" value="{{trans('messages.keyword_save')}}">
                                                                          <a onclick="conferma(event);" type="submit" href="{{url('/admin/quizdemodelete/id' . '/' . $quizdemodettagli->id)}}" class="btn danger"><button type="button" class="btn btn-danger">{{trans('messages.keyword_clear')}}</button></a></td>
                                                                  </div>	
                                                              </div>		
                                                          </form>
                                                          </tr>	
                                                          </div>
                                                          @endforeach
                                                      </table>
                                                      </div>	
                                                      @endif 
                                                      </fieldset>

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