@extends('layouts.app')

@section('content')

@if(!empty(Session::get('msg')))

    <script>

    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';

    document.write(msg);

    </script>

@endif

@include('common.errors')                                     

 <!-- CSS required for STEP Wizard  -->
 <style>
.wizard {
    margin: 20px auto;
    background: #fff;
}

    .wizard .nav-tabs {
        position: relative;
        margin: 40px auto;
        margin-bottom: 0;
        border-bottom-color: #e0e0e0;
    }

    .wizard > div.wizard-inner {
        position: relative;
    }

.connecting-line {
    height: 2px;
    background: #e0e0e0;
    position: absolute;
    width: 80%;
    margin: 0 auto;
    left: 0;
    right: 0;
    top: 50%;
    z-index: 1;
}

.wizard .nav-tabs > li.active > a, .wizard .nav-tabs > li.active > a:hover, .wizard .nav-tabs > li.active > a:focus {
    color: #555555;
    cursor: default;
    border: 0;
    border-bottom-color: transparent;
}

span.round-tab {
    width: 70px;
    height: 70px;
    line-height: 70px;
    display: inline-block;
    border-radius: 100px;
    background: #fff;
    border: 2px solid #e0e0e0;
    z-index: 2;
    position: absolute;
    left: 0;
    text-align: center;
    font-size: 25px;
}
span.round-tab i{
    color:#555555;
}
.wizard li.active span.round-tab {
    background: #fff;
    border: 2px solid #5bc0de;
    
}
.wizard li.active span.round-tab i{
    color: #5bc0de;
}

span.round-tab:hover {
    color: #333;
    border: 2px solid #333;
}

.wizard .nav-tabs > li {
    width: 25%;
}

.wizard li:after {
    content: " ";
    position: absolute;
    left: 46%;
    opacity: 0;
    margin: 0 auto;
    bottom: 0px;
    border: 5px solid transparent;
    border-bottom-color: #5bc0de;
    transition: 0.1s ease-in-out;
}

.wizard li.active:after {
    content: " ";
    position: absolute;
    left: 46%;
    opacity: 1;
    margin: 0 auto;
    bottom: 0px;
    border: 10px solid transparent;
    border-bottom-color: #5bc0de;
}

.wizard .nav-tabs > li a {
    width: 70px;
    height: 70px;
    margin: 20px auto;
    border-radius: 100%;
    padding: 0;
}

    .wizard .nav-tabs > li a:hover {
        background: transparent;
    }

.wizard .tab-pane {
    position: relative;
    padding-top: 50px;
}

.wizard h3 {
    margin-top: 0;
}

@media( max-width : 585px ) {

    .wizard {
        width: 90%;
        height: auto !important;
    }

    span.round-tab {
        font-size: 16px;
        width: 50px;
        height: 50px;
        line-height: 50px;
    }

    .wizard .nav-tabs > li a {
        width: 50px;
        height: 50px;
        line-height: 50px;
    }

    .wizard li.active:after {
        content: " ";
        position: absolute;
        left: 35%;
    }
}
</style>

<link href="{{asset('public/css/dropzone.css')}}" rel="stylesheet" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/css/tether.min.css">
<link href="{{asset('public/css/cropper_main.css')}}" rel="stylesheet" />
<link href="{{asset('public/css/cropper.css')}}" rel="stylesheet" />

<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>
<!-- <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js"></script> -->

<script type="text/javascript" src="{{asset('public/scripts/dropzone.js')}}"></script>

<div class="row quiz-wizard">
  <div class="col-md-12">
    <h1> {{ trans('messages.keyword_quiz') }} </h1>
    <div class="wizard">
      <div class="wizard-inner">
        <div class="connecting-line"></div>
        <ul class="nav nav-tabs">
          <li role="presentation" class="active"> <a href="#" title="Step 1"> <span class="round-tab"> <img src="{{ asset('images/folder.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_enter_data') }} </span> </a> </li>
          <li role="presentation" class="disabled"> <a href="#" title="Step 2"> <span class="round-tab"> <img src="{{ asset('images/star.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_currency_demo') }} </span> </a> </li>
          <li role="presentation" class="disabled"> <a href="#" title="Step 3"> <span class="round-tab"> <img src="{{ asset('images/edit.png') }}"> </span> <span class="tab-name">{{ trans('messages.keyword_colors__layouts') }} </span> </a> </li>
          <li role="presentation" class="disabled"> <a href="#" title="Complete"> <span class="round-tab"> <img src="{{ asset('images/list.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_optional') }} </span> </a> </li>
          <li role="presentation" class="disabled"> <a href="#" title="Complete"> <span class="round-tab"> <img src="{{ asset('images/media.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_media') }} </span> </a> </li>
        </ul>
      </div>
      
        <!-- Content -->
  <div class="container">
    <div class="row">
      <div class="col-md-7">
        <!-- <h3>Demo:</h3> -->
        <div class="img-container">
          <img id="image" src="{{ asset('images/quiz-five/demo1-big.jpg') }}" alt="Picture">
        </div>
      </div>
      <div class="col-md-2">
        <!-- <h3>Preview:</h3> -->
        <div class="docs-preview clearfix">
          <div class="img-preview preview-lg"></div>
          <div class="img-preview preview-md"></div>
          <div class="img-preview preview-sm"></div>
          <div class="img-preview preview-xs"></div>
        </div>

        <!-- <h3>Data:</h3> -->
        <div class="docs-data">
          <div class="input-group input-group-sm">
            <label class="input-group-addon" for="dataX">X</label>
            <input type="text" class="form-control" id="dataX" placeholder="x">
            <span class="input-group-addon">px</span>
          </div>
          <div class="input-group input-group-sm">
            <label class="input-group-addon" for="dataY">Y</label>
            <input type="text" class="form-control" id="dataY" placeholder="y">
            <span class="input-group-addon">px</span>
          </div>
          <div class="input-group input-group-sm">
            <label class="input-group-addon" for="dataWidth"> {{ trans('messages.keyword_width') }} </label>
            <input type="text" class="form-control" id="dataWidth" placeholder="{{ trans('messages.keyword_width') }}">
            <span class="input-group-addon">px</span>
          </div>
          <div class="input-group input-group-sm">
            <label class="input-group-addon" for="dataHeight"> {{ trans('messages.keyword_height') }} </label>
            <input type="text" class="form-control" id="dataHeight" placeholder="{{ trans('messages.keyword_height') }}">
            <span class="input-group-addon">px</span>
          </div>
          <div class="input-group input-group-sm">
            <label class="input-group-addon" for="dataRotate"> {{ trans('messages.keyword_rotate') }} </label>
            <input type="text" class="form-control" id="dataRotate" placeholder="{{ trans('messages.keyword_rotate') }} ">
            <span class="input-group-addon">{{ trans('messages.keyword_deg') }}</span>
          </div>
          <div class="input-group input-group-sm">
            <label class="input-group-addon" for="dataScaleX">{{ trans('messages.keyword_scale') }}X</label>
            <input type="text" class="form-control" id="dataScaleX" placeholder="{{ trans('messages.keyword_scale') }}X ">
          </div>
          <div class="input-group input-group-sm">
            <label class="input-group-addon" for="dataScaleY">{{ trans('messages.keyword_scale') }}Y</label>
            <input type="text" class="form-control" id="dataScaleY" placeholder="{{ trans('messages.keyword_scale') }}Y">
          </div>
        </div>
      </div>

  
      <?php echo Form::close(); ?> 

        <?php $mediaCode = date('dmyhis');?>

        <div class="col-md-3">
        <!-- Form-3 start  -->

        <!-- <div class="pull-right col-md-4"> -->

            <div class="col-md-12">
            <label for="scansione">  {{ trans('messages.keyword_attachment') }} </label>
            </div>
            <br>
            <br>
            <div class="col-md-12">
                <div class="image_upload_div">
                <?php echo Form::open(array('url' => '/stepfive/uploadfiles/'. $mediaCode, 'files' => true,'class'=>'dropzone')) ?>
                {{ csrf_field() }}
                </form>             
                </div><script>
                var url = '<?php echo url('/stepfive/getfiles/'.$mediaCode); ?>';
                Dropzone.autoDiscover = false;
                $(".dropzone").each(function() {
                  $(this).dropzone({
                    complete: function(file) {
                      if (file.status == "success") {
                         $.ajax({url: url, success: function(result){
                            $("#files").html(result);
                            $(".dz-preview").remove();
                            $(".dz-message").show();
                        }});
                      }
                    }
                  });
                });

                function deleteQuoteFile(id){
                    var urlD = '<?php echo url('/stepfive/deletefiles/'); ?>/'+id;
                        $.ajax({url: urlD, success: function(result){
                            $(".quoteFile_"+id).remove();
                        }});
                }
                
                </script>
                <table class="table table-striped table-bordered">                  
                    <tbody><?php
                    if(isset($preventivo->id) && isset($quotefiles)){
                    foreach($quotefiles as $prev) {
                $imagPath = url('/storage/app/images/quote/'.$prev->name);
                $html = '<tr class="quoteFile_'.$prev->id.'"><td><img src="'.$imagPath.'" height="100" width="100"><a class="btn btn-danger pull-right" style="text-decoration: none; color:#fff" onclick="deleteQuoteFile('.$prev->id.')"><i class="fa fa-eraser"></i></a></td></tr>';
                $html .='<tr class="quoteFile_'.$prev->id.'"><td>';
                
                echo $html .='</td></tr>';
            }
                    }
                    ?></tbody>
                    <tbody id="files">
                    </tbody>
                    
              <script type="text/javascript">

              function isInArray(days, day) {
                return days.indexOf(day.toLowerCase()) > -1;
              }

              function displayFile(elem){
                  
                var src = $(elem).prop('src');
				        var filename=src.substr( (src.lastIndexOf('/') +1) )
                var extension = src.substr( (src.lastIndexOf('.') +1) );

                var imgformat = ["jpe", "jpeg", "jpg", "png", "img"];
                
                var  isTrue = isInArray(imgformat, extension);
              	filename1=filename.split('.');
				
                 // $(".img-container").css('display','none'); 

                  $.ajax({

                   type:'GET',
                 
                   url: "{{ url('fileviewer') }}/"+filename1[0]+"/"+filename1[1],

                   success:function(data) {
                     console.log(data);
                   }

                });


				if(isTrue==true){
                 $( ".cropper-canvas" ).children().attr('src', src);

                 $( ".cropper-view-box" ).children().attr('src', src);
              
                 $( ".preview-lg" ).children().attr('src', src);

                 $( ".preview-md" ).children().attr('src', src);

                 $( ".preview-sm" ).children().attr('src', src);

                 $( ".preview-xs" ).children().attr('src', src); 
				}
                    
                }
               
              </script>

                    <script>

                    // var $ = jQuery.noConflict();
                        var selezione = [];
                        var nFile = 0;
                        var kFile = 0;
                        $('#aggiungiFile').on("click", function() {
                            var tab = document.getElementById("files");
                            var tr = document.createElement("tr");
                            var check = document.createElement("td");
                            var checkbox = document.createElement("input");
                            checkbox.type = "checkbox";
                            checkbox.className = "selezione";
                            check.appendChild(checkbox);
                            kFile++;
                            var td = document.createElement("td");
                            var fileInput = document.createElement("input");
                            fileInput.type = "file";
                            fileInput.className = "form-control";
                            fileInput.name = "filee[]";
                            td.appendChild(fileInput);
                            tr.appendChild(check);
                            tr.appendChild(td);
                            tab.appendChild(tr);
                            $('.selezione').on("click", function() {
                                selezione[nFile] = $(this).parent().parent();
                                nFile++;
                            });
                        });
                        $('#eliminaFile').on("click", function() {
                           for(var i = 0; i < nFile; i++) {
                               selezione[i].remove();
                           }
                           nFile = 0;
                        });
                    </script>
                </table><hr>

              </div>
    
        </div>
    <div class="row">
      <div class="col-md-7 docs-buttons">
        <!-- <h3>Toolbar:</h3> -->
        <div class="btn-group">
          <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="move" title="Move">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;setDragMode&quot;, &quot;move&quot;)">
              <span class="fa fa-arrows"></span>
            </span>
          </button>
          <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="crop" title="Crop">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;setDragMode&quot;, &quot;crop&quot;)">
              <span class="fa fa-crop"></span>
            </span>
          </button>
        </div>

        <div class="btn-group">
          <button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1" title="Zoom In">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;zoom&quot;, 0.1)">
              <span class="fa fa-search-plus"></span>
            </span>
          </button>
          <button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1" title="Zoom Out">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;zoom&quot;, -0.1)">
              <span class="fa fa-search-minus"></span>
            </span>
          </button>
        </div>

        <div class="btn-group">
          <button type="button" class="btn btn-primary" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;move&quot;, -10, 0)">
              <span class="fa fa-arrow-left"></span>
            </span>
          </button>
          <button type="button" class="btn btn-primary" data-method="move" data-option="10" data-second-option="0" title="Move Right">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;move&quot;, 10, 0)">
              <span class="fa fa-arrow-right"></span>
            </span>
          </button>
          <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;move&quot;, 0, -10)">
              <span class="fa fa-arrow-up"></span>
            </span>
          </button>
          <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="10" title="Move Down">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;move&quot;, 0, 10)">
              <span class="fa fa-arrow-down"></span>
            </span>
          </button>
        </div>

        <div class="btn-group">
          <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45" title="Rotate Left">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;rotate&quot;, -45)">
              <span class="fa fa-rotate-left"></span>
            </span>
          </button>
          <button type="button" class="btn btn-primary" data-method="rotate" data-option="45" title="Rotate Right">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;rotate&quot;, 45)">
              <span class="fa fa-rotate-right"></span>
            </span>
          </button>
        </div>

        <div class="btn-group">
          <button type="button" class="btn btn-primary" data-method="scaleX" data-option="-1" title="Flip Horizontal">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;scaleX&quot;, -1)">
              <span class="fa fa-arrows-h"></span>
            </span>
          </button>
          <button type="button" class="btn btn-primary" data-method="scaleY" data-option="-1" title="Flip Vertical">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;scaleY&quot;, -1)">
              <span class="fa fa-arrows-v"></span>
            </span>
          </button>
        </div>

        <div class="btn-group">
          <button type="button" class="btn btn-primary" data-method="crop" title="Crop">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;crop&quot;)">
              <span class="fa fa-check"></span>
            </span>
          </button>
          <button type="button" class="btn btn-primary" data-method="clear" title="Clear">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;clear&quot;)">
              <span class="fa fa-remove"></span>
            </span>
          </button>
        </div>

        <div class="btn-group">
          <button type="button" class="btn btn-primary" data-method="disable" title="Disable">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;disable&quot;)">
              <span class="fa fa-lock"></span>
            </span>
          </button>
          <button type="button" class="btn btn-primary" data-method="enable" title="Enable">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;enable&quot;)">
              <span class="fa fa-unlock"></span>
            </span>
          </button>
        </div>

        <div class="btn-group">
          <button type="button" class="btn btn-primary" data-method="reset" title="Reset">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;reset&quot;)">
              <span class="fa fa-refresh"></span>
            </span>
          </button>
          <label class="btn btn-primary btn-upload" for="inputImage" title="Upload image file">
            <input type="file" class="sr-only" id="inputImage" name="file" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="{{ trans('messages.keyword_import_image_with_blob_url') }} ">
              <span class="fa fa-upload"></span>
            </span>
          </label>
          <button type="button" class="btn btn-primary" data-method="destroy" title="Destroy">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;destroy&quot;)">
              <span class="fa fa-power-off"></span>
            </span>
          </button>
        </div>

        <div class="btn-group btn-group-crop">
          <button type="button" class="btn btn-primary" data-method="getCroppedCanvas">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;getCroppedCanvas&quot;)">
             {{ trans('messages.keyword_get_cropped_canvas') }}
            </span>
          </button>
          <button type="button" class="btn btn-primary" data-method="getCroppedCanvas" data-option="{ &quot;width&quot;: 160, &quot;height&quot;: 90 }">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;getCroppedCanvas&quot;, { width: 160, height: 90 })">
              160&times;90
            </span>
          </button>
          <button type="button" class="btn btn-primary" data-method="getCroppedCanvas" data-option="{ &quot;width&quot;: 320, &quot;height&quot;: 180 }">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;getCroppedCanvas&quot;, { width: 320, height: 180 })">
              320&times;180
            </span>
          </button>
        </div>

        <!-- Show the cropped image in modal -->
        <div class="modal fade docs-cropped" id="getCroppedCanvasModal" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" role="dialog" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="getCroppedCanvasTitle">
                {{ trans('messages.keyword_cropped') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body"></div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"> {{ trans('messages.keyword_close') }} </button>
                <a class="btn btn-primary" id="download" href="javascript:void(0);" download="cropped.jpg"> {{ trans('messages.keyword_download') }}  </a>
              </div>
            </div>
          </div>
        </div><!-- /.modal -->

        <button type="button" class="btn btn-primary" data-method="getData" data-option data-target="#putData">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;getData&quot;)">
            {{ trans('messages.keyword_get_data') }}
          </span>
        </button>
        <button type="button" class="btn btn-primary" data-method="setData" data-target="#putData">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;setData&quot;, data)">
            {{ trans('messages.keyword_set_data') }}
          </span>
        </button>
        <button type="button" class="btn btn-primary" data-method="getContainerData" data-option data-target="#putData">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;getContainerData&quot;)">
            {{ trans('messages.keyword_get_container_data') }} 
          </span>
        </button>
        <button type="button" class="btn btn-primary" data-method="getImageData" data-option data-target="#putData">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;getImageData&quot;)">
            {{ trans('messages.keyword_get_image_data') }} 
          </span>
        </button>
        <button type="button" class="btn btn-primary" data-method="getCanvasData" data-option data-target="#putData">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;getCanvasData&quot;)">
            {{ trans('messages.keyword_get_canvas_data') }}
          </span>
        </button>
        <button type="button" class="btn btn-primary" data-method="setCanvasData" data-target="#putData">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;setCanvasData&quot;, data)">
            {{ trans('messages.keyword_set_canvas_data') }}
          </span>
        </button>
        <button type="button" class="btn btn-primary" data-method="getCropBoxData" data-option data-target="#putData">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;getCropBoxData&quot;)">
            {{ trans('messages.keyword_get_crop_box_data') }} 
          </span>
        </button>
        <button type="button" class="btn btn-primary" data-method="setCropBoxData" data-target="#putData">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;setCropBoxData&quot;, data)">
            {{ trans('messages.keyword_set_crop_box_data') }} 
          </span>
        </button>
        <button type="button" class="btn btn-primary" data-method="moveTo" data-option="0">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="cropper.moveTo(0)">
            {{ trans('messages.keyword_move_to') }} [0,0]
          </span>
        </button>
        <button type="button" class="btn btn-primary" data-method="zoomTo" data-option="1">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="cropper.zoomTo(1)">
            {{ trans('messages.keyword_zoom_to') }} 100%
          </span>
        </button>
        <button type="button" class="btn btn-primary" data-method="rotateTo" data-option="180">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="cropper.rotateTo(180)">
            {{ trans('messages.keyword_rotate') }}  180°
          </span>
        </button>
        <input type="text" class="form-control" id="putData" placeholder=" {{ trans('messages.keyword_get_data_here_with_value') }}
        ">
      </div><!-- /.docs-buttons -->

      <div class="col-md-2 docs-toggles">
        <!-- <h3>Toggles:</h3> -->
        <div class="btn-group d-flex flex-nowrap" data-toggle="buttons">
          <label class="btn btn-primary active">
            <input type="radio" class="sr-only" id="aspectRatio0" name="aspectRatio" value="1.7777777777777777">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="aspectRatio: 16 / 9">
              16:9
            </span>
          </label>
          <label class="btn btn-primary">
            <input type="radio" class="sr-only" id="aspectRatio1" name="aspectRatio" value="1.3333333333333333">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="aspectRatio: 4 / 3">
              4:3
            </span>
          </label>
          <label class="btn btn-primary">
            <input type="radio" class="sr-only" id="aspectRatio2" name="aspectRatio" value="1">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="aspectRatio: 1 / 1">
              1:1
            </span>
          </label>
          <label class="btn btn-primary">
            <input type="radio" class="sr-only" id="aspectRatio3" name="aspectRatio" value="0.6666666666666666">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="aspectRatio: 2 / 3">
              2:3
            </span>
          </label>
          <label class="btn btn-primary">
            <input type="radio" class="sr-only" id="aspectRatio4" name="aspectRatio" value="NaN">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="aspectRatio: NaN">
              {{ trans('messages.keyword_free') }} 
            </span>
          </label>
        </div>

        <div class="btn-group d-flex flex-nowrap" data-toggle="buttons">
          <label class="btn btn-primary active">
            <input type="radio" class="sr-only" id="viewMode0" name="viewMode" value="0" checked>
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=" {{ trans('messages.keyword_view_mode') }} 0">
              VM0
            </span>
          </label>
          <label class="btn btn-primary">
            <input type="radio" class="sr-only" id="viewMode1" name="viewMode" value="1">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="{{ trans('messages.keyword_view_mode') }} 1">
              VM1
            </span>
          </label>
          <label class="btn btn-primary">
            <input type="radio" class="sr-only" id="viewMode2" name="viewMode" value="2">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="{{ trans('messages.keyword_view_mode') }} 2">
              VM2
            </span>
          </label>
          <label class="btn btn-primary">
            <input type="radio" class="sr-only" id="viewMode3" name="viewMode" value="3">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="{{ trans('messages.keyword_view_mode') }} 3">
              VM3
            </span>
          </label>
        </div>

        <div class="dropdown dropup docs-options">
          <button type="button" class="btn btn-primary btn-block dropdown-toggle" id="toggleOptions" data-toggle="dropdown" aria-expanded="true">
            {{ trans('messages.keyword_toggle_options') }} 
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="toggleOptions" role="menu">
            <li class="form-check" role="presentation">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="responsive" checked>
                responsive
              </label>
            </li>
            <li class="form-check" role="presentation">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="restore" checked>
                restore
              </label>
            </li>
            <li class="form-check" role="presentation">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="checkCrossOrigin" checked>
                checkCrossOrigin
              </label>
            </li>
            <li class="form-check" role="presentation">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="checkOrientation" checked>
                checkOrientation
              </label>
            </li>

            <li class="form-check" role="presentation">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="modal" checked>
                modal
              </label>
            </li>
            <li class="form-check" role="presentation">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="guides" checked>
                guides
              </label>
            </li>
            <li class="form-check" role="presentation">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="center" checked>
                center
              </label>
            </li>
            <li class="form-check" role="presentation">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="highlight" checked>
                highlight
              </label>
            </li>
            <li class="form-check" role="presentation">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="background" checked>
                background
              </label>
            </li>

            <li class="form-check" role="presentation">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="autoCrop" checked>
                autoCrop
              </label>
            </li>
            <li class="form-check" role="presentation">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="movable" checked>
                movable
              </label>
            </li>
            <li class="form-check" role="presentation">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="rotatable" checked>
                rotatable
              </label>
            </li>
            <li class="form-check" role="presentation">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="scalable" checked>
                scalable
              </label>
            </li>
            <li class="form-check" role="presentation">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="zoomable" checked>
                zoomable
              </label>
            </li>
            <li class="form-check" role="presentation">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="zoomOnTouch" checked>
                zoomOnTouch
              </label>
            </li>
            <li class="form-check" role="presentation">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="zoomOnWheel" checked>
                zoomOnWheel
              </label>
            </li>
            <li class="form-check" role="presentation">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="cropBoxMovable" checked>
                cropBoxMovable
              </label>
            </li>
            <li class="form-check" role="presentation">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="cropBoxResizable" checked>
                cropBoxResizable
              </label>
            </li>
            <li class="form-check" role="presentation">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="toggleDragModeOnDblclick" checked>
                toggleDragModeOnDblclick
              </label>
            </li>
          </ul>
        </div><!-- /.dropdown -->

        <a class="btn btn-secondary btn-block" data-toggle="tooltip" data-animation="false" href="https://fengyuanchen.github.io/cropperjs" title="Cropper without jQuery">Cropper.js</a>

        <input type="hidden" name="quizid" id="quizid" value="{{ $quizid}}"/>

      </div><!-- /.docs-toggles -->
    </div>
  </div>
                

            <div class="step-footer">
              <div class="dots"> <span class="dot"> </span> <span class="dot"> </span> <span class="dot"> </span> <span class="dot"> </span> <span class="dot active"> </span> <span class="dot"> </span>
                <div class="page">5/7</div>
              </div>
              <ul class="list-inline">
                <li><a class="prev-step" id="prev_stepfive"> {{ trans('messages.keyword_back') }} </a></li>
                <li><a class="next-step" id="next_stepfive"> {{ trans('messages.keyword_next') }} </a></li>
              </ul>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script> -->

<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script> -->

<!-- <script type="text/javascript" src="{{asset('public/scripts/cropper.js')}}"></script> -->
<!-- <script type="text/javascript" src="{{asset('public/scripts/cropper_main.js')}}"></script> -->

<script type="text/javascript">

  $('#prev_stepfive').click(function() {
    window.history.back();
  });

  $('#next_stepfive').click(function() {

    var dataX = $("#dataX").val();
    var dataY = $("#dataY").val();
    var dataWidth = $("#dataWidth").val();
    var dataHeight = $("#dataHeight").val();
    var dataRotate = $("#dataRotate").val();
    var dataScaleX = $("#dataScaleX").val();
    var dataScaleY = $("#dataScaleY").val();
    var quizid = $("#quizid").val();
    var _token = $('input[name="_token"]').val();
    
    $.ajax({

        type:'POST',
        data: {
            'dataX': dataX,
            'dataY': dataY,
            'dataWidth': dataWidth,
            'dataHeight': dataHeight,
            'dataRotate': dataRotate,
            'dataScaleY': dataScaleY,
            'quiz_id':quizid,            
            '_token' : _token
        },

        url: '{{ url('storeStepfive') }}',

        success:function(data) {  
          console.log(data);
        }
    });

  });

</script>

@endsection