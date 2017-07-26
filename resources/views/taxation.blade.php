@extends('adminHome')
@section('page')
@include('common.errors')
<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('build/css/bootstrap-table.min.css') }}">
<script src="{{ asset('build/js/bootstrap-table.min.js') }}"></script>
<script src="{{ asset('build/js/bootstrap-table-it-IT.min.js') }}"></script>

<h1>{{trans('messages.keyword_templates_for_taxation')}}</h1><hr>
@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif
<a onclick="multipleAction('add');" id="add"  class="btn btn-warning" name="create" title="{{trans('messages.keyword_new_taxation')}}"><span class="fa fa-plus"></span></a>
<a onclick="multipleAction('modify');" id="modifica" class="btn btn-primary"  name="update" title="{{trans('messages.keyword_modift_taxation')}}"><span class="fa fa-pencil"></span></a>
<a id="delete" onclick="multipleAction('delete');" class="btn btn-danger" name="remove" title="{{trans('messages.keyword_delete_taxation')}}"><span class="fa fa-trash"></span></a>


<div class="space10"></div>

<div class="panel panel-default">
<div class="panel-body">

<div class="table-responsive">
    <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="taxation/json" data-classes="table table-bordered" id="table">
        <thead>
            <th data-field="tassazione_id" data-sortable="true">{{trans('messages.keyword_id')}}</th>
            <th data-field="tassazione_nome" data-sortable="true">{{trans('messages.keyword_name')}}</th>
            <th data-field="tassazione_percentuale" data-sortable="true">{{trans("messages.keyword_percentage")}}</th>
            <th data-field="status" data-sortable="true">{{trans("messages.keyword_active")}}</th>
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
function check() { return confirm("{{trans('messages.keyword_are_you_sure_you_want_to_delete:')}} " + n + " {{trans('messages.keyword_taxation')}}?"); }
 function updateTaxionStatus(id){
         var url = "{{ url('/taxation/changestatus') }}" + '/';
         var status = '1';
        if ($("#activestatus_"+id).is(':checked')) {
            status = '0';
        }
        $.ajax({
            type: "GET",
            url: url + id +'/'+status,
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
  switch(act) {
    case 'delete':
      link.href = "{{ url('/taxation/delete/') }}" + '/';
      if(check() && n!=0) {
        for(var i = 0; i < n; i++) {
          $.ajax({
            type: "GET",
            url : link.href + indici[i],
            error: function(url) {
              if(url.status==403) {
                link.href = "{{ url('/taxation/delete/') }}" + '/' + indici[n];
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
          link.href = "{{ url('/taxation/add/') }}" + '/' + indici[n];
          n = 0;
          selezione = undefined;
          link.dispatchEvent(clickEvent);
        }
      break;
    case 'add':
             
          link.href = "{{ url('/taxation/add/') }}";
          link.dispatchEvent(clickEvent);
        
      break;
    }
}
</script>

@endsection