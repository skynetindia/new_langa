@extends('layouts.app')
@section('content') 
<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script> 
<!-- Latest compiled and minified CSS -->
<link href="{{asset('/build/css/bootstrap-table.min.css')}}" rel="stylesheet">
<!--<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.css">--> 

<!-- Latest compiled and minified JavaScript --> 
<script src="{{asset('/build/js/bootstrap-table.min.js')}}"></script> 
<!--<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.js"></script>--> 

<!-- Latest compiled and minified Locales --> 
<script src="{{asset('/build/js/bootstrap-table-it-IT.min.js')}}"></script> 
<!--<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/locale/bootstrap-table-it-IT.min.js"></script>-->

<h1>Enti</h1>
<hr>
<script>
    
    
@if(!empty(Session::get('msg')))


    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);

@endif
</script>
<?php $loginuser = collect($loginuser)->toArray();?>
@if($loginuser['id']=='0' || $loginuser['dipartimento'] == '1' || $loginuser['dipartimento'] == '2')
<form action="{{ url('/enti/add/') }}" method="post">
  {{ csrf_field() }}
  <button class="btn btn-warning" type="submit" name="create" title="Crea nuovo - Aggiungi un nuovo ente"><i class="fa fa-plus"></i></button>
</form>
@endif 
<!-- Inizio filtraggio miei/tutti --> 

@if(isset($miei)) <a id="miei" class="button button2" href="{{url('/enti/myenti')}}" name="miei" title="<?php echo trans('messages.keyword_my').' - '.trans('messages.keyword_filter_your_entity'); ?>">{{trans('messages.keyword_my')}}</a>
<a id="tutti" href="{{url('/enti')}}"  class="button button3" name="tutti" title="<?php echo trans('messages.keyword_all').' - '.trans('messages.keyword_show_all'); ?>">{{trans('messages.keyword_all')}}</a> 
@else 
<a id="miei" class="button button2" href="{{url('/enti/miei')}}" name="miei"  title="<?php echo trans('messages.keyword_my').' - '.trans('messages.keyword_filter_your_entity'); ?>">{{trans('messages.keyword_my')}}</a>
<a id="tutti" class="button button3" href="{{url('/enti')}}" name="tutti" title="<?php echo trans('messages.keyword_all').' - '.trans('messages.keyword_show_all'); ?>">{{trans('messages.keyword_my')}}</a> 
@endif 
<!-- Fine filtraggio miei/tutti --> 
@if($loginuser['id']=='0' || $loginuser['dipartimento'] == '1' || $loginuser['dipartimento'] == '2')

<a onclick="multipleAction('modify');" id="modifica" class="btn btn-primary" name="update" title="<?php echo trans('messages.keyword_edit_-_edit_the_last_selected_entities');?>"><i class="fa fa-pencil"></i></a>
<a id="duplicate" onclick="multipleAction('duplicate');" class="btn btn-info" name="duplicate" title="<?php echo trans('messages.keyword_duplicate_-_duplicates_selected_entities');?>"><i class="fa fa-files-o"></i></a> 
<a id="delete" onclick="multipleAction('delete');" class="btn btn-danger" name="remove" title="<?php echo trans('messages.keyword_delete_-_delete_selected_entities') ?>"> <i class="fa fa-trash"></i></a>
<a id="newclient" onclick="multipleAction('newclient');" class="btn btn-warning" name="newclient" title="<?php echo trans('messages.keyword_create_send_credentials_for_the_customer_entity');?>">{{trans('messages.keyword_new_client')}}  </a> 
  <div class="space10"></div>
<div class="skype-call"> <a id="call" href="#" class="btn btn-warning"  title="skype "><img src="../images/phone-call.png" alt="skype call"/> Skype call</a> </div>
<div class="space30"></div>
@endif
<table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true"  data-show-columns="true" data-url="<?php if(isset($miei)) echo url('enti/myenti/json'); else echo url('/enti/json');?>" data-classes="table table-bordered" id="table">
  <thead>
  <th data-field="id" data-sortable="true">{{trans('messages.keyword_id')}}</th>
    <th data-field="nomeazienda" data-sortable="true">{{trans('messages.keyword_company_name')}}</th>
    <th data-field="nomereferente" data-sortable="true">{{trans('messages.keyword_company_name')}}</th>
    <th data-field="settore" data-sortable="true">{{trans('messages.keyword_sector')}}</th>
    <th data-field="telefonoazienda" data-sortable="true">{{trans('messages.keyword_telephone_company')}}</th>
    <th data-field="email" data-sortable="true">{{trans('messages.keyword_email')}}</th>
    <th data-field="indirizzo" data-sortable="true">{{trans('messages.keyword_address')}}</th>
    <th data-field="responsabilelanga" data-sortable="true">{{trans('messages.keyword_responsible')}} LANGA</th>
    <th data-field="statoemotivo" data-sortable="true">{{trans('messages.keyword_emotional_state')}}</th>
    <th data-field="tipo" data-sortable="true">{{trans('messages.keyword_guy')}}</th>
      </thead>
</table>
<script>
var selezione = [];
var indici = [];
var n = 0;

$('#table').on('click-row.bs.table', function (row, tr, el) {
	var cod = $(el[0]).children()[0].innerHTML;
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
				link.href = "{{ url('/enti/duplicate/corporation') }}" + '/';
                                for(var i = 0; i < n; i++) {
                                        $.ajax({
                                            type: "GET",
                                            url : link.href + indici[i],
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
									
								n = 0;
			break;
		}
}

</script> 
@endsection