@extends('adminHome')
@section('page')

@if(!empty(Session::get('msg')))

<script>

    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);</script>
@endif
@include('common.errors')

<style>
    #optionsub{
        display: none;
    }
    tr:hover {
        background: #f39538;
    }
    .selected {
        font-weight: bold;
        font-size: 16px;
    }
    th {
        cursor: pointer;
    }
    li label {
        padding-left: 10px;
    }
    .button {
        background-color: #4CAF50; /* Green */
        border: none;
        color: white;
        padding: 3px 15px;
        padding-bottom: 6px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        -webkit-transition-duration: 0.4s; /* Safari */
        transition-duration: 0.4s;
        cursor: pointer;
        border-radius: 4px;
    }
    .button2 { /* blue */
        background-color: white;
        color: black;
        border: 2px solid #337ab7;
    }

    .button2:hover {
        background-color: #337ab7;
        color: white;
    }

    .button3 { /* red */
        background-color: white;
        color: black;
        border: 2px solid #d9534f;
    }

    .button3:hover {
        background-color: #d9534f;
        color: white;
    }
</style>
<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>
<script src="{{asset('public/scripts/select2.full.min.js')}}"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.js"></script>
<!-- Latest compiled and minified Locales -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/locale/bootstrap-table-it-IT.min.js"></script>

<h1>{{trans('messages.keyword_menu_name')}}</h1><hr>
<br>

<form action="{{url('/menu/store')}}" method="post">
    {{ csrf_field() }}
    <div class="col-md-12">

        <div class="col-md-3"><label for="manuname">Menu name</label>
            <input name="manuname" id="manuname" placeholder="Menu name" class="form-control hasDatepicker" value="" type="text"><br></div>
        <div class="col-md-3">
            <label for="parentmenu">Parent</label>
            <select name="parentmenu" id="parentmenu" class="js-example-basic-single form-control">
                <option value="">Select parent</option>
                @foreach($parent as $par)
                <option value="{{$par->id}}">{{$par->modulo}} </option>
                @endforeach
            </select>        
        </div>
        <div class="col-md-3" id="optionsub">
            <label for="submenu">Sub Menu</label>
            <select name="submenu" id="submenu" class="js-example-basic-single form-control">           
            </select>
        </div>
        <script type="text/javascript">
    //$(".js-example-basic-single").select2();
        </script>
    </div>
    <div class="col-md-12">
        <div class="col-md-3"><label for="menulink">Menu link</label>
            <input name="menulink" id="menulink" placeholder="Menu Link" class="form-control hasDatepicker" value="" type="text"><br></div>
        <div class="col-md-3"><label for="menuclass">Menu Class</label>
            <input name="menuclass" id="menuclass" placeholder="Menu Class" class="form-control hasDatepicker" value="" type="text"><br></div>
    </div>
    <div class="col-md-12">
        <div class="col-md-3"><button type="submit" class="btn btn-warning">Save</button></div>
    </div>
</form>
@endsection