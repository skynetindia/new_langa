@extends('adminHome')
@section('page')

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

<h1>{{trans('messages.keyword_menu')}}</h1><hr>

<form action="{{ url('/menu/add') }}" method="post" style="display:inline;">
    {{ csrf_field() }}
    <button class="btn btn-warning" type="submit" name="create" title="Crea nuovo - Aggiungi un nuovo preventivo"><i class="fa fa-plus"></i></button>
</form>
<div class="btn-group" style="display:inline">
    <a onclick="multipleAction('modify');" id="modifica" style="display:inline;">
        <button class="btn btn-primary" type="button" name="update" title="Modifica - Modifica l'ultimo preventivo selezionato"><i class="fa fa-pencil"></i></button>
    </a>
    <a id="delete" onclick="multipleAction('delete');" style="display:inline;">
        <button class="btn btn-danger" type="button" name="remove" title="Elimina - Elimina i preventivi selezionati"><i class="fa fa-trash"></i></button>
    </a>
</div>
<br><br>
<table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="<?php echo url('menu/json'); ?>" data-classes="table table-bordered" id="table">
    <thead>
    <th data-field="id" data-sortable="true">{{trans('messages.keyword_no_body')}}
    <th data-field="modulo" data-sortable="true">{{trans('messages.keyword_menu')}}
<!--    <th data-field="modulo_sub" data-sortable="true">Sub menu
    <th data-field="modulo_subsub" data-sortable="true">Menu of Sub menu-->
    <th data-field="modulo_link" data-sortable="true">{{trans('messages.keyword_menu_link')}}
    <th data-field="modulo_class" data-sortable="true">{{trans('messages.keyword_menu_class')}}
    <th data-field="menu_active" data-sortable="true">{{trans('messages.keyword_menu_active')}}
    <th data-field="dipartimento" data-sortable="true">{{trans('messages.keyword_department')}}
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
                link.href = "{{ url('/menu/delete/') }}" + '/';
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
                    link.href = "{{ url('/menu/modify/')}}" + '/' + indici[n];
                    n = 0;
                    selezione = undefined;
                    link.dispatchEvent(clickEvent);
                }
                break;
        }
    }
</script>

@endsection