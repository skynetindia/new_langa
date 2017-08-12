@extends('adminHome')
@section('page')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

<!-- ckeditor -->
<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>

<h1><?php echo (isset($action) && $action=='add') ?  trans('messages.keyword_add_page') : trans('messages.keyword_edit_page'); ?></h1><hr>

@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif
@include('common.errors')

<?php if(isset($page->page_id)){ echo Form::open(array('url' => '/admin/page/update/' . $page->page_id, 'files' => true, 'id'=>'page_edit_form')); } else { echo Form::open(array('url' => '/admin/page/store/', 'files' => true,'id'=>'page_add_form')); } ?>

	{{ csrf_field() }}       

  <div class="row">
      <div class="col-lg-10">
					<div class="form-wrap">
            	<div class="col-sm-6">
                  <div class="form-group">
                    <label><font color="#FF0000">*</font> {{trans('messages.keyword_page_title')}} </label>
                    <input type="text" class="form-control" name="page_title" id="page_title" value="<?php if(isset($page->page_title)) echo $page->page_title;?>">
									</div>
              </div>	

              <div class="col-sm-6">
                  <div class="form-group">
                    <label><font color="#FF0000">*</font> {{trans('messages.keyword_menu')}} </label>

                  <select name="menu" id="menu" 
                    class="js-example-basic-single form-control">
                    <option style="background-color:white" selected disabled value=""> {{trans('messages.keyword_link_to')}}</option>
                    @foreach($frontmenu as $menu)                
                    <?php if(isset($page->menu_id) && $page->menu_id == $menu->id){ ?>
                    <option value="{{$menu->id}}" selected="selected">{{ ucwords(strtolower($menu->modulo)) }} </option> <?php } else { ?>
                    <option value="{{$menu->id}}" >{{ ucwords(strtolower($menu->modulo)) }}</option>
                    <?php } ?>
                    @endforeach
                  </select>   

                  </div>
              </div>

          <div class="col-sm-12">
              <div class="form-group"><?php ?>
              <ul class="nav nav-tabs">
                  @foreach ($language as $key => $val)
                   <li class="<?php echo ($val->code=='en')?'active':'';?>"><a data-toggle="tab" href="<?php echo '#'.$val->code;?>"><?php echo $val->name;?></a></li>
                  @endforeach
              </ul><br>

              <div class="tab-content">
              @foreach ($language as $key => $val)
              <?php $phase_data = array(); 
              if(isset($language_transalation->language_key) && $language_transalation->language_key != ""){                      $phase_data = DB::table('language_transalation')->where('code',$val->code)->where('language_key',$language_transalation->language_key)->first(); } ?>

            <div id="<?php echo $val->code;?>" class="tab-pane fade <?php echo ($val->code=='en')?'in active':'';?>">

              <div class="col-sm-12">
                <label><font color="#FF0000"></font> {{trans('messages.keyword_page_description')}} </label>
                <textarea class="form-control" style="resize:none" rows="10"  name="<?php echo $val->code.'_page_desc';?>" id="<?php echo $val->code.'_page_desc';?>"><?php if(isset($phase_data->language_value) && $phase_data->language_value != ""){ echo $phase_data->language_value;}?></textarea>
              </div>
              <script type="text/javascript" >
                CKEDITOR.replace( '<?php echo $val->code.'_page_desc';?>' );
              </script>  

              </div>
              @endforeach
            </div>
          </div>        
        </div> 

      </div>        
	   </div>
  </div>
  
		
<button type="submit" class="btn btn-warning">{{trans('messages.keyword_save')}}</button>

<a href="{{ url('admin/pages')}}" id="cancel" name="cancel" class="btn btn-danger">Cancel</a>

<?php echo Form::close(); ?>

<script>
  $(document).ready(function() {
    // validate page form on keyup and submit
    $("#page_add_form").validate({
        rules: {
            page_title: {
                required: true
            }
        },
        messages: {
            page_title: {
                required: "{{trans('messages.keyword_please_enter_page_title')}}"
            }
        }
    });

    $("#page_edit_form").validate({
        rules: {
            page_title: {
                required: true
            }
        },
        messages: {
            page_title: {
                required: "{{trans('messages.keyword_please_enter_page_title')}}"
            }
        }
    });

  });
</script>

@endsection