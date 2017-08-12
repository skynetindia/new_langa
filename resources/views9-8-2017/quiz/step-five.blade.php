@extends('layouts.app')
<meta name="_token" content="{{ csrf_token() }}">
@section('content')

@if(!empty(Session::get('msg')))

<script>

var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';

document.write(msg);

</script>

@endif

@include('common.errors')                                     

 <!-- CSS required for STEP Wizard  -->
 

<link href="{{asset('public/css/dropzone.css')}}" rel="stylesheet" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/css/tether.min.css">
<link href="{{asset('public/css/cropper_main.css')}}" rel="stylesheet" />
<link href="{{asset('public/css/cropper.css')}}" rel="stylesheet" />

<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>
<!-- <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js"></script> -->

<script type="text/javascript" src="{{asset('public/scripts/dropzone.js')}}"></script>
<?php //dd($lastupdated); ?>
<div class="row quiz-wizard">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <h1> {{ trans('messages.keyword_quiz') }} </h1>
    <div class="wizard wizard-step-line">
      <div class="wizard-inner">
        <div class="connecting-line"></div>
        <ul class="nav nav-tabs">
          <li role="presentation" class="top0 active"> <a href="{{ url('/quiz/stepone') }}" title="Step 1"> <span class="round-tab"> <img src="{{ asset('images/folder.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_enter_data') }} </span> </a> </li>
          <li role="presentation" class="top0 active"> <a href="{{ url('/quiz/steptwo/'.$quizid) }}" title="Step 2"> <span class="round-tab"> <img src="{{ asset('images/star.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_currency_demo') }} </span> </a> </li>
          <li role="presentation" class="top0 active"> <a href="{{ url('/quiz/stepthree/'.$quizid) }}" title="Step 3"> <span class="round-tab"> <img src="{{ asset('images/edit.png') }}"> </span> <span class="tab-name">{{ trans('messages.keyword_colors__layouts') }} </span> </a> </li>
          <li role="presentation" class="top0 active"> <a href="{{ url('/quiz/stepfour/'.$quizid) }}" title="Complete"> <span class="round-tab"> <img src="{{ asset('images/list.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_optional') }} </span> </a> </li>
          <li role="presentation" class="top0 active"> <a href="#" title="Complete"> <span class="round-tab"> <img src="{{ asset('images/media.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_media') }} </span> </a> </li>
          
          <li role="presentation" class="top0 disabled"> <a href="#" title="Complete"> <span class="round-tab"> <img src="{{ asset('images/flag.png') }}"> </span> <span class="tab-name"> {{ trans('messages.keyword_media') }} </span> </a> </li>
          
        </ul>
      </div>
      </div>
      <div class="wizard">
        <!-- Content -->
  <div class="step-five container">
    <div class="row">
      <div class="col-md-7 col-sm-12 col-xs-12">
        <!-- <h3>Demo:</h3> -->
        <div class="img-container">
          <img id="image" src="{{ asset('images/demo1-big.png') }}" alt="Picture" class="img-responsive">
        </div>
      </div>
      
     
      
      <div class="col-md-2 col-sm-12 col-xs-12">
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

        <input type="hidden" name="mediaCode" id="mediaCode" value="{{$mediaCode}}" />

        <div class="col-md-3 col-sm-12 col-xs-12">
        <!-- Form-3 start  -->

        <!-- <div class="pull-right col-md-4"> -->

            <div class="">
            <label for="scansione">  {{ trans('messages.keyword_attachment') }} </label>
            </div>
            <br>
        
            <div class="">

                <div class="image_upload_div">
                <?php echo Form::open(array('url' => '/stepfive/uploadfiles/'. $mediaCode, 'files' => true,'class'=>'dropzone')) ?>

                <input type="hidden" name="quizid" id="quizid" value="{{ $quizid}}"/>

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
                      if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                           $( "#addMediacommnetmodal" ).modal();
                           $('#addMediacommnetmodal').on('shown.bs.modal', function(){});
                      }
                    }
                  });
                });

                function deleteQuoteFile(id){
                    var urlD = '<?php echo url('/stepfive/deletefiles/'); ?>/'+id;
                        $.ajax({url: urlD, success: function(result){
                            $(".quoteFile_"+id).remove();
                        }});

                    var src = "<?php echo ""; ?>";          
                    $( "#image" ).attr('src', src);
                    $( ".cropper-canvas" ).children().attr('src', src);
                    $( ".cropper-view-box" ).children().attr('src', src);
                    $( ".preview-lg" ).children().attr('src', src);
                    $( ".preview-md" ).children().attr('src', src);
                    $( ".preview-sm" ).children().attr('src', src);
                    $( ".preview-xs" ).children().attr('src', src);  
                }

                function updateType(typeid,fileid,checkboxid1){           
                    var ischeck = 0;            
                    if($('#'+checkboxid1+':checkbox:checked').length > 0){                
                        var ischeck = 1;
                    }
                    var checkValues = $('input[name=rdUtente_'+fileid+']:checked').map(function()
                    {
                        return $(this).val();
                    }).get();
                    var urlD = '<?php echo url('/stepfive/updatefiletype/'); ?>/'+typeid+'/'+fileid;

                    $.ajax({
                        url: urlD,
                        type: 'post',
                        data: { "_token": "{{ csrf_token() }}",ids: checkValues },
                        success:function(data){
                        }
                    });
                    //$.ajax({url: urlD, success: function(result){ }});
                }   
                
                </script>
                
                <div class="set-height450">
                
        <table class="table table-striped table-bordered">                  
          <tbody><?php
          if(isset($quizid) && isset($quizfiles)){

          foreach($quizfiles as $prev) {
                $imagPath = url('/storage/app/images/quiz/'.$prev->name);
                        $titleDescriptions = (!empty($prev->title)) ? '<hr><strong>'.$prev->title.'</strong><p>'.$prev->description.'</p>' : "";
                $html = '<tr class="quoteFile_'.$prev->id.'"><td><img src="'.$imagPath.'" height="100" width="100" onclick="displayFile(this, '.$prev->id.' )"><a class="btn btn-danger pull-right"  onclick="deleteQuoteFile('.$prev->id.')"><i class="fa fa-trash"></i></a>'.$titleDescriptions.'</td></tr>';
                $html .='<tr class="quoteFile_'.$prev->id.'"><td>';
                $utente_file = DB::table('ruolo_utente')->select('*')->where('is_delete', '=', 0)->where('ruolo_id','!=','0')->get();             
                foreach($utente_file as $key => $val){
                  $check = '';
                  $array = explode(',', $prev->type);
                    if(in_array($val->ruolo_id,$array)){                    
                        $check = 'checked';
                    }
                    $specailcharcters = array("'", "`");
                    $rolname = str_replace($specailcharcters, "", $val->nome_ruolo);

                    $html .=' <div class="cust-checkbox"><input type="checkbox" name="rdUtente_'.$prev->id.'"  '.$check.' id="'.$rolname.'_'.$prev->id.'" onchange="updateType('.$val->ruolo_id.','.$prev->id.',this.id);"  value="'.$val->ruolo_id.'" /><label for="'.$rolname.'_'.$prev->id.'"> '.$val->nome_ruolo.'</label><div class="check"><div class="inside"></div></div></div>';
                }
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
    
        </div>

     <div class="modal fade" id="addMediacommnetmodal" role="dialog" aria-labelledby="modalTitle">
      <div class="modal-dialog modal-l">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title" id="modalTitle">{{trans('messages.keyword_add_title_and_description')}}</h3>
          </div>
          <div class="modal-body">
            <!-- Start form to add a new event -->
            <form action="{{ url('/quiz/mediacomment/').'/'.$mediaCode }}" name="commnetform" method="post" id="commnetform">
            {{ csrf_field() }}
            @include('common.errors')                       
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">                               
                    <div class="form-group">
                        <label for="title" class="control-label"> {{ ucfirst(trans('messages.keyword_title')) }} <span class="required">(*)</span> </label>
                          <input value="{{ old('title') }}" type="text" name="title" id="title" class="form-control" placeholder="{{ ucfirst(trans('messages.keyword_title')) }} ">
                      </div>
                      <div class="form-group">
                          <label for="descriptions" class="control-label"> {{ ucfirst(trans('messages.keyword_description')) }} <span class="required">(*)</span></label>
                          <textarea rows="5" name="descriptions" id="descriptions" class="form-control" placeholder="{{ ucfirst(trans('messages.keyword_description')) }}">{{ old('descriptions') }}</textarea>
                      </div>
                        </div>
                   </div>
                  <div class="modal-footer">
                    <input type="submit" class="btn btn-warning" value="{{ trans('messages.keyword_submit') }} ">
                  </div>
              </form>
              <!-- End form to add a new event -->
                </div>
            </div>
        </div>
    </div>



    <div class="">
      <div class="col-md-7 col-sm-12 col-xs-12 docs-buttons">
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

                <input type="hidden" id="imgid" name="imgid" value="">

                <a class="btn btn-primary" id="download" href="javascript:void(0);" download="cropped.jpg"> {{ trans('messages.keyword_download') }}  </a>

                <a class="btn btn-warning" id="save_cropped"> {{ trans('messages.keyword_save') }}  </a>

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

      <div class="col-md-2 col-sm-12 col-xs-12 docs-toggles">
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

        <div class="btn-block btn-group d-flex flex-nowrap" data-toggle="buttons">
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
              
              <div class="quiz-btn-save">
 
  <?php if(isset($payment_status->payment_status) && $payment_status->payment_status == 1) { ?>
 	
	 <button id="firm" class="btn btn-default">
    	{{ trans('messages.keyword_firm') }}
  	</button>
  
   <script type="text/javascript">
    $('.main_container').addClass('disabled');
    </script>
   <?php } ?>
  <?php if(isset($payment_status->payment_status) && $payment_status->payment_status == 2) { ?>

  <button id="down_payment" class="btn btn-default">
    {{ trans('messages.keyword_pay_down') }} 
  </button>
 
   <script type="text/javascript">
    $('.main_container').addClass('disabled');
    </script>
  <?php } ?>
</div>
            </div>
            
        </div>
      </div>
    </div>
  </div>
  
  
<?php 
  $request = parse_url($_SERVER['REQUEST_URI']);
  $path = ($_SERVER['HTTP_HOST'] == 'localhost') ? rtrim(str_replace('/easylanganew/', '', $request["path"]), '/') : $request["path"]; 
  $result = rtrim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $path), '/');
  $result = substr($result, 0, -3);
   $result=trim($result,'/');
  $comic = DB::table('quiz_comic')->where('url', $result)->first();

  if(isset($comic)){
    $language_transalation = DB::table('language_transalation')->where('language_key', $comic->lang_key)->first();
  }
?>



  
</div>



<script type="text/javascript">

$("#firm").click(function(e){
  var quizid = $("#quizid").val();
  var seekString = "/quiz";
  currenrUrl = window.location.href;
  var idx = currenrUrl.indexOf(seekString);
  if (idx !== -1) {
    var url = currenrUrl.substring(0, idx + seekString.length);
  }
  var quizid = $("#quizid").val();
  currenrUrl = document.location = url+"/stepseven/"+quizid;

});

$("#down_payment").click(function(e){

  var quizid = $("#quizid").val();
  var seekString = "/quiz";
  currenrUrl = window.location.href;
  var idx = currenrUrl.indexOf(seekString);
  if (idx !== -1) {
    var url = currenrUrl.substring(0, idx + seekString.length);
  }
  var quizid = $("#quizid").val();
  currenrUrl = document.location = url+"/stepseven/"+quizid;

});

  $('#save_cropped').on('click', function(){
    location.reload();
  });

  $('#prev_stepfive').click(function() {
    window.history.back();
  });

  $('#next_stepfive').click(function() {

      var quizid = $("#quizid").val();
      var seekString = "/quiz";
      currenrUrl = window.location.href;
      var idx = currenrUrl.indexOf(seekString);

      if (idx !== -1) {
        var url = currenrUrl.substring(0, idx + seekString.length);
      }

      var quizid = $("#quizid").val();
      currenrUrl = document.location = url+"/stepsix/"+quizid;


  //   var quizid = $("#quizid").val();
  //   var _token = $('input[name="_token"]').val();
    
  // $.ajax({

  //     type:'POST',
  //     data: {
  //         'dataX': dataX,
  //         'dataY': dataY,    //         
  //         'quiz_id':quizid,            
  //         '_token' : _token
  //     },

  //     url: '{{ url('storeStepfive') }}',

  //     success:function(data) {  
  //       // console.log(data);
  //     }
  // });

  });

  function displayFile(elem, id){

    var imgid = $("#imgid").val(id);    
    var src = $(elem).prop('src');
    var filename=src.substr( (src.lastIndexOf('/') +1) )
    var extension = src.substr( (src.lastIndexOf('.') +1) );
    var imgformat = ["jpe", "jpeg", "jpg", "png", "img"];    
    var  isTrue = isInArray(imgformat, extension);
    filename1=filename.split('.');

    $.ajax({
       type:'GET',     
       url: "{{ url('fileviewer') }}/"+filename1[0]+"/"+filename1[1],
       success:function(data) {
         console.log(data);
       }
    });

    if(isTrue==true){
      $( ".cropper-view-box" ).children().attr('src', src); 
      $( ".cropper-canvas" ).children().attr('src', src);          
      $( ".preview-lg" ).children().attr('src', src);
      $( ".preview-md" ).children().attr('src', src);
      $( ".preview-sm" ).children().attr('src', src);
      $( ".preview-xs" ).children().attr('src', src); 
    }
          
  }

  $(function(){
    $('#commnetform').on('submit',function(e){
      $.ajaxSetup({
          header:$('meta[name="_token"]').attr('content')
      })

      e.preventDefault(e);      
      $.ajax({
      type:"POST",
      url:'{{ url('/quiz/mediacomment/').'/'.$mediaCode }}',
      data:$(this).serialize(),
      //dataType: 'json',
      success: function(data) {                    
        if(data == 'success'){
        $.ajax({url: url, success: function(result){                
            $("#files").html(result);
            $(".dz-preview").remove();
            $(".dz-message").show();
        }});        
        $('#addMediacommnetmodal').modal('hide');
        }
      },
      error: function(data){                   
        if(data == 'success'){
          $.ajax({url: url, success: function(result){                
              $("#files").html(result);
              $(".dz-preview").remove();
              $(".dz-message").show();
          }});
          $('#addMediacommnetmodal').modal('hide');
          }
        }
      })
    });
});

$(document).ready(function() {
  $("#commnetform").validate({            
    rules: {
        title: {
            required: true
        },
        descriptions: {
            required: true                    
        }
    },
    messages: {
        title: {
            required: "{{trans('messages.keyword_please_enter_a_title')}}"
        },
        descriptions: {
            required: "{{trans('messages.keyword_please_enter_a_description')}}"
        }
      }
    });
 });

</script>
 
  <?php if($lastupdated){ ?>

      <script type="text/javascript">
        $( window ).on('load', function(){        
          var src = "<?php echo url('storage/app/images/quiz').'/'.$lastupdated->name; ?>";
          var id = "<?php echo $lastupdated->id; ?>";
          var imgid = $("#imgid").val(id);           
          $( "#image" ).attr('src', src);
          $( ".cropper-canvas" ).children().attr('src', src);
          $( ".cropper-view-box" ).children().attr('src', src);
          $( ".preview-lg" ).children().attr('src', src);
          $( ".preview-md" ).children().attr('src', src);
          $( ".preview-sm" ).children().attr('src', src);
          $( ".preview-xs" ).children().attr('src', src);          
        });
      </script>

  <?php } else { ?>

      <script type="text/javascript">        
        $( window ).on('load', function(){   
		setTimeout(function(){     
          var src = "<?php echo ""; ?>";          
          $( "#image" ).attr('src', src);
          $( ".cropper-canvas" ).children().attr('src', src);
          $( ".cropper-view-box" ).children().attr('src', src);
          $( ".preview-lg" ).children().attr('src', src);
          $( ".preview-md" ).children().attr('src', src);
          $( ".preview-sm" ).children().attr('src', src);
          $( ".preview-xs" ).children().attr('src', src);
		},300);
        });
      </script>


<!--<script type="text/javascript">        
        $( window ).on('load', function(){   
		    
          var src = "<?php echo ""; ?>";          
          $( "#image" ).attr('src', src);
          $( ".cropper-canvas" ).children().attr('src', src);
          $( ".cropper-view-box" ).children().attr('src', src);
          $( ".preview-lg" ).children().attr('src', src);
          $( ".preview-md" ).children().attr('src', src);
          $( ".preview-sm" ).children().attr('src', src);
          $( ".preview-xs" ).children().attr('src', src);
	
        });
      </script>-->


  <?php } ?>

@endsection