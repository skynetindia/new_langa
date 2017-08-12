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
<script type="text/javascript" src="{{asset('public/scripts/colors.js')}}"></script>
<script type="text/javascript" src="{{asset('public/scripts/jqColorPicker.min.js')}}"></script>

 <!-- CSS required for STEP Wizard  -->
 

<!-- tagging textarea -->
<link href="{{asset('public/css/jquery.tag-editor.css')}}" rel="stylesheet">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
  <!-- HTML Structure -->

<div class="row quiz-wizard">
  <div class="col-md-12">
    <h1> {{ trans('messages.keyword_quiz') }} </h1>
    <div class="wizard wizard-step-line">
      <div class="wizard-inner">
        <div class="connecting-line"></div>
        <ul class="nav nav-tabs">
          <li role="presentation" class="top0 active"> <a href="{{ url('/quiz/stepone') }}" title="Step 1"> <span class="round-tab"> <img src="{{ asset('images/folder.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_enter_data') }} </span> </a> </li>
          <li role="presentation" class="top0 active"> <a href="{{ url('/quiz/steptwo/'.$quizid) }}" title="Step 2"> <span class="round-tab"> <img src="{{ asset('images/star.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_currency_demo') }} </span> </a> </li>
          <li role="presentation" class="top0 active"> <a href="#" title="Step 3"> <span class="round-tab"> <img src="{{ asset('images/edit.png') }}"> </span> <span class="tab-name">{{ trans('messages.keyword_colors__layouts') }} </span> </a> </li>
          <li role="presentation" class="top0 disabled"> <a href="#" title="Complete"> <span class="round-tab"> <img src="{{ asset('images/list.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_optional') }} </span> </a> </li>
          <li role="presentation" class="top0 disabled"> <a href="#" title="Complete"> <span class="round-tab"> <img src="{{ asset('images/media.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_media') }} </span> </a> </li>

          <li role="presentation" class="top0 disabled"> <a href="#" title="Complete"> <span class="round-tab"> <img src="{{ asset('images/flag.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_media') }} </span> </a> </li>
          
        </ul>
      </div>
      </div>
      <div class="wizard">
      <div class="step-content step-three">
        <div class="step-pane">
          <form role="form" name="step_three" class="text-center register-for-quiz-form" method="post">
            <ol>
              <li><label> {{ trans('messages.keyword_which_pages_you_like') }} ? <span class="required">(*)</span> </label>
                   <div class="form-group">
            <!-- <textarea class="form-control" rows="5" ></textarea> 
            -->
            {{ csrf_field() }}

            <input type="hidden" name="quizid" id="quizid" value="{{ $quizid}}"/>
            
             <textarea name="pages" id="pages" cols="100" rows="7">{{ $oldquiz->pagine }}</textarea>
                     </div>
                </li>
                <span id="span_pages"  class="none"> {{ trans('messages.keyword_pages_required') }}  </span>

                <li><label> {{ trans('messages.keyword_what_colors_you_like') }} ? <span class="required">(*)</span> </label> 
                  <div class="form-group">
                      <div class="input-group">
                        <input type="text" class="form-control color no-alpha" value="<?php echo isset($oldquiz->colore_primario) ? $oldquiz->colore_primario : '#F7F7F7'; ?>" id="colore_primario"
                        name="colore_primario" placeholder=" {{ trans('messages.keyword_primary_color') }} ">
                        <span class="input-group-addon" id="colore_primario_span"> {{ trans('messages.keyword_color_picker_goes_here') }}   </span> 
                         </div>
                  </div>
                 <span id="span_primario" style="display: none;"> {{ trans('messages.keyword_primary_color_required') }}  </span>
                 <div class="form-group">
                     <div class="input-group">
                      <input type="text" class="form-control color " value="<?php echo isset($oldquiz->colore_secondario) ? $oldquiz->colore_secondario : '#F7F7F7'; ?>" name="colore_secondario" placeholder=" {{ trans('messages.keyword_secondary_color') }} " id="colore_secondario">
                      <span class="input-group-addon" id="colore_secondario_span"> {{ trans('messages.keyword_color_picker_goes_here') }} </span> 
                       </div>
                </div>
                
                <div class="form-group">
                     <div class="input-group">
                      <input type="text" class="form-control color" value="<?php echo isset($oldquiz->colore_alternativo) ? $oldquiz->colore_alternativo : '#F7F7F7'; ?>" name="colore_alternativo" placeholder="{{ trans('messages.keyword_alternative_color') }} " id="colore_alternativo">
                      <span class="input-group-addon" id="colore_alternativo_span">{{ trans('messages.keyword_color_picker_goes_here') }} </span> 
                       </div>
                </div>
                 </li>
                  
                 <li><label> {{ trans('messages.keyword_which_characters_would_like_use') }} ?</label>
                  <div class="row">
                    <div class="col-md-6">
                       <div class="form-group">
                       <select class="form-control" id="fontsize" name="fontsize">

                        @foreach($fontsize as $size)
                          @if($oldquiz->font_dimensione == $size->size)
                            <option value="{{ $size->id }} " selected="selected">{{ $size->size }}</option>
                          @else
                            <option value="{{ $size->id }}">{{ $size->size }}</option>
                            @endif
                        @endforeach

                        </select>
                      </div>
                      
                           <div class="form-group">
                            <select class="form-control" id="fontfamily" name="fontfamily">
                             
                        @foreach($fontfamily as $family)
                          @if($oldquiz->font_famiglia == $family->family)
                            <option value="{{ $family->id }} " selected="selected">{{ $family->family }}</option>
                          @else
                            <option value="{{ $family->id }}">{{ $family->family }}</option>
                            @endif
                        @endforeach

                            </select>
                          </div>
                  
                      </div>                        
                        
                      <div class="col-md-6">
                                
                      <div class="form-group">
                        <textarea class="form-control" rows="15" id="font_preview" name="font_preview">
                          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus lacinia dictum varius. Aenean fermentum est a nisl luctus, eu consequat dolor auctor. Aliquam dignissim sed felis a cursus. Aliquam ac vulputate metus. Proin sit amet felis auctor, elementum orci nec, hendrerit massa.
                        </textarea>
                        </div>
                    
                      </div>

                    </div>
                 </li>
            
            </ol>
            
          <div class="step-footer">
              <div class="dots"> <span class="dot"> </span> <span class="dot"> </span> <span class="dot active"> </span> <span class="dot"> </span> <span class="dot"> </span> <span class="dot"> </span>
                <div class="page">3/7</div>
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


  
<!-- tagging textarea -->
<script src="https://code.jquery.com/ui/1.10.2/jquery-ui.min.js"></script>
<script src="{{asset('/public/scripts/jquery.tag-editor.js')}}"></script>
<script src="{{asset('/public/scripts/jquery.caret.min.js')}}"></script>

<script type="text/javascript">
$("#colore_alternativo_span").click(function(){
     $("#colore_alternativo").trigger("click");
});
$("#colore_primario_span").click(function(){
     $("#colore_primario").trigger("click");
});
$("#colore_secondario_span").click(function(){
     $("#colore_secondario").trigger("click");
});
  $('.color').colorPicker();

  var family = $('#fontfamily').find("option:selected").text();
  var size = $('#fontsize').find("option:selected").text()+"px";

  $('#font_preview').css({"font-size":size});
  $('#font_preview').css({"font-family":family});

    $("#fontfamily").change(function() {
      var currFamily = $(this).find("option:selected").text();
      $("#font_preview").css({'font-family':currFamily});
    });

    $("#fontsize").change(function() {
      var currSize = $(this).find("option:selected").text()+"px";
      $("#font_preview").css({'font-size':currSize});
    });

    $('#prev_stepthree').click(function() {
      history.back();
      // location.reload();
      // window.location.href=window.location.href;
       // setTimeout(function(){ window.location.reload(); }, 3000);
    });


    $("#step-three").click(function(e){
        
        var pages = document.getElementById("pages");
        var colore_primario = document.getElementById("colore_primario");

        if (pages.value == '') {
            document.getElementById("span_pages").style.display = "block";
            document.getElementById("span_pages").style.color = "red"; 
            pages.focus();        
            return false;

        } 

        if (colore_primario.value == '') {
            document.getElementById("span_primario").style.display = "block";
            document.getElementById("span_pages").style.display = "none";
            document.getElementById("span_primario").style.color = "red";
            pages.focus();
            return false;
        } 
          e.preventDefault();

          var quizid = $("#quizid").val();
          var pages = $("#pages").val(); 
          var colore_primario = $("#colore_primario").val();
          var colore_secondario = $("#colore_secondario").val();
          var colore_alternativo = $("#colore_alternativo").val(); 
          var fontsize = $("#fontsize").val(); 
          var fontfamily = $("#fontfamily").val();
          var font_preview = $("#font_preview").val();
          var _token = $('input[name="_token"]').val();

          $.ajax({
            type:'POST',
            data: {
                    'pages': pages,
                    'colore_primario':colore_primario,
                    'colore_secondario': colore_secondario,
                    'colore_alternativo': colore_alternativo,
                    'fontsize':fontsize,
                    'fontfamily':fontfamily,
                    'font_preview': font_preview,
                    'quiz_id':quizid,
                    '_token' : _token
                  },
            url: '{{ url('storeStepthree') }}',
            success:function(data) {
              // console.log(data);
              var seekString = "/quiz";
              currenrUrl = window.location.href;
              var idx = currenrUrl.indexOf(seekString);

              if (idx !== -1) {
                var url = currenrUrl.substring(0, idx + seekString.length);
              }

              var quizid = $("#quizid").val();
              currenrUrl = document.location = url+"/stepfour/"+quizid;     
            }

        });

     });

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

</script>

 <script>

  ;(function($){

        // jQuery UI autocomplete extension - suggest labels may contain HTML tags
        // github.com/scottgonzalez/jquery-ui-extensions/blob/master/src/autocomplete/jquery.ui.autocomplete.html.js
        (function($){var proto=$.ui.autocomplete.prototype,initSource=proto._initSource;function filter(array,term){var matcher=new RegExp($.ui.autocomplete.escapeRegex(term),"i");return $.grep(array,function(value){return matcher.test($("<div>").html(value.label||value.value||value).text());});}$.extend(proto,{_initSource:function(){if(this.options.html&&$.isArray(this.options.source)){this.source=function(request,response){response(filter(this.options.source,request.term));};}else{initSource.call(this);}},_renderItem:function(ul,item){return $("<li></li>").data("item.autocomplete",item).append($("<a></a>")[this.options.html?"html":"text"](item.label)).appendTo(ul);}});})(jQuery);

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
            $('#pages').tagEditor({
                placeholder: '{{ trans('messages.keyword_enter_pages') }}...',
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