@extends('adminHome')



@section('page')
<h1>Elenco Utenti</h1>
<hr>
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

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.css">

<!-- Latest compiled and minified JavaScript --> 
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.js"></script> 

<!-- Latest compiled and minified Locales --> 
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/locale/bootstrap-table-it-IT.min.js"></script>
<div class="btn-group"> 
<a onclick="multipleAction('add');" id="add" >
  <button class="btn btn-warning" type="button" name="add" title="Add  - Add new utente"><i class="glyphicon glyphicon-plus"></i></button>
  </a>
  <a onclick="multipleAction('modify');" id="modifica" >
  <button class="btn btn-warning" type="button" name="update" title="Modifica - Modifica l'ultimo ente selezionato"><i class="glyphicon glyphicon-pencil"></i></button>
  </a>
   <a id="delete" onclick="multipleAction('delete');" >
  <button class="btn btn-danger" type="button" name="remove" title="Elimina - Elimina gli enti selezionati"><i class="fa fa-trash"></i></button>
  </a> 
  </div>
<br>
<br>
<div class="table-responsive table-custom-design">
  <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="{{ url('users/json') }}" data-classes="table table-bordered" id="table">
    <thead>
    <th data-field="id" data-sortable="true" class="id">ID </th>
      <th data-field="name" data-sortable="true">Nome </th>
      <th data-field="nome_ruolo" data-sortable="true" class="profilazione">Profilazione</th>
      <th data-field="cellulare" data-sortable="true">Cellulare </th>
      <th data-field="email" data-sortable="true">Email </th>
      <th data-field="id_ente" data-sortable="true">ID Ente </th>
        </thead>
  </table>
  
  
  <!-- <div class="table-responsive">

<table class="selectable table table-hover table-bordered" id="table" cellspacing="0" cellpadding="0">

<thead>

<tr style="background: #999; color:#ffffff"> --> 
  
  <!-- Intestazione tabella dipartimenti --> 
  
  <!-- <th>#</th>

<th>Codice</th>

<th>Nome</th>

<th>Profilazione</th>

<th>Cellulare</th>

<th>Email</th>

<th>ID Ente</th>

</tr>

</thead>

<tbody>
 -->
  <?php $count = 0; ?>
  
  <!--

'sconti'

'entisconti' = legame tra l'id_sconto e l'id_tipo ente,

'tipienti' = Elenco dei tipi enti (POTENZIALE, CLIENTE, ... con ->color)

--> 
  
  <!-- @foreach ($utenti as $utente) --> 
  
  <!-- <tr>

		<td><input class="selectable" type="checkbox"></td>

		<td>{{$utente->id}}</td>

                <td>{{$utente->name}}</td>

                @php
                $department = DB::table('ruolo_utente')
                    ->where('ruolo_id', '=', $utente->dipartimento)
                    ->first();
                @endphp
                <td>
                    {{ $department->nome_ruolo }}
                </td>

                <td>{{$utente->cellulare}}</td>

                <td>{{$utente->email}}</td> -->
  
  <?php 
                        
                    if(strchr($utente->id_ente, ',')){ 

                        $enti = explode(',',$utente->id_ente);

                        echo "<td>";
                        foreach ($enti as $value) { ?>
  
  <!--   <a href="{{url('/enti/modify/corporation' . "/" . $value )}}">{{ $value }}</a> -->
  
  <?php } echo "</td>"; } else {  ?>
  <!-- 
                        <td><a href="{{url('/enti/modify/corporation' . "/" . $utente->id_ente )}}">{{$utente->id_ente}}</a></td> -->
  
  <?php } ?>
  </tr>
  <?php $count++; ?>
  
  <!-- @endforeach		 -->
  
  </tbody>
  </table>
  <?php if($count==0) {

	echo "<h3 style='text-align:center;'>Nessuno utenti trovato</h3>";

} ?>
</div>
<div class="pull-right"> 
  
  <!-- {{ $utenti->links() }} --> 
  
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
      link.href = "{{ url('/admin/destroy/utente') }}" + '/';
      if(check() && n!=0) {
        for(var i = 0; i < n; i++) {
          $.ajax({
            type: "GET",
            url : link.href + indici[i],
            error: function(url) {
              if(url.status==403) {
                link.href = "{{ url('/admin/destroy/utente') }}" + '/' + indici[n];
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
          link.href = "{{ url('/admin/modify/utente') }}" + '/' + indici[n];
          n = 0;
          selezione = undefined;
          link.dispatchEvent(clickEvent);
        }
      break;
    case 'add':
             
          link.href = "{{ url('/admin/modify/utente') }}";
          link.dispatchEvent(clickEvent);
        
      break;
    }
}
</script> 
<script>

// var selezione = [];

// var n = 0;

// $(".selectable tbody tr input[type=checkbox]").change(function(e){
// 	var stato = e.target.checked;
//   if (stato) {
	
// 	  $(this).closest("tr").addClass("selected");
// 	  selezione[n] = $(this).closest("tr").children()[1].innerHTML;
// 	   n++;
//   } else {
// 	  selezione[n] = undefined;
// 	  n--;
// 	  $(this).closest("tr").removeClass("selected");
//   }
// });

// $(".selectable tbody tr").click(function(e){
//     var cb = $(this).find("input[type=checkbox]");
//     cb.trigger('click');
// });


// function check() {
// return confirm("Sei sicuro di voler eliminare: " + n + " utenti?");
// }



// function multipleAction(act) {

// 	var link = document.createElement("a");

// 	var clickEvent = new MouseEvent("click", {

// 	    "view": window,

// 	    "bubbles": true,

// 	    "cancelable": false

// 	});

// 	if(selezione!==undefined) {

// 		switch(act) {

// 			case 'delete':

// 				link.href = "{{ url('/admin/destroy/utente') }}" + '/';

// 				if(check()) {

//                                     for(var i = 0; i < n; i++) {

//                                         $.ajax({

//                                             type: "GET",

//                                             url : link.href + selezione[i],

//                                             error: function(url) {

//                                                 if(url.status==403) {

//                                                     link.href = "{{ url('/admin/destroy/utente') }}" + '/' + selezione[--n];

//                                                     link.dispatchEvent(clickEvent);

//                                                 } 

//                                             }

//                                         });

//                                     }

//                                     setTimeout(function(){location.reload();},100*n);

//                                 }

					

// 			break;

// 			case 'modify':
// 				n--;
//                 if(selezione[n]!=undefined) {
					
// 					link.href = "{{ url('/admin/modify/utente') }}" + '/' + selezione[n];
// 					n = 0;
// 					selezione = undefined;
// 					link.dispatchEvent(clickEvent);
// 				}
// 				n = 0;
// 			break;

//             case 'add':
        
//                 link.href = "{{ url('/admin/modify/utente') }}"; 
//                 link.dispatchEvent(clickEvent);
          
//             break;

// 		}

// 	}

// }

</script> 
@endsection 