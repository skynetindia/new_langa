@extends('adminHome')
@section('page')

<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="{{ asset('build/css/bootstrap-table.min.css') }}">
<script src="{{ asset('build/js/bootstrap-table.min.js') }}"></script>
<script src="{{ asset('build/js/bootstrap-table-it-IT.min.js') }}"></script>
<h1>{{trans('messages.keyword_languages')}}</h1><hr>
<script>
@if(!empty(Session::get('msg')))
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
@endif
</script>
<?php /*<form action="{{ url('/admin/modify/language') }}" method="GET">
{{ csrf_field() }}
<button class="btn btn-warning" type="submit" name="create" title="Add New - Add new language"><i class="fa fa-plus"></i></button>
</form>

<form action="{{ url('/admin/add/languagetranslation') }}" method="GET" >
{{ csrf_field() }}
<button class="btn btn-warning" type="submit" name="create" title="{{trans('messages.keyword_add_phases')}}">{{trans('messages.keyword_add_phases')}}</button>
</form>*/?>
<a href="{{ url('/admin/modify/language') }}" id="create" class="btn btn-warning" name="create" title="Add New - Add new language"><i class="fa fa-plus"></i></a>
<!-- Inizio filtraggio miei/tutti -->

<!-- Fine filtraggio miei/tutti -->
<a onclick="multipleAction('modify');" id="modifica" class="btn btn-primary" name="update" title="Modifica - Modifica l'ultimo ente selezionato"><i class="fa fa-pencil"></i></a>
<?php /*<a id="duplicate" onclick="multipleAction('duplicate');" style="display:inline;">
<button class="btn btn-info" type="button" name="duplicate" title="Duplica - Duplica gli enti selezionati"><i class="fa fa-files-o"></i></button>
</a>*/?>
<a id="delete" onclick="multipleAction('delete');" class="btn btn-danger" name="remove" title="Elimina - Elimina gli enti selezionati"><i class="fa fa-trash"></i></a>
<a href="{{ url('/admin/add/languagetranslation') }}" id="create" class="btn btn-warning" name="create" title="{{trans('messages.keyword_add_phases')}}">{{trans('messages.keyword_add_phases')}}</a>
<a onclick="multipleAction('updatePhase');" id="modifica" class="btn btn-primary" name="update" title="{{trans('messages.keyword_update_phases')}}">{{trans('messages.keyword_update_phases')}}</a>

<div class="space10"></div>

<div class="panel panel-default">
<div class="panel-body">
<table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true"  data-show-columns="true" data-url="<?php  echo url('admin/language/json');?>" data-classes="table table-bordered" id="table">
<thead>
<th data-field="id" data-sortable="true">{{trans('messages.keyword_id')}}</th>
<th data-field="code" data-sortable="true">{{trans('messages.keyword_code')}}</th>
<th data-field="name" data-sortable="true">{{trans('messages.keyword_name')}}</th>
<th data-field="original_name" data-sortable="true">{{trans('messages.keyword_original_name')}}</th>
<th data-field="icon" data-sortable="true">{{trans('messages.keyword_icon')}}</th>
</thead>
</table>
</div>
</div>

<script>
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
	return confirm("{{trans('messages.keyword_are_you_sure_you_want_to_delete:')}} " + n + " {{trans('messages.keyword_languages')}}?");
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
				link.href = "{{ url('/admin/destroy/language') }}" + '/';
				if(check() && n!= 0) {
                        for(var i = 0; i < n; i++) {                            
                            $.ajax({
                                type: "GET",
                                url : link.href + indici[i],
                                error: function(url) {
                                    
                                    if(url.status==403) {
                                        link.href = "{{ url('/admin/languagetranslation/delete') }}" + '/' + indici[n];
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
					link.href = "{{ url('/admin/modify/language') }}" + '/' + indici[n];
					n = 0;
					selezione = undefined;
					link.dispatchEvent(clickEvent);
				}
			break;
            case 'updatePhase':
                if(n!=0) {
                    n--;
                    link.href = "{{ url('/admin/languagetranslation/') }}" + '/' + indici[n];
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