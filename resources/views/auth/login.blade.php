@extends('layouts.app')
@section('content')
<style>
	#please_wait_bg{ 
	background: rgba(0, 0, 0, 1) ;
    height: 100%;
    left: 0;
    position: fixed;
	display:none;
    top: 0;
    transition: all 0.3s ease 0s;
    width: 100%;
	opacity:0.85;
    z-index: 10;}
	
	#please_wait
	{
		position:fixed;
		z-index:1000;
		text-align:center;
		margin:0 auto;
		display:none;
		text-align:center;
		background-color:transparent;
		font-size:16px;
		vertical-align:middle;
/*		box-shadow:0px 0px 10px 1px #333;*/
		z-index:13;
		padding:50px 0;
		top: 50%;
    transform: translateX(-50%) translateY(-50%);
backface-visibility: hidden;
    height: auto;
    left: 50%;
    max-width:1040px;
    min-width: 320px;    width: 60%;
		
	}
	.height1{ background-color:#f2f2f2; min-height:110vh;}
	
	
	/************popup country css***/
	.language-wrap .language-wrap {
  display: inline-block;
  margin-bottom: 60px;
  margin-right: 50px;
}
.language-wrap h1 {
  color: #fff;
  margin-bottom: 60px;
}


/**********************/
.lang-select {
  position: relative;
}
.lang-select > img {
  height: 20px;
  max-width: 100%;
  position: absolute;
  right: 5px;
  top: 9px;
  width: auto;
}
.login-form .form-group input {
  padding: 0 36px 0 12px;
}

</style>
<?php         $valueCode = (session()->has('locale'))?session('locale'):'en';
			$allLanguages = DB::table('languages')
							->select('*')
							->where('is_deleted', '0')
							->get();	
      $currentLanguages = DB::table('languages')
              ->select('*')
              ->where('code', $valueCode)
              ->first();  
        
				?>

<div class="">
	<div class="height-width100">
    	<div class="login-wrap">
        	<div class="logo-langa-login"><img src="{{ url('http://betaeasy.langa.tv/storage/app/images/logo/LOGO_Easy_LANGA_without_contour.svg')}}"  height="150" width="150"/></div> <br></br> 
            <div class="login-form">
            	   <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                            {{ csrf_field() }}
                	<div class="form-group">
                      	<div class="lang-select"> <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="{{ucwords(trans('messages.keyword_email'))}}" required="required">
                                   
                        <img src="{{url('storage/app/images/languageicon/').'/'.$currentLanguages->icon}}" alt="Country" onclick="showHide()"/></div>
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
                                        
                                            <input type="checkbox" id="logincheck" name="remember">
                                        <label for="logincheck"><?php echo Lang::get('messages.keyword_remember_me'); ?></label>
                                    </div>
                    </div>
                    <div class="login-btn">
                    <button type="submit" class="btn btn-warning">{{trans('messages.keyword_log_in')}}</button>
                    <a class="btn btn-warning" href="{{ url('/register') }}">{{ trans('messages.keyword_register_here') }}</a> 
                    <a class="btn btn-warning" href="http://www.easyinfo.langa.tv" target="_blank"><img src="{{ url('storage/app/images/logo/information.svg')}}" width="25px"/><small><small><small>   MOBILE</small></small></small></a>
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
        @foreach($allLanguages as $langs)
        	<div class="language-wrap"><img src="{{url('storage/app/images/languageicon/').'/'.$langs->icon}}" alt="{{$langs->code}}" class="lang-img" width="100"/></div>
            @endforeach 
            
        </div>
    </div>
</div>
<div id="please_wait_bg" onclick="showHide()">
</div>
<script src="{{ url('public/scripts/jquery.min.js')}}"></script>
<script type="text/javascript">
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

$('.lang-img').click(function(){
	
	//$(this).find('img').attr(alt);
	var locale=$(this).attr('alt');
	 showHide();
	     var saveData = $.ajax({
                type: "GET",
                url: "{{url('language')}}",
                data: {locale:locale},
                dataType: "json",
                success: function(resultData){
                 
                },
                complete: function(){
                  window.location.reload(true);
                }
              });

});
</script>
@endsection
