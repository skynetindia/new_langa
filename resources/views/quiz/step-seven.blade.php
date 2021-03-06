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

<!-- CSS required for STEP Wizard  -->
 
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
  <!-- HTML Structure -->

<div class="row quiz-wizard">
  <div class="col-md-12">
    <h1> {{ trans('messages.keyword_quiz') }} </h1>
    <div class="wizard">
      <div class="wizard-inner">
        <div class="connecting-line"></div>
        <ul class="nav nav-tabs">
          <li role="presentation" class="top0 active"> <a href="#" title="Step 1"> <span class="round-tab"> <img src="{{ asset('images/folder.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_enter_data') }} </span> </a> </li>
          <li role="presentation" class="top0 active"> <a href="#" title="Step 2"> <span class="round-tab"> <img src="{{ asset('images/star.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_currency_demo') }} </span> </a> </li>
          <li role="presentation" class="top0 active"> <a href="#" title="Step 3"> <span class="round-tab"> <img src="{{ asset('images/edit.png') }}"> </span> <span class="tab-name">{{ trans('messages.keyword_colors__layouts') }} </span> </a> </li>
          <li role="presentation" class="top0 active"> <a href="#" title="Complete"> <span class="round-tab"> <img src="{{ asset('images/list.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_optional') }} </span> </a> </li>
          <li role="presentation" class="top0 active"> <a href="#" title="Complete"> <span class="round-tab"> <img src="{{ asset('images/media.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_media') }} </span> </a> </li>

          <li role="presentation" class="top0 active"> <a href="#" title="Complete"> <span class="round-tab"> <img src="{{ asset('images/flag.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_media') }} </span> </a> </li>
          
        </ul>
      </div>
     
       <div class="step-footer">          
          <div class="dots"> <span class="dot"> </span> <span class="dot"> </span> <span class="dot"> </span> <span class="dot"> </span> <span class="dot"> </span> <span class="dot"> </span> <span class="dot active"> </span>
          <div class="page">7/7</div>
          </div>
          <ul class="list-inline">
          <li><a class="prev-step" id="prev_stepthree"> {{ trans('messages.keyword_back') }} </a></li>
          <li><a class="next-step" id="step-three"> {{ trans('messages.keyword_next') }} </a></li>
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
    </div>
  </div>
  
  
 

  
</div>

  
<!-- tagging textarea -->
<script src="https://code.jquery.com/ui/1.10.2/jquery-ui.min.js"></script>

<script type="text/javascript">

  $('#prev_stepthree').click(function() {
    history.back();
  });

</script>

<!-- JQeury code required for STEP wizard -->

<script>

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