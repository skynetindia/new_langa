@extends('adminHome')

@section('page')
<h1>Lavorazioni</h1>
<hr>
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
  <form action="{{url('/admin/tassonomie/lavorazioninew')}}" method="post">
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
    <h4>Aggiungi tipo</h4>
    {{ csrf_field() }}
    <input type="hidden" name="departments_id" id="departments_id" value="{{$departments->id}}" />
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <input type="text" class="form-control" required="required" name="name" placeholder="Nome">
        </div>
      </div>
      <div class="col-md-8">
        <div class="form-group">
          <input type="text" class="form-control" name="description" placeholder="Descrizione">
        </div>
      </div>
      <div class="col-md-12 text-right">
        <input type="submit" class="btn btn-primary" value="Aggiungi">
      </div>
    </div>
  </form>
  <h4>Modifica tipi</h4>
  <div class="table-responsive">
    <table class="table table-striped table-bordered top-up text-right">
      @foreach($lavorazioni as $lavorazioni)
      <tr>
        <td><form action="{{url('/admin/tassonomie/lavorazioniupdate')}}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="departments_id" id="departments_id" value="{{$departments->id}}" />
            <input type="hidden" name="id" value="{{$lavorazioni->id}}">
            <table class="table sub-table">
              <tr>
                <td width="20%" class="text-left"><label>Nome lavorazione</label>
                  <input type="text" required="required" class="form-control" name="name" id="name" value="{{$lavorazioni->nome}}"></td>
                <td class="text-left"><label>Descizione</label>
                  <input type="text" class="form-control" name="description" value="{{$lavorazioni->description}}">
                  <input type="hidden" name="color" value="{{$lavorazioni->color}}" />
                  <?php 
			// ON ACTIVE THIS REMOVE HIDDEN COLOR INPUT TYPE
			/*<div class="col-xs-6 col-sm-3">
				<td><input type="text" class="form-control color no-alpha" name="color" value="{{$lavorazioni->color}}"></td>
			</div>*/?></td>
                <td width="15%">
                <div class="space20"></div>
                <input type="submit" class="btn btn-primary" value="Salva">
                  <a onclick="conferma(event);" type="submit" href="{{url('/admin/tassonomie/lavorazionidelete/id' . '/' . $lavorazioni->id)}}" class="btn btn-danger">Cancella</a></td>
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
<div class="footer-svg">
	<img src="{{asset('images/ADMIN_TASSONOMIE-footer.svg')}}" alt="tassonomie">
</div>
<script>
	function conferma(e) {
	var confirmation = confirm("Sei sicuro?") ;
    if (!confirmation)
        e.preventDefault();
	return confirmation ;
}
</script> 
<script type="text/javascript" src="{{asset('public/scripts/index.js')}}">
@endsection