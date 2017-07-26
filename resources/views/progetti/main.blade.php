@extends('layouts.app')
@section('content')
@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif
@include('common.errors')
<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('build/css/bootstrap-table.min.css') }}">
<script src="{{ asset('build/js/bootstrap-table.min.js') }}"></script>
<script src="{{ asset('build/js/bootstrap-table-it-IT.min.js') }}"></script>

<div class="main-blade">
    <div class="header-right">
        <div class="float-left">      
        <h1>{{ucwords(trans('messages.keyword_projectlist'))}}</h1><hr>
            <div class="btn-header-main-blade">
            @if(checkpermission('4', '18', 'scrittura','true'))
            <a href="{{url('/progetti/add')}}" id="modifica"  class="btn btn-warning" name="update" title="{{trans('messages.keyword_addnewproject')}}"><i class="fa fa-plus"></i></a>
            @endif
            @if(isset($miei))
            <a  class="button button2" id="miei" href="{{url('/progetti/miei')}}" name="miei" title="{{trans('messages.keyword_myfilterproject')}}" >
                {{trans('messages.keyword_my')}}
            </a>
            <a id="tutti" href="{{url('/progetti')}}" class="button button3" name="tutti" title="{{trans('messages.keyword_allshowpojects')}}">
                {{trans('messages.keyword_all')}}
            </a>
            @else
            <a id="miei" href="{{url('/progetti/miei')}}" class="button button2" name="miei" title="{{trans('messages.keyword_myfilterproject')}}">
                {{trans('messages.keyword_my')}}
            </a>
            <a id="tutti" href="{{url('/progetti')}}" class="button button3" name="tutti" title="{{trans('messages.keyword_allshowpojects')}}">
                {{trans('messages.keyword_all')}}
            </a>
            @endif
            <!-- Fine filtraggio miei/tutti -->
            @if(checkpermission('4', '18', 'scrittura','true'))
            <div class="btn-group">
                <a onclick="multipleAction('modify');" id="modifica" class="btn btn-primary" title="{{trans('messages.keyword_edit_last_selected_project')}}">
                    <i class="fa fa-pencil"></i>
                </a>

                <a id="duplicate" onclick="multipleAction('duplicate');" class="btn btn-info" title="{{trans('messages.keyword_duplicates_selected_project')}}">
                    <i class="fa fa-files-o"></i>
                </a>  

                <a id="delete" onclick="multipleAction('delete');" class="btn btn-danger" name="remove" title="{{trans('messages.keyword_delete_selected_project')}}">
                    <i class="fa fa-trash"></i>
                </a>
            </div>
            @else 
            <div class="btn-group">
                <a onclick="multipleAction('modify');" id="modifica" class="btn btn-primary" title="{{trans('messages.keyword_edit_last_selected_project')}}">
                    <i class="fa fa-info"></i>
                </a>
            </div>
            @endif
            <?php echo ticketprobelm(); ?>
        </div>
    </div>
@if(isset($miei) && $miei=='1')
	<div class="header-svg float-right">
        <img src="{{url('images/HEADER1_RT_PROJECT.svg')}}" alt="header image">
    </div>
@else    
    <div class="header-svg float-right">
        <img src="{{url('images/HEADER1_LT_PROJECT.svg')}}" alt="header image">
    </div>    
@endif
</div>
</div>

<div class="clearfix"></div>
<div class="panel panel-default">
	<div class="panel-body">
    <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="<?php if(isset($miei)) echo url('progetti/miei/json'); else echo url('/progetti/json');?>" data-classes="table table-bordered" id="table">
        <thead>
            <th data-field="codice" data-sortable="true">{{ucwords(trans('messages.keyword_noproject'))}}</th>
            <th data-field="ente" data-sortable="true">{{ucwords(trans('messages.keyword_entity'))}}</th>
            <th data-field="nomeprogetto" data-sortable="true">{{ucwords(trans('messages.keyword_projectname'))}}</th>
            <th data-field="da" data-sortable="true">{{ucwords(trans('messages.keyword_from'))}}</th>
            <th data-field="datainizio" data-sortable="true">{{ucwords(trans('messages.keyword_startdate'))}}</th>
            <th data-field="datafine" data-sortable="true">{{ucwords(trans('messages.keyword_enddate'))}}</th>
            <th data-field="progresso" data-sortable="true">{{ucwords(trans('messages.keyword_progress'))}}</th>
            <th data-field="statoemotivo" data-sortable="true">{{ucwords(trans('messages.keyword_emotional_state'))}}</th>
        </thead>
    </table>
    </div>
</div>
    
<div class="footer-svg">
  <img src="{{url('images/FOOTER3_ORIZZONTAL_PROJECT.svg')}}" alt="ORIZZONTAL PROJECT">
</div>

<?php 

$request = parse_url($_SERVER['REQUEST_URI']);
$path = ($_SERVER['HTTP_HOST'] == 'localhost') ? rtrim(str_replace('/easylanganew/', '', $request["path"]), '/') : $request["path"];      
$result = rtrim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $path), '/');
$result=trim($result,'/');
$current_module = DB::select('select * from modulo where TRIM(BOTH "/" FROM modulo_link) = :link', ['link' => $result]);

?>
<!-- Aggiungi nuova disposizione MODALE -->
<div id="problem-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> {{ trans('messages.keyword_problem') }} </h4>
      </div>
      <div class="modal-body">

        <p>
        {{ trans('messages.keyword_your_problems_are_important_to_us') }} ? 
        </p>

        <hr>        

        <form action="{{url('ticket/problem/store')}}" method="post" name="add_project" id="add_project" enctype="multipart/form-data"> {{ csrf_field() }}  

        In that page you were when the problem occurred?
        <input type="text" name="page" class="form-control" placeholder="http://betaeasy.langa.tv/enti/myenti"> 
        <br>

        <input type="hidden" name="module_id" value="<?php echo (isset($current_module[0]->modulo_sub)) ? $current_module[0]->modulo_sub : 0 ?>"> 

        Please describe the error you have found
        <textarea cols="50" rows="10" name="problem" class="form-control"></textarea>
        <br>

        Attach a picture
        <input type="file" name="file" class="form-control"> 

      </div>
      <div class="modal-footer">
          <p style="text-align: left;">{{ trans('messages.keyword_we_get_back_to_you') }}
          </p>
          LANGA Team        
          <br><br>
        <input type="submit" class="btn btn-warning" value="{{ trans('messages.keyword_send') }}">
        </form>

      </div>
    </div>
  </div>
</div>

<!-- <div id="problem-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> {{ trans('messages.keyword_problem') }} </h4>
      </div>
      <div class="modal-body">
      <p>{{ trans('messages.keyword_your_problems_are_important_to_us') }}
      ? </p>

        <form action="{{url('ticket/problem/store')}}" method="post" name="add_project" id="add_project"> {{ csrf_field() }}   
        <input type="hidden" name="module_id" value="<?php //echo (isset($current_module[0]->modulo_sub)) ? $current_module[0]->modulo_sub : 0; ?>">         
       <textarea cols="50" rows="10" name="problem"></textarea>
      </div>
      <div class="modal-footer">
          <p style="text-align: left;">{{ trans('messages.keywordwe_get_back_to_you') }}
          ? </p>
          LANGA Team        
          <br><br>
        <input type="submit" class="btn btn-warning" value="{{ trans('messages.keyword_send') }}">
        </form>
      </div>
    </div>
  </div>
</div> -->
<!-- FINE MODALE AGGIUNGI DISPOSIZIONE -->

<script>

function problem() {
    $("#problem-modal").modal();
}

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



function check() { return confirm("{{trans('messages.keyword_are_you_sure_you_want_to_delete:')}} " + n + " {{trans('messages.keyword_projects')}}?"); }
function multipleAction(act) {
	var link = document.createElement("a");
	var clickEvent = new MouseEvent("click", {
	    "view": window,
	    "bubbles": true,
	    "cancelable": false
	});
	var error = false;
		switch(act) {
			case 'delete':
    			link.href = "{{ url('/progetti/delete/project') }}" + '/';
    			if(check() && n!=0) {
                    n--;
                    link.href = "{{ url('/progetti/delete/project') }}" + '/'+ indici[n];
                        n = 0;
                        selezione = undefined;
                        link.dispatchEvent(clickEvent);
                }
			break;
			case 'modify':
                if(n != 0) {
					n--;
					link.href = "{{ url('/progetti/modify/project') }}" + '/' + indici[n];
					n = 0;
					selezione = undefined;
					link.dispatchEvent(clickEvent);
				}
			break;
            case 'duplicate':
				link.href = "{{ url('/progetti/duplicate/project') }}" + '/';
                for(var i = 0; i < n; i++) {
                    $.ajax({
                        type: "GET",
                        url : link.href + indici[i],
                        error: function(url) {
                            if(url.status==403) {
                                link.href = "{{ url('/progetti/duplicate/project') }}" + '/' + indici[n];
                                link.dispatchEvent(clickEvent);
                                error = true;
                            } 
                        }
                    });
                }
                selezione = undefined;
                if(error === false)
                    setTimeout(function(){location.reload();},100*n);
                n = 0;
			break;
		}
}    
</script>
@endsection