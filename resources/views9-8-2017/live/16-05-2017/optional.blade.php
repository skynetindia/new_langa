@extends('adminHome')
@section('page')
<h1>Optional</h1>
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
<form action="{{ url('/admin/tassonomie/optional/add') }}" method="post">
  {{ csrf_field() }}
  <button class="btn btn-warning" type="submit" name="create" title="Crea nuovo - Aggiungi un nuovo optional"><i class="fa fa-plus"></i></button>
</form>
<div class="space10"></div>
<a onclick="multipleAction('modify');" id="modifica" class="btn btn-primary" title="Modifica - Modifica l'ultimo ente selezionato"> <i class="glyphicon glyphicon-pencil"></i></a> 
<a id="delete" onclick="multipleAction('delete');"  class="btn btn-danger" name="remove" title="Elimina - Elimina gli enti selezionati"><i class="fa fa-trash"></i> </a>
<div class="space30"></div>
<div class=" table-responsive table-custom-design">
  <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="{{ url('optional/json') }}" data-classes="selectable table table-bordered" id="table">
    <thead>
    <th data-field="id" data-sortable="true">Codice</th>
      <th data-field="code" data-sortable="true">Code</th>
      <th data-field="label" data-sortable="true">Nome</th>
      <th data-field="description" data-sortable="true">Descrizione</th>
      <th data-field="icon" data-sortable="true">Icona</th>
      <th data-field="price" data-sortable="true">Prezzo</th>
        </thead>
  </table>
</div>
<div class="space50"></div>
<div class="footer-svg">
	<img src="http://betaeasy.langa.tv/images/ADMIN_TASSONOMIE-footer.svg" alt="tassonomie">
</div>
<!--     
<div class="table-responsive">

<table class="selectable table table-hover table-bordered" id="table" cellspacing="0" cellpadding="0">

<thead>

<tr style="background: #999; color:#ffffff"> --> 

<!-- Intestazione tabella dipartimenti --> 

<!-- <th>#</th>

<th>Codice</th>

<th>Code</th>

<th>Nome</th>

<th>Descrizione</th>

<th>Icona</th>

<th>Prezzo</th>

</tr>

</thead>

<tbody> -->

<?php //$count = 0; ?>

<!-- @foreach ($optional as $opt) --> 

<!-- <tr>

		<td><input class="selectable" type="checkbox"></td>

		<td>{{$opt->id}}</td>

                <td>{{$opt->code}}</td>

                <td>{{$opt->label}}</td>

                <td>{{$opt->description}}</td>

                <td><img src="{{ asset('storage/app/images/'.$opt->icon) }}" style="max-width:100px; max-height:100px"></img></td>

                <td>{{$opt->price}}</td>

	</tr>

        <?php //$count++; ?> --> 

<!-- @endforeach		 --> 

<!-- </tbody>

</table> -->

<?php //if($count==0) {

	//echo "<h3 style='text-align:center;'>Nessun optional trovato</h3>";

//} ?>


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

	return confirm("Sei sicuro di voler eliminare: " + n + " optional?");

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

				link.href = "{{ url('/admin/tassonomie/delete/optional') }}" + '/';

				if(check() && selezione != undefined) {

                                    for(var i = 0; i < n; i++) {

                                        $.ajax({

                                            type: "GET",

                                            url : link.href + selezione[i],

                                            error: function(url) {

                                                if(url.status==403) {

                                                    link.href = "{{ url('/admin/tassonomie/delete/optional') }}" + '/' + selezione[n];

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
					link.href = "{{ url('/admin/tassonomie/modify/optional') }}" + '/' + selezione[n];
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