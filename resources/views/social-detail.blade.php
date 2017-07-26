<?php $imageurl=array(1=>"projects", 3 =>"invoice", 0=>"quote", 4=>"quiz");
$name=$imageurl[$social->master_type];?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<meta property="og:title" content="{{$social->title}}" />

<meta property="og:type" content="website" />

<meta property="og:url" content="{{url('social/share/'.$social->id)}}" />
<meta property="og:image" content="{{url('storage/app/images/'.$imageurl[$social->master_type].'/'.$social->name)}}" />

<meta property="og:description" content="{{$social->description}}" />

<meta property="og:site_name" content="Easy Langa" />
<link href="{{url('storage/app/images/logo/favicon.png')}} " rel="shortcut icon">
<title>{{$social->title}}</title>

</head>

<body>
<h1>{{$social->title}}</h1>
<p>{{$social->description}}</p>
<img src="{{url('storage/app/images/'.$imageurl[$social->master_type]."/".$social->name)}}" />
</body>
</html>
