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

        <?php $i=1; ?>

        @foreach($optional as $option)

          	<div class="col-md-6 logo<?php echo $i;?>" onclick="setdiv(<?php echo $i;?>)">
          		<div class="item-wrapper">
                	<img class="logo_icon<?php echo $i;?>" src="{{ asset('storage/app/images/'.$option->icon) }}" height="200" width="230">
                	<div class="on-hover-text logo_label<?php echo $i;?>"">
                    	{{ $option->label }}
                    </div>
                </div>
            </div>

            <div style="display: none;">

              <img src="{{ asset('storage/app/images/'.$option->immagine) }}" 
              class="logo_immagine<?php echo $i;?>">

              <div class="logo_description<?php echo $i;?>"> 
                {{ $option->description }}                 
              </div>

              <div class="logo_price<?php echo $i;?>" id="logo_price">
                  {{ $option->price }}
              </div>

            </div>
            
        <?php $i++; ?>
        @endforeach
            
       </div>
          
        </div>
        
        <div class="right-side">
        	<div class="right-header">
            	<div class="right-heading">
                	<img src="{{ asset('storage/app/images/'.$default->icon) }}" id="icon_logo">
                    <p id="icon_label"> {{ $default->label }}</p>
                </div>
                <div class="price" id="icon_price">
                	€ {{ $default->price }} {{ trans('messages.keyword_cad') }} 
                </div>
            </div>
            <div class="right-description">
            	<div class="description-heading">
	                <span> {{ trans('messages.keyword_description') }} </span>
                 </div>
                 
                    <div class="description">
                        <div class="desciption-img" id="imgnotfound">
                            <img src="{{ asset('storage/app/images/'.$default->immagine) }}" alt=" image not found "  id="icon_immagine">
                        </div>
                        <div class="description-text">
                            <h4 id="label_h4">{{ $default->label }} </h4>
                            <p id="icon_description"> {{ $default->description }} </p>
                        </div>
                    </div>
              
            </div>
        </div>
        
      </div>
    </div>
  </div>
</div>

<script>

function setdiv(i) {

  var icon = $('.logo_icon'+i).attr("src");
  var image = $('.logo_immagine'+i).attr("src");
  var label = $(".logo_label"+i).text();
  var price = $(".logo_price"+i).text();
  var description = $(".logo_description"+i).text();     
  var id = $(".optioan_id"+i).val();      

  label = label.replace(/(^\s*)|(\s*$)/gi,"");
  label = label.replace(/[ ]{2,}/gi," ");
  label = label.replace(/\n /,"\n");
  price = price.replace(/(^\s*)|(\s*$)/gi,"");
  price = price.replace(/[ ]{2,}/gi," ");
  price = price.replace(/\n /,"\n");

  $('#icon_logo').attr('src',icon);
  $('#icon_immagine').attr('src',image);
  $('#icon_label').text(label);
  $('#icon_price').text("€ " + price + " {{ trans('messages.keyword_cad') }}");
  $('#label_h4').text(label);
  $('#icon_description').text(description);

  var isImage = image.indexOf(".");
  
  if(isImage == -1){
    document.getElementById("imgnotfound").style.display = "none";   
  } else {
    document.getElementById("imgnotfound").style.display = "inline-block";
  }
}

$(document).ready(function(){

    $("#myBtn").click(function(){
        $("#myModal").modal();
    });

});

</script>

@endsection