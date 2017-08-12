@extends('layouts.app')
@section('content')



<div class="">
	<div class="height-width100">
    	<div class="login-wrap">
        	<div class="logo-langa-login"><img src="{{ url('storage/app/images/logo/LOGO_Easy_LANGA_without_contour.svg')}}"  height="150" width="150"/></div>
            <div class="login-form">
            	   <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                            {{ csrf_field() }}
                	<div class="form-group">
                      	<div class="lang-select"> <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="{{ucwords(trans('messages.keyword_email'))}}" required="required">
                                   
                        <img src="{{url('public/images/country4.png')}}" alt="Country" onclick="showHide()"/></div>
                         @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                    </div>
                    <div class="form-group">
                     <input id="password" type="password" class="form-control" name="password" placeholder="{{ucfirst(trans('messages.keyword_password'))}}" required="required">
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                    </div>
                    <div class="form-group">
                    <div class="checkbox">
                                        
                                            <input type="checkbox" id="logincheck" name="remember"><span><?php echo Lang::get('messages.keyword_remember_me'); ?></span>
                                        <label for="logincheck"></label>
                                    </div>
                    </div>
                    <div class="login-btn">
                    <button type="submit" class="btn btn-warning">{{trans('messages.keyword_log_in')}}</button>
                    <a class="btn btn-warning" href="{{ url('/register') }}">{{ trans('messages.keyword_register_here') }}</a>
                    <a class="btn btn-warning" href="Javascript:void(0);"><img src="{{ url('storage/app/images/logo/information.svg')}}"/></a>
                    </div>
                    
                    <div class="forgot-pass"><a href="{{ url('/password/reset') }}">{{trans('messages.keyword_did_you_forget_your_password?')}}</a></div>
                    
                </form>
                
                
                <div class="access-social">
                	<p class="text">Access with your social</p>
                	<a href="{{url('redirect/google')}}" class="btn btn-warning"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
                    <a href="{{url('redirect/twitter')}}" class="btn btn-warning"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                    <a href="{{url('redirect/facebook')}}" class="btn btn-warning"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                </div>
                
            </div>
        </div>
    </div>
</div>


<!---popup--->
<div id="please_wait">
	<div class="language-wrap">
		<h1>Choose your language</h1>
        <div class="language-img-wrap">
        	<div class="language-wrap"><img src="images/country1.png"/></div>
            <div class="language-wrap"><img src="images/country2.png"/></div>
            <div class="language-wrap"><img src="images/country3.png"/></div>
             <div class="language-wrap"><img src="images/country4.png"/></div>
              <div class="language-wrap"><img src="images/country5.png"/></div>
              <div class="language-wrap"><img src="images/country6.png"/></div>
              <div class="language-wrap"><img src="images/country7.png"/></div>
              <div class="language-wrap"><img src="images/country8.png"/></div>
              <div class="language-wrap"><img src="images/country9.png"/></div>
              <div class="language-wrap"><img src="images/country10.png"/></div>
              <div class="language-wrap"><img src="images/country11.png"/></div>
              <div class="language-wrap"><img src="images/country12.png"/></div>
        </div>
    </div>
</div>
<div id="please_wait_bg" onclick="showHide()">
</div>

<script>
function showHide(){
	var el = document.getElementById("please_wait");
	var bg = document.getElementById("please_wait_bg");
    if( el && el.style.display == 'block')    
        el.style.display = 'none';
    else 
        el.style.display = 'block';
		
	if( bg && bg.style.display == 'block'){    
        bg.style.display = 'none';
		jQuery(window).unbind('scroll');
		  
	}
    else {
        bg.style.display = 'block';
		jQuery(window).scroll(function() { return false; });
	}
}

</script>
@endsection
