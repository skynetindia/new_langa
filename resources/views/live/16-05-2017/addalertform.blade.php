@extends('adminHome')
@section('page')

@include('common.errors') 
<script src="{{ asset('public/scripts/jquery.min.js') }}"></script> 
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<!-- Latest compiled and minified JavaScript --> 
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.js"></script> 
<!-- Latest compiled and minified Locales --> 
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/locale/bootstrap-table-it-IT.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script> 
<!-- ckeditor --> 
<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script> 
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<h1>Aggiungi Alert</h1>
<hr>
@if(!empty(Session::get('msg'))) 
<script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script> 
@endif
<div class="row">
<form action="{{url('/admin/alert/store')}}" method="post" id="addalert">
  {{ csrf_field() }}
  <div class="col-md-9">
  	<div class="form-group">
    <label> Alert<span class="required" >(*)</span> </label>
    <input class="form-control" id="nome_alert" name="nome_alert" value="" placeholder="Nome Alert">
    </div>
  </div>
  <?php 
  $alert_tipo = DB::table('alert_tipo')
            ->get();

    // foreach($alert_tipo as $type) {

    //     if(isset($type->color)){

    //     $type->nome_tipo = '<span style="color:'.$type->color.'">'.$type->nome_tipo.'</span>';

    //     }
    //     // var_dump($type);
    //     $tipo[] = $type; 
    // }

    // dd($tipo);
?>
  <div class="col-md-3">
  <div class="form-group">
    <label> Tipo Alert<span class="required">(*)</span> </label>
    <select class="form-control" id="tipo_alert" name="tipo_alert" >
      <option value=""></option>
        @foreach($alert_tipo as $type)
      <option style="background-color:{{ $type->color }};" value="{{ $type->id_tipo }};"> {{ $type->nome_tipo }} </option>
        @endforeach
    </select>
    </div> 
    <script>
	    var yourSelect = document.getElementById( "tipo_alert" );
     document.getElementById("tipo_alert").style.backgroundColor = yourSelect.options[yourSelect.selectedIndex].style.backgroundColor;
                $('#tipo_alert').on("change", function() {
                    var yourSelect = document.getElementById( "tipo_alert" );
					console.log(yourSelect.options[yourSelect.selectedIndex].style.backgroundColor);
                    document.getElementById("tipo_alert").style.backgroundColor = yourSelect.options[yourSelect.selectedIndex].style.backgroundColor;
                });
				</script> 
  </div>
  <?php /* 
  <div class="col-md-6">

  <textarea id="show_ente" name="show_ente" class="form-control" rows="4"></textarea><br>

  </div>

  <div class="col-md-6">

  <textarea id="show_role" name="show_role" class="form-control" rows="4"></textarea><br>

  </div> 

  <br>*/?>
  <div class="col-md-6">
   <div class="form-group">
    <label for="ente">Ente</label>
    <select id="ente" name="ente[]" class="js-example-basic-multiple form-control" multiple="multiple">
      <option></option>
    @foreach($enti as $enti)
      <option value="{{ $enti->id }}"> {{$enti->nomeazienda}} </option>
    @endforeach
    </select>
    </div>
  </div>
  
  <div class="col-md-6">
   <div class="form-group">
    <label for="ruolo">Ruolo</label>
    <select id="ruolo" name="ruolo[]" class="js-example-basic-multiple form-control" onchange="myRole()"  multiple="multiple">
      <option></option>
    @foreach($ruolo_utente as $ruolo_utente)
      <option value="{{ $ruolo_utente->ruolo_id }}"> {{$ruolo_utente->nome_ruolo}} </option>
    @endforeach
    </select>
    </div>
    <script type="text/javascript">

         $(".js-example-basic-multiple").select2();
		$('#ente').on("select2:selecting", function(e) { 
			/*var selectad=$(".select2-selection").html();			
			$("#show_ente").html(selectad);*/
		   	//var theSelection = $('#ente').select2('data').text;
			//alert(theSelection);
   			// what you would like to happen
		});

        function myEnte() {
          var ente = document.getElementsByName("ente");

          console.log(ente.length);

          for(var x=0; x < ente.length; x++)   
          {
            console.log(ente[x].value, "hello");
            // document.getElementById("show_ente").innerHTML = ente[x].value;
          }
          
        }

        function myRole() {
          var x = document.getElementById("ruolo").value;
          console.log(x);
          // document.getElementById("show_role").innerHTML = x;
        }

      </script> 
  </div>

<div class="row">
<div class="col-md-12">
 <div class="form-group">
  <label>Messaggio</label>
  <textarea name="messaggio" id="messaggio" rows="10" cols="50" class="form-control"></textarea>
  </div>
  <script type="text/javascript" >
      CKEDITOR.replace( 'messaggio' );
    </script> 
  
  <input class="btn btn-warning" type="submit" value="INVIA">
  </div>
  </div>
</form>
</div>
<div class="space30"></div>
<h1 class="cst-datatable-heading">Elenco Activity</h1>
<table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="{{ url('/alert/enti/json') }}" data-classes="table table-bordered" id="table">
  <thead>
  
    <th data-field="id_ente" data-sortable="true">n° ente
    
    <th data-field="nome_azienda" data-sortable="true">Nome azienda
    
    <th data-field="nome_referente" data-sortable="true">Nome referente
    
    <th data-field="settore" data-sortable="true">Settore
    
    <th data-field="telefono_azienda" data-sortable="true">Telefono azienda
    
    <th data-field="email" data-sortable="true">Email
    
    <th data-field="data_lettura" data-sortable="true">Data e Ora di Lettura
    
    <th data-field="responsible_langa" data-sortable="true">Responsible LANGA
    
    <th data-field="comment" data-sortable="true"> Comment
    
    <th data-field="conferma" data-sortable="true">Conferma
      </thead>
</table>
<div class="footer-svg">
	<img src="{{asset('images/ADMIN_AVVISI-footer.svg')}}" alt="avvisi">
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

function check() { return confirm("Sei sicuro di voler eliminare: " + n + " newsletter?"); }
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
      link.href = "{{ url('/newsletter/delete/') }}" + '/';
      if(check() && n!=0) {
        for(var i = 0; i < n; i++) {
          $.ajax({
            type: "GET",
            url : link.href + indici[i],
            error: function(url) {
              if(url.status==403) {
                link.href = "{{ url('/newsletter/delete/') }}" + '/' + indici[n];
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
          link.href = "{{ url('/newsletter/modify/') }}" + '/' + indici[n];
          n = 0;
          selezione = undefined;
          link.dispatchEvent(clickEvent);
        }
      break;
    }
}
</script> 
@endsection 