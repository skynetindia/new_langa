<!DOCTYPE html>
<html>
    <head>
        <title>Azione non autorizzata.</title>
<link rel="shortcut icon" href="{{asset('public/favicon.ico')}}" />
        <link rel="stylesheet" href="{{asset('public/css/stylesheet.css')}}">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		<style>
            body {
                background: #f37f0d;
                font-family: 'nexa_lightregular';
            }
        </style>
    </head>
    <body>
		<div class="container">
			<h1 style="text-align:center;color:#ffffff">Non ti è permesso l'accesso, torna 
			<a href="javascript:window.history.back();" style="text-decoration: none;color:#ffffff"><strong>indietro da qui</strong></a></h1>
            <img class="img-responsive" src="{{asset('images/403_easy.jpg')}}"></img>
        </div>
    </body>
</html>
