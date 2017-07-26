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


<h1>{{trans('messages.keyword_menu_modify')}}
</h1><hr>
<br>

<form action="{{url("/menu/update/$menu->id")}}" method="post">
    {{ csrf_field() }}
    <div class="col-md-12">

        <div class="col-md-3"><label for="manuname">{{trans('messages.keyword_menu_name')}}</label>
            <input name="manuname" id="manuname" placeholder="{{trans('messages.keyword_menu_name')}}" class="form-control hasDatepicker" value="{{$menu->modulo}}" type="text"><br></div>
        <div class="col-md-3">
            <label for="parentmenu">{{trans('messages.keyword_parent')}}</label>
            <select name="parentmenu" id="parentmenu" class="js-example-basic-single form-control">
                <option value="">{{trans('messages.keyword_select_parent')}}</option>
                @foreach($parent as $par)
                @if($par->id == $menu->modulo_sub)
                <option value="{{$par->id}}" selected="">{{$par->modulo}} </option>
                @else
                <option value="{{$par->id}}">{{$par->modulo}} </option>
                @endif
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
        <div class="col-md-3"><label for="menulink">{{trans('messages.keyword_menu_link')}}</label>
            <input name="menulink" id="menulink" placeholder="{{trans('messages.keyword_menu_link')}}" class="form-control hasDatepicker" value="{{$menu->modulo_link}}" type="text"><br></div>
        <div class="col-md-3"><label for="menuclass">{{trans('messages.keyword_menu_class')}}</label>
            <input name="menuclass" id="menuclass" placeholder="{{trans('messages.keyword_menu_class')}}" class="form-control hasDatepicker" value="{{$menu->modulo_class}}" type="text"><br></div>
    </div>
    <div class="col-md-12">
        <div class="col-md-3"><button type="submit" class="btn btn-warning">{{trans('messages.keyword_save')}}</button></div>
    </div>
</form>
<script>
    var selezione = [];
    var indici = [];
    var n = 0;
    $('#table').on('click-row.bs.table', function (row, tr, el) {
        var cod = /\d+/.exec($(el[0]).children()[0].innerHTML);
        if (!selezione[cod]) {
            $(el[0]).addClass("selected");
            selezione[cod] = cod;
            indici[n] = cod;
            n++;
        } else {
            $(el[0]).removeClass("selected");
            selezione[cod] = undefined;
            for (var i = 0; i < n; i++) {
                if (indici[i] == cod) {
                    for (var x = i; x < indici.length - 1; x++)
                        indici[x] = indici[x + 1];
                    break;
                }
            }
            n--;
        }
    });
    function check() {
        return confirm("Sei sicuro di voler eliminare: " + n + " preventivi?");
    }
    function multipleAction(act) {

        alert("1");
        var link = document.createElement("a");
        var clickEvent = new MouseEvent("click", {
            "view": window,
            "bubbles": true,
            "cancelable": false
        });
        var error = false;
        switch (act) {
            case 'delete':
                link.href = "{{ url('/preventivi/delete/quote') }}" + '/';
                if (check() && n != 0) {
                    for (var i = 0; i < n; i++) {
                        $.ajax({
                            type: "GET",
                            async: false,
                            url: link.href + indici[i],
                            success: function (data, textStatus, jqXHR) {
                                if (data == "error.403") {
                                    alert("Non ti è permesso l'accesso");
                                    return false;
                                }
                            },
                            error: function (url) {
                                if (url.status == 403) {
                                    link.href = "{{ url('/preventivi/delete/quote') }}" + '/' + indici[n];
                                    link.dispatchEvent(clickEvent);
                                    error = true;
                                }
                            }
                        });
                    }
                    selezione = undefined;
                    if (error === false) {
                        setTimeout(function () {
                            location.reload();
                        }, 100 * n);
                    }
                    //n = 0;
                }
                break;
            case 'modify':
                if (n != 0) {
                    n--;
                    link.href = "{{ url('/preventivi/modify/quote') }}" + '/' + indici[n];
                    n = 0;
                    selezione = undefined;
                    link.dispatchEvent(clickEvent);
                }
                break;
        }
    }



    $("#parentmenu").change(function () {
        if ($("#parentmenu").val()) {
            url = "{{ url('/menu/submenu') }}" + '/' + $("#parentmenu").val();
            $.ajax({
                type: "GET",
                url: url,
                success: function (data, textStatus, jqXHR) {
                    var submenu = jQuery.parseJSON(data);
                    if (submenu != "") {
                        $("#submenu").children().remove();
                        $("#submenu").append($("<option></option>").attr("value", "").text('Select submenu'));
                        $.each(submenu, function (key, value) {
                            $("#submenu").append($("<option></option>").attr("value", value.id).text(value.modulo));
                        });
                        $("#optionsub").css("display", "block");
                    } else {
                        $("#submenu").children().remove();
                        $("#optionsub").css("display", "none");
                    }
                },
                error: function (data) {
                    alert("error");
                }
            });
        } else {
            $("#submenu").children().remove();
            $("#optionsub").css("display", "none");
        }
    });
    // A $( document ).ready() block.
    $(document).ready(function () {
        if ($("#parentmenu").val()) {
            url = "{{ url('/menu/submenu') }}" + '/' + $("#parentmenu").val();
            $.ajax({
                type: "GET",
                url: url,
                success: function (data, textStatus, jqXHR) {
                    var submenu = jQuery.parseJSON(data);
                    if (submenu != "") {
                        $("#submenu").children().remove();
                        $("#submenu").append($("<option></option>").attr("value", "").text('Select submenu'));
                        $.each(submenu, function (key, value) {
                            var selected = "<?php echo $menu->modulo_subsub?>";
                           
                            if(selected == value.id){
                            $("#submenu").append($("<option selected></option>").attr("value", value.id).text(value.modulo));
                            }else{
                            $("#submenu").append($("<option></option>").attr("value", value.id).text(value.modulo));
                            }
                            
                        });
                        $("#optionsub").css("display", "block");
                    } else {
                        $("#submenu").children().remove();
                        $("#optionsub").css("display", "none");
                    }
                },
                error: function (data) {
                    alert("error");
                }
            });
        } else {
            $("#submenu").children().remove();
            $("#optionsub").css("display", "none");
        }
    });

</script>

@endsection