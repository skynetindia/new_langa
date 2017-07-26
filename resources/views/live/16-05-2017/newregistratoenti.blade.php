@extends('adminHome')
@section('page')
<h1>New Enti <strong>LANGA</strong></h1> 
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
@if (\Session::has('success'))
<div class="alert alert-success fade in alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a> {!! \Session::get('success') !!} </div>
@endif
<div class="table-responsive">
  <table class="selectable table table-hover table-bordered grey-heading" id="table" cellspacing="0" cellpadding="0">
    <thead>
      <tr> 
        
        <!-- Intestazione tabella dipartimenti -->
        
        <th>#</th>
        <th>Codice</th>
        <th>Nome azienda</th>
        <th>Nome referente</th>
        <th>Email</th>
        <th> Azione </th>
      </tr>
    </thead>
    <tbody>
      <?php $count = 0; ?>
      
      <!--

'sconti'

'entisconti' = legame tra l'id_sconto e l'id_tipo ente,

'tipienti' = Elenco dei tipi enti (POTENZIALE, CLIENTE, ... con ->color)

-->
    @foreach ($corporations as $corporations)
    <tr>
      <td><input class="selectable cst-checkbox" id="lettura<?php echo $count; ?>" type="checkbox">
        <label for="lettura<?php echo $count; ?>"> lettura<?php echo $count; ?> </label></td>
      <td>{{$corporations->id}}</td>
      <td>{{$corporations->nomeazienda}}</td>
      <td>{{$corporations->nomereferente}}</td>
      <td>{{$corporations->email}}</td>
      <td><a class="btn btn-primary" id="approvare" href="{{ url('/approvareenti/'.$corporations->id) }}" onclick="return confirm('Are you sure you want to Approvare this item?');"> Approvare </a> <a class="btn btn-danger" id="rifiutare" class="btn btn-default" href="{{ url('/rifiutareenti/'.$corporations->id) }}" onclick="return confirm('Are you sure you want to Rifiutare this item?');"> Rifiutare </a></td>
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

    return confirm("Sei sicuro di voler eliminare: " + n + " utenti?");

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

                link.href = "{{ url('/admin/destroy/utente') }}" + '/';

                if(check()) {

                                    for(var i = 0; i < n; i++) {

                                        $.ajax({

                                            type: "GET",

                                            url : link.href + selezione[i],

                                            error: function(url) {

                                                if(url.status==403) {

                                                    link.href = "{{ url('/admin/destroy/utente') }}" + '/' + selezione[--n];

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
                    
                    link.href = "{{ url('/admin/modify/utente') }}" + '/' + selezione[n];
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