@extends('adminHome')
@section('page') 
<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script> 
<link rel="stylesheet" href="{{ asset('build/css/bootstrap-table.min.css') }}">
<script src="{{ asset('build/js/bootstrap-table.min.js') }}"></script>
<script src="{{ asset('build/js/bootstrap-table-it-IT.min.js') }}"></script>

<h1>{{trans('messages.keyword_list_pages')}} </h1>
<hr>
<script>
@if(!empty(Session::get('msg')))
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
@endif
</script>

<!-- Fine filtraggio miei/tutti -->
<a onclick="multipleAction('add');" id="add" class="btn btn-warning" name="update" title=" {{trans('messages.keyword_create_a_new_page')}}"><i class="fa fa-plus"></i>  </a>

<a onclick="multipleAction('modify');" id="modifica" class="btn btn-primary" name="update" title=" {{trans('messages.keyword_edit_last_selected_format')}}"><i class="fa fa-pencil"></i>  </a>
 
<a id="delete" onclick="multipleAction('delete');" class="btn btn-danger" name="remove" title=" {{trans('messages.keyword_delete_selected_format')}} "><i class="fa fa-trash"></i></a> 

<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />

<table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true"  data-show-columns="true" data-url="<?php  echo url('json/pages')?>" data-classes="table table-bordered" id="table">
  <thead>
    <th data-field="page_id" data-sortable="true">
    {{trans('messages.keyword_page_id')}}</th>
    <th data-field="page_title" data-sortable="true">{{trans('messages.keyword_page_title')}}</th>
    <th data-field="is_enabled" data-sortable="true">{{trans('messages.keyword_active')}}</th>
    </thead>
</table>
<script>

function page_enabled(id){

    var check = $(id).is(":checked");

    if(check == true) {
        is_enabled = 1;
    } else {
        is_enabled = 0;
    }

    var page_id = $(id).val();    
    var _token = $('input[name="_token"]').val(); 

    $.ajax({
        type:"POST",
        url:'{{ url('/page/is-enabled/') }}',
        data: { 'page_id': page_id, 'is_enabled': is_enabled, '_token' : _token },
        success: function(data) {         
            console.log(data);
        }
    });
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

	return confirm("{{trans('messages.keyword_are_you_sure_you_want_to_delete:')}}: " + n + " {{trans('messages.keyword_page')}}?");
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
                   link.href = "{{ url('/admin/page/delete') }}" + '/';
                    if(check() && n!= 0) {   

                        n--;
                        link.href = "{{ url('/admin/page/delete') }}" + '/' + indici[n];
                        n = 0;
                        selezione = undefined;
                        link.dispatchEvent(clickEvent);
                    }
			break;
			case 'modify':
                if(n != 0) {
					n--;
					link.href = "{{ url('/admin/modify/page') }}" + '/' + indici[n];
					n = 0;
					selezione = undefined;
					link.dispatchEvent(clickEvent);
				}
			break;
            case 'add':
                link.href = "{{ url('/admin/modify/page') }}";
                selezione = undefined;
                link.dispatchEvent(clickEvent);
            break;
		}
}

</script> 
@endsection