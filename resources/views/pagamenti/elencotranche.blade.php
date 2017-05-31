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

<div class="header-lst-img">
	<div class="header-svg text-left float-left">
        <img src="http://betaeasy.langa.tv/images/HEADER1_LT_ACCOUNTING.svg" alt="header image">
    </div>
    <div class="float-right text-right">
    	<h1> {{ trans('messages.keyword_list_invoices') }} </h1><hr>
        <div class="btn-group">
            <a onclick="multipleAction('modify');" id="modifica" class="btn btn-warning" name="update" title="{{ trans('messages.keyword_edit_last_selected_format') }} ">
				<i class="fa fa-pencil"></i>
            </a>
            <a id="duplicate" onclick="multipleAction('duplicate');" class="btn btn-info" name="duplicate" title="{{ trans('messages.keyword_duplicates_selected_layouts') }}">
				<i class="fa fa-files-o"></i>
            </a>    
            <a id="delete" onclick="multipleAction('delete');" class="btn btn-danger" name="remove" title="{{ trans('messages.keyword_delete_last_selected_lauout') }} ">
				<i class="fa fa-trash"></i>
            </a>
            <a id="pdf" onclick="multipleAction('pdf');" class="btn" name="pdf" title=" {{ trans('messages.keyword_generate_pdf_selected_formats') }} ">
				<i class="fa fa-file-pdf-o"></i>
            </a>
        </div>
    </div>
</div>

<div class="clearfix"></div>
<div class="height20"></div>


    <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="<?php echo url('/pagamenti/tranche/json');?>" data-classes="table table-bordered" id="table">
        <thead>
            <th data-field="id" data-sortable="true"> 
            {{ trans('messages.keyword_noprovision') }} 
            <th data-field="idfattura" data-sortable="true"> 
            {{ trans('messages.keyword_invoicenumber') }} 
            <th data-field="ente" data-sortable="true"> 
            {{ trans('messages.keyword_entity') }}
            <th data-field="nomequadro" data-sortable="true"> 
            {{ trans('messages.keyword_picturename') }} 
            <th data-field="tipo" data-sortable="true"> 
            {{ trans('messages.keyword_types') }} 
            <th data-field="datainserimento" data-sortable="true"> 
            {{ trans('messages.keyword_inserting') }} 
            <th data-field="datascadenza" data-sortable="true"> 
            {{ trans('messages.keyword_deadline') }} 
            <th data-field="percentuale" data-sortable="true">%
            <th data-field="dapagare" data-sortable="true"> 
            {{ trans('messages.keyword_topay') }} 
            <th data-field="statoemotivo" data-sortable="true"> 
            {{ trans('messages.keyword_emotional_state') }} 
        </thead>
    </table>

<script>
var selezione = [];
var indici = [];
var n = 0;

$('#table').on('click-row.bs.table', function (row, tr, el) {
	var cod = /\d+/.exec($(el[0]).children()[0].innerHTML);
	//console.log(/\d+/.exec($(el[0]).children()[1].innerHTML));
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



function check() { return confirm(" {{ trans('messages.keyword_sure') }}: " + n + " {{ trans('messages.keyword_tranche') }} ?"); }
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
				link.href = "{{ url('/pagamenti/tranche/delete/') }}" + '/';
				if(check() && n!=0) {
                                    for(var i = 0; i < n; i++) {
                                        $.ajax({
                                            type: "GET",
                                            url : link.href + indici[i],
                                            error: function(url) {
                                                if(url.status==403) {
                                                    link.href = "{{ url('/pagamenti/tranche/delete/') }}" + '/' + indici[n];
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
					link.href = "{{ url('/pagamenti/tranche/modifica') }}" + '/' + indici[n];
					n = 0;
					selezione = undefined;
					link.dispatchEvent(clickEvent);
				}
			break;
			case 'pdf':
               link.href = "{{ url('/pagamenti/tranche/pdf') }}" + '/';
			    for(var i = 0; i < n; i++) {
                    var url = link.href + indici[i];
                    var win = window.open(url, '_blank');
                    win.focus();
                }
                n = 0;
                selezione = undefined;
                setTimeout(function(){location.reload();},100*n);
			break;
            case 'duplicate':
				link.href = "{{ url('/pagamenti/tranche/duplicate') }}" + '/';
                for(var i = 0; i < n; i++) {
                    $.ajax({
                        type: "GET",
                        url : link.href + indici[i],
                        error: function(url) {
                            if(url.status==403) {
                                link.href = "{{ url('/pagamenti/tranche/duplicate') }}" + '/' + indici[n];
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

<div class="footer-svg">
  <img src="http://betaeasy.langa.tv/images/FOOTER2_RB_ACCOUNTING.svg" alt="footer enti image">
</div>


@endsection