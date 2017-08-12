@extends('layouts.app')

@section('content')



<?php if (Session::has('reg_user_id')) {
    $reg_user_id = Session::get('reg_user_id');
    $reg_user =  DB::table('users')->where('id', $reg_user_id)->first();
}
?>




 <!-- top -->

 <div class="login-process-step">
<div class="navigation-root">
    <ul class="navigation-list">
        <li class="navigation-item navigation-previous-item  <?php echo (!isset($reg_user->name))?'navigation-active-item':'' ?>" id="firstst"></li>
        <li class="navigation-item <?php echo (isset($reg_user->name))? 'navigation-previous-item navigation-active-item':'' ?>" id="secondst"></li>
        <li class="navigation-item" id="thirdst"></li>
        <li class="navigation-item" id="fourthst"></li>
        <li class="navigation-item" id="fifthst"></li>
       
    </ul>
</div>
</div> 

<!-- Sign Up -->

<div class="row sign-in sign-up-step-three" id="first-step" <?php if(isset($reg_user->name)) { ?> style="display: none;" <?php } ?> >

    <div class="col-md-12">
        <div class="signin-innr">
        <h3>{{ trans('messages.keyword_sign_in_to_langa') }}</h3>
        <form name="signupForm" id="signupForm" role="form" method="POST" action="{{ url('/register') }}">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <div class="label-box"><label>
                        {{ trans('messages.keyword_firstname') }} 
                        <p style="color:#f37f0d; display:inline">(*)</p>
                        </label></div>
                        <div class="txt-box"><input id="firstname" name="firstname" type="text" class="form-control" placeholder="{{ trans('messages.keyword_firstname') }}" value="@isset($reg_user->name) {{ $reg_user->name }} @endisset" /></div>
                    </div>
                    <span id="span_firstname" style="display: none;"> 
                    {{ trans('messages.keyword_firstname_not_null') }} 
                    </span>
                </div>
                
             
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <div class="label-box"><label>{{ trans('messages.keyword_lastname') }} <p style="color:#f37f0d; display:inline">(*)</p></label></div>
                        <div class="txt-box"><input id="lastname" name="lastname" type="text" class="form-control" placeholder="{{ trans('messages.keyword_lastname') }}" value="@isset($reg_user->name) {{ $reg_user->name }} @endisset" /></div>
                        <span id="span_lastname" style="display: none;"> 
                        {{ trans('messages.keyword_lastname_not_null') }} 
                        </span>
                    </div>
                </div>
               
            </div>
            
            <div class="form-group">
                <div class="label-box"><label>{{ trans('messages.keyword_email') }} <p style="color:#f37f0d; display:inline">(*)</p></label></div>
                <div class="txt-box"><input id="email" name="email" type="text" class="form-control" placeholder="{{ trans('messages.keyword_email') }}" value="@isset($reg_user->email) {{ $reg_user->email }} @endisset" /></div>
            </div>
            <span id="span_email" style="display: none;"> 
                {{ trans('messages.keyword_email_not_null') }} 
            </span>
            
            <div class="form-group">
                <div class="label-box"><label>{{ trans('messages.keyword_password') }} <p style="color:#f37f0d; display:inline">(*)</p></label></div>
                <div class="txt-box"><input id="password" name="password" type="password" class="form-control" placeholder="{{ trans('messages.keyword_password') }}" value="@isset($reg_user->password) {{ $reg_user->password }} @endisset" /></div>
            </div>
            <span id="span_password" style="display: none;"> 
                {{ trans('messages.keyword_password_not_null') }} 
            </span>

   
            <div class="password-strong"><b class="line1"></b><b class="line2"></b><b class="line3"></b><b class="line4"></b></div>
            
            <!-- Capcta here  -->
            
            <div class="newhere"><p> {{ trans('messages.keyword_creating_account_agree') }} <a href="#"> {{ trans('messages.keyword_privacy_policy') }} </a></p></div>
            
            <div class="form-group">
                <a href="#" class="btn btn-warning" id="create_account">
                <!--<i class="fa fa-btn fa-sign-in"></i> --> {{ trans('messages.keyword_create_account_continue') }} </a>
            </div>
        </form>
            <div class="newhere"><p> {{ trans('messages.keyword_already_got_an_account') }} ? <a href="{{ url('login') }}" class="login-process-pra"> {{ trans('messages.keyword_sign_in_here') }} </a></p></div>
        </div>
    </div>
</div>


<!--  step 2 -->

<div class="row signup-process-four" id="second-step"  <?php if(isset($reg_user->name)) { ?> style="display: block;" <?php } else { ?> style="display: none;" <?php  } ?>>
<div class="signup-process-innr">
<h3> {{ trans('messages.keyword_welcome_to_step') }} 2</h3>
<form id="second-step-form" name="second-step-form">
    
    <input type="hidden" id="user_id_two" name="user_id_two" value="@isset($reg_user_id) {{ $reg_user_id }} @endisset">

    <?php $roles = DB::table('ruolo_utente')->where('is_delete', 0)->get(); ?>

    <div class="form-group">
        <div class="label-box">
        <label>{{ trans('messages.keyword_department') }} <p style="color:#f37f0d; display:inline">(*)</p>

         <span id="span_role" style="display: none;"> 
                {{ trans('messages.keyword_please_select_a_role') }} 
        </span>

        </label>
        </div>
    </div>

    @foreach($roles as $role)
    <div class="form-group">
        <div class="radio-question">
        <input class="radio-button-radio" value="{{ $role->ruolo_id }}" name="role" id="role_{{ $role->ruolo_id }}" type="radio">
        <label for="role_{{ $role->ruolo_id }}" class="radio-button-label"> {{ $role->nome_ruolo }}
            <div class="radio-button-check">
                <div class="radio-button-innr"></div>
            </div>
        </label>
        </div>
    </div>
    @endforeach
	<div class="row">
    <div class="col-lg-6">
        <a href="#" class="btn btn-warning" id="steptwo_back">
            {{ trans('messages.keyword_back') }}
        </a>
    </div>

    <div class="col-lg-6 text-right">
        <a href="#" class="btn btn-warning" id="steptwo_next">
            {{ trans('messages.keyword_next') }}
        </a>
    </div>
    </div>
    
</form>
</div>
</div>

<!-- Step 3 -->

<div class="row signup-process-four" id="third-step" style="display: none;" >
<div class="signup-process-innr" >
<h3> {{ trans('messages.keyword_welcome_to_step') }} 3 </h3>

    <form id="third-step-form" name="third-step-form"> 

        <?php $states = DB::table('stato')->select('id_stato', 'nome_stato')->get(); ?>

        <input type="hidden" id="user_id_three" name="user_id_three" value="@isset($reg_user_id) {{ $reg_user_id }} @endisset">

            <div class="form-group">
                <div class="label-box"><label>{{ trans('messages.keyword_state') }}
                </label></div>
                <div class="txt-box">
                <select id="state" class="form-control" name="state">
                    <option style="background-color:white" selected disabled>
                    -- {{ trans('messages.keyword_selectstate') }} --
                    </option>
                    @foreach($states as $state)
                        <option value="{{ $state->id_stato }}"> {{ ucwords(strtolower($state->nome_stato)) }}  </option>
                    @endforeach                    
                </select>
                </div>
            </div>

            <div class="form-group">
                <div class="label-box"><label>{{ trans('messages.keyword_city') }}
                </label></div>
                <div class="txt-box">
                    <select id="city" class="form-control " name="city">
                        <option style="background-color:white" selected disabled>
                        -- {{ trans('messages.keyword_selectcity') }} --
                    </select>
                </div>
            </div>            
        
       <div class="row">
    <div class="col-lg-6">
            <a href="#" class="btn btn-warning" id="stepthree_back">
                {{ trans('messages.keyword_back') }}
            </a>
        </div>

    
    <div class="col-lg-6 text-right">
            <a href="#" class="btn btn-warning" id="stepthree_next">
                {{ trans('messages.keyword_next') }}
            </a>
        </div>
        </div>

    </form>
    </div>
</div>


<!-- step 4 -->

<div class="row signup-process-five" id="forth-step" style="display: none;">
<div class="signup-process-innr">
<h3>{{ trans('messages.keyword_welcome_to_step') }} <span id="four_four" style="display: none;"> 4 </span> <span id="four_three" style="display: none;"> 3 </span>

 </h3>

<form id="forth-step-form" name="forth-step-form">

<input type="hidden" id="user_id_forth" name="user_id_forth" value="@isset($reg_user_id) {{ $reg_user_id }} @endisset">
    
    <div class="form-group">
        <div class="label-box"><label>{{ trans('messages.keyword_image') }} </label></div>
        <div class="txt-box">
        <label for="logo">Browse...</label>
        <input id="logo" name="logo" type="file" class="form-control" placeholder="{{ trans('messages.keyword_image') }} " /></div>
    </div>

    <div class="form-group">
        <div class="label-box"><label>{{ trans('messages.keyword_color') }} </label></div>
        <div class="txt-box"><input class="form-control color no-alpha" value="#f37f0d" name="color" id="color" placeholder="{{ trans('messages.keyword_color') }}" />
        </div>
    </div>

    <div class="form-group">
        <div class="label-box"><label>{{ trans('messages.keyword_cell') }} </label></div>
        <div class="txt-box"><input id="cellphone" name="cellphone" type="text" class="form-control" placeholder="{{ trans('messages.keyword_cell') }}" /></div>
    </div>

   <div class="row">
    <div class="col-lg-6">
        <a href="#" class="btn btn-warning" id="stepfour_back">
            {{ trans('messages.keyword_back') }}
        </a>
    </div>

    <div class="col-lg-6 text-right">
        <a href="#" class="btn btn-warning" id="stepfour_next">
        {{ trans('messages.keyword_next') }}</a>
    </div>
    </div>
    
</form>
</div>
</div>

<!--  step 5 -->

<div class="row signup-process-four" id="fifth-step" style="display: none;">
<div class="signup-process-innr">
<h3> {{ trans('messages.keyword_welcome_to_step') }} 
<span id="five_five" style="display: none;"> 5 </span>
<span id="five_four" style="display: none;"> 4 </span>
 </h3>
<form>

   <div class="form-group m-select lblshow">
        <input name="iagree" id="iagree" type="checkbox">
        <label for="iagree"> I Agree </label>
    </div>

     <div class="row">
    <div class="col-lg-6">
        <a href="#" class="btn btn-warning" id="stepfive_back">
            {{ trans('messages.keyword_back') }}
        </a>
    </div>

    <div class="col-lg-6 text-right">
        <a href="#" class="btn btn-warning" id="submit">
        {{ trans('messages.keyword_submit') }} 
        </a>
    </div>
    </div>

</form>
</div>
</div>

<!-- script -->

<script src="{{ url('public/scripts/jquery.min.js')}}"></script>
<!-- jQuery validation js --> 
<script src="http://localhost/easylanganew/public/scripts/jquery.validate.min.js"></script> 
<script type="text/javascript" src="{{asset('public/scripts/colors.js')}}"></script>
<script type="text/javascript" src="{{asset('public/scripts/jqColorPicker.min.js')}}"></script>

<script type="text/javascript"> 
    $('.color').colorPicker();   
</script>

<script type="text/javascript">

    $(document).ready(function() {
		$('.container').addClass('register-wrap');

        $('#steptwo_back').click(function() {        
            $('#second-step').css('display', 'none');
            $('#first-step').css('display', 'block'); 
        });

        $('#stepthree_back').click(function() {
            $('#third-step').css('display', 'none');
            $('#second-step').css('display', 'block'); 
        });

        $('#stepfour_back').click(function() {
            $('#forth-step').css('display', 'none');
            $('#third-step').css('display', 'block'); 
        });

        $('#stepfive_back').click(function() {
            $('#fifth-step').css('display', 'none');
            $('#forth-step').css('display', 'block');
        });

        $('#create_account').on('click', function(){       

            var firstname = $('#firstname').val();
            var lastname = $('#lastname').val();
            var email = $('#email').val();           
            var password = $('#password').val();

            if (firstname == '') {
                document.getElementById("span_firstname").style.display="block";
                document.getElementById("span_firstname").style.color = "red";
				 document.getElementById("span_firstname").style.marginBottom = "8px";
                $('#firstname').focus();        
                return false;

            } else if (lastname == '') {            
                document.getElementById("span_lastname").style.display="block";
                document.getElementById("span_lastname").style.color = "red";
				 document.getElementById("span_lastname").style.marginBottom = "8px";
                document.getElementById("span_firstname").style.display="none";
                $('#lastname').focus();        
                return false;

            } else if (email == '') {            
                document.getElementById("span_email").style.display="block";
                document.getElementById("span_email").style.color = "red";
				document.getElementById("span_email").style.marginBottom = "8px";
                document.getElementById("span_lastname").style.display="none";
                $('#email').focus();        
                return false;

            } else if (password == '') {            
                document.getElementById("span_password").style.display="block";
                document.getElementById("span_password").style.color = "red";
				document.getElementById("span_password").style.marginBottom = "8px";
                document.getElementById("span_email").style.display="none";
                $('#password').focus();        
                return false;
            } 

            var atpos = email.indexOf("@");
            var dotpos = email.lastIndexOf(".");
            if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length){
              alert(" {{ trans('messages.keyword_valid_email_required') }} ");
              email.focus();
              return false;
            } 

            $.ajax({            
                url: '{{ url('register') }}',
                type:'POST',
                data: { 'firstname': firstname, 'lastname': lastname, 
                        'email': email, 'password': password, '_token': '{{ csrf_token() }}' 
                    },              
                success:function(data) { 
                    if(data == 1){                        
                        $('#second-step').css('display', 'block');
                        $('#first-step').css('display', 'none');
						$('#firstst').removeClass('navigation-active-item');
						$('#secondst').addClass('navigation-previous-item');
						$('#secondst').addClass('navigation-active-item');
                    } else {
                        var data = $.parseJSON(data); 
                        var user_id = data.id;           
                        if(user_id) { location.reload(); }
                    }
                },
                error: function (request, status, error) {
                    alert(request.responseText);
                   
                }
            });
        });

		$('#logo').change(function() {
		  var i = $(this).prev('label').clone();
		  var file = $('#logo')[0].files[0].name;
		  $(this).prev('label').text(file);
		});


		$('#second-step-form .radio-button-radio').click(function(){
			$('.form-group').removeClass('selected');
			if($(this).prop('checked')==true)
			{
				$(this).parents('.form-group').addClass('selected');
			}
		});
        $('#steptwo_next').on('click', function(){       
            
            var role = $("input[name='role']:checked").val();  
            var user_id = $('#user_id_two').val(); 

            if(role == null){
                document.getElementById("span_role").style.display="block";
                document.getElementById("span_role").style.color = "red";
				document.getElementById("span_role").style.marginBottom = "8px";
				
                return false;
            } 
                   
            $.ajax({            
                url: '{{ url('registration-step-two') }}',
                type:'POST',
                data: { 'role': role, 'user_id' : user_id, '_token': '{{ csrf_token() }}' 
                    },              
                success:function(data) { 
                    console.log(data);
                    if(data != 'false'){
                        var data = $.parseJSON(data);
                        var user_id = data.id;     
                        var role_dept = data.dipartimento;
                        $('#user_id_three').val(user_id);                        
                         if(role_dept ==2 || role_dept == 4 || role_dept == 5) {
                            $('#third-step').css('display', 'block');
                            $('#second-step').css('display', 'none');
                            $('#five_five').css('display', 'inline-block');
							$('#four_four').css('display', 'inline-block');
							 $('#four_three').css('display', 'none');
                            $('#five_four').css('display', 'none');
							$('.login-process-step').removeClass('four-sign');
                        }  else {
                            $('#forth-step').css('display', 'block');
                            $('#second-step').css('display', 'none');
							 $('#five_five').css('display', 'none');
							$('#four_four').css('display', 'none');
                            $('#four_three').css('display', 'inline-block');
                            $('#five_four').css('display', 'inline-block');
							$('.login-process-step').addClass('four-sign');
                            $('#user_id_forth').val(user_id);
                        }
						$('#secondst').removeClass('navigation-active-item');
						$('#thirdst').addClass('navigation-previous-item');
						$('#thirdst').addClass('navigation-active-item');
                    } 
                    if(data == 'false'){
                        alert("this value is aleady save.");
                    } 
                }
            });
        });

        $('#stepthree_next').on('click', function(){       
            
            var city = $('#city').val();
            var state = $('#state').val();
            var user_id_three = $('#user_id_three').val();

            $.ajax({            
                url: '{{ url('registration-step-three') }}',
                type:'POST',
                data: { 'city': city, 'state': state, '_token': '{{ csrf_token() }}', 'user_id_three' : user_id_three
                },              
                success:function(data) {                      
                    if(data != 'false'){
                        var data = $.parseJSON(data);
                        var user_id = data.id;     
                        var role_dept = data.dipartimento;
                        $('#user_id_forth').val(user_id);
                        $('#forth-step').css('display', 'block');
                        $('#second-step').css('display', 'none'); 
                        $('#third-step').css('display', 'none'); 
                    }  
                    if(data == 'false'){
                        alert("this value is aleady save.");
                    }                   
                }
            });
        });

        $('#stepfour_next').on('click', function(){       
            
            var color = $('#color').val();
            var cellphone = $('#cellphone').val();
            var logo = $('#logo').val();
            var user_id_forth = $('#user_id_forth').val();

            var mob = /^[1-9]{1}[0-9]{9}$/;
            if (cellphone != false) {
                if (mob.test(cellphone) == false) {
                    alert("{{ trans('messages.keyword_mobile_number_range') }} ");
                    $('#cellphone').focus();
                    return false;
                }
            }

            $.ajax({            
                url: '{{ url('registration-step-four') }}',
                type:'POST',
                data: { 'color': color, 'cellphone': cellphone, 'logo': logo,'_token': '{{ csrf_token() }}', 'user_id_forth' : user_id_forth
                },              
                success:function(data) {                      
                    if(data != 'false'){
                        var data = $.parseJSON(data);
                        var user_id = data.id;     
                        var role_dept = data.dipartimento;                       
                        $('#fifth-step').css('display', 'block');
                        $('#forth-step').css('display', 'none'); 
                    }
                    if(data == 'false'){
                        alert("this value is aleady save.");
                    } 
                }
            });
        });

        $('#submit').on('click', function(){  
            var iagree = $('#iagree').val();
            if($('#iagree').prop("checked") == false){
                alert("{{ trans('messages.keyword_please_check_i_agree ') }} ");
            } else{
                window.location = "<?php /*Session::forget('reg_user_id'); Session::forget('reg_user_role');*/ echo url('/login'); ?>";
            }           
        });

        $('select[name="state"]').on('change', function() {

            var stateID = $(this).val();
            if(stateID) {

                $.ajax({
                    url: '{{ url('/cities/') }}'+ '/' + stateID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('select[name="city"]').empty();
                         $('select[name="city"]').append('<option style="background-color:white" selected disabled>-- {{ trans('messages.keyword_selectcity') }} --</option>');
                        $.each(data, function(key, value) {
                            $('select[name="city"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            }else{
                $('select[name="city"]').empty();
            }
        });

    });
</script>
@endsection
