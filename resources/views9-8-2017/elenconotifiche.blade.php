@extends('adminHome')
@section('page')
@include('common.errors')
<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="{{ asset('build/css/bootstrap-table.min.css') }}">
<script src="{{ asset('build/js/bootstrap-table.min.js') }}"></script>
<script src="{{ asset('build/js/bootstrap-table-it-IT.min.js') }}"></script>
<!--<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>-->
<!-- ckeditor
<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script> -->
@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif
<h1>{{trans('messages.keyword_listnotification')}}</h1><hr>
<a onclick="multipleAction('add');" id="add" class="btn btn-warning" name="add" title="{{trans('messages.keyword_addnotification')}}"> <i class="fa fa-plus"></i></a>
<a onclick="multipleAction('modify');" id="modifica" class="btn btn-primary"  name="update" title="{{trans('messages.keyword_edit_the_last_selected_notification')}}"><i class="glyphicon glyphicon-pencil"></i></a>
<a id="delete" onclick="multipleAction('delete');" class="btn btn-danger" name="remove" title="{{trans('messages.keyword_delete_the_last_selected_notification')}}"><i class="fa fa-trash"></i></a>
<a id="detail" onclick="multipleAction('detail');" class="btn btn-info" name="detail" title="{{trans('messages.keyword_detail_the_selected_notification')}}"><i class="glyphicon glyphicon-list-alt"></i></a>

<div class="space10"></div>

<div class="panel panel-default">
<div class="panel-body">
<div class="table-responsive">
<table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="{{ url('/notification/json') }}" data-classes="table table-bordered" id="table" class="remove-hover">
        <thead>
            <th data-field="id" data-sortable="true">{{trans('messages.keyword_id')}}</th>
            <th data-field="notification_type" data-sortable="true">{{trans('messages.keyword_types')}}</th>
            <th data-field="tempo_avviso" data-sortable="true">{{trans('messages.keyword_warntime')}}</th>
           <th data-field="ruolo" data-sortable="true">{{trans('messages.keyword_viewing')}}</th>
        </thead>
    </table>
  </div>
  </div>
</div>
  
  <div class="footer-svg">
  <img src="{{asset('images/ADMIN_AVVISI-footer.svg')}}" alt="avvisi">
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

function check() { return confirm("{{trans('messages.keyword_are_you_sure_you_want_to_delete:')}}: " + n + " {{trans('messages.keyword_notification')}}?"); }
function multipleAction(act) {
  var error = false;
  var link = document.createElement("a");
  var clickEvent = new MouseEvent("click", {
      "view": window,
      "bubbles": true,
      "cancelable": false
  });
  switch(act) {
    case 'delete':
      link.href = "{{ url('/notification/delete/') }}" + '/';
      if(check() && n!=0) {
        for(var i = 0; i < n; i++) {
          $.ajax({
            type: "GET",
            url : link.href + indici[i],
            error: function(url) {
              if(url.status==403) {
                link.href = "{{ url('/notification/delete/') }}" + '/' + indici[n];
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
                if(n!=0) {
          n--;

          link.href = "{{ url('/admin/notification') }}" + '/' + indici[n];
          n = 0;
          selezione = undefined;
          link.dispatchEvent(clickEvent);
        }
      break;
    case 'add':{
                
          link.href = "{{ url('/admin/notification/') }}";
          link.dispatchEvent(clickEvent);

        }
      break;

    case 'detail':
        if(n!=0) {
          n--;

          link.href = "{{ url('/notification/detail') }}" + '/' + indici[n];  
          n = 0;
          selezione = undefined;
          link.dispatchEvent(clickEvent);
        } else {
          link.href = "{{ url('/notification/detail') }}";
          link.dispatchEvent(clickEvent);
        }
      break;
  }
}
</script>

@endsection

