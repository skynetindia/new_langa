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

<div class="my-ticket-tbl">
<div class="main-blade">
    <div class="header-right">
        <div class="float-left">      
        <h1>{{ucwords(trans('messages.keyword_problems'))}}</h1><hr>

        <div class="btn-header-main-blade">
        <div class="btn-group">

            <a onclick="multipleAction('modify');" id="modifica" class="btn btn-primary" title="{{trans('messages.keyword_edit_last_selected_format')}}"> <i class="fa fa-pencil"></i>
            </a>
            <a id="delete" onclick="multipleAction('delete');" class="btn btn-danger" name="remove" title="{{trans('messages.keyword_delete_last_selected_lauout')}}">
                <i class="fa fa-trash"></i>
            </a>

        </div>
        </div>
    </div>
</div>
</div>

<div class="clearfix"></div> <div class="space30"></div>
<div class="panel panel-default">
	<div class="panel-body">
    <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="<?php echo url('/tickets/json');?>" data-classes="table table-bordered" id="table">
        <thead>
            <th data-field="random_tid" data-sortable="true">{{ucwords(trans('messages.keyword_ticket_id'))}}</th>
            <th data-field="problem" data-sortable="true">{{ucwords(trans('messages.keyword_problems'))}}</th>
            <th data-field="ticket_status" data-sortable="true">{{ucwords(trans('messages.keyword_ticket_status'))}}</th>
            <th data-field="module_id" data-sortable="true">{{ucwords(trans('messages.keyword_module'))}}</th>  
            <th data-field="created_at" data-sortable="true">{{ucwords(trans('messages.keyword_created_at'))}}</th>  
            <th data-field="updated_at" data-sortable="true">{{ucwords(trans('messages.keyword_updated_at'))}}</th>            
        </thead>
    </table>
    </div>
</div>
 </div>   

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

function check() { return confirm("{{trans('messages.keyword_are_you_sure_you_want_to_delete:')}} {{trans('messages.keyword_tickets')}}?"); 
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
    			link.href = "{{ url('/ticket/delete') }}" + '/';
    			if(check() && n!=0) {
                    n--;
                    link.href = "{{ url('/ticket/delete') }}" + '/'+ indici[n];
                    n = 0;
                    selezione = undefined;
                    link.dispatchEvent(clickEvent);
                }
			break;
			case 'modify':
                if(n != 0) {
					n--;
					link.href = "{{ url('/ticket/modify') }}" + '/' + indici[n];
					n = 0;
					selezione = undefined;
					link.dispatchEvent(clickEvent);
				}
			break;
		}
}    
</script>
@endsection