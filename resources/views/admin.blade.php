@extends('adminHome')
@section('page')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>

<link rel="stylesheet" href="{{ asset('build/css/bootstrap-table.min.css') }}">
<script src="{{ asset('build/js/bootstrap-table.min.js') }}"></script>
<script src="{{ asset('build/js/bootstrap-table-it-IT.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('build/css/bootstrap-modal-carousel.min.css') }}">
<div id="show_alert_msg"></div>
<h1>{{trans('messages.keyword_dashboard')}}</h1>
<hr>

<div class="panel panel-default">
	 <div class="panel-body">
<h1 class="cst-datatable-heading">{{trans('messages.keyword_users')}}</h1>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
  <!-- Static user list -->
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
      
  <!-- STatic user list End -->
  </div>
</div>
</div>
</div>
<div class="space40"></div>
<div class="panel panel-default">
	 <div class="panel-body">
<h1 class="cst-datatable-heading">{{trans('messages.keyword_quotes')}}</h1>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
  <!-- Static Preventivi Start -->
  <div class="table-responsive">
    <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="<?php if(isset($miei)) echo url('estimates/miei/json'); else echo url('/estimates/json');?>" data-classes="table table-bordered" id="table">
        <thead>
            <th data-field="id" data-sortable="true">{{trans('messages.keyword_no_estimate')}}</th>
            <th data-field="ente" data-sortable="true">{{trans('messages.keyword_entity')}}</th>
            <th data-field="oggetto" data-sortable="true">{{trans('messages.keyword_object')}}</th>
            <th data-field="data" data-sortable="true">{{trans('messages.keyword_execution_date')}}</th>
            <th data-field="valenza" data-sortable="true">{{trans('messages.keyword_expiry_date')}}</th>
            <th data-field="dipartimento" data-sortable="true">{{trans('messages.keyword_department')}}</th>
            <th data-field="finelavori" data-sortable="true">{{trans('messages.keyword_end_date_works')}}</th>
            <th data-field="statoemotivo" data-sortable="true">{{trans('messages.keyword_emotional_state')}}</th>
        </thead>
    </table>
    </div>
<!-- STatic Preventivi End -->
	</div>
</div>
</div>
</div>

<div class="space40"></div>

<div class="row">

	<div class="col-md-6 col-sm-12 col-xs-12">
    <div class="panel panel-default">
	 <div class="panel-body">
    	<h1 class="cst-datatable-heading">{{trans('messages.keyword_projects')}}</h1>
         <!-- Static Progetti Start -->     
         <div class="table-responsive">    
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
    	<!-- Static Progetti End -->
    </div>
    </div>
   </div>
   
    
    <div class="col-md-6 col-sm-12 col-xs-12">
    <div class="panel panel-default">
	 <div class="panel-body">
    	<h1 class="cst-datatable-heading">{{trans('messages.keyword_statistics')}}</h1>        
          <!-- Static Statistiche Start - Can use chart here -->
          <div class="table-responsive">
    		<table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="<?php echo url('costi/json');?>" data-classes="table table-bordered" id="table">
            <thead>
                <th data-field="id" data-sortable="true">
                {{ ucwords(trans('messages.keyword_code')) }} </th>
                <th data-field="ente" data-sortable="true">
                {{ ucwords(trans('messages.keyword_entity')) }}</th>
                <th data-field="oggetto" data-sortable="true">
                {{ ucwords(trans('messages.keyword_object')) }} </th>
                <th data-field="costo" data-sortable="true"> 
                {{ ucwords(trans('messages.keyword_cost')) }} </th>
                <th data-field="datainserimento" data-sortable="true">
                {{ ucwords(trans('messages.keyword_insertion_date')) }} </th>
            </thead>
        </table>    
        </div>
      <!-- Static Statistiche END -->
    </div>

</div>
</div>
</div>
<script type="text/javascript">
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
    function access(id) {        
        window.location = "{{ url('admin/user/access') }}" + '/'+id ;        
    }
var urlfile = '<?php echo url('/admin/globalsetting/store'); ?>';    
    $(document).ready(function (e) {            
            $("#frontlogo").on('change', (function (e) { 
                e.preventDefault();
                var formData = new FormData($('#frmfrontlogo')[0]);
               $('#show_alert_msg').html("");
                $.ajax({
                    url: urlfile,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {                        
                      if(data =='fail'){
                         $('#show_alert_msg').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'+jslang_keyword_the_file_must_be_a_type_of_image+'! </div>');
                         $('#frmfrontlogo')[0].reset();
                      }
                      else {
                        $('#show_alert_msg').html("");
                        $("#frontlogopreview").html(data);
                      }
                    },
                    error: function () {
                    }
                });
            }));
            $("#adminlogo").on('change', (function (e) { 
                e.preventDefault();
                var formData = new FormData($('#frmadminlogo')[0]);
               $('#show_alert_msg').html("");
                $.ajax({
                    url: urlfile,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                      if(data =='fail'){
                         $('#show_alert_msg').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'+jslang_keyword_the_file_must_be_a_type_of_image+'! </div>');
                         $('#frmadminlogo')[0].reset();
                      }
                      else {     
                      $('#show_alert_msg').html("");                   
                        $("#adminlogopreview").html(data);
                      }
                    },
                    error: function () {
                    }
                });
            }));
            $("#frontfavicon").on('change', (function (e) { 
                e.preventDefault();
                var formData = new FormData($('#frmfrontfavicon')[0]);
               $('#show_alert_msg').html("");
                $.ajax({
                    url: urlfile,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {                        
                      if(data =='fail') {
                         $('#show_alert_msg').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'+jslang_keyword_the_file_must_be_a_type_of_image+'! </div>');
                         $('#frmfrontfavicon')[0].reset();
                      }
                      else {
                        $('#show_alert_msg').html("");
                        $("#frontfaviconpreview").html(data);
                      }
                    },
                    error: function () {
                    }
                });
            }));
            $("#adminfavicon").on('change', (function (e) { 
                e.preventDefault();
                var formData = new FormData($('#frmadminfavicon')[0]);
               $('#show_alert_msg').html("");
                $.ajax({
                    url: urlfile,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {                        
                      if(data =='fail'){
                         $('#show_alert_msg').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'+jslang_keyword_the_file_must_be_a_type_of_image+'! </div>');
                         $('#frmadminfavicon')[0].reset();
                      }
                      else {
                        $('#show_alert_msg').html("");
                        $("#adminfaviconpreview").html("");
                        $("#adminfaviconpreview").html(data);
                      }
                    },
                    error: function () {
                    }
                });
            }));
            $("#pdflogo").on('change', (function (e) { 
                e.preventDefault();
                var formData = new FormData($('#frmpdflogo')[0]);
               $('#show_alert_msg').html("");
                $.ajax({
                    url: urlfile,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                      if(data =='fail'){
                         $('#show_alert_msg').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'+jslang_keyword_the_file_must_be_a_type_of_image+'! </div>');
                         $('#frmpdflogo')[0].reset();
                      }
                      else {     
                      $('#show_alert_msg').html("");                   
                        $("#pdflogopreview").html(data);
                      }
                    },
                    error: function () {
                    }
                });
            }));
        });
    function saveimages(type) {
      var urlsave = '<?php echo url('/admin/globalsetting/save'); ?>';       
      $.ajax({
          url: urlsave,
          type: 'post',
          data: { "_token": "{{ csrf_token() }}",type: type },
          success:function(data){                
               $('#frm'+type)[0].reset();
               $('#show_alert_msg').html('<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'+data+'! </div>');
          }
      });
    }
    
    function previewlogo(type) {
      var urlpreviewlogo = '<?php echo url('/admin/globalsetting/previewlogo'); ?>';       
      $.ajax({
          url: urlpreviewlogo,
          type: 'post',
          data: { "_token": "{{ csrf_token() }}",type: type },
          success:function(data){                               
               $('#preview_content').html(data);
          }
      });
    }

   
</script>



<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="preview_content">
      
    </div>
  </div>
</div>
</div>
</div>

  <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>-->
  <script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
  <script src="{{ asset('build/js/bootstrap-modal-carousel.min.js') }}"></script>
@endsection