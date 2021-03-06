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
          <li role="presentation" class="active"> <a href="#" title="Step 1"> <span class="round-tab"> <img src="{{ asset('images/folder.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_enter_data') }} </span> </a> </li>
          <li role="presentation" class="disabled"> <a href="#" title="Step 2"> <span class="round-tab"> <img src="{{ asset('images/star.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_currency_demo') }} </span> </a> </li>
          <li role="presentation" class="disabled"> <a href="#" title="Step 3"> <span class="round-tab"> <img src="{{ asset('images/edit.png') }}"> </span> <span class="tab-name">{{ trans('messages.keyword_colors__layouts') }} </span> </a> </li>
          <li role="presentation" class="disabled"> <a href="#" title="Complete"> <span class="round-tab"> <img src="{{ asset('images/list.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_optional') }} </span> </a> </li>
          <li role="presentation" class="disabled"> <a href="#" title="Complete"> <span class="round-tab"> <img src="{{ asset('images/media.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_media') }} </span> </a> </li>
        </ul>
      </div>

      <div id="success_message"></div>

      <div class="step-content">
        <div class="step-pane">
          <form role="form" name="step_1" class="text-center register-for-quiz-form" method="post">

          {{ csrf_field() }}
            <div class="form-group">
              <label for="usr"> {{ trans('messages.keyword_company_name') }}<p style="color:#f37f0d;display:inline">(*)</p> </label>
              <!-- <div class = "input-group"> -->
                <input type = "text" class = "form-control" name="nome_azienda" id="nome_azienda" placeholder="{{ trans('messages.keyword_enter_company_name') }} ">
                <span class = "input-group-addon" id="exist" style="display: none;"><a href="#" id="link" onclick="return confirm('{{ trans('messages.keyword_sure_exsting_entity') }} ?');"></a> {{ trans('messages.keyword_existing_entity') }} ? </span>
                <div id="confirm" style="display: none;"> 
                {{ trans('messages.keyword_do_you_want') }}  
                  <b id="oldente"> {{ trans('messages.keyword_old') }} </b> {{ trans('messages.keyword_or') }} 
                  <b id="newente"> 
                  {{ trans('messages.keyword_new') }} </b>
                </div>
                 <!-- </div> -->
                 
                <span id="span_azienda" style="display: none;"> {{ trans('messages.keyword_company_name_required') }}  </span>
            </div>
            <div class="form-group">
              <label for="ref-name"> {{ trans('messages.keyword_refname') }} <p style="color:#f37f0d;display:inline">(*)</p> </label>
              <input type="text" class="form-control" id="ref_name" name="ref_name" placeholder=" {{ trans('messages.keyword_enter_reference_name') }} ">
            </div>
            <span id="span_referente" style="display: none;"> {{ trans('messages.keyword_reference_name_required') }} </span>

            <div class="form-group" >
              <datalist id="settori"></datalist>
              <label for="sel1"> {{ trans('messages.keyword_commodity_sector') }}  <p style="color:#f37f0d;display:inline">(*)</p> </label>
               <input value="" list="settori" class="form-control" type="text" id="settore_merceologico" name="settore_merceologico" placeholder=" {{ trans('messages.keyword_search_industry') }} ">
            </div>
            <span id="span_settore" style="display: none;"> {{ trans('messages.keyword_commodity_sector_required') }} </span>
           
            <div class="form-group">
              <label for="Indirizzo"> {{ trans('messages.keyword_address') }} : <p style="color:#f37f0d;display:inline">(*)</p> </label>
              <input type="text" class="form-control" name="indirizzo" id="indirizzo" placeholder="{{ trans('messages.keyword_enter_address') }} ">
            </div>
            <span id="span_indirizzo" style="display: none;"> {{ trans('messages.keyword_address_required') }}  </span>

            <div class="form-group">
              <label for="Telefono"> {{ trans('messages.keyword_phone') }} : <p style="color:#f37f0d;display:inline">(*)</p> </label>
              <input type="text" name="telefono" class="form-control" id="telefono" placeholder=" {{ trans('messages.keyword_enter_phone') }} ">
            </div>
            <span id="span_telefono" style="display: none;"> {{ trans('messages.keyword_phone_required') }}  </span>

            <div class="form-group">
              <label for="email"> {{ trans('messages.keyword_email') }}: <p style="color:#f37f0d;display:inline">(*)</p> </label>
              <input type="email" name="email" class="form-control" id="email" placeholder=" {{ trans('messages.keyword_enter_email') }} " pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$">
            </div>
            <span id="span_email" style="display: none;"> {{ trans('messages.keyword_valid_email_required') }}  </span><p id="demo"></p>

            <div class="step-footer">
              <div class="dots"> <span class="dot active"> </span> 
              <span class="dot"> </span> <span class="dot"> </span> 
              <span class="dot"> </span> <span class="dot"> </span> 
              <span class="dot"> </span>
                <div class="page">1/7</div>
              </div>
              <ul class="list-inline">
                <li><a class="prev-step" id="prev_stepone"> {{ trans('messages.keyword_back') }} </a></li>
                <li><a href="#" class="next-step" id="step-one"> {{ trans('messages.keyword_next') }} </a> </li>
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
    $(document).ready(function () {

    $('#prev_stepone').click(function() {
      history.back();
    });

    $("#oldente").click(function(){
        
        var nome_azienda = $("#nome_azienda").val();
        var _token = $('input[name="_token"]').val();

        $.ajax({

          type:'POST',
          data: {
                  'nome_azienda': nome_azienda,
                  '_token' : _token
                },

          url: '{{ url('oldente') }}',
          success:function(data) {            
            document.location = "steptwo/" + data;           
          }

        });

    });

    $("#newente").click(function(){
      
      var nome_azienda = $("#nome_azienda").val(); 
      var ref_name = $("#ref_name").val();
      var settore_merceologico = $("#settore_merceologico").val();
      var indirizzo = $("#indirizzo").val(); 
      var telefono = $("#telefono").val(); 
      var email = $("#email").val();
      var _token = $('input[name="_token"]').val();

      $.ajax({
        type:'POST',
        data: {
                'nome_azienda': nome_azienda,
                'ref_name':ref_name,
                'settore_merceologico': settore_merceologico,
                'indirizzo': indirizzo,
                'telefono':telefono,
                'email': email,
                '_token' : _token
              },
        url: '{{ url('newente') }}',

        success:function(data) {
          document.location = "steptwo/" + data;
        }

      });

    });  

    $("#step-one").click(function(e){
        
        var nome_azienda = document.getElementById("nome_azienda");
        var ref_name = document.getElementById("ref_name");
        var settore_merceologico = document.getElementById("settore_merceologico");
        var indirizzo = document.getElementById("indirizzo");
        var telefono = document.getElementById("telefono");
        var email = document.getElementById("email");
        
        if (nome_azienda.value == '') {            
            document.getElementById("span_azienda").style.display = "block";
            document.getElementById("span_azienda").style.color = "red"; 
            nome_azienda.focus();        
            return false;

        } else if (ref_name.value == '') {
            document.getElementById("span_referente").style.display = "block";
            document.getElementById("span_referente").style.color = "red";
            document.getElementById("span_azienda").style.display = "none";
            ref_name.focus();
            return false;

        } else if (settore_merceologico.value == '') {           
            document.getElementById("span_settore").style.display = "block";
            document.getElementById("span_settore").style.color = "red";
            document.getElementById("span_referente").style.display = "none";
            settore_merceologico.focus();
            return false;

        } else if (indirizzo.value == '') {
            document.getElementById("span_indirizzo").style.display = "block";
            document.getElementById("span_indirizzo").style.color = "red";
            document.getElementById("span_settore").style.display = "none";
            indirizzo.focus();
            return false;

        } else if (telefono.value == '') {
            document.getElementById("span_telefono").style.display = "block";
            document.getElementById("span_telefono").style.color = "red";
            document.getElementById("span_indirizzo").style.display = "none";
            telefono.focus();           
            return false;

        } else if (email.value == '') {
            document.getElementById("span_email").style.display = "block";
            document.getElementById("span_email").style.color = "red";
            document.getElementById("span_telefono").style.display = "none";
            email.focus();         
            return false;
        }

        var mob = /^[1-9]{1}[0-9]{9}$/;
        if (mob.test(telefono.value) == false) {
            alert("{{ trans('messages.keyword_mobile_number_range') }} ");
            telefono.focus();
            return false;
        }
        
        var email = email.value;
        var atpos = email.indexOf("@");
        var dotpos = email.lastIndexOf(".");
        if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length){
          alert(" {{ trans('messages.keyword_valid_email_required') }} ");
          email.focus();
          return false;
        } else {
            document.getElementById("span_email").style.display = "none";
        }

        e.preventDefault();

          var nome_azienda = $("#nome_azienda").val(); 
          var ref_name = $("#ref_name").val();
          var settore_merceologico = $("#settore_merceologico").val();
          var indirizzo = $("#indirizzo").val(); 
          var telefono = $("#telefono").val(); 
          var email = $("#email").val();
          var _token = $('input[name="_token"]').val();
          
          $.ajax({
            type:'POST',
            data: {
                    'nome_azienda': nome_azienda,
                    'ref_name':ref_name,
                    'settore_merceologico': settore_merceologico,
                    'indirizzo': indirizzo,
                    'telefono':telefono,
                    'email': email,
                    '_token' : _token
                  },
            url: '{{ url('storeStepone') }}',
            success:function(data) {
              
               if(data == 'false'){
                  
                  $("#exist").css("display", "block");
                  $("#exist").css("color", "red");
                  $("#confirm").css("display", "block");
                  $("#confirm").css("color", "blue");

               } else {
                  
                  document.location = "steptwo/" + data;
               
               }             
            }
        });

     });

     // Carica i settori nel datalist dal file.json
    var datalist = document.getElementById("settori");
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(response) {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var json = JSON.parse(xhr.responseText);
            json.forEach(function(item) {
                var option = document.createElement('option');
                option.value = item;
                datalist.appendChild(option);
            });
        }
    }
    xhr.open('GET', "{{ asset('public/json/settori.json') }}", true);
    xhr.send();

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