@extends('layouts.app')

@section('content')

@if(!empty(Session::get('msg')))

    <script>

    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';

    document.write(msg);

    </script>

@endif

@include('common.errors')

<style>
tr:hover {
	background: #f39538;
}
.selected {
	font-weight: bold;
	font-size: 16px;
}
th {
	cursor: pointer;
}
li label {
	padding-left: 10px;
}
.button {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 3px 15px;
    padding-bottom: 6px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    -webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.4s;
    cursor: pointer;
    border-radius: 4px;
}
.button2 { /* blue */
    background-color: white;
    color: black;
    border: 2px solid #337ab7;
}

.button2:hover {
    background-color: #337ab7;
    color: white;
}

.button3 { /* red */
    background-color: white;
    color: black;
    border: 2px solid #d9534f;
}

.button3:hover {
    background-color: #d9534f;
    color: white;
}
</style>

<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.js"></script>

<!-- Latest compiled and minified Locales -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/locale/bootstrap-table-it-IT.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<h1> {{ trans('messages.keyword_quiz') }} </h1>
<hr>

<div class="quiz-category">
<div class="row">
	<div class="col-md-4">
    	<div class="quiz-category-box-wrapper">
        	<div class="quiz-category-img">
            	<img src="public/images/web.jpg">
            </div>
            <div class="quiz-category-text">
            	<h3> {{ trans('messages.keyword_web') }}  </h3>
                <p> {{ trans('messages.keyword_complete_quiz_find_best_offer') }} ! </p>
                
                <div class="quiz-category-actions">
                	<a href="#" id="myBtn" class="button btn-danger" data-toggle="modal><i class="fa fa-plus" aria-hidden="true"></i> {{ trans('messages.keyword_info') }}  </a>
                    <a href="{{ url('/quiz/stepone') }}" class="button btn-default"> {{ trans('messages.keyword_start_quiz') }} </a>
                </div>
            
            </div>
        </div>
    </div>
    
    
    <div class="col-md-4">
    	<div class="quiz-category-box-wrapper">
        	<div class="quiz-category-img">
            	<img src="public/images/print.jpg">
            </div>
            <div class="quiz-category-text">
            	<h3> {{ trans('messages.keyword_print') }} </h3>
                <p> {{ trans('messages.keyword_choose_suitable_options_for_marketing.') }} </p>
                
                <div class="quiz-category-actions">
                	<a href="#" class="button btn-danger"><i class="fa fa-plus" aria-hidden="true"></i> {{ trans('messages.keyword_info') }}  </a>
                    <a href="#" class="button btn-default"> {{ trans('messages.keyword_start_quiz') }} </a>
                </div>
            
            </div>
        </div>
    </div>
    
     <div class="col-md-4">
    	<div class="quiz-category-box-wrapper">
        	<div class="quiz-category-img">
            	<img src="public/images/video.jpg">
            </div>
            <div class="quiz-category-text">
            	<h3> {{ trans('messages.keyword_video') }} </h3>
                <p> {{ trans('messages.keyword_technicians_video_knowledge_business') }} </p>
                
                <div class="quiz-category-actions">
                	<a href="#" class="button btn-danger"><i class="fa fa-plus" aria-hidden="true"></i> {{ trans('messages.keyword_info') }} </a>
                    <a href="#" class="button btn-default"> {{ trans('messages.keyword_start_quiz') }} </a>
                </div>
            
            </div>
        </div>
    </div>
    
    <div class="col-md-12">
    	<hr>
    </div>
</div>
</div>


<div class="quiz-page-info-wrapper">
	<div class="row">
    	<div class="col-md-3">
        	<div class="quiz-page-info">
            	<h4> {{ trans('messages.keyword_who') }} ?</h4>
                <p> {{ trans('messages.keyword_who_static_details') }} </p>
            </div>
        
        </div>
        
        <div class="col-md-3">
        	<div class="quiz-page-info">
            	<h4> {{ trans('messages.keyword_cosa') }} ?</h4>
                <p> {{ trans('messages.keyword_thing_static_details') }} </p>
            </div>
        </div>
        
        
         <div class="col-md-3">
        	<div class="quiz-page-info">
            	<h4> {{ trans('messages.keyword_because') }} ?</h4>
                <p> {{ trans('messages.keyword_because_static_details') }} </p>
            </div>
        </div>
        
        
          <div class="col-md-3">
        	<div class="quiz-page-info">
            	<h4>  {{ trans('messages.keyword_as') }} ?</h4>
                <p> {{ trans('messages.keyword_as_static_details') }} </p>
            </div>
        </div>
    
    </div>

</div>
<div class="modal fade quiz-popup" id="myModal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> {{ trans('messages.keyword_see_the_options') }} <b>LANGA WEB</b></h4>
      </div>
      
      <div class="modal-body">
        <div class="left-side">
      
          
          <div class="row">
          	<div class="col-md-6">
          		<div class="item-wrapper">
                	<img src="public/images/3d.jpg">
                	<div class="on-hover-text">
                    	{{ trans('messages.keyword_section') }} <br>
                      % {{ trans('messages.keyword_blog') }}
                    </div>
                </div>
            </div>
            
            
            <div class="col-md-6">
          		<div class="item-wrapper">
                	<img src="public/images/video-editing.jpg">
                	<div class="on-hover-text">
                    {{ trans('messages.keyword_') }}	Sezione<br>
                    {{ trans('messages.keyword_') }}  %blog
                    </div>
                </div>
            </div>
            
            
             <div class="col-md-6">
          		<div class="item-wrapper">
                	<img src="public/images/video-editing.jpg">
                	<div class="on-hover-text">
                    {{ trans('messages.keyword_') }}	Sezione<br>
                    {{ trans('messages.keyword_') }}    %blog
                    </div>
                </div>
            </div>
            
            
              <div class="col-md-6">
          		<div class="item-wrapper">
                	<img src="public/images/mobile-touch.jpg">
                	<div class="on-hover-text">
                    {{ trans('messages.keyword_') }}	Sezione<br>
                    {{ trans('messages.keyword_') }}    %blog
                    </div>
                </div>
            </div>
            
             <div class="col-md-6">
          		<div class="item-wrapper">
                	<img src="public/images/3d.jpg">
                	<div class="on-hover-text">
                    {{ trans('messages.keyword_') }}	Sezione<br>
                    {{ trans('messages.keyword_') }}    %blog
                    </div>
                </div>
            </div>
            
             <div class="col-md-6">
          		<div class="item-wrapper">
                	<img src="public/images/video-editing.jpg">
                	<div class="on-hover-text">
                    {{ trans('messages.keyword_') }}	Sezione<br>
                    {{ trans('messages.keyword_') }}    %blog
                    </div>
                </div>
            </div>
            
          </div>
          
        </div>
        
        <div class="right-side">
        	<div class="right-header">
            	<div class="right-heading">
                	<img src="public/images/news.jpg">
                    <p> {{ trans('messages.keyword_section') }} 
                    %{{ trans('messages.keyword_blog') }}</p>
                </div>
                <div class="price">
                	€ 50.00 {{ trans('messages.keyword_cad') }} 
                </div>
            </div>
            <div class="right-description">
            	<div class="description-heading">
	                <span> {{ trans('messages.keyword_description') }} </span>
                 </div>
                 <div class="description">
                 	<div class="desciption-img">
                    	<img src="public/images/description-img.jpg" alt="description">
                    </div>
                    <div class="description-text">
                    	<h4> {{ trans('messages.keyword_section') }} 
                            %{{ trans('messages.keyword_blog') }}</h4>
                        <p> {{ trans('messages.keyword_') }} Create web forms, surveys, quizzers and polls as easy as 1-2-3! With 123 Form Builder it takes just few clicks to create any custom form for Wiz. And no programming experience is requied.</p>
                    </div>
                 </div>
            </div>
        </div>
        
      </div>
    </div>
  </div>
</div>

<script>

$(document).ready(function(){

    $("#myBtn").click(function(){
        $("#myModal").modal();
    });

});

</script>

@endsection