@extends('adminHome')
@section('page')

@include('common.errors')

<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.js"></script>

<!-- Latest compiled and minified Locales -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/locale/bootstrap-table-it-IT.min.js"></script>
<h1>Template per Tassazione</h1><hr>
@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif
<a onclick="multipleAction('add');" id="add"  class="btn btn-warning" name="create" title="Crea nuovo - Aggiungi un nuovo taxation"><span class="fa fa-plus"></span></a>
<div class="space10"></div>
<a onclick="multipleAction('modify');" id="modifica" class="btn btn-primary"  name="update" title="Modifica - Modifica l'ultimo taxation selezionato"><span class="fa fa-pencil"></span></a>
<a id="delete" onclick="multipleAction('delete');" class="btn btn-danger" name="remove" title="Elimina - Elimina i taxation selezionati"><span class="fa fa-trash"></span></a>
<div class="table-responsive">
    <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="taxation/json" data-classes="table table-bordered" id="table">
        <thead>
            <th data-field="tassazione_id" data-sortable="true">n° id</th>
            <th data-field="tassazione_nome" data-sortable="true">Nome</th>
            <th data-field="tassazione_percentuale" data-sortable="true">Percentuale</th>
        </thead>
    </table>
</div>

<script>
var selezione = [];
var indici = [];
var n = 0;

$('#table').on('click-row.bs.table', function (row, tr, el) {
  var cod = /\d+/.exec($(el[0]).children()[0].innerHTML);
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

function check() { return confirm("Sei sicuro di voler eliminare: " + n + " tassazione?"); }
function multipleAction(act) {
  var error = false;
  var link = document.createElement("a");
  var clickEvent = new MouseEvent("click", {
      "view": window,
      "bubbles": true,
      "cancelable": false
  });
  switch(act) {
    case 'delete':
      link.href = "{{ url('/taxation/delete/') }}" + '/';
      if(check() && n!=0) {
        for(var i = 0; i < n; i++) {
          $.ajax({
            type: "GET",
            url : link.href + indici[i],
            error: function(url) {
              if(url.status==403) {
                link.href = "{{ url('/taxation/delete/') }}" + '/' + indici[n];
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
                if(n!=0) {
          n--;
          link.href = "{{ url('/taxation/add/') }}" + '/' + indici[n];
          n = 0;
          selezione = undefined;
          link.dispatchEvent(clickEvent);
        }
      break;
    case 'add':
             
          link.href = "{{ url('/taxation/add/') }}";
          link.dispatchEvent(clickEvent);
        
      break;
    }
}
</script>

@endsection