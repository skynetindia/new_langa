@extends('layouts.app')
@section('content')

<h1>Elenco optional del preventivo: <strong>{{$preventivo->oggetto}}</strong></h1>

@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif

<a class="btn btn-info" onclick="window.close();" title="Torna al progetto"><span class="fa fa-arrow-left"></span></a>

<br>
<form action="{{url('/preventivo/optional/aggiorna') . '/' . $preventivo->id}}" method="post">
    {{ csrf_field() }}

<!-- hide Salva button  -->

   <!--  <div class="row">
        <div class="col-md-12">
            <input type="submit" class="btn btn-warning btn-sm" value="Salva">
        </div>
    </div> -->
    <div class="table-responsive">
        <table class="table table-bordered">
        <?php $count = 0;?>

            @foreach($optional as $opt)
                <tr>
                	<td>
                        Ordinamento: <input type="number" name="ord[]" value="{{$opt->ordine}}" class="form-control">
                    </td>
                    <td>
                        Oggetto: <input type="text" name="oggetti[]" value="{{$opt->oggetto}}" class="form-control">
                    </td>
                    <td>
                        Descrizione:                                                                                  <input type="text" name="desc[]" value="{{$opt->descrizione}}" class="form-control">
                    </td>
                    <td>
                        Q.tà: <input type="number" name="qt[]" value="{{$opt->qta}}" class="form-control">
                    </td>
                    <td>
                        Prezzo unitario: <input type="number" step=any name="pru[]" value="{{$opt->prezzounitario}}" class="form-control">
                    </td>
                    <td>
                        Totale: <input type="number" name="tot[]" step=any value="{{$opt->totale}}" class="form-control">
                    </td>
                    <td>
                        Asterisca:
                        <select name="ast[]" class="form-control">
                        @if($opt->asterisca == 1)
                            <option selected value="1">Si</option>
                            <option value="0">No</option>
                        @else
                            <option value="1">Si</option>
                            <option selected value="0">No</option>
                        @endif
                        </select>
                    </td>
                    <td>
                    Ciclicita<br />
						<input name="cicli[{{ $count}}]" value="1_M" <?php if($opt->Ciclicita == '1_M'){ echo 'checked';} ?> type="radio"> 1 M. 
                        <input name="cicli[{{ $count}}]" value="2_M" <?php if($opt->Ciclicita == '2_M'){ echo 'checked';} ?> type="radio"> 2 M. 
                        <input name="cicli[{{ $count}}]" value="3_M" <?php if($opt->Ciclicita == '3_M'){ echo 'checked';} ?> type="radio"> 3 M. 
                        <input name="cicli[{{ $count}}]" value="4_M" <?php if($opt->Ciclicita == '4_M'){ echo 'checked';} ?> type="radio"> 6 M. 
                        <input name="cicli[{{ $count}}]" value="5_M" <?php if($opt->Ciclicita == '5_M'){ echo 'checked';} ?> type="radio"> 1 A. 
                    </td>
                    <td>
                        <a onclick="return confirm('Sei sicuro di voler eliminare questo optional?');" href="{{url('/preventivi/optional/elimina') . '/' . $opt->id}}" class="btn btn-danger">Elimina optional</a>
                    </td>
                </tr><?php $count++?>
                     
            @endforeach
        </table>
    </div>
    <div class="row">
        <div class="col-md-12">
            <input type="submit" class="btn btn-warning btn-sm" value="Salva">
        </div>
    </div>
</form>

@endsection