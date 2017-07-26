@extends('adminHome')
@section('page')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>

<link rel="stylesheet" href="{{ asset('build/css/bootstrap-table.min.css') }}">
<script src="{{ asset('build/js/bootstrap-table.min.js') }}"></script>
<script src="{{ asset('build/js/bootstrap-table-it-IT.min.js') }}"></script>

<link rel="stylesheet" href="{{ asset('build/css/bootstrap-modal-carousel.min.css') }}">


<div id="show_alert_msg"></div>
<h1>{{trans('messages.keyword_file_media_manager')}}</h1>
<hr>
<div class="dashboard-res">
<div class="panel panel-default">
<div class="panel-body">
<div class="row">
  <div class="col-md-6 col-sm-12 col-xs-12">  
    <div class="col-md-10 col-sm-10 col-xs-12"> {!! Form::open(array('url' => 'admin/globalsetting/store', 'files' => true,'id'=>'frmfrontlogo')) !!}
      <div class="form-group">
        <label for="logo"><strong>{{trans('messages.keyword_application_logo')}}</strong></label>
        <input type="file" name="frontlogo" id="frontlogo" required="required" class="form-control">        
      </div>
      <div class="form-group">
        <input value="{{trans('messages.keyword_save')}}" onclick="saveimages('frontlogo');" type="button" class="btn btn-warning">        
          <button class="btn btn-warning" onclick="previewlogo('frontlogo');" type="button" data-toggle="modal" data-target=".bs-example-modal-lg">{{trans('messages.keyword_preview')}}</button>       
      </div>
      {!! Form::close() !!} </div>
    <div class="col-md-2">
      <div class="dashboard-logo" id='frontlogopreview'><img class="img-responsive" height="100" width="100" src="<?php echo (isset($adminsettings->frontlogo) && !empty($adminsettings->frontlogo)) ? url('storage/app/images/logo/'.$adminsettings->frontlogo) : url('images/LOGO_Easy_LANGA_without_contour.svg'); ?>"></img> </div>

    </div>
  </div>
  <div class="col-md-6 col-sm-12 col-xs-12">
    <div class="col-md-10 col-sm-10 col-xs-12"> {!! Form::open(array('url' => 'admin/globalsetting/store', 'files' => true,'id'=>'frmadminlogo')) !!}
      <div class="form-group">
        <label for="logo"><strong>{{trans('messages.keyword_admin_logo')}}</strong></label>
        <input type="file" name="adminlogo" id="adminlogo" required="required" class="form-control">        
      </div>
      <div class="form-group">
        <input value="{{trans('messages.keyword_save')}}" onclick="saveimages('adminlogo');" type="button" class="btn btn-warning">
        <button class="btn btn-warning" onclick="previewlogo('adminlogo');" type="button" data-toggle="modal" data-target=".bs-example-modal-lg">{{trans('messages.keyword_preview')}}</button>
      </div>
      {!! Form::close() !!} </div>
    <div class="col-md-2 col-sm-2 col-xs-12">
      <div class="dashboard-logo" id="adminlogopreview"> <img class="img-responsive" height="100" width="100" src="<?php echo (isset($adminsettings->adminlogo) && !empty($adminsettings->adminlogo)) ? url('storage/app/images/logo/'.$adminsettings->adminlogo) : url('images/LOGO_Easy_LANGA_without_contour.svg') ?>"></img> </div>
    </div>
  </div>
  <div class="col-md-6 col-sm-12 col-xs-12">
    <div class="col-md-10 col-sm-10 col-xs-12"> {!! Form::open(array('url' => 'admin/globalsetting/store', 'files' => true,'id'=>'frmfrontfavicon')) !!}
      <div class="form-group">
        <label for="logo"><strong>{{trans('messages.keyword_application_favicon')}}</strong></label>
        <input type="file" name="frontfavicon" id="frontfavicon" required="required" class="form-control">         
      </div>
      <div class="form-group">
        <input value="{{trans('messages.keyword_save')}}" type="button" onclick="saveimages('frontfavicon');"  class="btn btn-warning" >
      </div>
      {!! Form::close() !!} </div>
    <div class="col-md-2 col-sm-2 col-xs-12">
      <div class="dashboard-logo" id="frontfaviconpreview"> <img class="img-responsive" height="100" width="100" src="<?php echo (isset($adminsettings->frontfavicon)&& !empty($adminsettings->frontfavicon)) ? url('storage/app/images/logo/'.$adminsettings->frontfavicon) : url('images/LOGO_Easy_LANGA_without_contour.svg') ?>"></img> </div>
    </div>
  </div>
  <div class="col-md-6 col-sm-12 col-xs-12">
    <div class="col-md-10 col-sm-10 col-xs-12"> {!! Form::open(array('url' => 'admin/globalsetting/store', 'files' => true,'id'=>'frmadminfavicon')) !!}
      <div class="form-group">
        <label for="logo"><strong>{{trans('messages.keyword_admin_favicon')}}</strong></label>
        <input type="file" name="adminfavicon" id="adminfavicon" required="required" class="form-control">         
      </div>
      <div class="form-group">
        <input value="{{trans('messages.keyword_save')}}" type="button" onclick="saveimages('adminfavicon');" class="btn btn-warning" >
      </div>
      {!! Form::close() !!} </div>
    <div class="col-md-2 col-sm-2 col-xs-12">
      <div class="dashboard-logo" id="adminfaviconpreview"> <img class="img-responsive" height="100" width="100" src="<?php echo (isset($adminsettings->adminfavicon) && !empty($adminsettings->adminfavicon)) ? url('storage/app/images/logo/'.$adminsettings->adminfavicon) : url('images/LOGO_Easy_LANGA_without_contour.svg') ?>"></img> </div>
    </div>
  </div>
  <div class="col-md-6 col-sm-12 col-xs-12">
    <div class="col-md-10 col-sm-10 col-xs-12"> {!! Form::open(array('url' => 'admin/globalsetting/store', 'files' => true,'id'=>'frmpdflogo')) !!}
      <div class="form-group">
        <label for="logo"><strong>{{trans('messages.keyword_pdf_logo')}}</strong></label>
        <input type="file" name="pdflogo" id="pdflogo" required="required" class="form-control">        
      </div>
      <div class="form-group">
        <input value="{{trans('messages.keyword_save')}}" onclick="saveimages('pdflogo');" type="button" class="btn btn-warning">
        <button class="btn btn-warning" onclick="previewlogo('pdflogo');" type="button" data-toggle="modal" data-target=".bs-example-modal-lg">{{trans('messages.keyword_preview')}}</button>
      </div>
      {!! Form::close() !!} </div>
    <div class="col-md-2 col-sm-2 col-xs-12">
      <div class="dashboard-logo" id="pdflogopreview"> <img class="img-responsive" height="100" width="100" src="<?php echo (isset($adminsettings->pdflogo) && !empty($adminsettings->pdflogo)) ? url('storage/app/images/logo/'.$adminsettings->pdflogo) : url('images/pdfimages/langa-logo.jpg') ?>"></img> </div>
    </div>
  </div>  
</div> 
</div>
</div>
<div class="space40"></div>
<script type="text/javascript">
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