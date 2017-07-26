@extends('adminHome')
@section('page')
<h1>New Enti <strong>LANGA</strong></h1><hr>
@include('common.errors')
<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
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
<div class="table-responsive">
<table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true"  data-show-columns="true" data-url="<?php  echo url('newenti/json');?>" data-classes="table table-bordered" id="table">
<thead>
<th data-field="id" data-sortable="true">{{ trans('messages.keyword_code')}}</th>
<th data-field="nomeazienda" data-sortable="true">{{ trans('messages.keyword_name')}}</th>
<th data-field="nomereferente" data-sortable="true">{{ trans('messages.keyword_email')}}</th>
<th data-field="action" data-sortable="true">{{ trans('messages.keyword_action')}}</th>
</thead>
</table>
</div>
<div class="footer-svg">
    <img src="{{asset('images/ADMIN_TASSONOMIE-footer.svg')}}" alt="tassonomie">
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