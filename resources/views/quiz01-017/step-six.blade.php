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
 <!-- CSS required for STEP Wizard  -->

  <!-- HTML Structure -->
<div class="row quiz-wizard">
  <div class="col-md-12">
    <h1> {{ trans('messages.keyword_quiz') }} </h1>
    <div class="wizard">
      <div class="wizard-inner">
        <div class="connecting-line"></div>
        <ul class="nav nav-tabs">
          <li role="presentation" class="top0 active"> <a href="#" title="Step 1"> <span class="round-tab"> <img src="{{ url('/images').'/folder.png' }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_enter_data') }} </span> </a> </li>
          <li role="presentation" class="top0 active"> <a href="#" title="Step 2"> <span class="round-tab"> <img src="{{ url('/images').'/star.png' }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_currency_demo') }} </span> </a> </li>
          <li role="presentation" class="top0 active"> <a href="#" title="Step 3"> <span class="round-tab"> <img src="{{ url('/images').'/edit.png' }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_colors__layouts') }}</span> </a> </li>
          <li role="presentation" class="top0 active"> <a href="#" title="Complete"> <span class="round-tab"> <img src="{{ url('/images').'/list.png' }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_optional') }} </span> </a> </li>
          <li role="presentation" class="top0 active"> <a href="#" title="Complete"> <span class="round-tab"> <img src="{{ url('/images').'/media.png' }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_media') }} </span> </a> </li>
          
          <li role="presentation" class="top0 active"> <a href="#" title="Complete"> <span class="round-tab"> <img src="{{ asset('images/flag.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_media') }} </span> </a> </li>
          
        </ul>
      </div>      

      <div class="step-content step-two step-six">
          
            <input type="hidden" name="quizid" id="quizid" value="{{ $quizid}}"/>

            <div class="left-side col-md-6">

              <div class="row">        
              	<div class="col-md-12"><h5> <b> {{ trans('messages.keyword_legal_office_billing') }} </b> </h5> </div>                   
                
                    <div class="col-md-6"> 
	                    @isset($order->indirizzo) {{ $order->indirizzo }}      @endisset 
    	              </div>

                  <div class="col-md-6">
	                  <p> <b> {{ trans('messages.keyword_vat_identification_number') }}: </b> </p>
    	                @isset($order->vat_number) {{ $order->vat_number }}      @endisset                                             
                  </div>
                         
              </div>	

              <hr>

              <div class="row"> 

                <div class="col-md-12"> 
                  <h4> <b> {{ trans('messages.keyword_item_of_order') }} </b> </h4> 
                  <span> SITO WEB LANGA WEB- {{ trans('messages.keyword_package') }}</span>
                  <br>
                  ID ORDER # @isset($order->order_id) {{ $order->order_id }}      @endisset  
                  <br><br>
                  <p> {{ trans('messages.keyword_paying_through_secure_paypal_cashier') }} </p>
                </div> 

              </div>  

              <hr>

              <div class="row"> 

              

                <div class="col-md-8">         
                
                	<h4> <b> {{ trans('messages.keyword_accounting_plan') }} </b> </h4>
                         
                  {{ trans('messages.keyword_total') }}:  @isset($order->totale_prezzo) {{ $order->totale_prezzo }}€ @endisset + IVA <br>

                  {{ "Province" }}: @isset($quiz_province->provincie) {{ $order->totale_prezzo*$quiz_province->provincie/100 }} @endisset<br>

                  {{ trans('messages.keyword_use_the_coin') }}: LANGA-10%
                  
						                  <div class="switch">
                                                 <span>  </span>
                                                <input class="form-control input-check" value="1" name="stepsix" id="stepsix" type="checkbox">
                                                <label for="stepsix" class="checkbox-inline"> </label>
                                                </div>
                  
                  <br><br>

                  <?php if(isset($order->totale_prezzo)) { 

                    $totale_prezzo = isset($order->totale_prezzo) ? $order->totale_prezzo : 0;

                    $ediscount = $totale_prezzo*80 / 100;

                    $tassazione_percentuale = isset($vat->tassazione_percentuale) ? $vat->tassazione_percentuale : 0;

                    $etax = $ediscount*$tassazione_percentuale / 100;

                    if(isset($quiz_province->provincie)){ 
                      $province = $order->totale_prezzo*$quiz_province->provincie/100;
                    } else {
                      $province = 0;
                    }

                    $etax = $etax + $ediscount - $province; 

                  } ?>

                  <p id="ediscount" title="select method"> {{ trans('messages.keyword_balance_on_delivery') }}:  @isset($ediscount) {{ $ediscount }}€ @endisset + IVA - Province @isset($etax) {{ $etax }}€ @endisset </p>
                 
                <!-- pick -->
                                   
                </div> 

                <div class="col-md-4 text-right">      
                	 <h4> <b> {{ trans('messages.keyword_deposit') }} 20% </b> </h4>
                </div> 


            	<div class="col-md-8"> <hr>
                  <?php if(isset($order->totale_prezzo)) {

                    $totale_prezzo = isset($order->totale_prezzo) ? $order->totale_prezzo : 0;

                    $tdiscount = $totale_prezzo*20 / 100;

                    $tassazione_percentuale = isset($vat->tassazione_percentuale) ? $vat->tassazione_percentuale : 0;

                    $ttax = $tdiscount*$tassazione_percentuale / 100;

                    $ttax = $ttax + $tdiscount; 
                    
                  } ?>

                  <span id="tdiscount" title="select method" class="tdiscount"> {{ trans('messages.keyword_topay') }}: @isset($tdiscount) {{ $tdiscount }}€ @endisset + IVA  @isset($ttax) {{ $ttax }}€ @endisset
                  </span>
                </div>
                
                <div class="col-md-4 text-right">     <div class="height30"></div> 
                  <button id="confirm" class="btn btn-warning confirm" disabled="disabled"> {{ trans('messages.keyword_confirm') }} </button>
                </div> 
         


              </div>  
              <br>
             
             <div class="row"><div class="col-md-12">{{ trans('messages.keyword_using_langa_currency_you_qualify_for_discount') }}</div></div>

            </div>

            <input type="hidden" id="quoteid" name="quoteid" value="">

            <div class="right-side col-md-6" id="right_side">

			<div class="height550">
            <div class="row">
              		<div class="header-top col-md-12"><b> {{ trans('messages.keyword_stamp_signature_for_acceptance') }} :</b>_______________________</div>
              <br><br>
             		<div class="col-md-12 middle-top"> <b>{{ trans('messages.keyword_object') }}:</b> SITO WEB LANGA WEB - {{ trans('messages.keyword_package') }} % WEB </div>
              <br><br>
              <div class="col-md-6">
              <p>
                <b> {{ $reference->nomereferente }} </b> {{ trans('messages.keyword_of') }} {{ $reference->nomeazienda }}<br>
                
                {{ $reference->sedelegale }} <br><br>
               
              </p>
              </div>

              <div class="col-md-6">
              <p>
                <b>  {{ trans('messages.keyword_date') }}: @isset($quote->created_at) </b>
                {{  Carbon\Carbon::parse($quote->created_at)->format('d/m/Y') }} @endisset  <br>
                <b> {{ trans('messages.keyword_quote') }}: </b> @isset($quote->id) #{{ $quote->id }} @endisset <br>
                <b> {{ trans('messages.keyword_agent') }} / {{ trans('messages.keyword_retailer') }}: </b> {{ $reference->nomereferente }} <br>
                <b> {{ trans('messages.keyword_contacts') }}: </b> 
                {{ $reference->telefonoresponsabile }} / {{ $reference->email }}
              </p>
              </div>

            </div>

            <div class="row">
              
              <div class="col-md-6">
                <div class="innr-head"><h3> <b> {{ trans('messages.keyword_from') }}  </b> </h3></div>

                <div class="col-md-3">
                   <img src="{{ asset('storage/app/images/'.$departments->logo) }}" height="50" width="50">
                </div>

                <div class="col-md-9">
                	<ul class="list-unstyled">
		                <li>{{ trans('messages.keyword_responsible') }} Easy Langa: {{ $departments->nomereferente }}</li>
                		<li>{{ $departments->nomedipartimento }}</li>
		                <li>{{ $departments->indirizzo }}</li>
		                <li>{{ $departments->telefonodipartimento }} / {{ $departments->cellularedipartimento }}</li>
		                <li>{{ $departments->email }} / {{ $departments->emailsecondaria }}</li>
                	</ul>
                </div>
                
              </div>

              <div class="col-md-6">

                <div class="innr-head"><h3> <b> {{ trans('messages.keyword_to') }}  </b> </h3></div>

                <div class="col-md-3">
                  <img src="{{ asset('storage/app/images/quiz/'.$quiz_detail->logo) }}" height="50" width="50">
                </div>

                <div class="col-md-9">
                	<ul class="list-unstyled">
		                 <li>{{ trans('messages.keyword_contact') }}:</li>
		                 <li>@isset($order->nome_azienda) {{ $order->nome_azienda }} @endisset</li>
		                 <li>@isset($order->indirizzo) {{ $order->indirizzo }} @endisset</li>
		                 <li>@isset($order->telefono) {{ $order->telefono }} @endisset</li>
		                 <li>@isset($order->email) {{ $order->email }} @endisset</li>
                 	</ul>
                </div>

              </div>

            </div>
            	
              
            
            
            <div class="row">
              
              <div class="col-md-12">

              <?php if(isset($order_record)) { ?>
              
              <table class="selectable table table-hover table-bordered" id="table" cellspacing="0" cellpadding="0">

                <thead>
                  <tr>
                    <th> {{ trans('messages.keyword_qty') }} </th>
                    <th> {{ trans('messages.keyword_object') }} </th>
                    <th> {{ trans('messages.keyword_description') }} </th>
                    <th> {{ trans('messages.keyword_unit_price') }} </th>
                    <th> {{ trans('messages.keyword_total') }} </th>
                  </tr>
                </thead>

                <tbody>
                  
                  <?php foreach ($order_record as $order_record) { ?>
                  <tr>
                    <td> {{ $order_record->qty }} </td>
                    <td> {{ $order_record->label }} </td>
                    <td> {{ $order_record->description }} </td>
                    <td> {{ $order_record->prezzo_base }} </td>
                    <td> {{ $order_record->prezzo_totale }} </td>
                  </tr>
                  <?php } ?>
                    
                </tbody>

              </table>
              
              <?php } ?>
          
              </div>

            </div>

			<div class="step-six-fixed">
				<div class="row">
                	<div class="col-md-10"><textarea name="emailid" id="emailid" cols="100"></textarea></div>
                    <div class="col-md-2 text-right">  <button class="btn btn-warning" id="sendEmail"> {{ trans('messages.keyword_send') }} </button></div>
                </div>
            </div>
              
            </div>
            
            </div>
            
            
            <div class="clearfix"></div>

            <!-- <div class="step-footer"> -->
            <div class="step-footer">
              <div class="dots"> <span class="dot"> </span> <span class="dot active"> </span> <span class="dot"> </span> <span class="dot"> </span> <span class="dot"> </span> <span class="dot"> </span>
                <div class="page">6/7</div>
              </div>
              <ul class="list-inline">
                <li><a class="prev-step" id="prev_steptwo"> 
                {{ trans('messages.keyword_back') }} </a></li>
                <li id="next-step" class="none"><a class="next-step" id="step_twonext"> {{ trans('messages.keyword_next') }} </a></li> 
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
              <?php if(isset($payment_status->payment_status) && $payment_status->payment_status == 3) { ?>
              <button id="settled" class="btn btn-default">
                {{ trans('messages.keyword_settled') }}  
              </button>
               <?php } ?>
            </center>

        </div>

      </div>
    </div>
  </div>
</div>

<!-- tagging textarea -->

<script src="https://code.jquery.com/ui/1.10.2/jquery-ui.min.js"></script>
<script src="{{asset('/public/scripts/jquery.tag-editor.js')}}"></script>
<script src="{{asset('/public/scripts/jquery.caret.min.js')}}"></script>

<!-- JQeury code required for STEP wizard -->
  <script>

    $('#sendEmail').on('click', function(){      
      var email = $("#emailid").val();     
      var quizid = $("#quizid").val(); 
      $.ajax({
        type:'POST',
        data: { 'email': email, 'quizid':quizid, '_token': '{{ csrf_token() }}'},
        url: '{{ url('stepsix/send-email') }}',
        success:function(data) {  
          console.log(data);            
        }
      });
    });

    $('#ediscount').on('click', function(){      
      $('#confirm').attr("disabled", false);      
      $('#ediscount').css("background-color", "green");
      $('#tdiscount').css("background-color", "white");
    });

    $('#tdiscount').on('click', function(){      
      $('#confirm').attr("disabled", false);
      $('#tdiscount').css("background-color", "green");
      $('#ediscount').css("background-color", "white");
    });

    $('#confirm').on('click', function(){  

      var ecolor = $('#ediscount').css( "background-color" );
      var tcolor = $('#tdiscount').css( "background-color" );

      if ($("#ediscount").css('background-color')=="rgb(0, 128, 0)") {
        var payment_status = 3;
      } 

      if ($("#tdiscount").css('background-color')=="rgb(0, 128, 0)") {
        var payment_status = 1;
      } 

      var quizid = $("#quizid").val();
      $.ajax({
        type:'POST',
        data: { 'quizid': quizid, '_token': '{{ csrf_token() }}', 'payment_status':payment_status },
        url: '{{ url('stepsix/confirm') }}',
        success:function(data) {
          location.reload();
        }
      });

      // var seekString = "/easylanganew";
      // currenrUrl = window.location.href;
      // var idx = currenrUrl.indexOf(seekString);

      // if (idx !== -1) {
      //   var url = currenrUrl.substring(0, idx + seekString.length);
      // }

      // var quizid = $("#quizid").val();
      // currenrUrl = document.location = url+"/quiz/stepseven/"+quizid;

    });

    $('#prev_steptwo').click(function() {
        history.back();
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
            $('#emailid').tagEditor({
                placeholder:'{{ trans('messages.keyword_enter_email') }}',
                autocomplete: { source: googleSuggest, minLength: 3, delay: 250, html: true, position: { collision: 'flip' } }
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



@endsection