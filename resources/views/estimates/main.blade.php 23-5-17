@extends('layouts.app')
@section('content')
@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif

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
<!-- Latest compiled and minified JavaScript -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.js"></script>
<!-- Latest compiled and minified Locales -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/locale/bootstrap-table-it-IT.min.js"></script>

<h1>{{trans('messages.keyword_quotes')}}</h1><hr>
<form action="{{ url('/estimates/add') }}" method="post" style="display:inline;">
    {{ csrf_field() }}
    <button class="btn btn-warning" type="submit" name="create" title="{{trans('messages.keyword_create_new_-_add_a_new_estimate')}}"><i class="fa fa-plus"></i></button>
</form>
<!-- Inizio filtraggio miei/tutti -->
@if(isset($miei))
<a id="miei" href="{{url('/estimates/my')}}" style="display:inline;">
<button class="button button2" type="button" name="miei" title="{{trans('messages.keyword_my_-_filter_your_budgets')}}" style="background-color:#337AB7;color:#ffffff">{{trans('messages.keyword_my')}}</button>
</a>
<a id="tutti" href="{{url('/estimates')}}" style="display:inline;">
<button class="button button3" type="button" name="tutti" title="{{trans('messages.keyword_all__show_all_budgets')}}">{{trans('messages.keyword_all')}}</button>
</a>
@else
<a id="miei" href="{{url('/estimates/my')}}" style="display:inline;">
<button class="button button2" type="button" name="miei" title="{{trans('messages.keyword_my_-_filter_your_budgets')}}">{{trans('messages.keyword_my')}}</button>
</a>
<a id="tutti" href="{{url('/estimates')}}" style="display:inline;">
<button class="button button3" type="button" name="tutti" title="{{trans('messages.keyword_all__show_all_budgets')}}" style="background-color:#D9534F;color:#ffffff">{{trans('messages.keyword_all')}}</button>
</a>
@endif
<!-- Fine filtraggio miei/tutti -->
<div class="btn-group" style="display:inline">
<a onclick="multipleAction('modify');" id="modifica" style="display:inline;">
<button class="btn btn-primary" type="button" name="update" title="{{trans('messages.keyword_edit_the_last_selected_estimate')}}"><i class="fa fa-pencil"></i></button>
</a>

<a id="duplicate" onclick="multipleAction('duplicate');" style="display:inline;">
<button class="btn btn-info" type="button" name="duplicate" title="{{trans('messages.keyword_duplicates_selected_quotes')}}"><i class="fa fa-files-o"></i></button>
</a>    
    
<a id="delete" onclick="multipleAction('delete');" style="display:inline;">
<button class="btn btn-danger" type="button" name="remove" title="{{trans('messages.keyword_delete_selected_estimates')}}"><i class="fa fa-trash"></i></button>
</a>

<a id="pdf" onclick="multipleAction('pdf');" style="display:inline;">
<button class="btn" type="button" name="pdf" title="{{trans('messages.keyword_general_pdf_of_selected_quotes')}}"><i class="fa fa-file-pdf-o"></i></button>
</a>
</div>
<br><br>
    <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="<?php if(isset($miei)) echo url('estimates/miei/json'); else echo url('/estimates/json');?>" data-classes="table table-bordered" id="table">
        <thead>
            <th data-field="id" data-sortable="true">{{trans('messages.keyword_no_estimate')}}</th>
            <th data-field="ente" data-sortable="true">{{trans('messages.keyword_entity')}}</th>
            <th data-field="oggetto" data-sortable="true">{{trans('messages.keyword_object')}}</th>
            <th data-field="data" data-sortable="true">{{trans('messages.keyword_execution_date')}}</th>
            <th data-field="valenza" data-sortable="true">{{trans('messages.keyword_expiry_date')}}</th>
            <th data-field="dipartimento" data-sortable="true">{{trans('messages.keyword_department')}}</th>
            <th data-field="finelavori" data-sortable="true">{{trans('messages.keyword_end_date_works')}}</th>
            <th data-field="statoemotivo" data-sortable="true">{{trans('messages.keyword_emotional_state')}}</th>
        </thead>
    </table>
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

function check() { return confirm("<?php echo trans('messages.keyword_are_you_sure_you_want_to_delete:'); ?>" + n + " <?php echo trans('messages.keyword_quotes');?>?"); }
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
			link.href = "{{ url('/estimates/delete/quote') }}" + '/';
			if(check() && n!=0) {
				for(var i = 0; i < n; i++) {
					$.ajax({
						type: "GET",
						url : link.href + indici[i],
						error: function(url) {
							if(url.status==403) {
								link.href = "{{ url('/estimates/delete/quote') }}" + '/' + indici[n];
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
					link.href = "{{ url('/estimates/modify/quote') }}" + '/' + indici[n];
					n = 0;
					selezione = undefined;
					link.dispatchEvent(clickEvent);
				}
			break;
        case 'duplicate':
			link.href = "{{ url('/estimates/duplicate/quote') }}" + '/';
				for(var i = 0; i < n; i++) {
					$.ajax({
						type: "GET",
						url : link.href + indici[i],
						error: function(url) {
							if(url.status==403) {
                                link.href = "{{ url('/estimates/duplicate/quote') }}" + '/' + indici[n];
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
			case 'pdf':

			    link.href = "{{ url('/estimates/pdf/quote') }}" + '/';

			    for(var i = 0; i < n; i++) {
                    var url = link.href + indici[i];
                    var win = window.open(url, '_blank');
                    win.focus();
                }
                n = 0;
                selezione = undefined;
                setTimeout(function(){location.reload();},100*n);
			break;
		}
}
</script>

@endsection