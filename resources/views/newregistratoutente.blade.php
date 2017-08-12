@extends('layouts/app')

@section('content')

<h1>{{ trans('messages.keyword_newuser') }} Easy <strong>LANGA</strong></h1><hr>

@include('common.errors')
<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>

<link rel="stylesheet" href="{{ asset('build/css/bootstrap-table.min.css') }}">
<script src="{{ asset('build/js/bootstrap-table.min.js') }}"></script>
<script src="{{ asset('build/js/bootstrap-table-it-IT.min.js') }}"></script>

<script>
  $(function(){
        $("table").stupidtable();
    });
@if(!empty(Session::get('msg')))
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
@endif
</script>
<div class="btn-group">
@if (\Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li>{!! \Session::get('success') !!}</li>
        </ul>
    </div>
@endif
</div>
<?php if(Auth::user()->dipartimento==0){?>
 <a onclick="multipleAction('add');" id="add" class="btn btn-warning" name="add" title="{{ trans('messages.keyword_adduser') }}"><i class="glyphicon glyphicon-plus"></i></a>    
        <a class="btn btn-primary" onclick="multipleAction('modify');" id="modifica" name="update" title="{{ trans('messages.keyword_edit') }}"><i class="glyphicon glyphicon-pencil"></i></a>
        <a id="delete" class="btn btn-danger" onclick="multipleAction('delete');" name="remove" title="{{ trans('messages.keyword_delete') }}"><i class="fa fa-trash"></i></a>
        
        <div class="space10"></div>
        <?php }?>
<div class="panel panel-default">
<div class="panel-body">

<div class="table-responsive table-custom-design">
<table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="newutente/json" data-classes="table table-bordered" id="table">
    <thead>
        <th data-field="id" data-sortable="true">
        {{ trans('messages.keyword_id') }} </th>
        <th data-field="name" data-sortable="true">
        {{ trans('messages.keyword_name') }} </th>
        <th data-field="email" data-sortable="true">
        {{ trans('messages.keyword_email') }} </th>
        <th data-field="id_ente" data-sortable="true">
        {{ trans('messages.keyword_entity') }} </th>
        <th data-field="cellulare" data-sortable="true">
        {{ trans('messages.keyword_cell') }} </th>     
         <th data-field="nome_ruolo" data-sortable="true">
        {{ trans('messages.keyword_profile') }} </th>      
        <th data-field="azione" data-sortable="true"> {{trans('messages.keyword_action')}} </th>
    </thead>
</table>
</div>
</div>

</div>
<script>
var selezione = [];
var n = 0;
$(".selectable tbody tr input[type=checkbox]").change(function(e){
    var stato = e.target.checked;
  if (stato) {    
      $(this).closest("tr").addClass("selected");
      selezione[n] = $(this).closest("tr").children()[1].innerHTML;
       n++;
  } else {
      selezione[n] = undefined;
      n--;
      $(this).closest("tr").removeClass("selected");
  }
});

$(".selectable tbody tr").click(function(e){
    var cb = $(this).find("input[type=checkbox]");
    cb.trigger('click');
});


function check() {

    return confirm("Sei sicuro di voler eliminare: " + n + " utenti?");

}


function multipleAction(act) {

    var link = document.createElement("a");

    var clickEvent = new MouseEvent("click", {

        "view": window,

        "bubbles": true,

        "cancelable": false

    });

    if(selezione!==undefined) {

        switch(act) {

            case 'delete':

                link.href = "{{ url('/admin/destroy/utente') }}" + '/';

                if(check()) {

            for(var i = 0; i < n; i++) {

                $.ajax({

                    type: "GET",

                    url : link.href + selezione[i],

                    error: function(url) {

                        if(url.status==403) {

                            link.href = "{{ url('/admin/destroy/utente') }}" + '/' + selezione[--n];

                            link.dispatchEvent(clickEvent);

                        } 

                    }

                });

            }

            setTimeout(function(){location.reload();},100*n);

        }

                    

        break;

        case 'modify':
            n--;
            if(selezione[n]!=undefined) {
                
                link.href = "{{ url('/admin/modify/utente') }}" + '/' + selezione[n];
                n = 0;
                selezione = undefined;
                link.dispatchEvent(clickEvent);
            }
            n = 0;
        break;

    }

}

}


</script>


@endsection