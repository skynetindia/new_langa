  @extends('adminHome')
  @section('page')
  <h1> {{ trans('messages.keyword_discounts') }} </h1><hr>
  @include('common.errors')
  <script src="{{ asset('public/scripts/jquery.min.js') }}"></script>
  <script>
    $(function(){
          $("table").stupidtable();
      });
  @if(!empty(Session::get('msg')))
      var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
      document.write(msg);
  @endif
  </script>
  <link rel="stylesheet" href="{{ asset('build/css/bootstrap-table.min.css') }}">
  <script src="{{ asset('build/js/bootstrap-table.min.js') }}"></script>
  <script src="{{ asset('build/js/bootstrap-table-it-IT.min.js') }}"></script>



<a onclick="multipleAction('add');" id="modifica" class="btn btn-warning" name="update" title="{{ trans('messages.keyword_adddiscount') }}"><i class="glyphicon glyphicon-plus"></i> </a> 
<div class="space10"></div>
<a onclick="multipleAction('modify');" id="modifica" class="btn btn-primary" name="update" title="{{ trans('messages.keyword_edit') }}"><i class="glyphicon glyphicon-pencil"></i> </a> 
<a id="delete" onclick="multipleAction('delete');" class="btn btn-danger" name="remove" title="{{ trans('messages.keyword_delete') }}" ><i class="fa fa-trash"></i></a>
<div class="space10"></div>

<div class="panel panel-default">
<div class="panel-body">
  <div class="table-responsive table-custom-design">
      <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="{{ url('/admin/sconti/json') }}" data-classes="selectable table table-hover table-bordered" id="table">
          <thead>
            <th data-field="id" data-sortable="true">
            {{ trans('messages.keyword_code') }} </th>
            <th data-field="name" data-sortable="true">
            {{ trans('messages.keyword_name') }} </th>
            <th data-field="descrizione" data-sortable="true">
            {{ trans('messages.keyword_description') }} </th>
            <th data-field="text" data-sortable="true">
            {{ trans('messages.keyword_types') }} </th>
            <th data-field="sconto" data-sortable="true">
            {{ trans('messages.keyword_discount') }} </th>
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

  function check() { return confirm("{{ trans('messages.keyword_sure') }} " + n + " {{ trans('messages.keyword_discounts') }} ?"); }

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
        link.href = "{{ url('/admin/tassonomie/delete/sconto') }}" + '/';
        if(check() && n!=0) {
          for(var i = 0; i < n; i++) {
            $.ajax({
              type: "GET",
              url : link.href + indici[i],
              error: function(url) {
                if(url.status==403) {
                  link.href = "{{ url('/admin/tassonomie/delete/sconto') }}" + '/' + indici[n];
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
            link.href = "{{ url('/admin/tassonomie/modify/sconto') }}" + '/' + indici[n];
            n = 0;
            selezione = undefined;
            link.dispatchEvent(clickEvent);
          }
        break;
      case 'add':
            link.href = "{{ url('/admin/tassonomie/sconti/add') }}";
            link.dispatchEvent(clickEvent);        
        break;
     
      }
  }
  </script>

  @endsection