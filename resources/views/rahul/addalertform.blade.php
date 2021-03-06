@extends('adminHome')
@section('page')
@include('common.errors')
<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>
<!-- Latest compiled and minified CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<!-- Latest compiled and minified Locales -->
<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/locale/bootstrap-table-it-IT.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script> 

<link rel="stylesheet" href="{{ asset('build/css/bootstrap-table.min.css') }}">
<script src="{{ asset('build/js/bootstrap-table.min.js') }}"></script>
<script src="{{ asset('build/js/bootstrap-table-it-IT.min.js') }}"></script>

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

  <div class="col-md-9">
    <div class="form-group">
      <label> {{ trans('messages.keyword_alert') }}  <span class="required" >(*)</span> </label>
      <input class="form-control" id="nome_alert" name="nome_alert" value="" placeholder="{{ trans('messages.keyword_alert') }} {{ trans('messages.keyword_name') }}">
    </div>
  </div>

  <div class="col-md-3">
<div class="form-group">
    <label> {{ trans('messages.keyword_tipoalert') }}  <span class="required" >(*)</span></label>

      <select  class="form-control" id="tipo_alert" name="tipo_alert" style="color:#ffffff" >

        <!-- <option style="background-color:black;" selected disabled> select </option>   -->

        <option selected disabled>-- {{ trans('messages.keyword_select') }} --</option>  

        @foreach($alert_tipo as $type)

          <option style="background-color:{{ $type->color }};" value="{{ $type->id_tipo }}"> {{ ucwords(strtolower($type->nome_tipo)) }} </option>

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

<div class="col-md-6">
<div class="form-group">
<label for="ente"> {{ trans('messages.keyword_entity') }} </label>

<select id="ente" name="ente[]" class="js-example-basic-multiple form-control" multiple="multiple">

    @foreach($enti as $enti)
      <option value="{{ $enti->id }}">
        {{ ucwords(strtolower($enti->nomeazienda)) }}
      </option>
    @endforeach
  </select>
</div>
  </div>

<div class="col-md-6">
<div class="form-group">
<label for="ruolo"> {{ trans('messages.keyword_role') }} </label>

<select id="ruolo" name="ruolo[]" class="js-example-basic-multiple form-control" onchange="myRole()"  multiple="multiple">

    @foreach($ruolo_utente as $ruolo_utente)
      <option value="{{ $ruolo_utente->ruolo_id }}">
        {{ ucwords(strtolower($ruolo_utente->nome_ruolo)) }}
      </option>
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

    <label> {{ trans('messages.keyword_message') }} </label>

    <textarea name="messaggio" id="messaggio" rows="10" cols="50" class="form-control"></textarea>
</div>
    <script type="text/javascript" >
      CKEDITOR.replace( 'messaggio' );
    </script>
<div class="chkselect">
  <div class="form-group">
    <input type="checkbox" id="is_email" name="is_email" value="1">
    <label for="is_email"> {{ trans('messages.keyword_is_email_info') }}? </label>
   </div>
</div>

<input class="btn btn-warning" type="submit" value="{{ trans('messages.keyword_send') }}">
</div>
  </div>
    </form>
  </div>
<div class="space10"></div>

<div class="panel panel-default">
<div class="panel-body">
<h1 class="cst-datatable-heading"> {{ trans('messages.keyword_activitylist') }} </h1>
<table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="{{ url('/alert/enti/json') }}" data-classes="table table-bordered" id="table">
        <thead>
            <th data-field="id_ente" data-sortable="true">
            {{ trans('messages.keyword_ente') }}  </th>
            <th data-field="nome_azienda" data-sortable="true">
            {{ trans('messages.keyword_company_name') }} </th>
            <th data-field="nome_referente" data-sortable="true">
            {{ trans('messages.keyword_reference_name') }}  </th>
            <th data-field="settore" data-sortable="true">
            {{ trans('messages.keyword_sector') }}  </th>
            <th data-field="telefono_azienda" data-sortable="true">
            {{ trans('messages.keyword_telephone_company') }}  </th>
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
</div>

    <div class="footer-svg">
  <img src="{{asset('images/ADMIN_AVVISI-footer.svg')}}" alt="avvisi">
</div>
    <script type="text/javascript">
    $(document).ready(function() {
        // validate signup form on keyup and submit
        $("#addalert").validate({
            rules: {
                nome_alert: {
                    required: true
                },
                tipo_alert: {
                    required: true
                },
                ente: {
                    required: true
                },
                ruolo: {
                    required: true              
                },
                messaggio: {                   
                     required: function(textarea) {
                      CKEDITOR.instances[textarea.id].updateElement(); // update textarea
                      var editorcontent = textarea.value.replace(/<[^>]*>/gi, ''); // strip tags
                      return editorcontent.length === 0;
                    }
                }
            },
            messages: {
                nome_alert: {
                    required: "{{trans('messages.keyword_please_enter_a_alert_name')}}"
                },
                tipo_alert: {
                    required: "{{trans('messages.keyword_please_select_a_alert_type')}}"
                },
                ente: {
                    required: "{{trans('messages.keyword_please_select_an_entity')}}"
                },
                ruolo: {
                    required: "{{trans('messages.keyword_please_select_a_role')}}"                    
                },
                messaggio: {
                    required: "{{trans('messages.keyword_please_enter_message')}}"            
                }
            }

        });
      });


      
    </script>
@endsection