@extends('layouts.app')
@section('content')
@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif
@include('common.errors')
<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.js"></script>
<!-- Latest compiled and minified Locales -->
<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/locale/bootstrap-table-it-IT.min.js"></script> -->
<script src="{{asset('public/scripts/select2.full.min.js')}}"></script>
<script>
var urlmodifica = "";
function aggiungiDisposizione() {
	$("#nuovaDisposizione").modal();
}
</script>

<div class="header-lst-img">
    <div class="header-svg text-left float-left">
        <img src="{{url('images/HEADER1_LT_ACCOUNTING.svg')}}" alt="header image">
    </div>
    <div class="float-right text-right">
        <h1> {{ trans('messages.keyword_project_design') }} </h1><hr>
        <div class="btn-group">
          <button class="btn btn-warning" type="button" name="update" title=" {{ trans('messages.keyword_add_new_layout') }} " onclick="aggiungiDisposizione()"><i class="fa fa-plus"></i></button>
        <a id="mostra" class="btn btn-warning" name="remove" title=" {{ trans('messages.keyword_display_selected_format') }} " onclick="multipleAction('mostra');">
        	<i class="fa fa-pencil"></i>
        </a>
        <a onclick="multipleAction('modify');" id="modifica"  class="btn btn-primary" name="update" title=" {{ trans('messages.keyword_edit_last_selected_format') }} ">
       		<i class="fa fa-pencil-square-o"></i>
        </a>
        <a id="duplicate" class="btn btn-info" name="duplicate" title=" {{ trans('messages.keyword_duplicates_selected_layouts') }}  " onclick="multipleAction('duplicate');">
			<i class="fa fa-files-o"></i>
        </a>    
        <a id="delete" class="btn btn-danger" name="remove" title=" {{ trans('messages.keyword_delete_selected_project') }}  " onclick="multipleAction('delete');">
			<i class="fa fa-trash"></i>
        </a>
        
        </div>
    </div>
</div>

<div class="clearfix"></div>
<div class="height20"></div>

<br><br>
    <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="<?php echo url('/pagamenti/json');?>" data-classes="table table-bordered" id="table">
        <thead>
            <th data-field="id" data-sortable="true"> 
            {{ trans('messages.keyword_no_picture') }} 
            <th data-field="ente" data-sortable="true"> 
            {{ trans('messages.keyword_entity') }}
            <th data-field="nomeprogetto" data-sortable="true"> 
            {{ trans('messages.keyword_picturename') }} 
            <th data-field="id_progetto" data-sortable="true">
            {{ trans('messages.keyword_projectname') }}
            <th data-field="data" data-sortable="true">
            {{ trans('messages.keyword_date') }} 
        </thead>
    </table>

<!-- Aggiungi nuova disposizione MODALE -->
<div id="nuovaDisposizione" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> {{ trans('messages.keyword_add_framework_provisions') }} </h4>
      </div>
      <div class="modal-body">
        <form action="{{url('/pagamenti/store')}}" method="post" name="add_project" id="add_project">
        	{{ csrf_field() }}
        	<label for="nomeprogetto"> {{ trans('messages.keyword_picturename') }} <span class="required">(*)</span> </label>
        	<input id="nomeprogetto" name="nomeprogetto" type="text" class="form-control" value="{{old('nomeprogetto')}}" placeholder=" {{ trans('messages.keyword_framework_name_framework_project') }} "><br>
            <!-- Seleziona progetto -->
            <label for="idprogetto"> {{ trans('messages.keyword_linktoproject') }} <span class="required">(*)</span> </label>
            <select id="idprogetto" name="idprogetto" class="js-example-basic-single form-control" >
            <option></option>
            @foreach($progetti as $progetto)
            	<option value="{{$progetto->id}}">::{{$progetto->id}}<?php echo '/' . substr($progetto->datainizio, -2);?> | {{$progetto->nomeprogetto}}</option>
            @endforeach
            </select><br>
            <!-- fine progetto -->
            <br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"> {{ trans('messages.keyword_close') }} </button>
        <input type="submit" class="btn btn-warning" value="{{ trans('messages.keyword_add') }}">
        </form>
      </div>
    </div>

  </div>
</div>
<!-- FINE MODALE AGGIUNGI DISPOSIZIONE -->
<script>
var quadri = <?php echo json_encode($quadri); ?>;
</script>
<!-- Modifica disposizione MODALE -->
<div id="modificaDisposizione" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> {{ trans('messages.keyword_modification_framework_provisions') }} </h4>
      </div>
      <div class="modal-body">
        <form method="post" id="modificaform" name="modificaform">
        	<script>
				function impostaUrl() {

					$('#modificaform').attr('action', urlmodifica);
					for(var i = 0; i < quadri.length; i++) {
						if(quadri[i]["id"] == indici[tmp]) {                            
							$(".modal-body #nomeprogetto").val(quadri[i]["nomeprogetto"]);
							$(".modal-body #idprogetto").val(quadri[i]["id_progetto"]);
							break;		
						}	
					}
				}
			</script>
        	{{ csrf_field() }}
        	<label for="nomeprogetto"> {{ trans('messages.keyword_picturename') }} <span class="required">(*)</span> </label>
        	<input id="nomeprogetto" name="nomeprogetto" type="text" class="form-control" value="{{old('nomeprogetto')}}" placeholder=" {{ trans('messages.keyword_framework_name_framework_project') }}"><br>
            <!-- Seleziona progetto -->
            <label for="idprogetto"> {{ trans('messages.keyword_linktoproject') }} <span class="required">(*)</span></label>
           
            <select id="idprogetto" name="idprogetto" class="js-example-basic-single form-control" >
            <option></option>

            @foreach($progetti as $progetto)
            	<option value="{{$progetto->id}}">::{{$progetto->id}}<?php echo '/' . substr($progetto->datainizio, -2);?> | {{$progetto->nomeprogetto}}</option>
            @endforeach

            </select><script type="text/javascript">

            $(".js-example-basic-single").select2("val", ''); 


</script><br>
            <!-- fine progetto -->
            <br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"> {{ trans('messages.keyword_close') }} </button>
        <input type="submit" class="btn btn-warning" value="{{ trans('messages.keyword_save') }}">
        </form>
      </div>
    </div>

  </div>
</div>
<div class="footer-svg">
  <img src="{{url('images/FOOTER2_RB_ACCOUNTING.svg')}}" alt="footer enti image">
</div>

<!-- FINE MODALE MODIFICA DISPOSIZIONE -->
<script>
var selezione = [];
var indici = [];
var n = 0;

$('#table').on('click-row.bs.table', function (row, tr, el) {
	var cod = /\d+/.exec($(el[0]).children()[0].innerHTML);
	if (!selezione[cod]) {
        $('#table tr.selected').removeClass("selected");       
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
        $('#table tr.selected').removeClass("selected");       
        $(el[0]).addClass("selected");
        selezione[cod] = cod;
        indici[n] = cod;
        n++;
	}
});

var tmp;

function check() { return confirm(" {{ trans('messages.keyword_sure') }}: " + n + " {{ trans('messages.keyword_provisions') }} ?"); }
function multipleAction(act) {
	var link = document.createElement("a");
	var clickEvent = new MouseEvent("click", {
	    "view": window,
	    "bubbles": true,
	    "cancelable": false
	});
	var error = false;
		switch(act) {
			case 'delete':
				link.href = "{{ url('/pagamenti/delete/accounting') }}" + '/';
				if(check() && n!=0) {
                    for(var i = 0; i < n; i++) {
                        $.ajax({
                            type: "GET",
                            url : link.href + indici[i],
                            error: function(url) {
                                if(url.status==403) {
                                    link.href = "{{ url('/pagamenti/delete/accounting') }}" + '/' + indici[n];
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
                if(n != 0) {
					tmp = n;
					tmp--;
					urlmodifica = "{{ url('/pagamenti/modifica/accounting') }}" + '/' + indici[tmp];
					$("#modificaDisposizione").modal();
					impostaUrl();
				}
			break;
            case 'duplicate':
				link.href = "{{ url('/pagamenti/duplicate/accounting') }}" + '/';
                for(var i = 0; i < n; i++) {
                    $.ajax({
                        type: "GET",
                        url : link.href + indici[i],
                        error: function(url) {
                            if(url.status==403) {
                                link.href = "{{ url('/pagamenti/duplicate/accounting') }}" + '/' + indici[n];
                                link.dispatchEvent(clickEvent);
                                error = true;
                            } 
                        }
                    });
                }
                selezione = undefined;
                if(error === false)
                    setTimeout(function(){location.reload();},100*n);
                n = 0;
			break;
			case 'mostra':
				if(n != 0) {
					n--;
					link.href = "{{ url('/pagamenti/mostra/accounting') }}" + '/' + indici[n];
					n = 0;
					selezione = undefined;
					link.dispatchEvent(clickEvent);
				}
			break;
		}
}    

</script>



<script type="text/javascript">
$(document).ready(function() {
      
    // validate add project form on keyup and submit
    $("#add_project").validate({
        
        rules: {   
            nomeprogetto: {
                required:true
            },
            idprogetto: {
                required: true
            }
        },
        messages: {
            nomeprogetto: {
                required: "{{ trans('messages.keyword_please_enter_projectname') }}"
            },
            idprogetto: {
                required: "{{ trans('messages.keyword_please_select_projectlink') }}"
            }
        }

    });

    // validate edit project form on keyup and submit
    $("#modificaform").validate({
        
        rules: {   
            nomeprogetto: {
                required:true
            },
            idprogetto: {
                required: true
            }
        },
        messages: {
            idprogetto: {
                required: "{{ trans('messages.keyword_please_enter_projectname') }}"
            },
            DA: {
                required: "{{ trans('messages.keyword_please_select_projectlink') }}"
            }
        }

    });

});

</script>

@endsection