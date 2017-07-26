@extends('adminHome')
@section('page')
<h1>{{ trans('messages.keyword_users') }} Easy <strong>LANGA</strong></h1><hr>
@include('common.errors')
<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>
<script>
$(function () {
    $("table").stupidtable();
});
</script>
@if (!empty(Session::get('msg')))
<script>
var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
document.write(msg);
</script>
@endif

<link rel="stylesheet" href="{{ asset('build/css/bootstrap-table.min.css') }}">
<script src="{{ asset('build/js/bootstrap-table.min.js') }}"></script>
<script src="{{ asset('build/js/bootstrap-table-it-IT.min.js') }}"></script>

    <a onclick="multipleAction('add');" id="add" class="btn btn-warning" name="add" title="{{ trans('messages.keyword_adduser') }}"><i class="glyphicon glyphicon-plus"></i></a>    
        <a class="btn btn-primary" onclick="multipleAction('modify');" id="modifica" name="update" title="{{ trans('messages.keyword_edit') }}"><i class="glyphicon glyphicon-pencil"></i></a>
        <a id="delete" class="btn btn-danger" onclick="multipleAction('delete');" name="remove" title="{{ trans('messages.keyword_delete') }}"><i class="fa fa-trash"></i></a>
<div class="space10"></div>
<div class="panel panel-default">
<div class="panel-body">

<div class="table-responsive table-custom-design">
    <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="{{ url('users/json') }}" data-classes="table table-bordered" id="table">
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
        <th data-field="status" data-sortable="true">
            {{ trans('messages.keyword_active') }}</th>
        <th data-field="button" data-sortable="true">
            {{ trans('messages.keyword_access') }}</th>
        </thead>

    </table>

</div>

</div>
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
            for (var i = 0; i < n; i++) {
                if (indici[i] == cod) {
                    for (var x = i; x < indici.length - 1; x++)
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
        return confirm("{{ trans('messages.keyword_sure') }} " + n + " {{ trans('messages.keyword_users') }} ?");
    }
    function updateStaus(userid){
         var url = "{{ url('/admin/user/changestatus') }}" + '/';
         var status = '1';
        if ($("#activestatus_"+userid).is(':checked')) {
            status = '0';
        }
        $.ajax({
            type: "GET",
            url: url + userid +'/'+status,
            error: function (url) {                
            },
            success:function (data) {             
            }
         });
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
