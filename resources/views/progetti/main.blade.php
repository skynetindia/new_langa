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
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/locale/bootstrap-table-it-IT.min.js"></script>
<div class="progetti-header">
	<div class="header-svg float-left">
        <img src="{{url('images/HEADER1_LT_PROJECT.svg')}}" alt="header image">
    </div>    
    <div class="header-svg float-right">
        <img src="{{url('images/HEADER1_RT_PROJECT.svg')}}" alt="header image">
    </div>
</div>

<div class="clearfix"></div>
<div class="height20"></div>

<div class="progetti-btn-head">
    	<h1>{{trans('messages.keyword_projectlist')}}</h1><hr>
        	<a href="{{url('/progetti/add')}}" id="modifica"  class="btn btn-warning" name="update" title="{{trans('messages.keyword_addnewproject')}}">
            	<i class="fa fa-plus"></i>
            </a>
            @if(isset($miei))
            <a  class="button button2" id="miei" href="{{url('/progetti/miei')}}" name="miei" title="{{trans('messages.keyword_myfilterproject')}}" >
            	{{trans('messages.keyword_my')}}
            </a>
            <a id="tutti" href="{{url('/progetti')}}" class="button button3" name="tutti" title="{{trans('messages.keyword_allshowpojects')}}">
            	{{trans('messages.keyword_all')}}
            </a>
            @else
            <a id="miei" href="{{url('/progetti/miei')}}" class="button button2" name="miei" title="{{trans('messages.keyword_myfilterproject')}}">
            	{{trans('messages.keyword_my')}}
            </a>
            <a id="tutti" href="{{url('/progetti')}}" class="button button3" name="tutti" title="{{trans('messages.keyword_allshowpojects')}}">
				{{trans('messages.keyword_all')}}
            </a>
            @endif
            <!-- Fine filtraggio miei/tutti -->
        <div class="btn-group">
            <a onclick="multipleAction('modify');" id="modifica" class="btn btn-primary" title="{{trans('messages.keyword_edit_last_selected_project')}}">
            	<i class="fa fa-pencil"></i>
            </a>
            <a id="duplicate" onclick="multipleAction('duplicate');" class="btn btn-info" title="{{trans('messages.keyword_duplicates_selected_quotes')}}">
            	<i class="fa fa-files-o"></i>
            </a>    
            <a id="delete" onclick="multipleAction('delete');" class="btn btn-danger" name="remove" title="{{trans('messages.keyword_delete_selected_estimates')}}">
				<i class="fa fa-trash"></i>
            </a>
    	</div>
 

</div>
<br><br>
    <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="<?php if(isset($miei)) echo url('progetti/miei/json'); else echo url('/progetti/json');?>" data-classes="table table-bordered" id="table">
        <thead>
            <th data-field="codice" data-sortable="true">{{trans('messages.keyword_noproject')}}</th>
            <th data-field="ente" data-sortable="true">{{trans('messages.keyword_entity')}}</th>
            <th data-field="nomeprogetto" data-sortable="true">{{trans('messages.keyword_projectname')}}</th>
            <th data-field="da" data-sortable="true">{{trans('messages.keyword_from')}}</th>
            <th data-field="datainizio" data-sortable="true">{{trans('messages.keyword_startdate')}}</th>
            <th data-field="datafine" data-sortable="true">{{trans('messages.keyword_enddate')}}</th>
            <th data-field="progresso" data-sortable="true">{{trans('messages.keyword_progress')}}</th>
            <th data-field="statoemotivo" data-sortable="true">{{trans('messages.keyword_emotional_state')}}</th>
        </thead>
    </table>
<div class="footer-svg">
  <img src="{{url('images/FOOTER3_ORIZZONTAL_PROJECT.svg')}}" alt="ORIZZONTAL PROJECT">
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



function check() { return confirm("{{trans('messages.keyword_are_you_sure_you_want_to_delete:')}} " + n + " {{trans('messages.keyword_projects')}}?"); }
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
				link.href = "{{ url('/progetti/delete/project') }}" + '/';
				if(check() && n!=0) {
                                    for(var i = 0; i < n; i++) {
                                        $.ajax({
                                            type: "GET",
                                            url : link.href + indici[i],
                                            error: function(url) {
                                                if(url.status==403) {
                                                    link.href = "{{ url('/progetti/delete/project') }}" + '/' + indici[n];
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
					n--;
					link.href = "{{ url('/progetti/modify/project') }}" + '/' + indici[n];
					n = 0;
					selezione = undefined;
					link.dispatchEvent(clickEvent);
				}
			break;
            case 'duplicate':
				link.href = "{{ url('/progetti/duplicate/project') }}" + '/';
                for(var i = 0; i < n; i++) {
                    $.ajax({
                        type: "GET",
                        url : link.href + indici[i],
                        error: function(url) {
                            if(url.status==403) {
                                link.href = "{{ url('/progetti/duplicate/project') }}" + '/' + indici[n];
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
		}
}    
</script>
@endsection