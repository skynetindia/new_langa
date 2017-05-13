@extends('adminHome')
@section('page')

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
.button {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 3px 15px;
    padding-bottom: 6px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    -webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.4s;
    cursor: pointer;
    border-radius: 4px;
}
.button2 { /* blue */
    background-color: white;
    color: black;
    border: 2px solid #337ab7;
}

.button2:hover {
    background-color: #337ab7;
    color: white;
}

.button3 { /* red */
    background-color: white;
    color: black;
    border: 2px solid #d9534f;
}

.button3:hover {
    background-color: #d9534f;
    color: white;
}
</style>

<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.css">

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

<!-- Latest compiled and minified JavaScript -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.js"></script>

<!-- Latest compiled and minified Locales -->
<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/locale/bootstrap-table-it-IT.min.js"></script> -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<style>.select2-container, .select2-choices, .selection, .select2-selection, .select2-selection--multiple { height: 150px;}</style>
<!-- ckeditor -->
<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
 <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<h1> {{ trans('messages.keyword_addalert') }}  </h1><hr>

@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif

<div class="row">

  <form action="{{url('/admin/alert/store')}}" method="post" id="addalert">

  {{ csrf_field() }}

  <div class="col-md-8">

    <label> {{ trans('messages.keyword_alert') }}  <p style="color:#f37f0d;display:inline">(*)</p> </label>

    <input class="form-control" id="nome_alert" name="nome_alert" value="" placeholder="{{ trans('messages.keyword_alert') }} {{ trans('messages.keyword_name') }}">

  </div>

  <div class="col-md-4">

    <label> {{ trans('messages.keyword_tipoalert') }}  <p style="color:#f37f0d;display:inline">(*)</p></label>

      <select  class="form-control" id="tipo_alert" name="tipo_alert" style="color:#ffffff" >

        <!-- <option style="background-color:black;" selected disabled>-- select --</option>   -->

        <option selected disabled>-- {{ trans('messages.keyword_select') }} --</option>  

        @foreach($alert_tipo as $type)

          <option style="background-color:{{ $type->color }};" value="{{ $type->id_tipo }}"> {{ $type->nome_tipo }} </option>

        @endforeach
        
      </select><br>
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

<div class="col-md-6">

<label for="ente"> {{ trans('messages.keyword_entity') }} </label>

<select id="ente" name="ente[]" class="js-example-basic-multiple form-control" multiple="multiple">

    @foreach($enti as $enti)
      <option value="{{ $enti->id }}">
        {{$enti->nomeazienda}}
      </option>
    @endforeach
  </select>

  </div>

<div class="col-md-6">

<label for="ruolo"> {{ trans('messages.keyword_role') }} </label>

<select id="ruolo" name="ruolo[]" class="js-example-basic-multiple form-control" onchange="myRole()"  multiple="multiple">

    @foreach($ruolo_utente as $ruolo_utente)
      <option value="{{ $ruolo_utente->ruolo_id }}">
        {{$ruolo_utente->nome_ruolo}}
      </option>
    @endforeach
</select>

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

</div>

    
    <br>

    <label> {{ trans('messages.keyword_message') }} </label>

    <textarea name="messaggio" id="messaggio" rows="10" cols="50" class="form-control"></textarea>

    <script type="text/javascript" >
      CKEDITOR.replace( 'messaggio' );
    </script>

    <br>

    <input class="btn btn-warning" type="submit" value="{{ trans('messages.keyword_send') }}">

    </form>

  </div>

</div>



<h1> {{ trans('messages.keyword_activitylist') }} </h1>

<div class="table-responsive table-custom-design">

<table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="{{ url('/alert/enti/json') }}" data-classes="table table-bordered" id="table">
        <thead>
            <th data-field="id_ente" data-sortable="true">
            {{ trans('messages.keyword_ente') }}  </th>
            <th data-field="nome_azienda" data-sortable="true">
            {{ trans('messages.keyword_compname') }} </th>
            <th data-field="nome_referente" data-sortable="true">
            {{ trans('messages.keyword_refname') }}  </th>
            <th data-field="settore" data-sortable="true">
            {{ trans('messages.keyword_sector') }}  </th>
            <th data-field="telefono_azienda" data-sortable="true">
            {{ trans('messages.keyword_comptele') }}  </th>
            <th data-field="email" data-sortable="true">
            {{ trans('messages.keyword_email') }}  </th>
            <th data-field="data_lettura" data-sortable="true">
            {{ trans('messages.keyword_readdatetime') }}  </th>
            <th data-field="responsible_langa" data-sortable="true">
            {{ trans('messages.keyword_respolanga') }}  </th>
            <th data-field="comment" data-sortable="true"> 
            {{ trans('messages.keyword_comment') }}  </th>
            <th data-field="conferma" data-sortable="true">
            {{ trans('messages.keyword_confirm') }}  </th>
        </thead>
    </table>

</div>



@endsection
