@extends('adminHome')

@section('page')

<h1>Impostazioni globali</h1><hr>
{!! Form::open(array('url' => 'admin/globali/store', 'files' => true)) !!}
	<div class="form-group">
		<label for="logo">Logo</label>
		<?php echo Form::file('logo'); ?><br>
		<div style="width:50px; height:50px">
			<img style="width:50px; height:50px;" src="data:image/png;base64,<?php echo $logo; ?>"></img>
		</div>
	</div>
	<input value="Salva" type="submit" class="btn btn-primary" style="background:#f37f0d;border-color:#333">
{!! Form::close() !!}
<br>
<h4>Profilazione Easy <strong>LANGA</strong></h4>
<hr><?php //print_r($profilazioni);exit;?>
<div class="table-responsive">
    <table class="table table-striped">
        <th>Profilazione
        <th>Lettura
        <th>Scrittura
    @foreach($profilazioni as $profilazione)
    <tr>
        <td>
            {{$profilazione->nome_ruolo}}
        </td>
        <td>
            <input type="radio">
        </td>
        <td>
            <input type="radio">
        </td>
    </tr>
    @endforeach
    </table>
</div>

@endsection