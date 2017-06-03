@extends('adminHome')
@section('page')
<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.js"></script>

<!-- Latest compiled and minified Locales -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/locale/bootstrap-table-it-IT.min.js"></script>

<h1>{{trans('messages.keyword_quiz_pacchetto')}}</h1><hr>
@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif
</script>
<!-- Fine filtraggio miei/tutti -->
<a onclick="multipleAction('add');" id="add" class="btn btn-warning" name="add" title="{{trans('messages.keyword_add_new_quiz_package')}}"><i class="glyphicon glyphicon-plus"></i></a>
<div class="space10"></div>
<a onclick="multipleAction('modify');" id="modifica" class="btn btn-primary" name="update" title="{{trans('messages.keyword_modify_selected_quiz_package')}}"><i class="glyphicon glyphicon-pencil"></i></a>
<a id="delete" onclick="multipleAction('delete');" class="btn btn-danger" name="remove" title="{{trans('messages.keyword_delete_selected_quiz_package')}}"><i class="fa fa-trash"></i></a>
<div class="space30"></div>
<div class="table-responsive">
<table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true"  data-show-columns="true" data-url="<?php  echo url('admin/quizpackage/json');?>" data-classes="table table-bordered" id="table">
<thead>
<th data-field="id" data-sortable="true">{{trans('messages.keyword_id')}}</th>
<th data-field="nome_pacchetto" data-sortable="true">{{trans('messages.keyword_package_name')}}</th>
<th data-field="pagine_totali" data-sortable="true">{{trans('messages.keyword_total_pages')}}</th>
<th data-field="prezzo_pacchetto" data-sortable="true">{{trans('messages.keyword_package_price')}}</th>
<th data-field="per_pagina_prezzo" data-sortable="true">{{trans('messages.keyword_per_price_page')}}</th>
</thead>
</table>
</div>
<div class="footer-svg">
    <img src="{{asset('images/ADMIN_QUIZ-footer.svg')}}" alt="quiz">
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

	} 
	else {
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

	return confirm("<?php echo trans('messages.keyword_are_you_sure_you_want_to_delete:')?> " + n + " <?php echo trans('messages.keyword_packages')?>?");
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
                                
				link.href = "{{ url('/admin/destroy/quizpackage') }}" + '/';
				if(check() && n!= 0) {
                        for(var i = 0; i < n; i++) {                            
                            $.ajax({
                                type: "GET",
                                url : link.href + indici[i],
                                error: function(url) {
                                    
                                    if(url.status==403) {
                                        link.href = "{{ url('/admin/destroy/quizpackage') }}" + '/' + indici[n];
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
					link.href = "{{ url('/admin/modify/quizpaackage') }}" + '/' + indici[n];
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
			 case 'add':        
                link.href = "{{ url('/admin/modify/quizpaackage') }}"; 
                link.dispatchEvent(clickEvent);
          
            break;
		}
}

</script>



@endsection