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
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/themes/base/jquery-ui.css" type="text/css" rel="stylesheet">
 <!-- CSS required for STEP Wizard  -->


  <!-- HTML Structure -->
<div class="row quiz-wizard">
  <div class="col-md-12 col-sm-12 col-xs-12">
    
    <h1> {{ trans('messages.keyword_quiz') }} </h1>
    <div class="wizard wizard-step-line">
    <div class="wizard-inner">
        <div class="connecting-line"></div>
        <ul class="nav nav-tabs">
          <li role="presentation" class="active"> <a href="{{ url('/quiz/stepone') }}" title="Step 1"> <span class="round-tab"> <img src="{{ url('/images').'/folder.png' }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_enter_data') }} </span> </a> </li>
          <li role="presentation" class="active"> <a href="#" title="Step 2"> <span class="round-tab"> <img src="{{ url('/images').'/star.png' }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_currency_demo') }} </span> </a> </li>
          <li role="presentation" class="disabled"> <a href="#" title="Step 3"> <span class="round-tab"> <img src="{{ url('/images').'/edit.png' }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_colors__layouts') }}</span> </a> </li>
          <li role="presentation" class="disabled"> <a href="#" title="Complete"> <span class="round-tab"> <img src="{{ url('/images').'/list.png' }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_optional') }} </span> </a> </li>
          <li role="presentation" class="disabled"> <a href="#" title="Complete"> <span class="round-tab"> <img src="{{ url('/images').'/media.png' }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_media') }} </span> </a> </li>
          
          <li role="presentation" class="disabled"> <a href="#" title="Complete"> <span class="round-tab"> <img src="{{ asset('images/flag.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_media') }} </span> </a> </li>
          
        </ul>
      </div>
    </div>
    
    <div class="wizard">      
      <div class="step-content step-two">
        <div class="step-pane">
          <form role="form" class="text-center">
          <input type="hidden" name="quizid" id="quizid" value="{{ $quizid}}"/>
          <div id="quiz-resize">
            <div class="left-side" id="left-quiz"> 
            <div class="selected-demo"><span id="demo-count"><?php if($quizdetail->rate_counter<3)echo 'Minimum 3 Required';?></span></div>           
				      <div class="height1000">
              <?php $i = 1; ?>
              <div class="row">
               @foreach($quizdemodettagli as $quizdemodettagli)	              
                <div class="col-md-6 col-sm-12 col-xs-12">
                  <div class="item-wrapper" onclick="getQuizDetails('<?php echo $quizdemodettagli->id;?>','<?php echo $quizid;?>', this);"> <img  src="{{ URL::to('/storage/app/images/quizdemo/'.$quizdemodettagli->immagine) }}" class="img-responsive getselect" id="select<?php echo $i; ?>" alt="{{ $quizdemodettagli->nome }}">

                  <div class="bg-white">
                  <div class="rating" id="rating_{{$quizdemodettagli->id}}"></div>
                  
                  <input type="hidden" id="detail_id" name="detail_id" value="{{ $quizdemodettagli->id }}">  

                  <div class="rating">                                         
                    <div class="star-count" id="star-count_{{$quizdemodettagli->id}}"><?php
                     $tassomedio = number_format($quizdemodettagli->tassomedio, 2, '.', ''); 
                     echo $tassomedio.'/'.$quizdemodettagli->tassototale;?></div>
                    </div>
                    <?php $i++; ?>
				        </div>
                        <div class="item-name">
                       {{ $quizdemodettagli->nome }}
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
            </div></div>
            <div class="height1000" id="right-quiz">
            <div class="right-side" id="right_side">				    
              <?php 
                if(isset($last_show)){  ?>
                  @include('quiz.step-two-details')
               <?php }
              ?>
          	</div> </div> 
            </div> 

			<div class="clearfix"></div>
          

            <!-- <div class="step-footer"> -->
            <div class="step-footer">
              <div class="dots"> <span class="dot"> </span> <span class="dot active"> </span> <span class="dot"> </span> <span class="dot"> </span> <span class="dot"> </span> <span class="dot"> </span>
                <div class="page">2/7</div>
              </div>
             
              <ul class="list-inline">
                <li><a class="prev-step" id="prev_steptwo"> 
                {{ trans('messages.keyword_back') }} </a></li>
                <li id="next-step" class="">
                <a class="<?php if(!isset($quizdetail->rate_id) || isset($quizdetail->rate_counter) && $quizdetail->rate_counter < 3) echo 'none';?> next-step" id="step_twonext"> {{ trans('messages.keyword_next') }} </a></li> 
              </ul>
              
              <div class="quiz-btn-save">
 
  <?php if(isset($payment_status->payment_status) && $payment_status->payment_status == 1) { ?>
 	
	 <button id="firm" class="btn btn-default">
    	{{ trans('messages.keyword_firm') }}
  	</button>
  
   <script type="text/javascript">
    $('.main_container').addClass('disabled');
    </script>
   <?php } ?>
  <?php if(isset($payment_status->payment_status) && $payment_status->payment_status == 2) { ?>

  <button id="down_payment" class="btn btn-default">
    {{ trans('messages.keyword_pay_down') }} 
  </button>
 
   <script type="text/javascript">
    $('.main_container').addClass('disabled');
    </script>
  <?php } ?>
</div>
              
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  
<?php 
  $request = parse_url($_SERVER['REQUEST_URI']);
  $path = ($_SERVER['HTTP_HOST'] == 'localhost') ? rtrim(str_replace('/easylanganew/', '', $request["path"]), '/') : $request["path"]; 
  $result = rtrim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $path), '/');
  $result = substr($result, 0, -3);
   $result=trim($result,'/');
  $comic = DB::table('quiz_comic')->where('url', $result)->first();
  if(isset($comic)){
    $language_transalation = DB::table('language_transalation')->where('language_key', $comic->lang_key)->first();
  }
?>



  
</div>



<!-- JQeury code required for STEP wizard -->
<script>

  $("#firm").click(function(e){
    var quizid = $("#quizid").val();
    var seekString = "/quiz";
    currenrUrl = window.location.href;
    var idx = currenrUrl.indexOf(seekString);
    if (idx !== -1) {
      var url = currenrUrl.substring(0, idx + seekString.length);
    }
    var quizid = $("#quizid").val();
    currenrUrl = document.location = url+"/stepseven/"+quizid;
  });

  $("#down_payment").click(function(e){
    var quizid = $("#quizid").val();
    var seekString = "/quiz";
    currenrUrl = window.location.href;
    var idx = currenrUrl.indexOf(seekString);
    if (idx !== -1) {
      var url = currenrUrl.substring(0, idx + seekString.length);
    }
    var quizid = $("#quizid").val();
    currenrUrl = document.location = url+"/stepseven/"+quizid;
  });

  $('#prev_steptwo').click(function() {
      history.back();
  });

   $("#step_twonext").click(function(){
      var quizid = $("#quizid").val();
      var seekString = "/quiz";
      currenrUrl = window.location.href;
      var idx = currenrUrl.indexOf(seekString);

      if (idx !== -1) {
        var url = currenrUrl.substring(0, idx + seekString.length);
      }
      var quizid = $("#quizid").val();
      currenrUrl = document.location = url+"/stepthree/"+quizid;
  });   

  var total_view = {{$quizdetail->rate_counter}};
  var viewedArr = [];

  function getQuizDetails( id, quizid, classId ){
	 $("#right_side").addClass('loading');
    $(".item-wrapper").removeClass('current');  
    $(classId).addClass( "getselect current" );

	  var path = '/quiz/getDetails/';

    if( $.inArray(id, viewedArr) == -1 ){
        viewedArr.push(id);
        total_view++;
    }
	
	  $.ajax({
        type:'GET',
        data:{ 'id': id, 'view_count': total_view, 'quizid': quizid },
        url:'{{ url("/quiz/getDetails/") }}',
        success:function( data ){
			
            $("#right_side").html(data);
			
			$('iframe').load(function(){
				  $("#right_side").removeClass('loading');
				//alert("iframe is done loading")
			}).show();				            
			
    				// if( $.inArray(id, viewedArr) == -1 ){
      		// 			viewedArr.push(id);
      		// 			total_view++;
    				// }            
            // var detail_id = $("#detail_id").val();
				    // alert(detail_id);
    				if(total_view >= 3){
						$('#demo-count').text('');
    					// $("#next-step").show();
              $("#step_twonext").css("display", "inline");
			  
    				}     
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
  
     <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
var $jp = jQuery.noConflict();
$jp(document).ready(function() {

// init


var containerWidth = $jp("#quiz-resize").width();
if($jp(window).width()>991){
    $jp("#left-quiz").resizable({
      handles: 'e',
      maxWidth: containerWidth-320,
      minWidth: 320,
      resize: function(event, ui){
          var currentWidth = ui.size.width;
         // alert(currentWidth);
          // this accounts for padding in the panels + 
          // borders, you could calculate this using jQuery
          var padding = 40; 
          
          // this accounts for some lag in the ui.size value, if you take this away 
          // you'll get some instable behaviour
          $jp(this).width(currentWidth-padding);
          console.log(currentWidth,'width');
		  console.log(containerWidth - (currentWidth + padding),'left');
          // set the content panel width
          $jp("#right-quiz").width(containerWidth - (currentWidth + padding));
		   //alert($jp("#right-resize").width(containerWidth - currentWidth - padding));            
      }
	});
}


});
</script>



@endsection