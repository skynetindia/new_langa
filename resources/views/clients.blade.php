@extends('adminHome')

@section('page')

<h1>{{ trans('messages.keyword_client') }} Easy <strong>LANGA</strong></h1><hr>

@include('common.errors')


<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>

<script>

$(function () {

    $("table").stupidtable();

});

@if (!empty(Session::get('msg')))

var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';

document.write(msg);

@endif

</script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.js"></script>

<!-- Latest compiled and minified Locales -->
<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/locale/bootstrap-table-it-IT.min.js"></script> -->
<div class="btn-group">
    <a onclick="multipleAction('add');" id="add">
        <button class="btn btn-primary" type="button" name="add" title="{{ trans('messages.keyword_adduser') }}"><i class="glyphicon glyphicon-plus"></i></button></a>
        <a onclick="multipleAction('modify');" id="modifica">
            <button class="btn btn-primary" type="button" name="update" title="{{ trans('messages.keyword_edit') }}"><i class="glyphicon glyphicon-pencil"></i></button>
        </a>
        <a id="delete" onclick="multipleAction('delete');">
            <button class="btn btn-danger" type="button" name="remove" title="{{ trans('messages.keyword_delete') }}"><i class="glyphicon glyphicon-erase"></i></button>
        </a>
</div>
<br><br>
<div class="table-responsive table-custom-design">
    <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="{{ url('clients/json') }}" data-classes="table table-bordered" id="table">
        <thead>

        <th data-field="id" data-sortable="true">
            {{ trans('messages.keyword_id') }} </th>
        <th data-field="name" data-sortable="true">
            {{ trans('messages.keyword_name') }} </th>
        <th data-field="nome_ruolo" data-sortable="true">
            {{ trans('messages.keyword_profile') }}</th>
        <th data-field="nome_stato" data-sortable="true">
            {{ trans('messages.keyword_zone') }} </th>
        <th data-field="email" data-sortable="true">
            {{ trans('messages.keyword_email') }} </th>
        <th data-field="cellulare" data-sortable="true">
            {{ trans('messages.keyword_cell') }} </th>
        <th data-field="id_ente" data-sortable="true">
            {{ trans('messages.keyword_entity') }}</th>
        <th data-field="button" data-sortable="true">
            {{ trans('messages.keyword_access') }}</th>
        </thead>

    </table>

</div>

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
        return confirm("{{ trans('messages.keyword_sure') }} " + n + " {{ trans('messages.keyword_users') }} ?");
    }
    function multipleAction(act) {
        var error = false;
        var link = document.createElement("a");
        var clickEvent = new MouseEvent("click", {
            "view": window,
            "bubbles": true,
            "cancelable": false
        });
        switch (act) {
            case 'delete':
                link.href = "{{ url('/admin/destroy/utente') }}" + '/';
                if (check() && n != 0) {
                    for (var i = 0; i < n; i++) {
                        $.ajax({
                            type: "GET",
                            url: link.href + indici[i],
                            error: function (url) {
                                if (url.status == 403) {
                                    link.href = "{{ url('/admin/destroy/utente') }}" + '/' + indici[n];
                                    link.dispatchEvent(clickEvent);
                                }
                            }
                        });
                    }
                    selezione = undefined;
                    setTimeout(function () {
                        location.reload();
                    }, 100 * n);
                    n = 0;
                }
                break;
            case 'modify':
                if (n != 0) {
                    n--;
                    link.href = "{{ url('/admin/modify/utente') }}" + '/' + indici[n];
                    n = 0;
                    selezione = undefined;
                    link.dispatchEvent(clickEvent);
                }
                break;
            case 'add':

                link.href = "{{ url('/admin/modify/utente') }}";
                link.dispatchEvent(clickEvent);

                break;
        }
    }

    function access(id) {
        
        window.location = "{{ url('admin/user/access') }}" + '/'+id ;
        
    }
</script>

@endsection
