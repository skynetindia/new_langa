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
<script src="{{ asset('public/scripts/jquery.raty.js') }}"></script>
<script src="{{ asset('public/scripts/labs.js') }}"></script>
<link rel="stylesheet" href="{{ asset('public/scripts/jquery.raty.css') }}">
 <!-- CSS required for STEP Wizard  -->
 <style>
        .wizard {
    margin: 20px auto;
    background: #fff;
}

    .wizard .nav-tabs {
        position: relative;
        margin: 40px auto;
        margin-bottom: 0;
        border-bottom-color: #e0e0e0;
    }

    .wizard > div.wizard-inner {
        position: relative;
    }

.connecting-line {
    height: 2px;
    background: #e0e0e0;
    position: absolute;
    width: 80%;
    margin: 0 auto;
    left: 0;
    right: 0;
    top: 50%;
    z-index: 1;
}

.wizard .nav-tabs > li.active > a, .wizard .nav-tabs > li.active > a:hover, .wizard .nav-tabs > li.active > a:focus {
    color: #555555;
    cursor: default;
    border: 0;
    border-bottom-color: transparent;
}

span.round-tab {
    width: 70px;
    height: 70px;
    line-height: 70px;
    display: inline-block;
    border-radius: 100px;
    background: #fff;
    border: 2px solid #e0e0e0;
    z-index: 2;
    position: absolute;
    left: 0;
    text-align: center;
    font-size: 25px;
}
span.round-tab i{
    color:#555555;
}
.wizard li.active span.round-tab {
    background: #fff;
    border: 2px solid #5bc0de;
    
}
.wizard li.active span.round-tab i{
    color: #5bc0de;
}

span.round-tab:hover {
    color: #333;
    border: 2px solid #333;
}

.wizard .nav-tabs > li {
    width: 25%;
}

.wizard li:after {
    content: " ";
    position: absolute;
    left: 46%;
    opacity: 0;
    margin: 0 auto;
    bottom: 0px;
    border: 5px solid transparent;
    border-bottom-color: #5bc0de;
    transition: 0.1s ease-in-out;
}

.wizard li.active:after {
    content: " ";
    position: absolute;
    left: 46%;
    opacity: 1;
    margin: 0 auto;
    bottom: 0px;
    border: 10px solid transparent;
    border-bottom-color: #5bc0de;
}

.wizard .nav-tabs > li a {
    width: 70px;
    height: 70px;
    margin: 20px auto;
    border-radius: 100%;
    padding: 0;
}

    .wizard .nav-tabs > li a:hover {
        background: transparent;
    }

.wizard .tab-pane {
    position: relative;
    padding-top: 50px;
}

.wizard h3 {
    margin-top: 0;
}

@media( max-width : 585px ) {

    .wizard {
        width: 90%;
        height: auto !important;
    }

    span.round-tab {
        font-size: 16px;
        width: 50px;
        height: 50px;
        line-height: 50px;
    }

    .wizard .nav-tabs > li a {
        width: 50px;
        height: 50px;
        line-height: 50px;
    }

    .wizard li.active:after {
        content: " ";
        position: absolute;
        left: 35%;
    }
}
</style>  

  <!-- HTML Structure -->
<div class="row quiz-wizard">
  <div class="col-md-12">
    <h1> {{ trans('messages.keyword_quiz') }} </h1>
    <div class="wizard">
      <div class="wizard-inner">
        <div class="connecting-line"></div>
        <ul class="nav nav-tabs">
          <li role="presentation" class="active"> <a href="#" title="Step 1"> <span class="round-tab"> <img src="{{ url('/images').'/folder.png' }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_enter_data') }} </span> </a> </li>
          <li role="presentation" class="active"> <a href="#" title="Step 2"> <span class="round-tab"> <img src="{{ url('/images').'/star.png' }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_currency_demo') }} </span> </a> </li>
          <li role="presentation" class="disabled"> <a href="#" title="Step 3"> <span class="round-tab"> <img src="{{ url('/images').'/edit.png' }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_colors__layouts') }}</span> </a> </li>
          <li role="presentation" class="disabled"> <a href="#" title="Complete"> <span class="round-tab"> <img src="{{ url('/images').'/list.png' }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_optional') }} </span> </a> </li>
          <li role="presentation" class="disabled"> <a href="#" title="Complete"> <span class="round-tab"> <img src="{{ url('/images').'/media.png' }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_media') }} </span> </a> </li>
        </ul>
      </div>      
      <div class="step-content step-two">
        <div class="step-pane">
          <form role="form" class="text-center">
          <input type="hidden" name="quizid" id="quizid" value="{{ $quizid}}"/>
            <div class="left-side">

              <div class="row">
               @foreach($quizdemodettagli as $quizdemodettagli)	              
                <div class="col-md-6">
                  <div class="item-wrapper"> <img height="100" width="100" src="{{ URL::to('/storage/app/images/quizdemo/'.$quizdemodettagli->immagine) }}" class="img-responsive" alt="{{ $quizdemodettagli->nome }}" onclick="getQuizDetails('<?php echo $quizdemodettagli->id;?>','<?php echo $quizid;?>');">

                  <div class="rating" id="rating_{{$quizdemodettagli->id}}"></div>
                  
                  <input type="hidden" id="detail_id" name="detail_id" value="{{ $quizdemodettagli->id }}">  

                  <div class="rating">                                         
                    <div class="star-count" id="star-count_{{$quizdemodettagli->id}}"><?php
                     $tassomedio = number_format($quizdemodettagli->tassomedio, 2, '.', ''); 
                     echo $tassomedio.'/'.$quizdemodettagli->tassototale;?></div>
                    </div>


                  </div>

         <script>	
        
					$('#rating_<?php echo $quizdemodettagli->id;?>').raty({
						path : '<?php echo url('/public/images/raty');?>',
						'score': '<?php  echo $quizdemodettagli->tassomedio;?>',
						readOnly    : true, 
						click: function(score, evt) {
							$("#star-count_<?php echo $quizdemodettagli->id;?>").text(score +'/5');
    						//alert('ID: ' + $(this).attr('id') + "\nscore: " + score + "\nevent: " + evt);
						  }
						});
                </script>
                </div>
	             @endforeach                
              </div>
            </div>
            <div class="right-side" id="right_side">

            <?php 
              if(isset($last_show)){ ?>
                @include('quiz.step-two-details')
             <?php }
            ?>
            </div>            

            <br><br><br><br><br><br><br><br>

            <!-- <div class="step-footer"> -->
            <div class="step-footer">
              <div class="dots"> <span class="dot"> </span> <span class="dot active"> </span> <span class="dot"> </span> <span class="dot"> </span> <span class="dot"> </span> <span class="dot"> </span>
                <div class="page">2/7</div>
              </div>
              <ul class="list-inline">
                <li><a class="prev-step" id="prev_steptwo"> 
                {{ trans('messages.keyword_back') }} </a></li>
                <li id="next-step" style="display: none;"><a class="next-step" id="step_twonext"> {{ trans('messages.keyword_next') }} </a></li> 
              </ul>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- JQeury code required for STEP wizard -->
  <script>

  $('#prev_steptwo').click(function() {
      history.back();
  });

  // $('.item-wrapper').click(function() {

  //     var detail_id = $("#detail_id").val();

  //     $.ajax({

  //       type:'GET',
  //       data:{ 'id': id, 'detail_id': detail_id },
  //       url:'{{ url("/quiz/lastclick/") }}',

  //       success:function( data ){
  //       }

  //     });

  // });

  var total_view = 0;
  var viewedArr = [];

  function getQuizDetails( id, quizid ){

	  var path = '/quiz/getDetails/';

	   $.ajax({
        type:'GET',
        data:{ 'id': id, 'quizid': quizid },
        url:'{{ url("/quiz/getDetails/") }}',
        success:function( data ){

            $("#right_side").html(data);				            

    				if( $.inArray(id, viewedArr) == -1 ){
      					viewedArr.push(id);
      					total_view++;
    				}            
            // var detail_id = $("#detail_id").val();
				    // alert(detail_id);
    				if(total_view >= 3){
    					// $("#next-step").show();
              $("#next-step").css("display", "inline");
    				} 
        
            $("#step_twonext").click(function(){

                // if(total_view >= 3){
                var seekString = "/easylanganew";
                currenrUrl = window.location.href;
                var idx = currenrUrl.indexOf(seekString);

                if (idx !== -1) {
                  var url = currenrUrl.substring(0, idx + seekString.length);
                }

                var quizid = $("#quizid").val();
                currenrUrl = document.location = url+"/quiz/stepthree/"+quizid;
              // }

            });   
        }
    });
  }
    $(document).ready(function () { 
  
    //Initialize tooltips
    $('.nav-tabs > li a[title]').tooltip();
    
    //Wizard
    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

        var $target = $(e.target);
    
        if ($target.parent().hasClass('disabled')) {
            return false;
        }
    });

    $(".next-step").click(function (e) {

        var $active = $('.wizard .nav-tabs li.active');
        $active.next().removeClass('disabled');
        nextTab($active);

    });
    $(".prev-step").click(function (e) {

        var $active = $('.wizard .nav-tabs li.active');
        prevTab($active);

    });
});

  function nextTab(elem) {
      $(elem).next().find('a[data-toggle="tab"]').click();
  }
  function prevTab(elem) {
      $(elem).prev().find('a[data-toggle="tab"]').click();
  }
  
  </script>




@endsection