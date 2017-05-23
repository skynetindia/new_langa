@extends('adminHome')
@section('page')
<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.js"></script>

<!-- Latest compiled and minified Locales -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/locale/bootstrap-table-it-IT.min.js"></script>
<h1>Langauge Phases : {{ $language->name }}  </h1><hr>
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


<script>
    
    
@if(!empty(Session::get('msg')))


    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);

@endif
</script>

<form action="{{ url('/admin/add/languagetranslation') }}" method="post" style="display:inline;">
{{ csrf_field() }}
<button class="btn btn-warning" type="submit" name="create" title="Crea nuovo - Aggiungi un nuovo ente"><i class="fa fa-plus"></i></button>
</form>
<!-- Inizio filtraggio miei/tutti -->
<?php /*@if(isset($miei))
<a id="miei" href="{{url('/enti/miei')}}" style="display:inline;">
<button class="button button2" type="button" name="miei" title="Miei - Filtra i tuoi enti" style="background-color:#337AB7;color:#ffffff">Miei</button>
</a>
<a id="tutti" href="{{url('/enti')}}" style="display:inline;">
<button class="button button3" type="button" name="tutti" title="Tutti - Mostra tutti gli enti">Tutti</button>
</a>
@else
<a id="miei" href="{{url('/enti/miei')}}" style="display:inline;">
<button class="button button2" type="button" name="miei" title="Miei - Filtra i tuoi enti">Miei</button>
</a>
<a id="tutti" href="{{url('/enti')}}" style="display:inline;">
<button class="button button3" type="button" name="tutti" title="Tutti - Mostra tutti gli enti" style="background-color:#D9534F;color:#ffffff">Tutti</button>
</a>
@endif */?>
<!-- Fine filtraggio miei/tutti -->
<div class="btn-group">

<a onclick="multipleAction('modify');" id="modifica" style="display:inline;">
<button class="btn btn-primary" type="button" name="update" title="Modifica - Modifica l'ultimo ente selezionato"><i class="fa fa-pencil"></i></button>
</a>

<?php /*<a id="duplicate" onclick="multipleAction('duplicate');" style="display:inline;">
<button class="btn btn-info" type="button" name="duplicate" title="Duplica - Duplica gli enti selezionati"><i class="fa fa-files-o"></i></button>
</a>*/?>

<a id="delete" onclick="multipleAction('delete');" style="display:inline;">
<button class="btn btn-danger" type="button" name="remove" title="Elimina - Elimina gli enti selezionati"><i class="fa fa-trash"></i></button>
</a>
</div><br>

<table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true"  data-show-columns="true" data-url="<?php  echo url('admin/languagetranslation/json').'/'.$code;?>" data-classes="table table-bordered" id="table">
<thead>
<th data-field="id" data-sortable="true">n° ente</th>
<th data-field="language_label" data-sortable="true">Language Label</th>
<th data-field="language_value" data-sortable="true">Language Phase</th>
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

	return confirm("Are you sure delete: " + n + " phase?");
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
                                
				link.href = "{{ url('/admin/languagetranslation/delete') }}" + '/';
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
					link.href = "{{ url('/admin/modify/languagetranslation') }}" + '/' + indici[n];
					n = 0;
					selezione = undefined;
					link.dispatchEvent(clickEvent);
				}
			break;
            case 'newclient':
                if(n!=0) {
                    n--;
                    link.href = "{{ url('/enti/nuovocliente/corporation') }}" + '/' + indici[n];
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