@extends('adminHome')
@section('page')
<h1>{{trans('messages.keyword_optional')}}</h1><hr>
@include('common.errors')
<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('build/css/bootstrap-table.min.css') }}">
<script src="{{ asset('build/js/bootstrap-table.min.js') }}"></script>
<script src="{{ asset('build/js/bootstrap-table-it-IT.min.js') }}"></script>

<script>    
$(function () {
$("table").stupidtable();
        });
        @if (!empty(Session::get('msg')))
var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
document.write(msg);
@endif
</script>
<form action="{{ url('/admin/taxonomies/optional/add') }}" method="post">
  {{ csrf_field() }}
  <button class="btn btn-warning" type="submit" name="create" title=" {{trans('messages.keyword_add_new_optional')}} "><i class="fa fa-plus"></i></button>
</form>
<div class="space10"></div>
<a onclick="multipleAction('modify');" id="modifica" class="btn btn-primary" title=" {{trans('messages.keyword_edit_last_selected_format')}} "> <i class="glyphicon glyphicon-pencil"></i></a> 
<a id="delete" onclick="multipleAction('delete');"  class="btn btn-danger" name="remove" title=" {{trans('messages.keyword_delete_selected_format')}} "><i class="fa fa-trash"></i> </a>
<div class="space10"></div>

<div class="panel panel-default">
<div class="panel-body">
<div class=" table-responsive table-custom-design">
<table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="<?php echo url('admin/taxonomies/json'); ?>" data-classes="table table-bordered" id="table">
    <thead>
    <th data-field="id" data-sortable="true">{{trans('messages.keyword_code')}}</th>
    <th data-field="code" data-sortable="true">{{trans('messages.keyword_short_name')}}</th>
    <th data-field="description" data-sortable="true">{{trans('messages.keyword_description')}}</th>
        <th data-field="icon" data-sortable="true">{{trans('messages.keyword_icon')}}</th>
    <th data-field="price" data-sortable="true">{{trans('messages.keyword_price')}}    </th>
 </thead>
</table>
</div>
</div>
</div>



<div class="space50"></div>
<div class="footer-svg">
    <img src="http://betaeasy.langa.tv/images/ADMIN_TASSONOMIE-footer.svg" alt="tassonomie">
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