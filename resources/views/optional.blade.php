@extends('adminHome')
@section('page')
<h1>{{trans('messages.keyword_optional')}}</h1><hr>
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
<script type="text/javascript" src="http://ff.kis.v2.scr.kaspersky-labs.com/A6847946-FDE4-3F4D-8DC3-B77A1A9B63D3/main.js" charset="UTF-8"></script>

<script>
    
$(function () {
$("table").stupidtable();
        });
        @if (!empty(Session::get('msg')))
var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
document.write(msg);
@endif

</script>
<div class="btn-group">
    <form action="{{ url('/admin/taxonomies/optional/add') }}" method="post" style="display:inline;">
        {{ csrf_field() }}
        <button class="btn btn-warning" type="submit" name="create" title="Crea nuovo - Aggiungi un nuovo optional"><i class="fa fa-plus"></i></button>
    </form><br>
    <a onclick="multipleAction('modify');" id="modifica" style="display:inline;">
        <button class="btn btn-primary" type="button" name="update" title="Modifica - Modifica l'ultimo ente selezionato"><i class="glyphicon glyphicon-pencil"></i></button>
    </a>
    <a id="delete" onclick="multipleAction('delete');" style="display:inline;">
        <button class="btn btn-danger" type="button" name="remove" title="Elimina - Elimina gli enti selezionati"><i class="glyphicon glyphicon-erase"></i></button>
    </a>
</div>
<br><br>

<table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="<?php echo url('admin/taxonomies/json'); ?>" data-classes="table table-bordered" id="table">
    <thead>
    <th data-field="id" data-sortable="true">{{trans('messages.keyword_code')}}
    <th data-field="code" data-sortable="true">{{trans('messages.keyword_short_name')}}
    <th data-field="description" data-sortable="true">{{trans('messages.keyword_description')}}
        <th data-field="icon" data-sortable="true">{{trans('messages.keyword_icon')}}
    <th data-field="price" data-sortable="true">{{trans('messages.keyword_price')}}    
 </thead>
</table>
</div>

<!--<div class="pull-right">
    {{ $optional->links() }}
</div>-->
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
            for (var i = 0; i < n; i++) {
                if (indici[i] == cod) {
                    for (var x = i; x < indici.length - 1; x++)
                        indici[x] = indici[x + 1];
                    break;
                }
            }
            n--;
        }
    });

    function check() {
        return confirm("Sei sicuro di voler eliminare: " + n + " preventivi?");
    }
    function multipleAction(act) {

        var link = document.createElement("a");
        var clickEvent = new MouseEvent("click", {
            "view": window,
            "bubbles": true,
            "cancelable": false
        });
        var error = false;
        switch (act) {
            case 'delete':
                link.href = "{{ url('/admin/taxonomies/delete/optional/') }}" + '/';
                if (check() && n != 0) {
                    for (var i = 0; i < n; i++) {
                        $.ajax({
                            type: "GET",
                            async: false,
                            url: link.href + indici[i],
                            success: function (data, textStatus, jqXHR) {
                                //menu deleted
                            },
                            error: function (url) {
//                                if (url.status == 403) {
//                                    link.href = "{{ url('/preventivi/delete/quote') }}" + '/' + indici[n];
//                                    link.dispatchEvent(clickEvent);
//                                    error = true;
//                                }
                            }
                        });
                    }
                    selezione = undefined;
                    if (error === false) {
                        setTimeout(function () {
                            location.reload();
                        }, 100 * n);
                    }
                    //n = 0;
                }
                break;
            case 'modify':
                if (n != 0) {
                    n--;
                    link.href = "{{ url('/admin/taxonomies/modify/optional/')}}" + '/' + indici[n];
                    n = 0;
                    selezione = undefined;
                    link.dispatchEvent(clickEvent);
                }
                break;
        }
    }
</script>

@endsection