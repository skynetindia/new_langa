@extends('layouts.app')
@section('content')
@include('common.errors')
@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif

<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-default">
      <div class="panel-heading">
         {{trans("messages.keyword_profile")}}
      </div>
      <div class="panel-body">
      	<div style="display:inline">
      		<h4 style="display:inline"> <h3>{{$utente->name}}</h3>
                        
                        <img src="{{ url("storage/app/images/$ente->logo") }}" style="max-width:100px; max-height:100px;display:inline"></img><hr>
						<div class="col-md-12">
							<div class="col-md-4">
							<?php echo Form::open(array('url' => '/profilo/aggiornaimmagine' . "/$ente->id", 'files' => true)) ?>
								{{ csrf_field() }}
								<label for="logo">{{trans("messages.keyword_load_profile_image")}}</label>
								<input class="form-control" type="file" id="logo" name="logo" required="required"><br>
								<input class="form-control btn btn-warning" type="submit" value="{{trans('messages.keyword_update_image')}}">
							</form>
						</div>
						<div class="col-md-6">
							<?php echo Form::open(array('url' => '/profilo/aggiungilink', 'files' => true)) ?>
								{{ csrf_field() }}
								<label for="name">{{trans("messages.keyword_name")}}</label>
								<input type="text" placeholder="Nome" name="name" class="form-control"><br>
								<label for="url">{{trans("messages.keyword_url_link")}}</label>
								<input type="text" placeholder="Link" name="url" class="form-control"><br>
								<label for="img">{{trans("messages.keyword_image")}}</label>
								<input type="file" name="img" class="form-control"><br>
								<input type="submit" class="form-control btn btn-warning" value="{{trans('messages.keyword_add_quick_link')}}">
							</form>
							<div class="table-responsive">
								<table class="table">
									@foreach($link as $l)
										<tr><td>{{ $l->name }} | {{ $l->url }} <a  href="{{url('/profilo/link/elimina') . '/' . $l->id}}" title="{{trans('messages.keyword_delete_this_shortcut')}}" class="btn btn-danger"><span class="fa fa-eraser"></span></a></td></tr>
									@endforeach
								</table>
							</div>
						</div>
					</div>
				</div>
      </div>
    </div>
  </div>
</div>

@endsection