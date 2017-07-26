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
<link rel="stylesheet" href="{{ asset('build/css/bootstrap-table.min.css') }}">
<script src="{{ asset('build/js/bootstrap-table.min.js') }}"></script>
<script src="{{ asset('build/js/bootstrap-table-it-IT.min.js') }}"></script>
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
        <h1> {{ ucwords(trans('messages.keyword_project_design')) }} </h1><hr>
        @if(checkpermission('5', '20', 'scrittura','true'))
        <div class="btn-group">
          <button class="btn btn-warning" type="button" name="update" title=" {{ trans('messages.keyword_add_new_layout') }} " onclick="aggiungiDisposizione()"><i class="fa fa-plus"></i></button>
        <?php /*<a id="mostra" class="btn btn-warning" name="remove" title=" {{ trans('messages.keyword_display_selected_format') }} " onclick="multipleAction('mostra');">
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
        </a>*/?>            
        </div>
        @endif

        <?php echo ticketprobelm(); ?>

    </div>
</div>



<?php 

$request = parse_url($_SERVER['REQUEST_URI']);
$path = ($_SERVER['HTTP_HOST'] == 'localhost') ? rtrim(str_replace('/easylanganew/', '', $request["path"]), '/') : $request["path"];      
$result = rtrim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $path), '/');
$current_module = DB::select('select * from modulo where TRIM(BOTH "/" FROM modulo_link) = :link', ['link' => $result]);

?>
<!-- Aggiungi nuova disposizione MODALE -->
<div id="problem-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> {{ trans('messages.keyword_problem') }} </h4>
      </div>
      <div class="modal-body">
        <p>{{ trans('messages.keyword_your_problems_are_important_to_us') }} ?</p><hr>        
        <form action="{{url('ticket/problem/store')}}" method="post" name="add_project" id="add_project" enctype="multipart/form-data"> {{ csrf_field() }}  

        In that page you were when the problem occurred?
        <input type="text" name="page" class="form-control" placeholder="http://betaeasy.langa.tv/enti/myenti"> 
        <br>

        <input type="hidden" name="module_id" value="<?php echo (isset($current_module[0]->modulo_sub)) ? $current_module[0]->modulo_sub : 0 ?>"> 

        Please describe the error you have found
        <textarea cols="50" rows="10" name="problem" class="form-control"></textarea>
        <br>

        Attach a picture
        <input type="file" name="file" class="form-control"> 

      </div>
      <div class="modal-footer">
          <p style="text-align: left;">{{ trans('messages.keyword_we_get_back_to_you') }}
          </p>
          LANGA Team        
          <br><br>
        <input type="submit" class="btn btn-warning" value="{{ trans('messages.keyword_send') }}">
        </form>

      </div>
    </div>
  </div>
</div>

<!-- <div id="problem-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> {{ trans('messages.keyword_problem') }} </h4>
      </div>
      <div class="modal-body">
      <p>{{ trans('messages.keyword_your_problems_are_important_to_us') }}
      ? </p>

        <form action="{{url('ticket/problem/store')}}" method="post" name="add_project" id="add_project"> {{ csrf_field() }}   
        <input type="hidden" name="module_id" value="<?php //echo (isset($current_module[0]->modulo_sub)) ? $current_module[0]->modulo_sub : 0; ?>">         
       <textarea cols="50" rows="10" name="problem"></textarea>
      </div>
      <div class="modal-footer">
          <p style="text-align: left;">{{ trans('messages.keywordwe_get_back_to_you') }}
          ? </p>
          LANGA Team        
          <br><br>
        <input type="submit" class="btn btn-warning" value="{{ trans('messages.keyword_send') }}">
        </form>
      </div>
    </div>
  </div>
</div> -->
<!-- FINE MODALE AGGIUNGI DISPOSIZIONE -->


<div class="clearfix"></div>
<div class="height20"></div>
    <div class="pagination_invoice" id="pagination_invoice">
    <div class="row pagamentifolder">
    @foreach($groupdetails as $key => $groupValue)
        <div class="col-md-2">  
            <div class="form-group">
            	<div class="bg-white folder-wrap">
                <div class="text-right">
                @if(checkpermission('5', '20', 'scrittura','true'))
                <button id="edit" onclick="showGroupName('{{$groupValue->groupid}}');" class="btn btn-warning text-right" name="remove" title=""><i class="fa fa-pencil"></i></button>
                <button id="delete" onclick="deletegroup('{{$groupValue->groupid}}');" class="btn btn-danger text-right" name="remove" title="">
                    <i class="fa fa-trash"></i>
                </button>
                @endif
                </div><?php
                $neededObjects = array_filter(
                        $invoiceDetails,
                        function ($e) use($groupValue) {
                            return $e->id_disposizione == $groupValue->id;
                        }
                    );        
                $invoicedetaillink = (count($neededObjects) > 0) ? 'href='.url('pagamenti/mostra/accounting/').'/'.$groupValue->id.'' : '';            
            	?><a {{$invoicedetaillink}}><img src="{{url('images/folder.jpg')}}">
                	<div class="dot-main"><?php                     
                    foreach ($neededObjects as $keyobj => $valueobj) {
                        ?><div class="dot-green" style="background-color: {{$valueobj->statoemotivo}}"></div><?php
                    }
                    //<div class="dot-green"></div><div class="dot-red"></div>
                    ?></div></a> 
                <label for="logo" id="lblgroupname_{{$groupValue->groupid}}" onDblClick="showGroupName('<?php echo $groupValue->groupid;?>');" >{{$groupValue->groupname}}</label>                
                <input type="text" name="groupnameupdate" class="groupnameTextbox form-control" id="groupnameupdate_{{$groupValue->groupid}}" value="{{$groupValue->groupname}}" style="display: none;">
                <?php /*<button class="btn btn-warning" onclick="editgroup('<?php echo $groupValue->id; ?>')"><i class="fa fa-pencil"></i></button>*/?>              
            </div>
            </div>
            </div>
    @endforeach
    </div>    
    {{ $groupdetails->links() }}
    </div>
    <?php /*<table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="<?php echo url('/pagamenti/json');?>" data-classes="table table-bordered" id="table">
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
    </table>*/?>
<!-- Aggiungi nuova disposizione MODALE -->
<div id="nuovaDisposizione" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> {{ trans('messages.keyword_add_grouping') }} </h4>
      </div>
      <div class="modal-body">
        <form action="{{url('/pagamenti/store')}}" method="post" name="add_project" id="add_project">
        	{{ csrf_field() }}
        	<label for="nomeprogetto"> {{ trans('messages.keyword_grouping_name') }}  </label>
        	<input id="nomeprogetto" name="nomeprogetto" type="text" class="form-control required-input error" value="{{old('nomeprogetto')}}" placeholder="{{trans('messages.keyword_grouping_name_per_project') }} "><br>

            <!-- Seleziona progetto -->
            <label for="idprogetto"> {{ trans('messages.keyword_linktoproject') }} </label>
            <select id="idprogetto" name="idprogetto" class="js-example-basic-single form-control required-input error">
                <option></option>
                <?php if(isset($progetti[0]) && $progetti[0] != ''){ foreach($progetti as $progetto){ ?>
                	<option value="{{$progetto->id}}">::{{$progetto->id}}<?php echo '/' . substr($progetto->datainizio, -2);?> | {{ ucwords(strtolower($progetto->nomeprogetto)) }}</option>
                <?php } } ?>
            </select><br><br>
            <!-- fine progetto -->            
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
            function showGroupName(gid){
                $("#groupnameupdate_"+gid).show();
                $("#lblgroupname_"+gid).hide();                
            }
            function editgroup(gid) {                                    
                    $("#modificaDisposizione").modal();
                    $('#modificaform').attr('action', urlmodifica);
                    for(var i = 0; i < quadri.length; i++) {
                        if(quadri[i]["id"] == gid) {                            
                            $(".modal-body #nomeprogetto").val(quadri[i]["nomeprogetto"]);
                            $(".modal-body #idprogetto").val(quadri[i]["id_progetto"]);
                            break;      
                        }   
                    }
                }            
            $('.groupnameTextbox').keydown(function (e){
                if(e.keyCode == 13) {
                    var textboxid = $(this).attr('id');
                    var textboxval = $(this).val();
                    var arraygrp = textboxid.split('_');
                    var grpid = arraygrp[1];                    
                    var linkhref = "{{ url('/pagamenti/modifica/accounting') }}" + '/';
                    $.ajax({
                        type: "POST",
                        url : linkhref + grpid,
                        data:{"_token": "{{ csrf_token() }}","nomeprogetto":textboxval},
                        error: function(url) {                            
                            /*if(url.status==403) {
                                link.href = "{{ url('/pagamenti/modifica/accounting') }}" + '/' + indici[n];
                                link.dispatchEvent(clickEvent);
                                error = true;
                            } */
                        },
                        success: function(response){
                           if(response=="true"){
                                $("#groupnameupdate_"+grpid).hide();                            
                                $("#lblgroupname_"+grpid).text(textboxval);                
                                $("#lblgroupname_"+grpid).show();                
                            }
                        }
                    });
                    //alert($(this).val());
                }
            })

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

            <?php if(isset($progetti[0]) && $progetti[0] != ''){ foreach($progetti as $progetto){ ?>
            	<option value="{{$progetto->id}}">::{{$progetto->id}}<?php echo '/' . substr($progetto->datainizio, -2);?> | {{$progetto->nomeprogetto}}</option>
            <?php } } ?>

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

function problem() {
    $("#problem-modal").modal();
}
function deletegroup(groupid){
    if(confirm("{{trans('messages.keyword_are_you_sure?')}}")){
    var linkhref = "{{ url('/pagamenti/accounting/delete') }}" ;
    $.ajax({
        type: "POST",
        url : linkhref,
        data:{"_token": "{{ csrf_token() }}","groupid":groupid},
        error: function(url) {                                      
        },
        success: function(response){
           if(response=="true"){
                window.location.href="{{url('pagamenti')}}";               
            }
        }
    });
    }
}

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

 $(function() {
    $('.pagination_invoice').on('click', '.pagination a', function(e) {
        e.preventDefault();
        $('#pagination_invoice a').css('color', '#dfecf6');
        $('#pagination_invoice').html('<div class="loading-gif"><img width="100" height="100" src="{{url('images/loading.gif')}}" /></div>');
        var url = $(this).attr('href');
        var arrurl = url.split("?");                        
        url = "{{url('pagamenti')}}"+"?"+arrurl[1];
        getArticles(url);
    });

    function getArticles(url) {
        $.ajax({
            url : url
        }).done(function (data) {
            $('#pagination_invoice').html(data);
        }).fail(function () {
            alert('Articles could not be loaded.');
        });
    }
});

$(document).ready(function() {      
    //validate add project form on keyup and submit
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
                required: "{{ trans('messages.keyword_please_enter_group_name') }}"
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