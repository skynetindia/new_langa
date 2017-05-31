@extends('adminHome')
@section('page')
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
<h1>{{trans('messages.keyword_menu')}}</h1><hr>
<form action="{{ url('/menu/add') }}" method="post">
    {{ csrf_field() }}
    <button class="btn btn-warning" type="submit" name="create" title="Crea nuovo - Aggiungi un nuovo preventivo"><i class="fa fa-plus"></i></button>
</form>
<div class="btn-group margin-r8">
    <a class="btn btn-primary" onclick="multipleAction('modify');" id="modifica">
        <i class="fa fa-pencil"></i>
    </a>
    <a class="btn btn-danger" id="delete" onclick="multipleAction('delete');">
        <i class="fa fa-trash"></i>
    </a>
</div>
<br><br>
<table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="<?php echo url('menu/json'); ?>" data-classes="table table-bordered" id="table">
    <thead>
    <th data-field="id" data-sortable="true">{{trans('messages.keyword_id')}}</th>
    <th data-field="modulo" data-sortable="true">{{trans('messages.keyword_menu')}}</th>
<!--    <th data-field="modulo_sub" data-sortable="true">Sub menu</th>
    <th data-field="modulo_subsub" data-sortable="true">Menu of Sub menu--></th>
    <th data-field="modulo_link" data-sortable="true">{{trans('messages.keyword_menu_link')}}</th>
    <th data-field="modulo_class" data-sortable="true">{{trans('messages.keyword_menu_class')}}</th>
    <th data-field="menu_active" data-sortable="true">{{trans('messages.keyword_menu_active')}}</th>
    <th data-field="type" data-sortable="true">{{trans('messages.keyword_menu_type')}}</th>
    
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