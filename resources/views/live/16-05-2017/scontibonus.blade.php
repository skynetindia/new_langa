@extends('adminHome')

@section('page')
<h1>Sconti bonus</h1><hr>
@include('common.errors')


<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>
<script>
  $(function(){
        $("table").stupidtable();
    });
    
    
@if(!empty(Session::get('msg')))


    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);

@endif
</script>


<form action="{{ url('/admin/tassonomie/scontibonus/add') }}" method="post">
{{ csrf_field() }}
<button class="btn btn-warning" type="submit" name="create" title="Crea nuovo - Aggiungi un nuovo sconto bonus"><i class="fa fa-plus"></i></button>
</form>
<div class="space10"></div>
<a onclick="multipleAction('modify');" id="modifica" name="update" class="btn btn-primary"  title="Modifica - Modifica l'ultimo ente selezionato"><i class="glyphicon glyphicon-pencil"></i></a>
<a id="delete" class="btn btn-danger" name="remove" title="Elimina - Elimina gli enti selezionati" onclick="multipleAction('delete');"><i class="fa fa-trash"></i></a>
<div class="space30"></div>

<div class="table-responsive">
<table class="selectable table table-hover table-bordered grey-heading" id="table" cellspacing="0" cellpadding="0">
<thead>
<tr>
<!-- Intestazione tabella dipartimenti -->
<th>#</th>
<th>Codice</th>
<th>Nome</th>
<th>Descrizione</th>
<th>Utente</th>
<th>Sconto %</th>
</tr>
</thead>
<tbody>
<?php $count = 0; ?>
    <!--
'sconti'
'entisconti' = legame tra l'id_sconto e l'id_tipo ente,
'tipienti' = Elenco dei tipi enti (POTENZIALE, CLIENTE, ... con ->color)
-->
@foreach ($sconti as $sconto)
	<tr>
		<td> <input class="selectable" type="checkbox" id="sconti<?php echo $count; ?>"> <label for="sconti<?php echo $count; ?>">sconti<?php echo $count; ?></label> </td>
		<td>{{$sconto->id}}</td>
                <td>{{$sconto->name}}</td>
                <td>{{$sconto->descrizione}}</td>
                @foreach($entisconti as $entesconto)
                    @if($entesconto->id_sconto == $sconto->id)
                        @foreach($tipienti as $tipoente)
                            @if($tipoente->id == $entesconto->id_tipo)
                                <td><p style="padding-left:5px;">{{$tipoente->name}}</p></td> 
                            @endif
                        @endforeach
                    @endif
                @endforeach
                <td>{{$sconto->sconto}}%</td>
	</tr>
        <?php $count++; ?>
@endforeach		
</tbody>
</table>
<?php if($count==0) {
	echo "<h3 style='text-align:center;'>Nessuno sconto trovato</h3>";
} ?>
</div>
<div class="pull-right">
{{ $sconti->links() }}
</div>
<div class="footer-svg">
	<img src="{{asset('images/ADMIN_TASSONOMIE-footer.svg')}}" alt="tassonomie">
</div>
<script>
var selezione = [];
var n = 0;
$(".selectable tbody tr input[type=checkbox]").change(function(e){
	var stato = e.target.checked;
  if (stato) {
	 
	  $(this).closest("tr").addClass("selected");
	  selezione[n] = $(this).closest("tr").children()[1].innerHTML;
	   n++;
  } else {
	  selezione[n] = undefined;
	  n--;
	  $(this).closest("tr").removeClass("selected");
  }
});

$(".selectable tbody tr").click(function(e){
    var cb = $(this).find("input[type=checkbox]");
    cb.trigger('click');
});


function check() {
	return confirm("Sei sicuro di voler eliminare: " + n + " bonus sconti?");
}

function multipleAction(act) {
	var link = document.createElement("a");
	var clickEvent = new MouseEvent("click", {
	    "view": window,
	    "bubbles": true,
	    "cancelable": false
	});
	if(selezione!==undefined) {
		switch(act) {
			case 'delete':
				link.href = "{{ url('/admin/tassonomie/delete/scontobonus') }}" + '/';
				if(check()) {
                                    for(var i = 0; i < n; i++) {
                                        $.ajax({
                                            type: "GET",
                                            url : link.href + selezione[i],
                                            error: function(url) {
                                                if(url.status==403) {
                                                    link.href = "{{ url('/admin/tassonomie/delete/scontobonus') }}" + '/' + selezione[n];
                                                    link.dispatchEvent(clickEvent);
                                                } 
                                            }
                                        });
                                    }
                                    setTimeout(function(){location.reload();},100*n);
                                }
					
			break;
			case 'modify':
                                
					n--;
                if(selezione[n]!=undefined) {
					link.href = "{{ url('/admin/tassonomie/modify/scontobonus') }}" + '/' + selezione[n];
					n = 0;
					selezione = undefined;
					link.dispatchEvent(clickEvent);
				}
				n = 0;
			break;
		}
	}
}

</script>

@endsection