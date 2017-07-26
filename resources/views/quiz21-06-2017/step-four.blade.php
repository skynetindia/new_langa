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


<div class="row quiz-wizard">
  <div class="col-md-12">
    <h1> {{ trans('messages.keyword_quiz') }} </h1>
    <div class="wizard">
      <div class="wizard-inner">
        <div class="connecting-line"></div>
        <ul class="nav nav-tabs">
          <li role="presentation" class="top0 active"> <a href="#" title="Step 1"> <span class="round-tab"> <img src="{{ asset('images/folder.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_enter_data') }} </span> </a> </li>
          <li role="presentation" class="top0 disabled"> <a href="#" title="Step 2"> <span class="round-tab"> <img src="{{ asset('images/star.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_currency_demo') }} </span> </a> </li>
          <li role="presentation" class="top0 disabled"> <a href="#" title="Step 3"> <span class="round-tab"> <img src="{{ asset('images/edit.png') }}"> </span> <span class="tab-name">{{ trans('messages.keyword_colors__layouts') }} </span> </a> </li>
          <li role="presentation" class="top0 disabled"> <a href="#" title="Complete"> <span class="round-tab"> <img src="{{ asset('images/list.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_optional') }} </span> </a> </li>
          <li role="presentation" class="top0 disabled"> <a href="#" title="Complete"> <span class="round-tab"> <img src="{{ asset('images/media.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_media') }} </span> </a> </li>
          
          <li role="presentation" class="top0 disabled"> <a href="#" title="Complete"> <span class="round-tab"> <img src="{{ asset('images/flag.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_media') }} </span> </a> </li>
          
        </ul>
      </div>
      
      <div class="step-content step-four">
        <div class="step-pane">
          <div class="row">
              <div class="col-md-6">
                  <div class="left-side">
       			<div class="height550">
          
          <br>

          <div class="row">

          <div class="col-md-12">

          <textarea cols="50" rows="2" id="get_lable"><?php if(isset($cart)){   foreach ($cart as $value) { echo $value->label . "\n"; } } ?>
          </textarea>
        
          </div>

          <?php $i=1; ?>
          @foreach($optional as $option)

          <div class="col-md-6 logo<?php echo $i;?>" onclick="setdiv(<?php echo $i ;?>)">
              <div class="item-wrapper">
                  <img src="{{ asset('storage/app/images/'.$option->icon) }}" height="50" width="50" class="logo_icon<?php echo $i;?>">
                  <div class="on-hover-text logo_label<?php echo $i;?>" id="">    
                  {{ $option->label }}
                  </div>
                </div>
            </div>

            <input type="hidden" name="quizid" id="quizid" value="{{ $quizid }}"/>

            <div class="none">
              <input type="hidden" name="optioan_id" class="optioan_id<?php echo $i;?>" value="{{ $option->id }}">
              <img src="{{ asset('storage/app/images/'.$option->immagine) }}" height="50" width="50" 
              class="logo_immagine<?php echo $i;?>">
              <div class="on-hover-text logo_description<?php echo $i;?>" id="">
                  {{ $option->description }}                 
              </div>
              <div class="on-hover-text logo_price<?php echo $i;?>" id="logo_price">
                  {{ $option->price }}
              </div>
            </div>

          <?php $i++; ?>
          @endforeach

         
          </div>
          
        </div>
                </div>
                </div>
                
            <div class="col-md-6">
               <div class="right-side">
               		<div class="height550">
                <div class="row right-header">
              <div class="col-md-6 right-heading">
                  <div class="pull-left"><img src="{{ url('storage/app/images/'.$default->icon) }}" id="icon_logo" height="50" width="50"></div>
                    <div class="pull-right"><p id="icon_label"> {{ $default->label }} </p></div>
                </div>
                <div class="col-md-6 price">
                  € <span id="icon_price"> {{ $default->price }} </span>
                  {{ trans('messages.keyword_cad') }}
                </div>

                <input type="hidden" name="icon_id" id="icon_id">

            </div>
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
            <div class="right-side text-right">
                <button id="logo_add" class="btn btn-warning"> {{ trans('messages.keyword_add') }}  
                </button>
            </div>

            <div class="right-description">
              <div class="description-heading">
              
                <span> {{ trans('messages.keyword_description') }} </span>
                </div>
                 <div class="description">
                 
                 	<div class="row">
                    	<div class="col-md-6">
                             <div class="desciption-img">
                              <img src="{{ asset('storage/app/images/'.$default->immagine) }}" alt="description" height="100" width="100" id="icon_immagine">
                            </div>
                    	</div>
                        <div class="col-md-6">
                            <div class="description-text">
                              <h4 id="icon_h4"> {{ $default->label }} </h4>
                                <p id="icon_description"> {{ $default->description }} </p>
                            </div>
                    	</div>
                    </div>
                    
                 </div>
            </div>
        </div></div>
                
                </div>
            
            </div>
            
            
            <div class="clearfix"></div>
            
            
            <div class="step-footer">
              <div class="dots"> <span class="dot"> </span> <span class="dot"> </span> <span class="dot active"> </span> <span class="dot"> </span> <span class="dot"> </span> <span class="dot"> </span>
                <div class="page">3/7</div>
              </div>
              <ul class="list-inline">
                <li><a class="prev-step" id="prev_stepfour"> 
                {{ trans('messages.keyword_back') }} </a></li>
                <li><a class="next-step" id="next_stepfour"> 
                {{ trans('messages.keyword_next') }} </a></li>
              </ul>
            </div>

            <center>
            <?php if(isset($payment_status->payment_status) && $payment_status->payment_status == 1) { ?>
            <button id="firm" class="btn btn-default">
              {{ trans('messages.keyword_firm') }}
            </button>
             <?php } ?>
            <?php if(isset($payment_status->payment_status) && $payment_status->payment_status == 2) { ?>
            <button id="down_payment" class="btn btn-default">
              {{ trans('messages.keyword_pay_down') }} 
            </button>
            <?php } ?>
          </center>
          
        </div>
      </div>
    </div>
  </div>
</div>



<!-- JQeury code required for STEP wizard -->

  <script>

  $('#prev_stepfour').click(function() {
    history.back();
  });

  $('#next_stepfour').click(function() {

      var quizid = $("#quizid").val();
      var seekString = "/quiz";
      currenrUrl = window.location.href;
      var idx = currenrUrl.indexOf(seekString);

      if (idx !== -1) {
        var url = currenrUrl.substring(0, idx + seekString.length);
      }

      var quizid = $("#quizid").val();
      currenrUrl = document.location = url+"/stepfive/"+quizid;
  });

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
      $('#icon_price').text(price);
      $('#icon_h4').text(label);
      $('#icon_description').text(description);
      $('#icon_id').val(id);

      }

      $("#logo_add").click(function(e){

          var label = $('#icon_label').text()
          $('#get_lable').append($("#icon_label").text() + ' \n' );
         
          e.preventDefault();

          var quizid = $("#quizid").val();
          var icon_label = $("#icon_label").text(); 
          var icon_description = $("#icon_description").text(); 
          var price = $("#icon_price").text();
          var optioan_id = $('#icon_id').val();
          var _token = $('input[name="_token"]').val();
         
          $.ajax({

              type:'POST',
              data: {
                      'icon_label': icon_label,
                      'icon_description': icon_description,
                      'price':price,
                      'optioan_id':optioan_id,
                      'quiz_id':quizid,
                      '_token' : _token
                    },

              url: '{{ url('storeStepfour') }}',

              success:function(data) {          
                  console.log(data);
              }
          });

      });
      
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