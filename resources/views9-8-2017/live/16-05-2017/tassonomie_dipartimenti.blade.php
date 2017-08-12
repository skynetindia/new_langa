@extends('adminHome')



@section('page')
<h1>Tassonomie dipartimenti</h1>
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
  <form action="{{ url('/admin/tassonomie/dipartimenti/add') }}" method="post">
    {{ csrf_field() }}
    <button class="btn btn-warning" type="submit" name="create" title="Crea nuovo - Aggiungi un nuovo dipartimento"><i class="fa fa-plus"></i></button>
  </form>
  <div class="space10"></div>
  <a onclick="multipleAction('modify');" id="modifica" class="btn btn-primary" name="update" title="Modifica - Modifica l'ultimo ente selezionato"><i class="glyphicon glyphicon-pencil"></i>  </a>
 <a id="delete" onclick="multipleAction('delete');" class="btn btn-danger" name="remove" title="Elimina - Elimina gli enti selezionati"> <i class="fa fa-trash"></i>  </a>
<div class="space30"></div>
<div class="table-responsive">
  <table class="selectable table table-hover table-bordered grey-heading" id="table" cellspacing="0" cellpadding="0">
    <thead>
      <tr> 
        <!-- Intestazione tabella dipartimenti -->
        <th>#</th>
        <th>Codice</th>
        <th>Nome dipartimento</th>
        <th>Nome referente</th>
        <th>Settore</th>
        <th>P.iva</th>
        <th>C.F.</th>
        <th>Tel. dipartimento</th>
        <th>Cell. dipartimento</th>
        <th>e-mail</th>
        <th>e-mail secondaria</th>
        <th>fax</th>
        <th>Indirizzo</th>
        <th>IBAN</th>
        <th>Logo</th>
      </tr>
    </thead>
    <tbody>
      <?php $count = 0; ?>
    @foreach ($dipartimenti as $dip)
    <tr>
      <td><input class="selectable" type="checkbox" id="dipartimenti<?php echo $count; ?>"> <label for="dipartimenti<?php echo $count; ?>"> dipartimenti<?php echo $count; ?> </label> </td>
      <td>{{$dip->id}}</td>
      <td>{{$dip->nomedipartimento}}</td>
      <td>{{$dip->nomereferente}}</td>
      <td>{{$dip->settore}}</td>
      <td>{{$dip->piva}}</td>
      <td>{{$dip->cf}}</td>
      <td>{{$dip->telefonodipartimento}}</td>
      <td>{{$dip->cellularedipartimento}}</td>
      <td>{{$dip->email}}</td>
      <td>{{$dip->emailsecondaria}}</td>
      <td>{{$dip->fax}}</td>
      <td>{{$dip->indirizzo}}</td>
      <td>{{$dip->iban}}</td>
      <td><img src="http://easy.langa.tv/storage/app/images/<?php echo $dip->logo; ?>" ></img></td>
    </tr>
    <?php $count++; ?>
    @endforeach
      </tbody>
    
  </table>
  <?php if($count==0) {

	echo "<h3 style='text-align:center;'>Nessun dipartimento trovato</h3>";

} ?>
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

	return confirm("Sei sicuro di voler eliminare: " + n + " dipartimenti?");

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

				link.href = "{{ url('/admin/tassonomie/dipartimenti/delete/department') }}" + '/';

				if(check()) {

                                    for(var i = 0; i < n; i++) {

                                        $.ajax({

                                            type: "GET",

                                            url : link.href + selezione[i],

                                            error: function(url) {

                                                if(url.status==403) {

                                                    link.href = "{{ url('/admin/tassonomie/dipartimenti/delete/department') }}" + '/' + selezione[--n];

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
					link.href = "{{ url('/admin/tassonomie/dipartimenti/modify/department') }}" + '/' + selezione[n];
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