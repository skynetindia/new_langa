@extends('layouts.app')
<!-- Main Content -->
@section('content')



				 @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

<div class="height-width100">
	<div class="resent-wrap login-wrap">
    	<div class="logo-langa-login"><img src="http://betaeasy.langa.tv/storage/app/images/logo/LOGO_Easy_LANGA_without_contour.svg" height="150" width="150"></div>
    	<div class="login-form">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
             {{ csrf_field() }}
            	 <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            
                            
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                           
                        </div>
                        <div class="form-group">
                            <div class="login-btn">
                            	<button type="submit" class="btn btn-warning">
                                    <i class="fa fa-paper-plane"></i> {{trans('messages.keyword_send_reset_password_link')}}
                                </button>
                                <a class="btn btn-warning" href="{{ url('/login') }}">{{trans('messages.keyword_back')}}</a>
                            </div>                            
                        </div>
            </form>
        </div>
    </div>
</div>






@endsection
