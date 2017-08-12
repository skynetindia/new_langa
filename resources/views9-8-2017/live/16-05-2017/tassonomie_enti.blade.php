@extends('adminHome')

@section('page')
<h1>Tassonomie enti</h1>
<hr>
@include('common.errors') 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> 
<script type="text/javascript" src="{{asset('public/scripts/colors.js')}}"></script> 
<script type="text/javascript" src="{{asset('public/scripts/jqColorPicker.min.js')}}"></script> 
<script type="text/javascript">
	
         $('.color').colorPicker(); // that's it
   
</script>
<fieldset>
  <legend>Tipi</legend>
  <h4>Aggiungi tipo</h4>
  <form action="{{url('/admin/tassonomie/new')}}" method="post">
    {{ csrf_field() }}
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <input type="text" class="form-control" name="name" placeholder="Nome">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <input type="text" class="form-control" name="description" placeholder="Descrizione">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <input class="form-control color no-alpha" value="#f37f0d" name="color" />
        </div>
      </div>
    </div>
    <div class="text-right">
      <input type="submit" class="btn btn-primary" value="Aggiungi">
    </div>
  </form>
  <h4>Modifica tipi</h4>
  <div class="table-responsive">
    <table class="table table-striped table-bordered text-right">
      @foreach($tipi as $tipo)
      <tr>
        <td><form action="{{url('/admin/tassonomie/update')}}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{$tipo->id}}">
            <table class="table sub-table">
              <tr>
                <td><input type="text" class="form-control" name="name" id="name" value="{{$tipo->name}}"></td>
                <td><input type="text" class="form-control" name="description" value="{{$tipo->description}}"></td>
                <td><input type="text" class="form-control color no-alpha" name="color" value="{{$tipo->color}}"></td>
                <td><input type="submit" class="btn btn-primary" value="Salva">
                  <a  onclick="conferma(event);" type="submit" href="{{url('/admin/tassonomie/delete/id' . '/' . $tipo->id)}}" class="btn btn-danger"> Cancella</a></td>
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
<fieldset>
  <legend>Stato emotivo</legend>
  <form action="{{url('/admin/tassonomie/nuovostatoemotivo')}}" method="post">
    {{ csrf_field() }}
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <input type="text" class="form-control" name="name" placeholder="Nome">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <input type="text" class="form-control" name="description" placeholder="Descrizione">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <input class="form-control color no-alpha" value="#f37f0d" name="color" />
        </div>
      </div>
      <div class="col-md-12 text-right">
        <input type="submit" class="btn btn-primary" value="Aggiungi">
      </div>
    </div>
  </form>
  <h4>Modifica stato emotivo</h4>
  <div class="table-responsive">
    <table class="table table-striped table-bordered text-right">
      @foreach($statiemotivitipi as $statoemotivotipo)
      <tr>
        <td><form action="{{url('/admin/tassonomie/aggiornastatiemotivi')}}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{$statoemotivotipo->id}}">
            <table class="table sub-table">
              <tr>
                <td><input type="text" class="form-control" name="name" id="name" value="{{$statoemotivotipo->name}}"></td>
                <td><input type="text" class="form-control" name="description" value="{{$statoemotivotipo->description}}"></td>
                <td><input type="text" class="form-control color no-alpha" name="color" value="{{$statoemotivotipo->color}}"></td>
                <td><input type="submit" class="btn btn-primary" value="Salva">
                  <a  onclick="conferma(event);" type="submit" href="{{url('/admin/tassonomie/statiemotivi/delete/id' . '/' . $statoemotivotipo->id)}}" class="btn btn-danger"> Cancella </a></td>
              </tr>
            </table>
          </form></td>
      </tr>
      @endforeach
    </table>
  </div>
  </form>
</fieldset>
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