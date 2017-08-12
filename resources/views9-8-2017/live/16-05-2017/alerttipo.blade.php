@extends('adminHome')

@section('page')
<h1> Alert Tipo </h1><hr>
@include('common.errors')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript" src="{{asset('public/scripts/colors.js')}}"></script>
<script type="text/javascript" src="{{asset('public/scripts/jqColorPicker.min.js')}}"></script>
<script type="text/javascript">
         $('.color').colorPicker(); // that's it
</script>
<fieldset>
<legend>Tipi</legend>
<form action="{{url('/alert/add/tipo')}}" method="post" name="alerttipo" id="alerttipo">
    {{ csrf_field() }}
	<div class="row">
    <div class="col-md-12">
    <h4>Aggiungi tipo</h4>
    </div>
    <div class="col-md-12">
   <label> <span class="required">(*)</span></label>
    </div>
    <div class="col-md-4"> 
    	<div class="form-group">
			<input type="text" class="form-control" id="nome_tipo" name="nome_tipo" placeholder="Nome">
        </div>
	</div>
    
	<div class="col-md-4">
    <div class="form-group">
		<input type="text" class="form-control" id="desc_tipo" name="desc_tipo" placeholder="Descrizione">
       </div>
	</div>
	<div class="col-md-4">
    <div class="form-group">
		<input class="form-control color no-alpha" value="#f37f0d" name="color" id="color" />
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
		@foreach($alert_tipo as $type)
		<tr>
    		<td>   
            	
        			<form action="{{url('/admin/update/tipo')}}" method="post" id="modifyalerttipo" name="modifyalerttipo">
		{{ csrf_field() }}
		<input type="hidden" name="id_tipo" value="{{$type->id_tipo}}">
			<table class="table sub-table">
            <tr>
        	<td>
				<input type="text" class="form-control" name="nome_tipo" id="nome_tipo" value="{{$type->nome_tipo}}"> 
			</td>
			<td><input type="text" class="form-control" name="desc_tipo" value="{{$type->desc_tipo}}"></td>
			<td><input type="text" class="form-control color no-alpha" name="color" value="{{$type->color}}"></td>
			<td><input type="submit" class="btn btn-primary" value="Salva">
			<a  onclick="conferma(event);" type="submit" href="{{url('/admin/delete/tipo' . '/' . $type->id_tipo)}}" class="btn btn-danger">Cancella</a></td>
			</tr>
            </table>
				</form>
    		</td>
		</tr>
	
	@endforeach
	</table>
	</div>
	
</form>
</fieldset>
<div class="footer-svg">
	<img src="{{asset('images/ADMIN_AVVISI-footer.svg')}}" alt="avvisi">
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