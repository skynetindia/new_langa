@extends('adminHome')
@section('page')
<h1><?php echo ($mastertype != 'admin') ? 'User '.trans('messages.keyword_login_activity') : 'Admin ' .trans('messages.keyword_login_activity');?></h1><hr>
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
<link rel="stylesheet" href="{{ asset('build/css/bootstrap-table.min.css') }}">
<script src="{{ asset('build/js/bootstrap-table.min.js') }}"></script>
<script src="{{ asset('build/js/bootstrap-table-it-IT.min.js') }}"></script>

<?php /*<a onclick="multipleAction('add');" id="add" class="btn btn-warning" name="add" title="{{ trans('messages.keyword_adduser') }}"><i class="glyphicon glyphicon-plus"></i></a>
<div class="space10"></div>
<a class="btn btn-primary" onclick="multipleAction('modify');" id="modifica" name="update" title="{{ trans('messages.keyword_edit') }}"><i class="glyphicon glyphicon-pencil"></i></a>*/?>
<div class="row">
  <div class="col-md-1 col-sm-12 col-xs-12">
  	<div class="space24"></div>
    <a id="delete" class="btn btn-danger"  onclick="multipleAction('delete');" name="remove" title="{{ trans('messages.keyword_delete') }}"><i class="fa fa-trash"></i></a>
</div>
@if($mastertype != 'admin')

<div class="col-md-3 col-sm-12 col-xs-12">
<div class="form-group">
    <label> {{ trans('messages.keyword_type') }} </label>
<select class="form-control" id="filterbytype">
    <option value="0">-- {{ trans('messages.keyword_select') }} --</option>
    @foreach($departments as $department)
        <option value="{{$department->ruolo_id}}" {{(isset($usertype)&& $usertype== $department->ruolo_id)?"selected":''}}>{{ ucwords(strtolower($department->nome_ruolo)) }}</option>
    @endforeach
</select>
  </div>
  </div>
@endif
</div>

<div class="space10"></div>

<div class="panel panel-default">
<div class="panel-body">
<div class="table-responsive table-custom-design">
    <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="{{ url('loginactivity/json/').'/'.$mastertype.'/'.$usertype }}" data-classes="table table-bordered" id="table">
        <thead>
            <th data-field="id" data-sortable="true"> {{ trans('messages.keyword_id') }} </th>
            <th data-field="username" data-sortable="true"> {{ trans('messages.keyword_user_name') }} </th>
            <th data-field="nome_ruolo" data-sortable="true"> {{ trans('messages.keyword_department') }} </th>
            <th data-field="log_date" data-sortable="true"> {{ trans('messages.keyword_date') }} </th>
            <th data-field="logs" data-sortable="true"> {{ trans('messages.keyword_activity') }}</th>
            <th data-field="ip_address" data-sortable="true"> {{ trans('messages.keyword_ip_address') }} </th>        
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
        return confirm("{{ trans('messages.keyword_sure') }} " + n + " {{ trans('messages.keyword_activity') }} ?");
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
                link.href = "{{ url('/admin/loginactivity/delete') }}" + '/';
                if (check() && n != 0) {
                    for (var i = 0; i < n; i++) {
                        $.ajax({
                            type: "GET",
                            url: link.href + indici[i],
                            error: function (url) {
                                if (url.status == 403) {
                                    link.href = "{{ url('/admin/loginactivity/delete') }}" + '/' + indici[n];
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
            /*case 'modify':
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
                break;*/
        }
    }

    function access(id) {        
        window.location = "{{ url('admin/user/access') }}" + '/'+id ;        
    }

    $('#filterbytype').on('change', function () {
        var type = $(this).val();
        window.location = "{{ url('/admin/loginactivity/user') }}" + '/'+type;
    });
</script>

@endsection
