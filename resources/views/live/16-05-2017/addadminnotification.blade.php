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

@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif



<div class="row">

  <form action="{{url('/admin/notification/store')}}" method="post" id="addnotification">

  {{ csrf_field() }}


  @if(isset($notifica))
    <h1>Update Notification</h1><hr>
     <div class="col-md-4">
		<div class="form-group">
	    <label>Tipo <span class="required">(*)</span> </label>
	    <input class="form-control" id="type" name="type" value="{{ $notifica->notification_type }}" placeholder="type of notification">
    </div>
  </div>

  <div class="col-md-4">
<div class="form-group">
    <label> Tempo di Avviso <span class="required">(*)</span> </label>

    <input class="form-control" id="tempo_avviso" name="tempo_avviso" value="{{ $notifica->tempo_avviso }}" placeholder="enter tempo di avviso">
</div>
  </div>


  <div class="col-md-4">
<div class="form-group">
    <label> Modulo <span class="required">(*)</span> </label>

      <select class="form-control" id="modulo" name="modulo">

        <option></option>
        @foreach($modulo as $modulo)

          @if($modulo->id == $notifica->modulo)
            <option value="{{ $modulo->id }}" selected="selected">
              {{$modulo->modulo}}
            </option>
          @else
            <option value="{{ $modulo->id }}" >
              {{$modulo->modulo}}
            </option>
          @endif
        @endforeach
      </select>
      </div>
  </div>

  <div class="col-md-6">
  <div class="form-group">
	  <textarea id="show_ente" name="show_ente" class="form-control" rows="4"></textarea>
  </div>
  </div>

  <div class="col-md-6">
	<div class="form-group">
  <textarea id="show_role" name="show_role" class="form-control" rows="4"></textarea>
  </div>
  </div>

<?php $entity = explode(",", $notifica->id_ente); ?>

<div class="col-md-6">
<div class="form-group">
<label for="ente">Ente</label>
<select id="ente" name="ente[]" class="js-example-basic-multiple form-control" onchange="myEnte()" multiple="multiple">

    <option></option>
    @foreach($enti as $enti)

      @if( $entity[0] != '' && in_array($enti->id, $entity) )

        <option value="{{ $enti->id }}" selected="selected">
          {{$enti->nomeazienda}}
        </option>

      @else
         <option value="{{ $enti->id }}">
          {{$enti->nomeazienda}}
        </option>

      @endif

    @endforeach
  </select>
  </div>

  </div>

<div class="col-md-6">
<div class="form-group">
<label for="ruolo">Ruolo <span class="required">(*)</span> </label>

<?php $ruolo = explode(",", $notifica->ruolo); ?>

<select id="ruolo" name="ruolo[]" class="js-example-basic-multiple form-control" onchange="myRole()"  multiple="multiple" required> 

    <option></option>

    @foreach($ruolo_utente as $ruolo_utente)

       @if(in_array($ruolo_utente->ruolo_id, $ruolo))

        <option value="{{ $ruolo_utente->ruolo_id }}" selected="selected">
          {{$ruolo_utente->nome_ruolo}}
        </option>

      @else

        <option value="{{ $ruolo_utente->ruolo_id }}">
          {{$ruolo_utente->nome_ruolo}}
        </option>

      @endif

    @endforeach

</select>
</div>

      <script type="text/javascript">

        $(".js-example-basic-multiple").select2();

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

  <div class="col-dm-12">  
  <div class="form-group">

    <label> Description </label>
		<textarea name="description" id="description" rows="10" cols="50" class="form-control">{{ $notifica->notification_desc }}</textarea>
    </div>
</div>
    <script type="text/javascript" >
      CKEDITOR.replace( 'description' );
    </script>

    <input type="hidden" name="id" value="{{ $notifica->id }}">
  @else
    <h1>Aggiungi Notification</h1><hr>
 <div class="col-md-4">
<div class="form-group">
    <label>Tipo <span class="required">(*)</span> </label>

    <input class="form-control" id="type" name="type" value="" placeholder="type of notification">
</div>
  </div>

  <div class="col-md-4">
<div class="form-group">
    <label> Tempo di Avviso <span class="required">(*)</span> </label>

    <input class="form-control" id="tempo_avviso" name="tempo_avviso" value="" placeholder="enter tempo di avviso">
</div>
  </div>

  <div class="col-md-4">
<div class="form-group">
    <label> Modulo <span class="required">(*)</span> </label>

      <select class="form-control" id="modulo" name="modulo">

        <option></option>
        @foreach($modulo as $modulo)
          <option value="{{ $modulo->id }}">
            {{$modulo->modulo}}
          </option>
        @endforeach
      </select>
      </div>
  </div>

  <div class="col-md-6">
<div class="form-group">
  <textarea id="show_ente" name="show_ente" class="form-control" rows="4"></textarea>
  </div>
  </div>

  <div class="col-md-6">
<div class="form-group">
  <textarea id="show_role" name="show_role" class="form-control" rows="4"></textarea>
</div>
  </div>

 
<div class="col-md-6">
<div class="form-group">
<label for="ente">Ente</label>
<select id="ente" name="ente[]" class="js-example-basic-multiple form-control " onchange="myEnte()" multiple="multiple">
    <option></option>
    @foreach($enti as $enti)
      <option value="{{ $enti->id }}">
        {{$enti->nomeazienda}}
      </option>
    @endforeach
  </select>
  </div>

  </div>

<div class="col-md-6">
<div class="form-group">
<label for="ruolo">Ruolo<span class="required">(*)</span> </label>
<select id="ruolo" name="ruolo[]" class="js-example-basic-multiple form-control" onchange="myRole()"  multiple="multiple" required>
    <option></option>
    @foreach($ruolo_utente as $ruolo_utente)
      <option value="{{ $ruolo_utente->ruolo_id }}">
        {{$ruolo_utente->nome_ruolo}}
      </option>
    @endforeach
</select>
</div>
</div>
      <script type="text/javascript">

        $(".js-example-basic-multiple").select2();

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

	<div class="col-md-12">
   <div class="form-group">

    <label> Description </label>

    <textarea name="description" id="description" rows="10" cols="50" class="form-control"></textarea>

    <script type="text/javascript" >
      CKEDITOR.replace( 'description' );
    </script>
	</div>
    </div>
  @endif

     
    <input class="btn btn-warning" type="submit" value="INVIA">

    </form>

  </div>

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
