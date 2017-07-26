@extends('adminHome')
@section('page')
<h1>Quiz Pacchetto</h1><hr>
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

<a onclick="multipleAction('add');" id="add" class="btn btn-warning" name="add" title="Add  - Add new utente"><i class="glyphicon glyphicon-plus"></i></a>
<div class="space10"></div>
<a onclick="multipleAction('modify');" id="modifica" class="btn btn-primary" name="update" title="Modifica - Modifica l'ultimo ente selezionato"><i class="glyphicon glyphicon-pencil"></i></a>
<a id="delete" onclick="multipleAction('delete');" class="btn btn-danger" name="remove" title="Elimina - Elimina gli enti selezionati"><i class="fa fa-trash"></i></a>
<div class="space30"></div>
<div class="table-responsive">
<table class="selectable table table-hover table-bordered grey-heading" id="table" cellspacing="0" cellpadding="0">
<thead>
<tr>
<!-- Intestazione tabella dipartimenti -->
<th>#</th>
<td>ID</td>
<th>Nome del pacchetto</th>
<th>Pagine totali</th>
<th>Prezzo del pacchetto</th>
<th>Per pagina prezzo</th>
</tr>
</thead>
<tbody>
<?php $count = 0; ?>
    <!--
'sconti'
'entisconti' = legame tra l'id_sconto e l'id_tipo ente,
'tipienti' = Elenco dei tipi enti (POTENZIALE, CLIENTE, ... con ->color)
-->
@foreach ($pacchetto as $pacchetto)
	<tr>
		<td><input class="selectable" type="checkbox"></td>
				<td>{{$pacchetto->id}}</td>
                <td>{{$pacchetto->nome_pacchetto}}</td>
                <td>{{$pacchetto->pagine_totali}}</td>
                <td>{{$pacchetto->prezzo_pacchetto}}</td>
                <td>{{$pacchetto->per_pagina_prezzo}}</td><?php 
                        
                   /* if(strchr($utente->id_ente, ',')){ 
                        $enti = explode(',',$utente->id_ente);
                        echo "<td>";
                        foreach ($enti as $value) { ?>
                            
                           <a href="{{url('/enti/modify/corporation' . "/" . $utente->id_ente )}}">{{ $value }}</a>
                
                <?php } echo "</td>"; } else {  ?>
                        <td><a href="{{url('/enti/modify/corporation' . "/" . $utente->id_ente )}}">{{$utente->id_ente}}</a></td>
                    <?php } */?>
	</tr>
        <?php $count++; ?>

@endforeach		
</tbody>
</table>
<?php if($count==0) {
	echo "<h3 style='text-align:center;'>Nessuno sconto trovato</h3>";
} ?>
</div>
<div class="footer-svg">
	<img src="{{asset('images/ADMIN_QUIZ-footer.svg')}}" alt="quiz">
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
	return confirm("Sei sicuro di voler eliminare: " + n + " pacchetto?");
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
				link.href = "{{ url('/admin/destroy/pacchetto') }}" + '/';
				if(check()) {
                                    for(var i = 0; i < n; i++) {
                                        $.ajax({
                                            type: "GET",
                                            url : link.href + selezione[i],
                                            error: function(url) {
                                                if(url.status==403) {
                                                    link.href = "{{ url('/admin/destroy/pacchetto') }}" + '/' + selezione[--n];
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
					
					link.href = "{{ url('/admin/modify/pacchetto') }}" + '/' + selezione[n];
					n = 0;
					selezione = undefined;
					link.dispatchEvent(clickEvent);
				}
				n = 0;
			break;
            case 'add':
        
                link.href = "{{ url('/admin/modify/pacchetto') }}"; 
                link.dispatchEvent(clickEvent);
          
            break;
		}
	}
}
</script>
@endsection