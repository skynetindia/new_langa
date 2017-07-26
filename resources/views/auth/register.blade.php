@extends('layouts.app')

@section('content')

<!--------------Script Required for Animation ------------>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.1/TweenMax.min.js"></script>

<div class="">

	<div class="login-process-step">
<div class="navigation-root">
    <ul class="navigation-list">
        <li class="navigation-item navigation-previous-item  navigation-active-item" id="firstst"></li>
        <li class="navigation-item " id="secondst"></li>
        <li class="navigation-item" id="thirdst"></li>
        <li class="navigation-item" id="fourthst"></li>
        <li class="navigation-item" id="fifthst"></li>
       
    </ul>
</div>
</div>

<div class="reg-step-two">
	<div class="height-width100">
    	<div class="registration-wrap">
        <div class="row">
        	<div class="col-md-6 col-sm-12 col-xs-12">
            	<div class="registrtion-left-side firstpart" id="firstpart">
                    <div class="heading"><img src="{{url('storage/app/images/logo/langa-logo1.png')}}"/> <h1><b>langa</b> group</h1> </div>
                    <div class="registration-content heading"><h3>Let's get started!</h3><p>Three things you need to know about being an envato author.</p></div>
                    <div class="registration-content">
                    	<h3>We live for quality and originality</h3>
                    	<p>Only the best authors and items make it through our review process.<br>
                        This way we make sure that all products meet our quality and<br> originally standards.</p>
                     </div>
                    <div class="registration-content"><h3>Make it clear and meaningful.</h3>
                    		<p>Only the best authors and items make it through our review process.<br>
                        This way we make sure that all products meet our quality and<br> originally standards.</p>
                        </div>
                    
                    <div class="i-agree"><a href="Javascript:void(0);" onclick="fun_next();" class="btn btn-warning">I agree, sign me up!</a>
                    <p>By continuing you agree to the Envato Market author terms and Envato Elements contributor terms.</p>
                    </div>
                    
                </div>
                <div class="registrtion-left-side reg-step-3 none secondpart" id="secondpart">
                    <div class="heading"><img src="{{url('storage/app/images/logo/langa-logo1.png')}}"/> <h1><b>langa</b> group</h1> </div>
                        <div class="registration-content heading"><h3>Create your Easy User</h3></div>
                       	
                       <form name="signupForm" id="signupForm" role="form" method="POST" action="{{ url('/register') }}">
                        	<div class="row">
                            	<div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                       <input id="firstname" name="firstname" type="text" class="form-control" placeholder="{{ trans('messages.keyword_firstname') }}" value="@isset($reg_user->name) {{ $reg_user->name }} @endisset" />
                                    </div>
                                     <span id="span_firstname" style="display: none;"> 
                                    {{ trans('messages.keyword_firstname_not_null') }} 
                                    </span>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                  <div class="form-group">
                                   <input id="lastname" name="lastname" type="text" class="form-control" placeholder="{{ trans('messages.keyword_lastname') }}" value="@isset($reg_user->name) {{ $reg_user->name }} @endisset" />
                                  </div>
                                    <span id="span_lastname" style="display: none;"> 
                        {{ trans('messages.keyword_lastname_not_null') }} 
                        </span>
                                </div> 
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                  <div class="form-group">
                                   <input id="email" name="email" type="text" class="form-control" placeholder="{{ trans('messages.keyword_email') }}" value="@isset($reg_user->email) {{ $reg_user->email }} @endisset" />
                                  </div>
                                   <span id="span_email" style="display: none;"> 
                {{ trans('messages.keyword_email_not_null') }} 
            </span>
                                </div> 
                                
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                  <div class="form-group">
                                   <input id="username" name="username" type="text" class="form-control" placeholder="{{ trans('messages.keyword_username') }}" value="@isset($reg_user->username) {{ $reg_user->username }} @endisset" />
                                  </div>
                                  <span id="span_username" style="display: none;"> 
                {{ trans('messages.keyword_username_not_null') }} 
            </span>
                                </div> 
                                
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                  <div class="form-group">
                                   <input id="password" name="password" type="password" class="form-control" placeholder="{{ trans('messages.keyword_password') }}" value="@isset($reg_user->password) {{ $reg_user->password }} @endisset" />
                                  </div>
                                  <span id="span_password" style="display: none;"> 
                                {{ trans('messages.keyword_password_not_null') }} 
                            </span>
                                </div> 
                                
                                <div class="col-md-12 col-sm-12 col-xs-12"><div class="form-group"><div class="capcha-block"></div></div></div>
                                 
                                 <div class="col-md-12 col-sm-12 col-xs-12">
                                 	<div class="privacy-blk">
                                    	<p>By creating an account you agree to our <a href="#">Privacy Policy</a></p>
                                        <button type="submit" class="btn btn-warning" id="create_account">Create account and countinue</button>
                                        <p>Already got an account? <a href="{{ url('/register') }}">Sign in here</a></p>
                                    </div>
                                 </div>   
                                 
                             </div>   
                        </form>
                       
                       
                    </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12">
            	<div class="registrtion-right-side firstpart" id="rightone">
             <div class="rocketman-wrapper">  
             	<div class="extra-wrapper"> 	
				  <svg version="1.1" class="rocketManSVG" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" x="0px" y="0px" viewBox="0 0 600 600" xml:space="preserve">

    <defs>
      <path id="rocketClip" d="M300,465.7L300,465.7c-13.8,0-25-11.3-25-25V249.4c0-13.7,11.3-25,25-25h0c13.7,0,25,11.2,25,25v191.3
			C325,454.5,313.8,465.7,300,465.7z" />
      <clipPath id="rainbowClip">
        <use xlink:href="#rocketClip" overflow="visible" />
      </clipPath>
      <symbol id="badge">

        <circle fill="#1668B2" stroke="#EF3D43" stroke-width="1.4389" stroke-miterlimit="10" cx="319.6" cy="288.9" r="8.7" />
        <g>
          <g>
            <path fill="#FFFFFF" d="M319.6,294.7L319.6,294.7c-1.7,0-2.8-0.9-2.6-1.9c0.5-2.6,0.9-5.2,1.4-7.8c0.2-1,0.4-2.8,1.2-2.8
					c0,0,0,0,0,0c0.8,0,1,1.8,1.2,2.8c0.5,2.6,0.9,5.2,1.4,7.8C322.5,293.8,321.3,294.6,319.6,294.7z" />
          </g>
          <path fill="#FFFFFF" d="M316.4,294.2L316.4,294.2c-0.4,0-0.8-0.3-0.8-0.8v-3.3c0-0.4,0.3-0.8,0.8-0.8l0,0c0.4,0,0.8,0.3,0.8,0.8
				v3.3C317.2,293.9,316.9,294.2,316.4,294.2z" />
          <path fill="#FFFFFF" d="M322.8,294.2L322.8,294.2c-0.4,0-0.7-0.3-0.7-0.7v-3.3c0-0.4,0.3-0.7,0.7-0.7l0,0c0.4,0,0.7,0.3,0.7,0.7
				v3.3C323.6,293.9,323.2,294.2,322.8,294.2z" />
        </g>

        <g>
          <circle fill="#FFFFFF" cx="314" cy="288.3" r="0.7" />
          <ellipse fill="#FFFFFF" cx="314" cy="288.3" rx="0.1" ry="1.2" />
          <ellipse fill="#FFFFFF" cx="314" cy="288.3" rx="1.3" ry="0.1" />
        </g>
        <g>
          <circle fill="#FFFFFF" cx="324.8" cy="286.4" r="0.7" />
          <ellipse fill="#FFFFFF" cx="324.8" cy="286.4" rx="0.1" ry="1.2" />
          <ellipse fill="#FFFFFF" cx="324.8" cy="286.4" rx="1.3" ry="0.1" />
        </g>

      </symbol>
    </defs>

    <polygon class="star" opacity="0.5" fill="#ECB447" points="1.2,0 1.6,0.8 2.4,0.9 1.8,1.5 1.9,2.3 1.2,1.9 0.5,2.3 0.6,1.5 0,0.9 0.8,0.8 " />
    <g class="starContainer"></g>
    <g class="satellite">
      <g class="satellitePulses" stroke="#2d2d2d">
        <path class="satellitePulse1" fill="none" stroke-width="1.5814" stroke-linejoin="round" stroke-miterlimit="10" d="M156.3,131.8
		c-2.8,2.8-7.2,2.8-10,0" />
        <path class="satellitePulse2" fill="none" stroke-width="1.5814" stroke-linejoin="round" stroke-miterlimit="10" d="M158.6,134
		c-4,4-10.5,4-14.4,0" />
        <path class="satellitePulse3" fill="none" stroke-width="1.5814" stroke-linejoin="round" stroke-miterlimit="10" d="M160.8,136.3
		c-5.2,5.2-13.7,5.2-18.9,0" />
      </g>
      <path fill="#2d2d2d" d="M106.7,91.3h-8.2v-8.2h8.2V91.3z M116.8,83.1h-8.2v8.2h8.2V83.1z M126.8,83.1h-8.2v8.2h8.2V83.1z
	 M136.9,83.1h-8.2v8.2h8.2V83.1z M106.7,93.2h-8.2v8.2h8.2V93.2z M116.8,93.2h-8.2v8.2h8.2V93.2z M126.8,93.2h-8.2v8.2h8.2V93.2z
	 M136.9,93.2h-8.2v8.2h8.2V93.2z M106.7,103.3h-8.2v8.2h8.2V103.3z M116.8,103.3h-8.2v8.2h8.2V103.3z M126.8,103.3h-8.2v8.2h8.2
	V103.3z M136.9,103.3h-8.2v8.2h8.2V103.3z M173.7,83.1h-8.2v8.2h8.2V83.1z M183.8,83.1h-8.2v8.2h8.2V83.1z M193.8,83.1h-8.2v8.2h8.2
	V83.1z M203.9,83.1h-8.2v8.2h8.2V83.1z M173.7,93.2h-8.2v8.2h8.2V93.2z M183.8,93.2h-8.2v8.2h8.2V93.2z M193.8,93.2h-8.2v8.2h8.2
	V93.2z M203.9,93.2h-8.2v8.2h8.2V93.2z M173.7,103.3h-8.2v8.2h8.2V103.3z M183.8,103.3h-8.2v8.2h8.2V103.3z M193.8,103.3h-8.2v8.2
	h8.2V103.3z M203.9,103.3h-8.2v8.2h8.2V103.3z M161.8,113.1V81c0-2.6-2.1-4.7-4.7-4.7h-11.7c-2.6,0-4.7,2.1-4.7,4.7v32.1
	c0,2.6,2.1,4.7,4.7,4.7h11.7C159.7,117.8,161.8,115.7,161.8,113.1z M165.6,96.3h-28.7v2.1h28.7V96.3z M152.3,117.8h-2.2v12.1h2.2
	V117.8z" />
    </g>


    <g class="speedLines" stroke="#3e3e3e" stroke-width="2" stroke-linejoin="round">
      <line id="speedLine0" fill="none" stroke-miterlimit="10" x1="252.5" y1="324" x2="252.5" y2="566" />
      <line id="speedLine1" fill="none" stroke-miterlimit="10" x1="299.5" y1="500" x2="299.5" y2="557" />
      <line id="speedLine2" fill="none" stroke-miterlimit="10" x1="347.5" y1="324" x2="347.5" y2="529" />
      <line id="speedLine3" fill="none" stroke-miterlimit="10" x1="74.5" y1="45" x2="74.5" y2="500" />
      <line id="speedLine4" fill="none" stroke-miterlimit="10" x1="544.5" y1="29" x2="544.5" y2="574" />
      <line id="speedLine5" fill="none" stroke-miterlimit="10" x1="415.5" y1="8" x2="415.5" y2="440" />
      <line id="speedLine6" fill="none" stroke-miterlimit="10" x1="165.5" y1="142" x2="165.5" y2="574" />
    </g>
    <rect x="275" y="263.3" clip-path="url(#rainbowClip)" fill="#ffffff" width="10" height="212.7" />
    <rect x="285" y="263.3" clip-path="url(#rainbowClip)" fill="#f37f0d" width="10" height="212.7" />
    <rect x="295" y="263.3" clip-path="url(#rainbowClip)" fill="#ffffff" width="10" height="212.7" />
    <rect x="305" y="263.3" clip-path="url(#rainbowClip)" fill="#164072" width="10" height="212.7" />
    <rect x="315" y="263.3" clip-path="url(#rainbowClip)" fill="#f37f0d" width="10" height="212.7" />


    <g class="astronaut">

      <g class="pulseSVG" opacity="0.2" stroke="#ededed">
        <path class="pulse1" fill="none" stroke-width="3" stroke-linejoin="round" stroke-miterlimit="10" d="M289.9,188.7
        c5.2-5.2,13.7-5.2,18.9,0" />
        <path class="pulse2" fill="none" stroke-width="3" stroke-linejoin="round" stroke-miterlimit="10" d="M285.6,184.5
        c7.6-7.6,19.8-7.6,27.4,0" />
        <path class="pulse3" fill="none" stroke-width="3" stroke-linejoin="round" stroke-miterlimit="10" d="M281.4,180.3
        c9.9-9.9,26-9.9,35.9,0" />
      </g>
      <g class="astronaut1">
        <g>
          <g>
            <path fill="#CCCCCC" d="M265,320.7c0,0,0.1,0,0.1,0h0.2c0,0,0,0,0,0l0.2,0c0,0,0,0,0,0v-16.1h-21.4c0.9,3.7,2.8,6.9,5.6,9.8
					C254,318.6,259.1,320.7,265,320.7 M334.9,320.7c0,0,0.1,0,0.1,0c5.9,0,11-2.1,15.2-6.3c2.9-2.9,4.7-6.1,5.6-9.8h-21.4v16.1
					l0.2,0c0,0,0,0,0,0h0h0H334.9 M271.8,224.4c-4.3,0.9-8.1,2.9-11.4,6.2c-4.5,4.5-6.7,9.9-6.7,16.2v13.6c3.3-2.1,7.1-3.2,11.3-3.2
					h0c0.9,0,1.7,0,2.6,0.1c-1.5-3.9-2.3-8.2-2.3-12.7C265.3,237,267.5,230.3,271.8,224.4 M346.3,260.4v-13.6
					c0-6.3-2.2-11.7-6.7-16.2c-3-3-6.5-5.1-10.4-6l-0.2,0.8c3.9,5.6,5.8,12,5.8,19.2c0,4.2-0.7,8.1-2,11.8l0.1,0.8
					c0.7-0.1,1.4-0.1,2.2-0.1h0C339.2,257.2,342.9,258.3,346.3,260.4z" />
            <path fill="#FFFFFF" d="M299.9,210.1c0,0-0.1,0-0.1,0c-9.5,0-17.6,3.4-24.3,10.1c-1.3,1.3-2.5,2.7-3.6,4.2
					c-4.3,5.9-6.5,12.6-6.5,20.3c0,4.6,0.8,8.8,2.3,12.7c0.2,0.6,0.5,1.2,0.8,1.8c1.7,3.6,4,6.9,7.1,9.9c3.3,3.3,6.8,5.7,10.7,7.4
					c0.1,0,0.2,0.1,0.2,0.1c0.8,0.3,1.6,0.7,2.5,0.9c3.4,1.1,7.1,1.7,11,1.7c9.5,0,17.7-3.4,24.4-10.1c3.6-3.6,6.2-7.5,7.9-11.8
					c0.1-0.3,0.2-0.6,0.3-0.9c1.3-3.6,1.9-7.6,1.9-11.7c0-7.2-1.9-13.5-5.7-19.1l-0.2-0.2c0,0,0-0.1-0.1-0.1l0,0l-0.1-0.1l-0.1-0.1
					c0,0,0,0,0,0l-0.1-0.1c0-0.1-0.1-0.1-0.1-0.2c0,0,0-0.1-0.1-0.1c-1.1-1.5-2.3-2.9-3.7-4.3C317.5,213.5,309.4,210.1,299.9,210.1
					 M350.1,263.5c-1.2-1.2-2.5-2.3-3.9-3.1c-3.3-2.1-7.1-3.2-11.3-3.2h0c-0.7,0-1.5,0-2.2,0.1c-0.1,0-0.2,0-0.3,0c0,0-0.1,0-0.1,0
					l-0.3-0.1c-1.7,4.3-4.3,8.3-7.9,11.8c-6.7,6.7-14.9,10.1-24.4,10.1c-3.9,0-7.6-0.6-11-1.7c-0.8-0.3-1.7-0.6-2.5-0.9
					c-0.1,0-0.2-0.1-0.2-0.1c-3.9-1.7-7.5-4.2-10.7-7.4c-3-3-5.4-6.3-7.1-9.9c-0.3-0.6-0.5-1.2-0.8-1.8c-0.8-0.1-1.7-0.1-2.6-0.1h0
					c-4.2,0-8,1.1-11.3,3.2c-1.4,0.9-2.7,1.9-3.9,3.1c-4.2,4.2-6.3,9.2-6.3,15.2v20.6c0,1.9,0.2,3.7,0.6,5.4h21.4v-22.6v22.6v16.1
					V338c0.6,3.3,2.2,6.2,4.7,8.7c3.3,3.4,7.3,5,12,5c4.7,0,8.9-1.8,12.7-5.3c2.8-2.6,4.5-5.5,5-8.7v-15.9h-12.7H300h13h-13v15.9
					c0.5,3.2,2.2,6.1,5,8.7c3.8,3.5,8,5.3,12.7,5.3c4.7,0,8.7-1.7,12-5c2.5-2.5,4-5.4,4.7-8.7v-17.3v-16.1v-22.6v22.6h21.4
					c0.4-1.7,0.6-3.5,0.6-5.4v-20.6C356.4,272.8,354.3,267.7,350.1,263.5 M300,311.1v-30.1V311.1z" />
            <path fill="#2D2D2D" d="M299.7,195.5c-1.1,0-2,0.4-2.7,1.1c-0.7,0.7-1.1,1.6-1.1,2.7c0,1.1,0.4,2,1.1,2.7
					c0.7,0.7,1.6,1.1,2.7,1.1c1.1,0,2-0.4,2.7-1.1c0.7-0.7,1.1-1.6,1.1-2.7c0-1.1-0.4-2-1.1-2.7
					C301.7,195.8,300.8,195.5,299.7,195.5z" />
          </g>
        </g>
        <path fill="none" stroke="#2D2D2D" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" d="M355.8,304.6
			c0.4-1.7,0.6-3.5,0.6-5.4v-20.6c0-5.9-2.1-11-6.3-15.2c-1.2-1.2-2.5-2.3-3.9-3.1c-3.3-2.1-7.1-3.2-11.3-3.2h0
			c-0.7,0-1.5,0-2.2,0.1c-0.1,0-0.2,0-0.3,0c0,0-0.1,0-0.1,0 M332.1,257.3c-1.7,4.3-4.3,8.3-7.9,11.8c-6.7,6.7-14.9,10.1-24.4,10.1
			c-3.9,0-7.6-0.6-11-1.7c-0.8-0.3-1.7-0.6-2.5-0.9c-0.1,0-0.2-0.1-0.2-0.1c-3.9-1.7-7.5-4.2-10.7-7.4c-3-3-5.4-6.3-7.1-9.9
			c-0.3-0.6-0.5-1.2-0.8-1.8c-0.8-0.1-1.7-0.1-2.6-0.1h0c-4.2,0-8,1.1-11.3,3.2c-1.4,0.9-2.7,1.9-3.9,3.1c-4.2,4.2-6.3,9.2-6.3,15.2
			v20.6c0,1.9,0.2,3.7,0.6,5.4h21.4v-22.6 M346.3,260.4v-13.6c0-6.3-2.2-11.7-6.7-16.2c-3-3-6.5-5.1-10.4-6 M328.9,225.4
			c3.9,5.6,5.8,12,5.8,19.2c0,4.2-0.7,8.1-2,11.8 M299.7,203.1c-1.1,0-2-0.4-2.7-1.1c-0.7-0.7-1.1-1.6-1.1-2.7c0-1.1,0.4-2,1.1-2.7
			c0.7-0.7,1.6-1.1,2.7-1.1c1.1,0,2,0.4,2.7,1.1c0.7,0.7,1.1,1.6,1.1,2.7c0,1.1-0.4,2-1.1,2.7C301.7,202.7,300.8,203.1,299.7,203.1
			v7.1c0,0,0.1,0,0.1,0c9.5,0,17.7,3.4,24.4,10.1c1.4,1.4,2.6,2.8,3.7,4.3c0,0,0,0.1,0.1,0.1c0,0.1,0.1,0.1,0.1,0.2l0.1,0.1
			c0,0,0,0,0,0c0,0,0.1,0.1,0.1,0.1c0,0,0,0,0,0c0,0,0,0,0,0l0.1,0.1l0,0c0,0,0,0,0.1,0.1l0.2,0.2c3.8,5.6,5.7,12,5.7,19.1
			c0,4.2-0.6,8.1-1.9,11.7c-0.1,0.3-0.2,0.6-0.3,0.9 M329.2,224.6L329.2,224.6C329.1,224.6,329.1,224.6,329.2,224.6
			C329.1,224.6,329.1,224.6,329.2,224.6c-0.3-0.1-0.6-0.1-0.8-0.2c0,0-0.1,0-0.2,0c0,0,0,0.1,0.1,0.1c0,0,0,0.1,0,0.1
			c0.1,0.1,0.2,0.3,0.3,0.4c0,0,0,0,0,0l0,0c0.1,0.1,0.2,0.3,0.3,0.4c0,0,0,0,0,0 M271.8,224.4c1.1-1.4,2.3-2.8,3.6-4.2
			c6.7-6.7,14.8-10.1,24.3-10.1 M253.7,260.4v-13.6c0-6.3,2.2-11.7,6.7-16.2c3.3-3.3,7.1-5.4,11.4-6.2c-4.3,5.9-6.5,12.6-6.5,20.3
			c0,4.6,0.8,8.8,2.3,12.7 M332.7,256.5C332.7,256.5,332.7,256.5,332.7,256.5L332.7,256.5c0,0,0,0.1,0,0.1c0,0,0,0,0,0.1l-0.2,0.5
			c0,0.1-0.1,0.1-0.1,0.2 M334.7,320.7h0.2c0,0,0.1,0,0.1,0c5.9,0,11-2.1,15.2-6.3c2.9-2.9,4.7-6.1,5.6-9.8h-21.4v16.1l0.2,0
			 M334.6,320.7L334.6,320.7 M287.3,321.8H300h13 M300,337.8c0.5,3.2,2.2,6.1,5,8.7c3.8,3.5,8,5.3,12.7,5.3c4.7,0,8.7-1.7,12-5
			c2.5-2.5,4-5.4,4.7-8.7v-17.3 M265.6,320.7V338c0.6,3.3,2.2,6.2,4.7,8.7c3.3,3.4,7.3,5,12,5c4.7,0,8.9-1.8,12.7-5.3
			c2.8-2.6,4.5-5.5,5-8.7v-15.9 M265.6,320.7C265.6,320.7,265.6,320.7,265.6,320.7l-0.3,0c0,0,0,0,0,0h-0.2c0,0-0.1,0-0.1,0
			c-5.9,0-11-2.1-15.2-6.3c-2.9-2.9-4.7-6.1-5.6-9.8 M265.6,304.6v16.1 M334.4,282.1v22.6 M300,311.1v-30.1" />
      </g>
      <g class="astronautglass">
        <path fill="#7592A0" d="M324.5,261.6c6.8-4.3,10.2-9.5,10.2-15.5c0-5.1-2.4-9.6-7.2-13.4H272c-4.8,3.8-7.3,8.3-7.3,13.4
			c0,6.1,3.4,11.2,10.2,15.5c6.8,4.3,15.1,6.4,24.7,6.4C309.4,268,317.6,265.9,324.5,261.6z" />
      </g>
      <path class="astronautglass" fill="none" stroke="#2D2D2D" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" d="M334.7,246.1
		c0,6.1-3.4,11.2-10.2,15.5c-6.8,4.3-15.1,6.4-24.7,6.4c-9.7,0-17.9-2.1-24.7-6.4c-6.8-4.3-10.2-9.5-10.2-15.5
		c0-5.1,2.4-9.6,7.3-13.4h55.5C332.3,236.5,334.7,241,334.7,246.1z" />

      <path class="astronautglass" fill="none" stroke="#E6E6E6" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" d="
		M323.5,240.6c2.4,3.5,2.4,7.8,0,12.7 M275.8,240.6c-2.4,3.5-2.4,7.8,0,12.7" />

       <g class="jetBubbles">
        <g id="greyJets" fill="#2d2d2d">

          <circle class="jetBubble1" cx="289" cy="489" r="23" />
          <circle class="jetBubble1" cx="270" cy="470" r="20" />
          <circle class="jetBubble1" cx="319" cy="483" r="21" />
        </g>
        <g id="colorJets" stroke-width="0" stroke="#3d3d3d">
          <circle class="jetBubble2" fill="#164072" cx="312" cy="449" r="8" />
          <circle class="jetBubble2" fill="#f37f0d" cx="320" cy="480" r="10" />
          <circle class="jetBubble2" fill="#f37f0d" cx="290" cy="460" r="10" />
          <circle class="jetBubble2" fill="#f37f0d" cx="329" cy="453" r="11" />
          <circle class="jetBubble" fill="#167240" cx="286" cy="463" r="7" />
          <circle class="jetBubble2" fill="#f37f0d" cx="289" cy="469" r="24" />
          <circle class="jetBubble2" fill="#164072" cx="260" cy="450" r="20" />
          <circle class="jetBubble3" fill="#ffffff" cx="319" cy="463" r="10" />
          <circle class="jetBubble1" fill="#134274" cx="290" cy="463" r="18" />
          <circle class="jetBubble3" fill="#f37f0d" cx="312" cy="443" r="21" />

          <circle class="jetBubble3" fill="#f37f0d" cx="275" cy="443.4" r="12" />
        </g>
<g class="badge1">
        <use xlink:href="#badge" x="0" y="0" />
</g>        
      </g>
    </g>
    
  </svg>
  				</div>
				</div>
                </div>
                <div class="registrtion-right-side reg-step-3 none secondpart" id="rightsecond">
                	<img src="images/easy-logo.svg" width="150" height="150"/>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
</div>


<script src="{{ url('public/scripts/jquery.min.js')}}"></script>
<!-- jQuery validation js --> 
<script src="http://localhost/easylanganew/public/scripts/jquery.validate.min.js"></script> 
<script type="text/javascript" src="{{asset('public/scripts/colors.js')}}"></script>
<script type="text/javascript" src="{{asset('public/scripts/jqColorPicker.min.js')}}"></script>

<script type="text/javascript"> 
    $('.color').colorPicker();   
</script>

<script type="text/javascript">
	function fun_next()
	{
		$('.firstpart').hide(400);
		$('.secondpart').show(400);
		$('#firstst').removeClass('navigation-active-item');
		$('#secondst').addClass('navigation-previous-item');
		$('#secondst').addClass('navigation-active-item');
	}

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

        $('#signupForm').on('submit', function(e){ 
		e.preventDefault();      
			
            var firstname = $('#firstname').val();
            var lastname = $('#lastname').val();
            var email = $('#email').val();   
			 var username = $('#username').val();           
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
			}
            else if (username == '') {            
                document.getElementById("span_username").style.display="block";
                document.getElementById("span_username").style.color = "red";
				document.getElementById("span_username").style.marginBottom = "8px";
                document.getElementById("span_email").style.display="none";
                $('#email').focus();        
                return false;

            }
			 else if (password == '') {            
                document.getElementById("span_password").style.display="block";
                document.getElementById("span_password").style.color = "red";
				document.getElementById("span_password").style.marginBottom = "8px";
                document.getElementById("span_username").style.display="none";
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
                        'email': email,'username':username, 'password': password, '_token': '{{ csrf_token() }}' 
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
                        if(user_id) { window.location="{{url('/register/step-two')}}";
						 }
                    }
                },
                error: function (request) {
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


<!-------------- Rocketman Animation Script ------------>

<script>
//var container = document.querySelector('.container');
var jetBubbles = document.getElementsByClassName('jetBubble');
var rocketManSVG = document.querySelector('.rocketManSVG');
var shakeGroup = document.querySelector('.shakeGroup');
var star = document.querySelector('.star');
var satellite = document.querySelector('.satellite');
var astronaut = document.querySelector('.astronaut');
var starContainer = document.querySelector('.starContainer');
var badgeLink = document.querySelector('#badgeLink');
/* 
TweenMax.set(container, {
  position:'absolute',
  top:'50%',
  left:'50%',
  xPercent:-50,
  yPercent:-50
}) */

TweenMax.to(astronaut, 0.05, {
  y:'+=4',
  repeat:-1, 
  yoyo:true
})
var mainTimeline = new TimelineMax({repeat:-1}).seek(100);
var mainSpeedLinesTimeline = new TimelineMax({repeat:-1, paused:false});

mainTimeline.timeScale(2);

function createJets(){
  TweenMax.set(jetBubbles, {
    attr:{
      r:'-=5'
    }
  })
 //jet bubbles
  for(var i = 0; i < jetBubbles.length; i++){    
    var jb = jetBubbles[i];    
    var tl = new TimelineMax({repeat:-1,repeatDelay:Math.random()}).timeScale(4);
    tl.to(jb, Math.random() + 1 , {
      attr:{
        r:'+=15'
      },
      ease:Linear.easeNone
    })
    .to(jb, Math.random() + 1 , {
      attr:{
        r:'-=15'
      },
      ease:Linear.easeNone
    })
    
    mainTimeline.add(tl, i/4)
  }
  //speed lines
	for(var i = 0; i < 7; i++){
    var sl = document.querySelector('#speedLine' + i);

    var stl = new TimelineMax({repeat:-1, repeatDelay:Math.random()});
    stl.set(sl, {
      drawSVG:false
    })
    .to(sl, 0.05, {
      drawSVG:'0% 30%',
      ease:Linear.easeNone
    })
    .to(sl, 0.2, {
      drawSVG:'70% 100%',
      ease:Linear.easeNone
    })  
    .to(sl, 0.05, {
      drawSVG:'100% 100%',
      ease:Linear.easeNone
    })
     .set(sl, {
      drawSVG:'-1% -1%'
    });

    mainSpeedLinesTimeline.add(stl, i/23);
}  
  //stars
	for(var i = 0; i < 7; i++){
    
    var sc = star.cloneNode(true);
    starContainer.appendChild(sc);
    var calc = (i+1)/2;
   
    TweenMax.fromTo(sc, calc, {
      x:Math.random()*600,
      y:-30,
      scale:3 - calc
    }, {
      y:(Math.random() * 100) + 600,
      repeat:-1,
      repeatDelay:1,
      ease:Linear.easeNone
    })
  }
  
  rocketManSVG.removeChild(star);
}


var satTimeline = new TimelineMax({repeat:-1});
satTimeline.to(satellite, 12, {
  rotation:360,
  transformOrigin:'50% 50%',
  ease:Linear.easeNone
})

TweenMax.staggerTo('.pulse', 0.8, {
  alpha:0,
  repeat:-1,
  ease:Power2.easeInOut,
  yoyo:false
}, 0.1);

TweenMax.staggerTo('.satellitePulse', 0.8, {
  alpha:0,
  repeat:-1,
  ease:Power2.easeInOut,
  yoyo:false
}, 0.1)

createJets();

//TweenMax.globalTimeScale(0.50)

</script>
@endsection
