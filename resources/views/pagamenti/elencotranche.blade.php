@extends('layouts.app')
@section('content')

@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif

@include('common.errors')
<style>
tr:hover {
	background: #f39538;
}
.selected {
	font-weight: bold;
	font-size: 16px;
}
th {
	cursor: pointer;
}
li label {
	padding-left: 10px;
}
</style>

<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.js"></script>

<!-- Latest compiled and minified Locales -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/locale/bootstrap-table-it-IT.min.js"></script>

<h1>Elenco fatture</h1><hr>

<div class="btn-group">
<a onclick="multipleAction('modify');" id="modifica" style="display:inline;">
<button class="btn btn-primary" type="button" name="update" title="Modifica - Modifica l'ultima disposizione selezionata"><i class="fa fa-pencil"></i></button>
</a>
<a id="duplicate" onclick="multipleAction('duplicate');" style="display:inline;">
<button class="btn btn-info" type="button" name="duplicate" title="Duplica - Duplica le disposizioni selezionate"><i class="fa fa-files-o"></i></button>
</a>    
<a id="delete" onclick="multipleAction('delete');" style="display:inline;">
<button class="btn btn-danger" type="button" name="remove" title="Elimina - Elimina le disposizioni selezionate"><i class="fa fa-trash"></i></button>
</a>
<a id="pdf" onclick="multipleAction('pdf');" style="display:inline;">
<button class="btn" type="button" name="pdf" title="PDF - Genera il PDF delle disposizioni selezionate"><i class="fa fa-file-pdf-o"></i></button>
</a>
</div>
<br><br>
    <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="<?php echo url('/pagamenti/tranche/json');?>" data-classes="table table-bordered" id="table">
        <thead>
            <th data-field="id" data-sortable="true">n° disposizione
            <th data-field="idfattura" data-sortable="true">n° fattura
            <th data-field="ente" data-sortable="true">Ente
            <th data-field="nomequadro" data-sortable="true">Nome quadro
            <th data-field="tipo" data-sortable="true">Tipo
            <th data-field="datainserimento" data-sortable="true">Inserimento
            <th data-field="datascadenza" data-sortable="true">Scadenza
            <th data-field="percentuale" data-sortable="true">%
            <th data-field="dapagare" data-sortable="true">Da pagare
            <th data-field="statoemotivo" data-sortable="true">Stato emotivo
        </thead>
    </table>

<script>
var selezione = [];
var indici = [];
var n = 0;

$('#table').on('click-row.bs.table', function (row, tr, el) {
	var cod = /\d+/.exec($(el[0]).children()[0].innerHTML);
	//console.log(/\d+/.exec($(el[0]).children()[1].innerHTML));
	if (!selezione[cod]) {
		$(el[0]).addClass("selected");
		selezione[cod] = cod;
		indici[n] = cod;
		n++;
	} else {
		$(el[0]).removeClass("selected");
		selezione[cod] = undefined;
		for(var i = 0; i < n; i++) {
			if(indici[i] == cod) {
				for(var x = i; x < indici.length - 1; x++)
					indici[x] = indici[x + 1];
				break;	
			}
		}
		n--;
	}
});



function check() { return confirm("Sei sicuro di voler eliminare: " + n + " tranche?"); }
function multipleAction(act) {
	var link = document.createElement("a");
	var clickEvent = new MouseEvent("click", {
	    "view": window,
	    "bubbles": true,
	    "cancelable": false
	});
	var error = false;
		switch(act) {
			case 'delete':
				link.href = "{{ url('/pagamenti/tranche/delete/') }}" + '/';
				if(check() && n!=0) {
                                    for(var i = 0; i < n; i++) {
                                        $.ajax({
                                            type: "GET",
                                            url : link.href + indici[i],
                                            error: function(url) {
                                                if(url.status==403) {
                                                    link.href = "{{ url('/pagamenti/tranche/delete/') }}" + '/' + indici[n];
                                                    link.dispatchEvent(clickEvent);
                                                } 
                                            }
                                        });
                                    }
                                    selezione = undefined;
                                    setTimeout(function(){location.reload();},100*n);
                                    n = 0;
                                }
			break;
			case 'modify':
                if(n != 0) {
					n--;
					link.href = "{{ url('/pagamenti/tranche/modifica') }}" + '/' + indici[n];
					n = 0;
					selezione = undefined;
					link.dispatchEvent(clickEvent);
				}
			break;
			case 'pdf':
               link.href = "{{ url('/pagamenti/tranche/pdf') }}" + '/';
			    for(var i = 0; i < n; i++) {
                    var url = link.href + indici[i];
                    var win = window.open(url, '_blank');
                    win.focus();
                }
                n = 0;
                selezione = undefined;
                setTimeout(function(){location.reload();},100*n);
			break;
            case 'duplicate':
				link.href = "{{ url('/pagamenti/tranche/duplicate') }}" + '/';
                for(var i = 0; i < n; i++) {
                    $.ajax({
                        type: "GET",
                        url : link.href + indici[i],
                        error: function(url) {
                            if(url.status==403) {
                                link.href = "{{ url('/pagamenti/tranche/duplicate') }}" + '/' + indici[n];
                                link.dispatchEvent(clickEvent);
                                error = true;
                            } 
                        }
                    });
                }
                selezione = undefined;
                if(error === false)
                    setTimeout(function(){location.reload();},100*n);
                n = 0;
			break;
		}
}    

</script>



@endsection