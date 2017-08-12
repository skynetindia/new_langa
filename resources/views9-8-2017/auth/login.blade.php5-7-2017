@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default login-panel">
                <div class="panel-heading">{{trans('messages.keyword_login_easy_langa')}}</div>
                <div class="panel-body">
                	<div class="col-md-4">              
                        <p class="text-center">
                        <a href="{{url('/')}}"><img style="width:200px;height:200px;padding-top:15px" src="{{url('images/Easy SERVER.png')}}" onmouseover="this.src='{{url('images/logo.png')}}'" onmouseout="this.src='{{url('images/Easy SERVER.png')}}'" /></a></p>  
                    </div>
		<div class="col-md-8">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <div class="height30"></div><label for="email" class="col-md-4 control-label">{{trans('messages.keyword_email')}}</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">{{ucfirst(trans('messages.keyword_password'))}}</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password">
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"><?php echo Lang::get('messages.keyword_remember_me'); ?>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="height10"></div><button type="submit" class="btn btn-warning"><i class="fa fa-btn fa-sign-in"></i> {{trans('messages.keyword_log_in')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default login-panel-default">
                <div class="panel-heading text-right">
                    <a class="btn btn-default"  href="{{url('/')}}">{{trans('messages.keyword_back')}}</a>
                    <a class="btn btn-default"  href="{{ url('/password/reset') }}">{{trans('messages.keyword_did_you_forget_your_password?')}}</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Inizio divisione clienti reseller -->
    <div class="row">
    	<div class="col-md-12">
        	<div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default login-content">
                        <div class="panel-heading">{{trans('messages.keyword_other_accesses')}}</div>
                        <div class="panel-body">
                        	<div class="row">
                            	<div class="col-md-6">
                                    <h4>{{trans('messages.keyword_client')}}?</h4><hr><h5>{!! trans('messages.keyword_login_page_message_one') !!}</h5><h6>{!! trans('messages.keyword_login_page_message_two') !!}</h6>
                                    <a href="http://client.easy.langa.tv/login" class="btn btn-warning" style="text-decoration:none">{{trans('messages.keyword_log_in')}} > {{trans('messages.keyword_client')}}</a>
                                    <div class="height30"></div>
                                </div>
                                <div class="col-md-6">
                                    <h4>{{trans('messages.keyword_reseller')}}?</h4><hr><h5>{!! trans('messages.keyword_login_page_message_three') !!}</h5><h6>{!! trans('messages.keyword_login_page_message_four') !!}</h6>
                                    <a href="http://reseller.easy.langa.tv/login" class="btn btn-warning" style="text-decoration:none">{{ trans('messages.keyword_log_in')}} > {{trans('messages.keyword_reseller') }}</a>
                                    <div class="height30"></div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
