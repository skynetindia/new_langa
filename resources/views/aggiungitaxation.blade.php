@extends('adminHome')
@section('page')

@if(!empty(Session::get('msg')))

    <script>

    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';

    document.write(msg);

    </script>

@endif
@include('common.errors')



<div class="row">
  <div class="col-md-8">

    <form action="{{url('/taxation/store')}}" id="taxation_form" method="post">
      {{ csrf_field() }}

      @if(isset($taxation))
          <h1>{{trans('messages.keyword_update_template_for_taxation')}}</h1><hr>
          <label>{{trans("messages.keyword_taxation_name")}}</label>
          <input class="form-control" name="tassazione_nome" value="{{ $taxation->tassazione_nome }}">
          <br>
          <label>{{trans("messages.keyword_percentage_taxation")}}</label>
          <input class="form-control" name="tassazione_percentuale" value="{{ $taxation->tassazione_percentuale }}">
          <br>
          <input type="hidden" name="tassazione_id" value="{{ $taxation->tassazione_id }}">
          <input class="btn btn-warning" type="submit" value="{{trans('messages.keyword_modify')}}">
      @else
          <h1>{{trans("messages.keyword_add_template_for_taxation")}}</h1><hr>
          <label>{{trans("messages.keyword_taxation_name")}}</label>
          <input class="form-control" name="tassazione_nome" value="">
          <br>
          <label>{{trans("messages.keyword_percentage_taxation")}}</label>
          <input class="form-control" name="tassazione_percentuale" value="">
          <br>
          <input class="btn btn-warning" type="submit" value="{{trans('messages.keyword_add')}}">
      @endif

    </form>
  </div>
</div>

@endsection