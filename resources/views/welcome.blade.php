@extends('layouts.app')

@section('content')

<style>
div.img {
    border: 1px solid #ccc;
}

div.img:hover {
    border: 1px solid #f37f0d;
}

div.img img {
    width: 300px;
    height: 200px;
}


div.desc {
    padding: 10px;
    text-align: center;
}

* {
    box-sizing: border-box;
}

.clearfix:after {
    content: "";
    display: table;
    clear: both;
}
</style>

@if(!empty(Session::get('nuovaregistrazione')))

    <h1 style="text-align:center;color:#ffffff">Tutto sotto controllo, manca soltanto la conferma dell'admin
    <img class="img-responsive" src="http://easy.langa.tv/storage/app/images/ok.jpg"></img>
    {{Session::forget('nuovaregistrazione')}}               
    
@elseif(!empty(Session::get('confermaregistrazione')))
    
    <h1 style="text-align:center;color:#ffffff">Account attivato con successo, una email è già stata inviata al nuovo utente
    <img class="img-responsive" src="http://easy.langa.tv/storage/app/images/ok.jpg"></img>
    {{Session::forget('confermaregistrazione')}}
    
@elseif (Auth::guest())  

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('messages.keyword_welcome_to_the_easy_system') }}
                </div>

                <div class="panel-body">
				    <div class="col-md-4">
                        <br>
                        <div style="text-align: center">
                            <a href="{{url('/')}}">
                                <img style="width:200px;height:200px" src="{{url('images/logo.png')}}" ></img>
                            </a>
                        </div>
					</div>
                    <br><br>
					<div class="col-md-8">
                        <br><h4>{{ trans('messages.keyword_welcome_to')}} <strong>LANGA</strong>!</h4>
                        {{ trans('messages.keyword_wecome_page_message')}}<br></br>
                        <small>{{ trans('messages.keyword_welcome_page_message_1')}}<br><br>
                        {{ trans('messages.keyword_more_information_about') }} <a href="http://www.langa.tv" target="_blank">www.langa.tv</a></small>
					</div>                     
                </div><br>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading" style="text-align: right">
                    <a class="btn btn-warning" href="{{ url('/login') }}">{{ trans('messages.keyword_access_the_easy_world') }}</a>
                    <a class="btn btn-warning" href="{{ url('/register') }}">{{ trans('messages.keyword_register_here') }}</a>
                </div>
            </div>
        </div>
    </div>
@else
 <?php return Redirect::to('dashboard');
 //redirect('/dashboard');?>
@endif
@endsection
