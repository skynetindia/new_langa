@extends('layouts.app')
@section('content') 
<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="{{ asset('build/css/bootstrap-table.min.css') }}">
<script src="{{ asset('build/js/bootstrap-table.min.js') }}"></script>
<script src="{{ asset('build/js/bootstrap-table-it-IT.min.js') }}"></script>
<!-- ckeditor -->
<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>

<div class="corporation-blade">
<div class="header-svg text-left float-left">
	<img src="{{url('images/HEADER1-LT_ENTITY.svg')}}" alt="header image">
</div>

<div class="float-right">
<h1>{{trans('messages.keyword_institutions')}}</h1>
<hr>
<?php $loginuser = collect($loginuser)->toArray();?>
<!-- Inizio filtraggio miei/tutti --> 

<?php /*<div class="inner-btn">
@if($loginuser['id']=='0' || $loginuser['dipartimento'] == '1' || $loginuser['dipartimento'] == '3' || $loginuser['dipartimento'] == '2')
<a id="create" class="btn btn-warning" href="{{url('/enti/add')}}" name="create" title="{{trans('messages.keyword_create_new_-_add_a_new_entity')}}"><i class="fa fa-plus"></i></a>
@endif 
@if(isset($miei)) <a id="miei" class="button button2" href="{{url('/enti/myenti')}}" name="miei" title="<?php echo trans('messages.keyword_my').' - '.trans('messages.keyword_filter_your_entity'); ?>">{{trans('messages.keyword_my')}}</a>
<a id="tutti" href="{{url('/enti')}}"  class="button button3" name="tutti" title="<?php echo trans('messages.keyword_all').' - '.trans('messages.keyword_show_all'); ?>">{{trans('messages.keyword_all')}}</a> 
@else 
<a id="miei" class="button button2" href="{{url('/enti/myenti')}}" name="miei"  title="<?php echo trans('messages.keyword_my').' - '.trans('messages.keyword_filter_your_entity'); ?>">{{trans('messages.keyword_my')}}</a>
<a id="tutti" class="button button3" href="{{url('/enti')}}" name="tutti" title="<?php echo trans('messages.keyword_all').' - '.trans('messages.keyword_show_all'); ?>">{{trans('messages.keyword_all')}}</a> 
@endif 
<!-- Fine filtraggio miei/tutti --> 
<a onclick="multipleAction('modify');" id="modifica" class="btn btn-warning" name="update" title="<?php echo trans('messages.keyword_edit_-_edit_the_last_selected_entities');?>"><i class="fa fa-pencil"></i></a>

@if($loginuser['id']=='0' || $loginuser['dipartimento'] == '2')
<a id="duplicate" onclick="multipleAction('duplicate');" class="btn btn-info" name="duplicate" title="<?php echo trans('messages.keyword_duplicate_-_duplicates_selected_entities');?>"><i class="fa fa-files-o"></i></a> 
<a id="delete" onclick="multipleAction('delete');" class="btn btn-danger" name="remove" title="<?php echo trans('messages.keyword_delete_-_delete_selected_entities') ?>"> <i class="fa fa-trash"></i></a>
<div class="skype-call"> <a id="call" onclick="multipleAction('skype');" class="btn btn-warning"  title="skype "><img src="{{url('images/phone-call.png')}}" alt="skype call"/> Skype call</a> </div>
@endif
<?php echo ticketprobelm();?>
</div>*/?>
<div class="inner-btn">
@if(checkpermission('1', '12', 'scrittura','true'))
<a id="create" class="btn btn-warning" href="{{url('/enti/add')}}" name="create" title="{{trans('messages.keyword_create_new_-_add_a_new_entity')}}"><i class="fa fa-plus"></i></a>
@endif 
@if(isset($miei)) <a id="miei" class="button button2" href="{{url('/enti/myenti')}}" name="miei" title="<?php echo trans('messages.keyword_my').' - '.trans('messages.keyword_filter_your_entity'); ?>">{{trans('messages.keyword_my')}}</a>
<a id="tutti" href="{{url('/enti')}}"  class="button button3" name="tutti" title="<?php echo trans('messages.keyword_all').' - '.trans('messages.keyword_show_all'); ?>">{{trans('messages.keyword_all')}}</a> 
@else 
<a id="miei" class="button button2" href="{{url('/enti/myenti')}}" name="miei"  title="<?php echo trans('messages.keyword_my').' - '.trans('messages.keyword_filter_your_entity'); ?>">{{trans('messages.keyword_my')}}</a>
<a id="tutti" class="button button3" href="{{url('/enti')}}" name="tutti" title="<?php echo trans('messages.keyword_all').' - '.trans('messages.keyword_show_all'); ?>">{{trans('messages.keyword_all')}}</a> 
@endif 
<!-- Fine filtraggio miei/tutti --> 
@if(checkpermission('1', '12', 'scrittura','true'))
<a onclick="multipleAction('modify');" id="modifica" class="btn btn-warning" name="update" title="<?php echo trans('messages.keyword_edit_-_edit_the_last_selected_entities');?>"><i class="fa fa-pencil"></i></a>
@else
<a onclick="multipleAction('modify');" id="modifica" class="btn btn-warning" name="update" title="<?php echo trans('messages.keyword_edit_-_edit_the_last_selected_entities');?>"><i class="fa fa-info"></i></a>
@endif

@if(checkpermission('1', '12', 'scrittura','true'))
<a id="duplicate" onclick="multipleAction('duplicate');" class="btn btn-info" name="duplicate" title="<?php echo trans('messages.keyword_duplicate_-_duplicates_selected_entities');?>"><i class="fa fa-files-o"></i></a> 
<a id="delete" onclick="multipleAction('delete');" class="btn btn-danger" name="remove" title="<?php echo trans('messages.keyword_delete_-_delete_selected_entities') ?>"> <i class="fa fa-trash"></i></a>
<div class="skype-call"> <a id="call" onclick="multipleAction('skype');" class="btn btn-warning"  title="skype "><img src="{{url('images/phone-call.png')}}" alt="skype call"/> Skype call</a> </div>
@endif
<?php echo ticketprobelm();?>
</div>

</div>
</div>

<!--<a id="newclient" onclick="multipleAction('newclient');" class="btn btn-warning" name="newclient" title="<?php echo trans('messages.keyword_create_send_credentials_for_the_customer_entity');?>">{{trans('messages.keyword_new_client')}}  </a> -->


  <div class="clearfix"></div>
<div class="space30"></div>
<div class="corporation-blade-set-height">
<div class="panel panel-default">
<div class="panel-body">
<script>
@if(!empty(Session::get('msg')))
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
@endif
</script>
<div class="table-responsive">
<table data-toggle="table" data-search="true" data-pagination="true" data-sort-name="id" data-sort-order="desc" data-id-field="id" data-show-refresh="true"  data-show-columns="true" data-url="<?php if(isset($miei)) echo url('enti/myenti/json'); else echo url('/enti/json');?>" data-classes="table table-bordered" id="table">
  <thead>
  <th data-field="id" data-sortable="true">{{trans('messages.keyword_id')}}</th>
    <th data-field="nomeazienda" data-sortable="true">{{trans('messages.keyword_company_name')}}</th>
    <th data-field="nomereferente" data-sortable="true">{{trans('messages.keyword_name')}}</th>
    <th data-field="settore" data-sortable="true">{{trans('messages.keyword_sector')}}</th>
    <th data-field="telefonoazienda" data-sortable="true">{{trans('messages.keyword_telephone_company')}}</th>
    <th data-field="email" data-sortable="true">{{trans('messages.keyword_email')}}</th>
    <th data-field="indirizzo" data-sortable="true">{{trans('messages.keyword_address')}}</th>
    <th data-field="responsabilelanga" data-sortable="true">{{trans('messages.keyword_responsible')}} LANGA</th>
    <th data-field="statoemotivo" data-sortable="true">{{trans('messages.keyword_emotional_state')}}</th>
    <th data-field="tipo" data-sortable="true">{{trans('messages.keyword_guy')}}</th>
      </thead>
</table>
</div>
</div>
</div>
</div>

<div class="clearfix"></div>

<div class="footer-svg">
  <img src="{{url('images/FOOTER3-ORIZZONTAL_ENTITY.svg')}}" alt="footer enti image">
</div>


<?php 
$request = parse_url($_SERVER['REQUEST_URI']);
$path = ($_SERVER['HTTP_HOST'] == 'localhost') ? rtrim(str_replace('/easylanganew/', '', $request["path"]), '/') : $request["path"]; 
$result = rtrim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $path), '/');
$result=trim($result,'/');
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

        <p>
        {{ trans('messages.keyword_your_problems_are_important_to_us') }} ? 
        </p>

        <hr>        

        <form action="{{url('ticket/problem/store')}}" method="post" name="add_project" id="add_project" enctype="multipart/form-data"> {{ csrf_field() }}  

        In that page you were when the problem occurred?
        <input type="text" name="page" class="form-control" placeholder="http://betaeasy.langa.tv/enti/myenti"> 
        <br>

        <input type="hidden" name="module_id" value="<?php echo (isset($current_module[0]->modulo_sub)) ? $current_module[0]->modulo_sub : 0 ?>"> 

        Please describe the error you have found
        <textarea cols="50" rows="10" name="problem" id="problem" class="form-control"></textarea>

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
      <p>{{ trans('messages.keyword_your_problems_are_important_to_us') }} ? 
      </p>
        <form action="{{url('ticket/problem/store')}}" method="post" name="add_project" id="add_project"> {{ csrf_field() }}   
        <input type="hidden" name="module_id" value="<?php //echo isset($current_module[0]->modulo_sub); ?>">         
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




<script>

// CKEDITOR.replace( 'problem' );

function problem() {
    $("#problem-modal").modal();
}

var selezione = [];
var indici = [];
var n = 0;

$('#table').on('click-row.bs.table', function (row, tr, el) {
    var cod = $(el[0]).children()[0].innerHTML;
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


function check() {

	return confirm("<?php echo trans('messages.keyword_are_you_sure_you_want_to_delete:');?> " + n + " <?php echo trans('messages.keyword_entity');?>?");
}
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
                                
				link.href = "{{ url('/enti/delete/corporation') }}" + '/';
				if(check() && n!= 0) {

                        for(var i = 0; i < n; i++) {
                            
                            $.ajax({

                                type: "GET",
                                url : link.href + indici[i],
                                error: function(url) {
                                    
                                    if(url.status==403) {
                                        link.href = "{{ url('/enti/delete/corporation') }}" + '/' + indici[n];
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
                    }
					
			break;
			case 'modify':
                if(n != 0) {
					n--;
					link.href = "{{ url('/enti/modify/corporation') }}" + '/' + indici[n];
					n = 0;
					selezione = undefined;
					link.dispatchEvent(clickEvent);
				}
			break;
            case 'newclient':
                if(n!=0) {
                    n--;
                    link.href = "{{ url('/enti/newclient/corporation') }}" + '/' + indici[n];
                    n = 0;
                    selezione = undefined;
                    link.dispatchEvent(clickEvent);
                }
            break;
			case 'duplicate':
                if(n!=0) {
                    n--;
                    link.href = "{{ url('/enti/duplicate/corporation') }}" + '/' + indici[n];
                    n = 0;
                    selezione = undefined;
                    link.dispatchEvent(clickEvent);
                }
				/*link.href = "{{ url('/enti/duplicate/corporation') }}" + '/';
                for(var i = 0; i < n; i++) {
                        $.ajax({
                            type: "GET",
                            url : link.href + indici[n],
                            error: function(url) {
                                if(url.status==403) {
									window.location.href = "{{ url('/enti/duplicate/corporation') }}" + '/' + indici[n];
                                    error = true;
                                } 
                            }
                        });
                    }
                    selezione = undefined;
                    
                if(error === false)
                    setTimeout(function(){location.reload();},100*n);
					
				n = 0;*/
			break;
            case 'skype':
                if(n!=0) {
                    //alert(n);
                    n--;                    
                    var url = "{{ url('/enti/getdetails') }}" + '/' + indici[n];
                    $.ajax({
                        type: "GET",
                        url : url,
                        error: function(url) {                            
                            if(url.status==403) {
                                link.href = "{{ url('/enti/getdetails') }}" + '/' + indici[n];
                                link.dispatchEvent(clickEvent);
                                error = true;
                            }
                        },
                        success:function(url){
                            if(url!="fail"){
                                var obj = jQuery.parseJSON(url);                                 
                                 if(obj.skype_id != "" && obj.skype_id != null) {   

                                    link.href = "skype:"+obj.skype_id+"?call";                                
                                    //selezione = undefined;
                                    link.dispatchEvent(clickEvent);
                                }
                            }
                        }                         
                    });                                       
                    //n = 0;
                }                
		}
}

</script> 
@endsection