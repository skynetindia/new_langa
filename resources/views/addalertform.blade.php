@extends('layouts.app')
@section('content')
@include('common.errors')
<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>
<!-- Latest compiled and minified CSS -->
<!--<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
 Latest compiled and minified Locales -->
<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/locale/bootstrap-table-it-IT.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script> -->
<link rel="stylesheet" href="{{ asset('build/css/bootstrap-table.min.css') }}">
<script src="{{ asset('build/js/bootstrap-table.min.js') }}"></script> 
<script src="{{ asset('build/js/bootstrap-table-it-IT.min.js') }}"></script>
<script src="{{asset('public/scripts/select2.full.min.js')}}"></script>

<!-- ckeditor -->
<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    @if(checkpermission('2', '14', 'scrittura','true'))
    <div class="add-alert-frm">	<h1> {{ trans('messages.keyword_addalert') }}  </h1><hr></div>
@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif

<div class="row">

  <form action="{{url('/alert/store')}}" method="post" id="addalert">

  {{ csrf_field() }}

  <div class="col-md-9 col-sm-12 col-xs-12">
    <div class="form-group">
      <label> {{ trans('messages.keyword_alert') }}</label>
      <input class="form-control required-input" id="nome_alert" name="nome_alert" value="" placeholder="{{ trans('messages.keyword_alert') }} {{ trans('messages.keyword_name') }}">
    </div>
  </div>
  <div class="col-md-3 col-sm-12 col-xs-12">
  <div class="form-group">
    <label> {{ trans('messages.keyword_tipoalert') }}</label>
      <select  class="form-control required-input" id="tipo_alert" name="tipo_alert" style="color:#ffffff" >
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
<div class="col-md-6 col-sm-12 col-xs-12">
<div class="form-group">
<label for="ente"> {{ trans('messages.keyword_entity') }} </label>
<select id="ente" name="ente[]" class="js-example-basic-multiple form-control" multiple="multiple">
    @foreach($enti as $enti)
      <option value="{{ $enti->id }}">
        {{ $enti->id }} | {{ ucwords(strtolower($enti->nomeazienda)) }}
      </option>
    @endforeach
  </select>
</div>
  </div>
<div class="col-md-6 col-sm-12 col-xs-12">
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
        $(".js-example-basic-multiple").select2({ containerCssClass : "required-input" });
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
          for(var x=0; x < ente.length; x++) {
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

<div class="col-md-12 col-sm-12 col-xs-12">
 <div class="form-group">
    <label> {{ trans('messages.keyword_message') }} </label>
    <textarea name="messaggio" id="messaggio" rows="10" cols="50" class="form-control"></textarea>
</div>
    <script type="text/javascript">
      CKEDITOR.replace('messaggio');
    </script>
<div class="chkselect">
  <div class="form-group">
        <label for="is_email"> {{ trans('messages.keyword_is_email_info') }}? </label>
        <div class="switch"><input type="checkbox" id="is_email" name="is_email" value="1"> <label for="is_email"></label></div>
        &nbsp;&nbsp;    
        <label for="is_system_info"> {{ trans('messages.keyword_is_system_info') }}? </label>
        <div class="switch"><input type="checkbox" checked="checked" id="is_system_info" name="is_system_info" value="1"> <label for="is_system_info"></label></div>
   </div>
</div>
<input class="btn btn-warning" type="submit" value="{{ trans('messages.keyword_send') }}">
</div>  
    </form>
  </div>
  @endif 
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

<?php /*<div class="footer-svg">
  <img src="{{asset('images/ADMIN_AVVISI-footer.svg')}}" alt="avvisi">
</div>*/?>
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
                "ente[]": {
                    required: true
                },
                "ruolo[]": {
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
                "ente[]": {
                    required: "{{trans('messages.keyword_please_select_an_entity')}}"
                },
                "ruolo[]": {
                    required: "{{trans('messages.keyword_please_select_a_role')}}"                    
                },
                messaggio: {
                    required: "{{trans('messages.keyword_please_enter_message')}}"            
                }
            }

        });
      });
/*
 $(document).ready(function () {

    //Transforms the listbox visually into a Select2.
    $("#lstColors").select2({
        placeholder: "Select a Color",
        width: "200px"
    });

    //Initialize the validation object which will be called on form submit.
    var validobj = $("#addalert").validate({
        onkeyup: false,
        errorClass: "error",

        //put error message behind each form element
        errorPlacement: function (error, element) {
            var elem = $(element);
            error.insertAfter(element);
        },

        //When there is an error normally you just add the class to the element.
        // But in the case of select2s you must add it to a UL to make it visible.
        // The select element, which would otherwise get the class, is hidden from
        // view.
        highlight: function (element, errorClass, validClass) {
            var elem = $(element);
            if (elem.hasClass("select2-offscreen")) {
                $("#s2id_" + elem.attr("id") + " ul").addClass(errorClass);
            } else {
                elem.addClass(errorClass);
            }
        },

        //When removing make the same adjustments as when adding
        unhighlight: function (element, errorClass, validClass) {
            var elem = $(element);
            if (elem.hasClass("select2-offscreen")) {
                $("#s2id_" + elem.attr("id") + " ul").removeClass(errorClass);
            } else {
                elem.removeClass(errorClass);
            }
        }
    });

    //If the change event fires we want to see if the form validates.
    //But we don't want to check before the form has been submitted by the user
    //initially.
    $(document).on("change", ".select2-offscreen", function () {
        if (!$.isEmptyObject(validobj.submitted)) {
            validobj.form();
        }
    });

    //A select2 visually resembles a textbox and a dropdown.  A textbox when
    //unselected (or searching) and a dropdown when selecting. This code makes
    //the dropdown portion reflect an error if the textbox portion has the
    //error class. If no error then it cleans itself up.
    $(document).on("select2-opening", function (arg) {
        var elem = $(arg.target);
        if ($("#s2id_" + elem.attr("id") + " ul").hasClass("myErrorClass")) {
            //jquery checks if the class exists before adding.
            $(".select2-drop ul").addClass("myErrorClass");
        } else {
            $(".select2-drop ul").removeClass("myErrorClass");
        }
    });
});*/ 
    </script>
@endsection