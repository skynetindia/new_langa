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
    <div class="row">
        <div class="col-md-3 col-sm-12 col-xs-12">
        	<div class="form-group">
        	<label for="manuname">{{trans('messages.keyword_menu_name')}}</label>
            <input name="manuname" id="manuname" placeholder="{{trans('messages.keyword_menu_name')}}" class="form-control hasDatepicker" value="{{isset($menu->modulo) ? $menu->modulo : old('manuname')}}" type="text"></div>
			</div>
            
        <div class="col-md-3 col-sm-12 col-xs-12">
        	<div class="form-group">
            <label for="menutype"> {{trans('messages.keyword_type')}}: </label>
            <select name="menutype" id="menutype" class="js-example-basic-single form-control">
                
                <option value=""> -- {{trans('messages.keyword_select')}} -- </option>
                
              
                    <option value="1" <?php if((isset($menu->type))&& ($menu->type == 1)){ ?> selected="selected" <?php } ?>>
                    {{ trans('messages.keyword_front_end')}}  </option>
                    <option value="2" <?php if((isset($menu->type))&& ($menu->type == 2)){ ?> selected="selected" <?php } ?>> {{trans('messages.keyword_back_end')}} </option>
                      

            </select>     
            </div>   
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

        <div class="col-md-3 none col-sm-12 col-xs-12" id="parent" >
        	<div class="form-group">
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
        </div>
        <div class="col-md-3 none col-sm-12 col-xs-12" id="optionsub">
        	<div class="form-group">
            <label for="submenu"> {{trans('messages.keyword_sub_menu')}} </label>
            <select name="submenu" id="submenu" class="js-example-basic-single form-control"></select>
            </div>
        </div>
        <script type="text/javascript">
    //$(".js-example-basic-single").select2();
        </script>
    </div>

    <div class="row">
        <div class="col-md-3 col-sm-12 col-xs-12">
        	<div class="form-group"><label for="menulink">{{trans('messages.keyword_menu_link')}}</label>
            <input name="menulink" id="menulink" placeholder="{{trans('messages.keyword_menu_link')}}" class="form-control hasDatepicker" value="{{isset($menu->modulo_link) ? $menu->modulo_link : old('menulink')}}" type="text"></div></div>
        <div class="col-md-3 col-sm-12 col-xs-12"><div class="form-group"><label for="menuclass">{{trans('messages.keyword_menu_class')}}</label>
            <input name="menuclass" id="menuclass" placeholder="{{trans('messages.keyword_menu_class')}}" class="form-control hasDatepicker" value="{{isset($menu->modulo_class) ? $menu->modulo_class : old('menuclass')}}" type="text"></div></div>
        <div class="col-md-3 col-sm-12 col-xs-12">
        	<div class="form-group">
            <label for="deparments">{{trans('messages.keyword_departments')}}</label>
            <select name="deparments" id="deparments" class="js-example-basic-single form-control">
            <option value="0">ALL</option>
            @foreach($departments as $department)                          
                <option value="{{$department->id}}" <?php echo (isset($menu->dipartimento) && $department->id == $menu->dipartimento) ? 'selected' : ''; ?>>{{ ucwords(strtolower($department->nomedipartimento)) }}</option>
            @endforeach
            </select>
            </div>
        </div>

        <div class="col-md-3 col-sm-12 col-xs-12"><div class="form-group"><label for="manuname"> Menu {{trans('messages.keyword_image')}} </label>
            <input name="image" id="image" class="form-control hasDatepicker" value="" type="file"></div>
        </div>

    </div>

    <div class="row">
        
        <div class="col-md-3 none col-sm-12 col-xs-12 " id="frontorder">
        	<div class="form-group">
        <label for="order" > {{trans('messages.keyword_front_menu_priority')}}   </label>
            <input name="frontpriority" id="frontpriority" class="form-control hasDatepicker" 
            value="{{isset($menu->frontpriority) ? $menu->frontpriority : old('frontpriority')}}" type="text">
        </div>
        	</div>

        <div class="col-md-3 none col-sm-12 col-xs-12" id="backorder">
        	<div class="form-group">
        <label for="order" > {{trans('messages.keyword_back_menu_priority')}}   </label>
            <input name="backpriority" id="backpriority"  class="form-control hasDatepicker" 
            value="{{isset($menu->backpriority) ? $menu->backpriority : old('priority')}}" type="text">
            </div>
        </div>
<?php /* 
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="manuname"> Avtar {{trans('messages.keyword_image')}} </label>
                <input name="avatar_image" id="avatar_image" class="form-control" value="" type="file">
                <label for="avatar_image" generated="true" class="error none" id="logo_validatio_msg"></label>
            </div>
        </div>
        <div class="col-md-2 logopreview col-sm-12 col-xs-12" id="logopreview"> 
            <div class="img-border-preview" style="<?php echo (isset($menu->avatar_image) && $menu->avatar_image != "") ? 'display:block' :'display:none';?>"> <?php if(isset($menu->avatar_image)) { ?> <img src="{{url('/storage/app/images/modulavtar').'/'.$menu->avatar_image}}" height="100" width="100" class="img-responsive" ><?php } ?>
            </div>
        </div>*/?>
    </div>
  <?php /* <div class="row">   <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="form-group admin-lang-tab">
          <ul class="nav nav-tabs">
            @foreach ($language as $key => $val)
            <li class="<?php echo ($val->code=='en')?'active':'';?>"><a data-toggle="tab" href="<?php echo '#'.$val->code;?>"><?php echo $val->name;?></a></li>
            @endforeach
          </ul>
        
          <div class="tab-content"> 
          @foreach ($language as $key => $val)
            <?php 
              $phase_data = array();                                  
              if(isset($menu->tutorial_lang_key) && $menu->tutorial_lang_key != ""){
                 $phase_data = DB::table('language_transalation')->where('code',$val->code)->where('language_key',$menu->tutorial_lang_key)->first();
              }
            ?><div id="<?php echo $val->code;?>" class="tab-pane fade <?php echo ($val->code=='en')?'in active':'';?>">
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <label> {{trans('messages.keyword_avatar_comic')}} </label>
                <textarea class="form-control" rows="10"  name="<?php echo $val->code.'_keyword_desc';?>" id="<?php echo $val->code.'_keyword_desc';?>"><?php if(isset($phase_data->language_value) && $phase_data->language_value != ""){ echo $phase_data->language_value;}?>
</textarea>
              </div>
              </div>
            </div>
            @endforeach </div>
        </div>
      </div>
	</div>*/?>
    
   <div class="row">     <div class="col-md-3 col-sm-12 col-xs-12"><button type="submit" class="btn btn-warning">{{trans('messages.keyword_save')}}</button></div></div>
    

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

                        console.log(value);

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
                        $("#parentmenu").append($("<option></option>").attr("value", "").text('<?php echo trans('messages.keyword_select_parent_menu'); ?>'));
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

//var $jp = jQuery.noConflict();
function readURL(input) {
if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
        $('#logopreview').html(' <div class="img-border-preview" style="display:block;"> <img height="100" width="100" src="'+e.target.result+'"></div>');
        /*$('#logopreview').attr('src', e.target.result);*/
    }
    reader.readAsDataURL(input.files[0]);
    }
}

$("#avatar_image").change(function(){ 
    var ext = $(this).val().split('.').pop().toLowerCase();
    var filessize = this.files[0].size/1024/1024;/*MB*/     
    if(($.inArray(ext, ['gif','png','jpg','jpeg','svg']) == -1) || (filessize > 2)) {
        $(this).val("");
        $("#logo_validatio_msg").show();
        $("#logo_validatio_msg").html("{{ trans('messages.keyword_please_upload_a_valid__image') }}");      
    }
    else {
        $("#logo_validatio_msg").html("");      
        readURL(this);  
    }
});

</script>

@endsection