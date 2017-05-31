@extends('adminHome')
@section('page')
@if(!empty(Session::get('msg')))
<script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);</script>
@endif
@include('common.errors')
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


<h1>{{ isset($menu->id) ? trans('messages.keyword_menu_modify') : trans('messages.keyword_menu_add') }}
</h1><hr>
<br>
<?php if(isset($menu->id)) {
    ?><form action="{{url("/menu/update/$menu->id")}}" method="post" id="frmmenu" enctype="multipart/form-data"><?php
}
else {
    ?><form action="{{url('/menu/store')}}" method="post" id="frmmenu" enctype="multipart/form-data"><?php
}
?>
    {{ csrf_field() }}
    <div class="col-md-12">
        <div class="col-md-3"><label for="manuname">{{trans('messages.keyword_menu_name')}}</label>
            <input name="manuname" id="manuname" placeholder="{{trans('messages.keyword_menu_name')}}" class="form-control hasDatepicker" value="{{isset($menu->modulo) ? $menu->modulo : old('manuname')}}" type="text"><br></div>

        <div class="col-md-3">
            <label for="menutype"> Type: </label>
            <select name="menutype" id="menutype" class="js-example-basic-single form-control">
                
                <option value=""> -- select -- </option>
                
                @if(isset($menu->type))
                    <option value="1" <?php if($menu->type == 1){ ?> selected="selected" <?php } ?>> Front-End </option>
                    <option value="2" <?php if($menu->type == 2){ ?> selected="selected" <?php } ?>> Back-End </option>
                @else
                    <option value="1" > Front-End </option>
                    <option value="2" > Back-End </option>
                @endif                

            </select>        
        </div>

        <script type="text/javascript">
            
            $( document ).ready(function() {
                
                if ($("#menutype").val()) {

                    url = "{{ url('/menu/parentmenu') }}" + '/' + $("#menutype").val();
                    
                    $.ajax({

                        type: "GET",
                        url: url,

                        success: function (data, textStatus, jqXHR) {
                            
                            var submenu = jQuery.parseJSON(data);

                            if (submenu != "") {

                                $("#parentmenu").children().remove();
                                $("#parentmenu").append($("<option></option>").attr("value", "").text('Select parentmenu'));

                                $.each(submenu, function (key, value) {

                                    var selected = "<?php echo isset($menu->modulo_sub) ? $menu->modulo_sub : '0' ;?>";
                                    
                                    if(selected == value.id){

                                        $("#parentmenu").append($("<option selected></option>").attr("value", value.id).text(value.modulo));
                                        if(value.modulo_sub == '0' || value.modulo_sub == null){
                                            $("#parent").val(selected);
                                        }
                                        else {
                                            $("#parent").val(value.modulo_sub);                               
                                        }                            
                                    } else {
                                        $("#parentmenu").append($("<option></option>").attr("value", value.id).text(value.modulo));
                                        
                                    }

                                });


                                // $.each(submenu, function (key, value) {
                                //     $("#parentmenu").append($("<option></option>").attr("value", value.id).text(value.modulo));
                                // });


                                $("#parent").css("display", "block");
                            } else {
                                $("#parentmenu").children().remove();
                                $("#parent").css("display", "none");
                            }
                        },

                        error: function (data) {
                            alert("error");
                        }
                    });
                } 
                else {
                    $("#parentmenu").children().remove();
                    $("#parent").css("display", "none");
                }

            });

        </script>

        <div class="col-md-3 displaynone" id="parent">
            <label for="parentmenu">{{trans('messages.keyword_parent')}}</label>
            <select name="parentmenu" id="parentmenu" class="js-example-basic-single form-control">
                <option value="">{{trans('messages.keyword_select_parent')}}</option>
                @foreach($parent as $par)                
                <?php 
                    if(isset($menu->modulo) == $par->modulo){
                ?>
               <option value="{{$par->id}}" selected="selected">{{$par->modulo}} </option>
               <?php } else { ?>
               <option value="{{$par->id}}" >{{$par->modulo}} </option>
              <?php  }
            ?>
                @endforeach
            </select>        
        </div>
        <div class="col-md-3 displaynone" id="optionsub">
            <label for="submenu">Sub Menu</label>
            <select name="submenu" id="submenu" class="js-example-basic-single form-control"></select>
        </div>
        <script type="text/javascript">
    //$(".js-example-basic-single").select2();
        </script>
    </div>

    <div class="col-md-12">
        <div class="col-md-3"><label for="menulink">{{trans('messages.keyword_menu_link')}}</label>
            <input name="menulink" id="menulink" placeholder="{{trans('messages.keyword_menu_link')}}" class="form-control hasDatepicker" value="{{isset($menu->modulo_link) ? $menu->modulo_link : old('menulink')}}" type="text"><br></div>
        <div class="col-md-3"><label for="menuclass">{{trans('messages.keyword_menu_class')}}</label>
            <input name="menuclass" id="menuclass" placeholder="{{trans('messages.keyword_menu_class')}}" class="form-control hasDatepicker" value="{{isset($menu->modulo_class) ? $menu->modulo_class : old('menuclass')}}" type="text"><br></div>
        <div class="col-md-3">
            <label for="deparments">Deparments</label>
            <select name="deparments" id="deparments" class="js-example-basic-single form-control">
            <option value="0">ALL</option>
            @foreach($departments as $department)                          
                <option value="{{$department->id}}" <?php echo (isset($menu->dipartimento) && $department->id == $menu->dipartimento) ? 'selected' : ''; ?>>{{$department->nomedipartimento}}</option>
            @endforeach
            </select>
        </div>

        <div class="col-md-3"><label for="manuname"> Menu Image </label>
            <input name="image" id="image" class="form-control hasDatepicker" value="" type="file"><br>
        </div>

    </div>

    <div class="col-md-12">
        
        <div class="col-md-3 displaynone" id="frontorder">
        <label for="order" > Front Menu Priority  </label>
            <input name="frontpriority" id="frontpriority" class="form-control hasDatepicker" 
            value="{{isset($menu->frontpriority) ? $menu->frontpriority : old('frontpriority')}}" type="text"><br>
        </div>

        <div class="col-md-3 displaynone" id="backorder">
        <label for="order" > Back Menu Priority  </label>
            <input name="backpriority" id="backpriority"  class="form-control hasDatepicker" 
            value="{{isset($menu->backpriority) ? $menu->backpriority : old('priority')}}" type="text"><br>
        </div>

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
                            if(value != ""){
                                var optionsname ="";  
                                $.each(submenu, function (key1, value1) {
                                  if(value.modulo_sub == value1.id){
                                    optionsname = value1.modulo;                                    
                                  }
                                });
                                if(optionsname != ""){
                                    optionsname = optionsname+' -> '+value.modulo;                                
                                }
                                else {
                                    optionsname = value.modulo;                                   
                                }
                                $("#submenu").append($("<option></option>").attr("value", value.id).text(optionsname));
                            }
                        });
                        $("#optionsub").css("display", "block");
                    } 
                    else {
                        $("#submenu").children().remove();
                        $("#optionsub").css("display", "none");
                    }
                },
                error: function (data) {
                    alert("error");
                }
            });
        } 
        else {
            $("#submenu").children().remove();
            $("#optionsub").css("display", "none");
        }
    });
    // A $( document ).ready() block.
    $(document).ready(function () {  

        var val = $("#menutype").val();

        if(val == 1){          

            $("#frontorder").css("display", "block");
            $("#backorder").css("display", "none");
        }

        if(val == 2){            
            $("#frontorder").css("display", "none");
            $("#backorder").css("display", "block");
        }

     $("#menutype").change(function () { 

        var val = $("#menutype").val();

        if(val == 1){          

            $("#frontorder").css("display", "block");
            $("#backorder").css("display", "none");
        }

        if(val == 2){            
            $("#frontorder").css("display", "none");
            $("#backorder").css("display", "block");
        }      
        
        if ($("#menutype").val()) {

            url = "{{ url('/menu/parentmenu') }}" + '/' + $("#menutype").val();
            
            $.ajax({

                type: "GET",
                url: url,

                success: function (data, textStatus, jqXHR) {
                    
                    var submenu = jQuery.parseJSON(data);
                    if (submenu != "") {
                        $("#parentmenu").children().remove();
                        $("#parentmenu").append($("<option></option>").attr("value", "").text('Select parentmenu'));
                        $.each(submenu, function (key, value) {
                            $("#parentmenu").append($("<option></option>").attr("value", value.id).text(value.modulo));
                        });
                        $("#parent").css("display", "block");
                    } else {
                        $("#parentmenu").children().remove();
                        $("#parent").css("display", "none");
                    }
                },
                error: function (data) {
                    alert("error");
                }
            });
        } 
        else {
            $("#parentmenu").children().remove();
            $("#parent").css("display", "none");
        }

        // $("#parent").css("display", "block");
    });


        var parenmenuid = '0';
        if ($("#parentmenu").val()) {
              parenmenuid = $("#parentmenu").val();
        }
        url = "{{ url('/menu/submenu') }}" + '/' + parenmenuid;
        $.ajax({
            type: "GET",
            url: url,
            success: function (data, textStatus, jqXHR) {
                var submenu = jQuery.parseJSON(data);
                if (submenu != "") {
                    $("#submenu").children().remove();
                    $("#submenu").append($("<option></option>").attr("value", "").text('Select submenu'));
                    
                    $.each(submenu, function (key, value) {
                        var selected = "<?php echo isset($menu->modulo_sub) ? $menu->modulo_sub : '0' ;?>";
                        //var parentSelected = '0';                       
                        if(selected == value.id){
                            $("#submenu").append($("<option selected></option>").attr("value", value.id).text(value.modulo));
                            if(value.modulo_sub == '0' || value.modulo_sub == null){
                                $("#parentmenu").val(selected);
                            }
                            else {
                                $("#parentmenu").val(value.modulo_sub);                               
                            }                            
                        }
                        else {
                            $("#submenu").append($("<option></option>").attr("value", value.id).text(value.modulo));
                            
                        }
                        
                    });
                    // $("#optionsub").css("display", "block");
                } else {
                    $("#submenu").children().remove();
                    $("#optionsub").css("display", "none");
                }
            },
            error: function (data) {
                alert("error");
            }
        });
        /*} else {
            //$("#submenu").children().remove();
            //$("#optionsub").css("display", "none");
        }*/
    });

</script>
<script type="text/javascript">
$(document).ready(function() {


      $("#frmmenu").validate({            
            rules: {
                manuname: {
                    required: true,
                    maxlength: 35
                },
                menutype : {
                    required: true
                }
            },
            messages: {
                manuname: {
                    required: "{{trans('messages.keyword_please_enter_menu_name')}}"
                },
                menutype: {
                    required: "{{trans('messages.keyword_please_select_menu_type')}}"
                }
            }

        });
  });

</script>

@endsection