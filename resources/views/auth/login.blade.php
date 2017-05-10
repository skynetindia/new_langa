@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login Easy LANGA</div>
                <div class="panel-body">
                	<div style="text-align:center" class="col-md-4">              
                        <p align="center"><a href="http://www.easy.langa.tv/"><img style="width:200px;height:200px;padding-top:15px" src="{{url('images/Easy SERVER.png')}}" onmouseover="this.src='{{url('images/logo.png')}}'" onmouseout="this.src='{{url('images/Easy SERVER.png')}}'" /></a></p>  
                    </div>
		<div class="col-md-8">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <br><label for="email" class="col-md-4 control-label">e-mail      </label>

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
                                <label for="password" class="col-md-4 control-label">Password</label>

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
                                            <input type="checkbox" name="remember"><?php echo Lang::get('messages.remember_me'); ?>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <br><button type="submit" class="btn btn-warning">
                                        <i class="fa fa-btn fa-sign-in"></i>   Entra</button>
                                    
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
            <div class="panel panel-default">
                <div class="panel-heading" style="text-align: right">
                    <button class="btn btn-default"><a style="color:#000000" href="http://easy.langa.tv/">Indietro</a></button>
                    <button class="btn btn-default"><a style="color:#000" href="{{ url('/password/reset') }}">Hai dimenticato la password?</a></button>
                </div>
            </div>
        </div>
    </div>
    <!-- Inizio divisione clienti reseller -->
    <div class="row">
    	<div class="col-md-12">
        	<div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Altri accessi</div>
                        <div class="panel-body">
                        	<div class="row">
                            	<div class="col-md-6">
                                    <h4>Cliente?</h4><hr><h5>Se sei un cliente, clicca sul bottone <strong>Client</strong> qui sotto e accedi all'area riservata per la lettura dei tuoi documenti.</h5><h6>Revisiona in remoto il tuo progetto, accedi ai tuoi contenuti, scarica le tue fatture, richiedi modifiche,...</h6></br>
                                    <a href="http://client.easy.langa.tv/login" class="btn btn-warning" style="text-decoration:none">Accedi > Client</a><br><br><br>
                                </div>
                                <div class="col-md-6">
                                    <h4>Rivenditore?</h4><hr><h5>Se sei un rivenditore, clicca sul bottone <strong>Reseller</strong> qui sotto e accedi all'area riservata per la configurazione dei tuoi ordini.</h5><h6>Gestisci autonomamente i tuoi caricamenti d'ordine, configura le scelte con il cliente e gestisci la contabilità.</h6></br>
                                    <a href="http://reseller.easy.langa.tv/login" class="btn btn-warning" style="text-decoration:none">Accedi > Reseller</a><br><br><br>
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
