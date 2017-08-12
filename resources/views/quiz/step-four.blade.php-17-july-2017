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
<!-- tagging textarea -->
<link href="{{asset('public/css/jquery.tag-editor.css')}}" rel="stylesheet">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">


<!-- CSS required for STEP Wizard  -->

<div class="row quiz-wizard">
  <div class="col-md-12">
    <h1> {{ trans('messages.keyword_quiz') }} </h1>
    <div class="wizard wizard-step-line">
      <div class="wizard-inner">
        <div class="connecting-line"></div>
        <ul class="nav nav-tabs">
          <li role="presentation" class="top0 active"> <a href="{{ url('/quiz/stepone') }}" title="Step 1"> <span class="round-tab"> <img src="{{ asset('images/folder.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_enter_data') }} </span> </a> </li>
          <li role="presentation" class="top0 active"> <a href="{{ url('/quiz/steptwo/'.$quizid) }}" title="Step 2"> <span class="round-tab"> <img src="{{ asset('images/star.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_currency_demo') }} </span> </a> </li>
          <li role="presentation" class="top0 active"> <a href="{{ url('/quiz/stepthree/'.$quizid) }}" title="Step 3"> <span class="round-tab"> <img src="{{ asset('images/edit.png') }}"> </span> <span class="tab-name">{{ trans('messages.keyword_colors__layouts') }} </span> </a> </li>
          <li role="presentation" class="top0 active"> <a href="#" title="Complete"> <span class="round-tab"> <img src="{{ asset('images/list.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_optional') }} </span> </a> </li>
          <li role="presentation" class="top0 disabled"> <a href="#" title="Complete"> <span class="round-tab"> <img src="{{ asset('images/media.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_media') }} </span> </a> </li>
          
          <li role="presentation" class="top0 disabled"> <a href="#" title="Complete"> <span class="round-tab"> <img src="{{ asset('images/flag.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_media') }} </span> </a> </li>
          
        </ul>
      </div>
    </div>
      <div class="wizard">
      <div class="step-content step-four">
        <div class="step-pane">
          <div class="row">
              <div class="col-md-6">
                  <div class="left-side">
       			<div class="height550">
       

          <div class="row">

          <br>
         <!--  <div class="col-md-12">

          <textarea cols="50" rows="2" id="get_lable"><?php //if(isset($cart)){   foreach ($cart as $value) { echo $value->label . "\n"; } } ?>
          </textarea>
        
          </div> -->

          <?php $i=1; ?>
          @foreach($optional as $option)

          <div class="col-md-6 logo<?php echo $i;?>" onclick="setdiv(<?php echo $i ;?>)">
              <div class="item-wrapper">
                  <img src="{{ asset('storage/app/images/'.$option->icon) }}" height="50" width="50" class="logo_icon<?php echo $i;?>">
                  <div class="on-hover-text logo_label<?php echo $i;?>" id="">    
                  {{ $option->code }}
                  </div>
                </div>
            </div>
            <input type="hidden" name="quizid" id="quizid" value="{{ $quizid }}"/>
            <div class="none">
              <input type="hidden" name="optioan_id" class="optioan_id<?php echo $i;?>" value="{{ $option->id }}">
              <img src="{{ asset('storage/app/images/'.$option->immagine) }}" height="50" width="50" 
              class="logo_immagine<?php echo $i;?>">
              <div class="on-hover-text logo_description<?php echo $i;?>" id="">
                  {{ $option->description_quize }}                 
              </div>
              <div class="on-hover-text logo_price<?php echo $i;?>" id="logo_price">
                  {{ ($option->price * $locationpercentage) }}
              </div>
            </div>

          <?php $i++; ?>
          @endforeach

         
          </div>
          
        </div>
      </div>
      
      <div class="col-md-12">
          <textarea name="get_lable" id="get_lable" style="display: none;" cols="100" placeholder="{{trans('messages.keyword_added_optional')}}">{{ $cart }}</textarea>
          <ul class="tag-editor ui-sortable">
          @foreach($cartdetail as $cartdetailkey => $cartdetailval)
          @if($cartdetailval->label != "")
            <li id="cartlist_{{$cartdetailval->id}}">
              <div class="tag-editor-spacer">&nbsp;,</div>
              <div class="tag-editor-tag">{{$cartdetailval->label}}</div>
              <div class="tag-editor-delete" val="{{$cartdetailval->optional_id}}" onclick="removefromcart({{$cartdetailval->id}})"><i></i></div>
            </li>            
          @endif
          @endforeach
         </ul>
      </div>

      </div>
      
            <div class="col-md-6">
               <div class="right-side">
               		<div class="height550">
                <div class="row right-header">
              <div class="col-md-6 right-heading">
                  <div class="pull-left"><img src="{{ url('storage/app/images/'.$default->icon) }}" id="icon_logo" height="50" width="50"></div>
                    <div class="pull-right"><p id="icon_label"> {{ $default->code }} </p></div>
                </div>
                <div class="col-md-6 price">
                  € <span id="icon_price"> {{ ($default->price * $locationpercentage) }} </span>
                  {{ trans('messages.keyword_cad') }}                  
                  <div class="right-side text-right"><?php
                  $currentcart = explode(",",$cart);
                  if(in_array($default->code, $currentcart)){
                      ?><button class="btn btn-warning quiz_cart_add"> Already In Cart </button><?php
                  }
                  else {
                    ?><button id="logo_add" class="btn btn-warning quiz_cart_add"> {{ trans('messages.keyword_add') }} </button><?php
                  }
                ?></div>
                  
                </div>

                <input type="hidden" name="icon_id" id="icon_id" value="{{ $default->id }}">

            </div>
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
            

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
                                <p id="icon_description"> {{ $default->description_quize }} </p>
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
              <div class="dots"> <span class="dot"> </span> <span class="dot"> </span> <span class="dot"> </span> <span class="dot active"> </span> <span class="dot"> </span> <span class="dot"> </span>
                <div class="page">4/7</div>
              </div>
              <ul class="list-inline">
                <li><a class="prev-step" id="prev_stepfour"> 
                {{ trans('messages.keyword_back') }} </a></li>
                <li><a class="next-step" id="next_stepfour"> 
                {{ trans('messages.keyword_next') }} </a></li>
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

<center>
<?php if(isset($payment_status->payment_status) && $payment_status->payment_status == 1) { ?>
<button id="firm" class="btn btn-default">
  {{ trans('messages.keyword_firm') }}
</button>
  <script type="text/javascript">
    $('.quiz-wizard').addClass('disabled');
  </script>
 <?php } ?>
<?php if(isset($payment_status->payment_status) && $payment_status->payment_status == 2) { ?>
<button id="down_payment" class="btn btn-default">
  {{ trans('messages.keyword_pay_down') }} 
</button>
  <script type="text/javascript">
    $('.quiz-wizard').addClass('disabled');
  </script>
<?php } ?>
</center>


<!-- tagging textarea -->
<script src="https://code.jquery.com/ui/1.10.2/jquery-ui.min.js"></script>
<script src="{{asset('/public/scripts/jquery.tag-editor.js')}}"></script>
<script src="{{asset('/public/scripts/jquery.caret.min.js')}}"></script>

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
      var currentcart = '<?php echo $cart;?>';
      var arrcurrentcart = currentcart.split(',');
       if ($.inArray(label, arrcurrentcart) == -1){
        $(".quiz_cart_add").attr('id',"logo_add");
        $(".quiz_cart_add").text("{{ trans('messages.keyword_add') }}");
       }
       else {        
        $(".quiz_cart_add").attr('id',"");
        $(".quiz_cart_add").text("Already In Cart");
       }     
      }

      var push = [];
      $(".quiz_cart_add").click(function(e){
        var idd = $(this).attr('id');
        if(idd != "logo_add"){
          return false;
        }
          var label = $('#icon_label').text();
          var optioan_id = $('#icon_id').val();
          if ($.inArray(optioan_id, push) == -1)
          {
            
            e.preventDefault();
          var quizid = $("#quizid").val();
          var icon_label = $("#icon_label").text(); 
          var icon_description = $("#icon_description").text(); 
          var price = $("#icon_price").text();          
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
              success:function(id) {          
                  push.push(optioan_id);  
                  $('#get_lable').append($("#icon_label").text()+ ',');
                  $('.tag-editor').append("<li id='cartlist_"+id+"'><div class='tag-editor-spacer'>&nbsp;,</div><div class='tag-editor-tag'>"+ label +"</div><div class='tag-editor-delete' val='"+optioan_id+"' onclick='removefromcart("+id+")'><i></i></div></li>");
              }
          });          
          }
      });
      function removefromcart(removeitem){    
        var _token = $('input[name="_token"]').val();
        $.ajax({
              type:'POST',
              data: {
                      'cartid': removeitem,                      
                      '_token' : _token
                    },
              url: '{{ url('quiz/removecart') }}',
              success:function(data) {          
                push = jQuery.grep(push, function(value) {
                    return value != removeitem;
                });         
                $("#cartlist_"+removeitem).remove();
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

<script>
/*  ;(function($){

        // jQuery UI autocomplete extension - suggest labels may contain HTML tags
        // github.com/scottgonzalez/jquery-ui-extensions/blob/master/src/autocomplete/jquery.ui.autocomplete.html.js
        (function($){
          var proto=$.ui.autocomplete.prototype,initSource=proto._initSource;
          function filter(array,term){
            var matcher=new RegExp($.ui.autocomplete.escapeRegex(term),"i");
            return $.grep(array,function(value){
              return matcher.test($("<div>").html(value.label||value.value||value).text());});
            }
            $.extend(proto,{_initSource:function(){
              if(this.options.html&&$.isArray(this.options.source)){
                this.source=function(request,response){
                  response(filter(this.options.source,request.term));
                };
              }
              else{
                initSource.call(this);
              }
            },_renderItem:function(ul,item){
                  return $("<li></li>").data("item.autocomplete",item).append($("<a></a>")[this.options.html?"html":"text"](item.label)).appendTo(ul);}
                });
          })(jQuery);

        var cache = {};
        function googleSuggest(request, response) {
            var term = request.term;
            if (term in cache) { response(cache[term]); return; }
            $.ajax({
                url: 'https://query.yahooapis.com/v1/public/yql',
                dataType: 'JSONP',
                data: { format: 'json', q: 'select * from xml where url="http://google.com/complete/search?output=toolbar&q='+term+'"' },
                success: function(data) {
                    var suggestions = [];
                    try { var results = data.query.results.toplevel.CompleteSuggestion; } catch(e) { var results = []; }
                    $.each(results, function() {
                        try {
                            var s = this.suggestion.data.toLowerCase();
                            suggestions.push({label: s.replace(term, '<b>'+term+'</b>'), value: s});
                        } catch(e){}
                    });
                    cache[term] = suggestions;
                    response(suggestions);
                }
            });
        }

        $(function() {
            $('#get_lable').tagEditor({
                placeholder: '{{ trans('messages.keyword_added_optional') }}...',
              autocomplete: { source: googleSuggest, minLength: 3, delay: 250, html: true, position: { collision: 'flip' },  response: function( event, ui ) {
        display(ui.content);
    },
    open: function( event, ui ) {
        $(".ui-autocomplete").hide();
    } }
            
      
      });
        
      
        
        
          
            $('#remove_all_tags').click(function() {
                var tags = $('#demo3').tagEditor('getTags')[0].tags;
                for (i=0;i<tags.length;i++){ $('#demo3').tagEditor('removeTag', tags[i]); }
            });

   
            function tag_classes(field, editor, tags) {
                $('li', editor).each(function(){
                    var li = $(this);
                    if (li.find('.tag-editor-tag').html() == 'red') li.addClass('red-tag');
                    else if (li.find('.tag-editor-tag').html() == 'green') li.addClass('green-tag')
                    else li.removeClass('red-tag green-tag');
                });
            }
            $('#demo6').tagEditor({ initialTags: ['custom', 'class', 'red', 'green', 'demo'], onChange: tag_classes });
            tag_classes(null, $('#demo6').tagEditor('getTags')[0].editor); // or editor == $('#demo6').next()
        });

        if (~window.location.href.indexOf('http')) {
            (function() {var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;po.src = 'https://apis.google.com/js/plusone.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);})();
            (function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s); js.id = id;js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4&appId=114593902037957";fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));
            !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
            $('#github_social').html('\
                <iframe style="float:left;margin-right:15px" src="//ghbtns.com/github-btn.html?user=Pixabay&repo=jQuery-tagEditor&type=watch&count=true" allowtransparency="true" frameborder="0" scrolling="0" width="110" height="20"></iframe>\
                <iframe style="float:left;margin-right:15px" src="//ghbtns.com/github-btn.html?user=Pixabay&repo=jQuery-tagEditor&type=fork&count=true" allowtransparency="true" frameborder="0" scrolling="0" width="110" height="20"></iframe>\
            ');
        }
        })(jQuery);
*/
    </script>



@endsection