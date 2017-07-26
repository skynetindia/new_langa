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
    <form action="{{url('/taxation/store')}}" id="taxation_form" method="post">
      {{ csrf_field() }}

      @if(isset($taxation))
      	  <div class="col-md-12">
          <h1>Update template per Tassazione</h1><hr>
          </div>
          <div class="col-md-6">
          <div class="form-group">
    	      <label>Tassazione Nome</label>
	          <input class="form-control" name="tassazione_nome" value="{{ $taxation->tassazione_nome }}">
          </div>
          </div>
          <div class="col-md-6">
          <div class="form-group">
          <label>Tassazione Percentuale</label>
          <input class="form-control" name="tassazione_percentuale" value="{{ $taxation->tassazione_percentuale }}">
          </div>
          </div>
          <div class="col-md-12">
          <input type="hidden" name="tassazione_id" value="{{ $taxation->tassazione_id }}">
          <input class="btn btn-warning" type="submit" value="Modify">
          </div>
      @else
      	  <div class="col-md-12">
          <h1>Aggiungi template per Tassazione</h1><hr>
          </div>
           <div class="col-md-6">
          <div class="form-group">
          <label>Tassazione Nome</label>
          <input class="form-control" name="tassazione_nome" value="">
          </div>
          </div>
           <div class="col-md-6">
          <div class="form-group">
          <label>Tassazione Percentuale</label>
          <input class="form-control" name="tassazione_percentuale" value="">
          </div>
          </div>
            <div class="col-md-12">
          <input class="btn btn-warning" type="submit" value="Aggiungi">
          </div>
      @endif
    </form>
</div>

@endsection