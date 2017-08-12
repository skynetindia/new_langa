<link href="{{asset('public/css/dropzone.css')}}" rel="stylesheet" />
<script type="text/javascript" src="{{asset('public/scripts/dropzone.js')}}"></script>
<?php
//$userid = Auth::user()->id;
$mediaDetails = getallmedias();
$mediaCode = date('dmyhis');
?><div class="space10"></div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="image_upload_div">
                    <?php echo Form::open(array('url' => 'dashboard/uploadfiles/'. $mediaCode, 'files' => true,'class'=>'dropzone')) ?>
                    {{ csrf_field() }}
                    </form>       
                </div>
                <div class="">
                    <input type="text" class="form-control" name="searchmediabox" id="searchmediabox" placeholder="{{trans('messages.keyword_search_media')}}">
                </div>
            </div>
            
            <div class="space10"></div>
<div class="col-md-12 col-sm-12 col-xs-12">
            <div class="set-height450">                
                <table class="table table-striped table-bordered">                  
                    <tbody id="mainmedialist"><?php
                    if(isset($mediaDetails) && count($mediaDetails) > 0){
                    foreach($mediaDetails as $prev) {
                        $arrFolder[0]='quote';
                        $arrFolder[1]='projects';
                        $arrFolder[3]='invoice';
                        $arrFolder[4]='quiz';
                        $arrFolder[5]='user';
                        $arrFolder[6]='dashboard';
                        
                        $imagPath = url('/storage/app/images/'.$arrFolder[$prev->master_type].'/'.$prev->name);
                        $downloadlink = url('/storage/app/images/'.$arrFolder[$prev->master_type].'/'.$prev->name);
                        $filename = $prev->name;            
                        $arrcurrentextension = explode(".", $filename);
                        $extention = end($arrcurrentextension);
                                    
                        $arrextension['docx'] = 'docx-file.jpg';
                        $arrextension['pdf'] = 'pdf-file.jpg';
                        $arrextension['xlsx'] = 'excel.jpg';
                        if(isset($arrextension[$extention])) {
                            continue;
                            $imagPath = url('/storage/app/images/default/'.$arrextension[$extention]);          
                        }
                        $titleDescriptions = (!empty($prev->title)) ? '<hr><strong>'.$prev->title.'</strong><p>'.$prev->description.'</p>' : "";
                        //if(checkpermission('3', '16', 'scrittura','true')){
                        if($prev->master_type=='6' && $prev->master_id==Auth::user()->id){
                            $html = '<tr class="quoteFile_'.$prev->id.'"><td><img src="'.$imagPath.'" height="100" width="100"><a href="'.$downloadlink.'" class="btn btn-info pull-right"  download><i class="fa fa-download"></i></a><a class="btn btn-success pull-right"  onclick="sociallinks('.$prev->id.')"><i class="fa fa-share-alt"></i></a><a class="btn btn-danger pull-right" style="text-decoration: none; color:#fff" onclick="deleteQuoteFile('.$prev->id.')"><i class="fa fa-trash"></i></a>'.$titleDescriptions.'</td></tr>';
                        }
                        else {
                            $html = '<tr class="quoteFile_'.$prev->id.'"><td><img src="'.$imagPath.'" height="100" width="100"><a href="'.$downloadlink.'" class="btn btn-info pull-right"  download><i class="fa fa-download"></i></a><a class="btn btn-success pull-right"  onclick="sociallinks('.$prev->id.')"><i class="fa fa-share-alt"></i></a>'.$titleDescriptions.'</td></tr>';   
                        }
                        $html .='<tr class="quoteFile_'.$prev->id.'"><td>';
                        $utente_file = DB::table('ruolo_utente')->select('*')->where('is_delete', '=', 0)->where('nome_ruolo','!=','SupperAdmin')->get();                           
                        /*foreach($utente_file as $key => $val){
                            $check = '';
                            $array = explode(',', $prev->type);
                            if(in_array($val->ruolo_id,$array)){                    
                                $check = 'checked';
                            }
                            $specailcharcters = array("'", "`");
                            $rolname = str_replace($specailcharcters, "", $val->nome_ruolo);
                            if(checkpermission('3', '16', 'scrittura','true')){    
                            $html .=' <div class="cust-checkbox"><input type="checkbox" name="rdUtente_'.$prev->id.'"  '.$check.' id="'.trim($rolname).'_'.$prev->id.'" onchange="updateType('.$val->ruolo_id.','.$prev->id.',this.id);"  value="'.$val->ruolo_id.'" /><label for="'.trim($rolname).'_'.$prev->id.'"> '.$val->nome_ruolo.'</label><div class="check"><div class="inside"></div></div></div>';
                            }
                            else {
                                $html .=' <div class="cust-checkbox"><input type="checkbox" name="rdUtente_'.$prev->id.'"  '.$check.' id="'.trim($rolname).'_'.$prev->id.'" disabled readyonly value="'.$val->ruolo_id.'" /><label for="'.trim($rolname).'_'.$prev->id.'"> '.$val->nome_ruolo.'</label><div class="check"><div class="inside"></div></div></div>';
                            }
                        }*/
                        echo $html .='</td></tr>';
                     }
                    }
                    ?></tbody>
                    <tbody id="files">
                    </tbody>
                    
                    <script>
                    $('#searchmediabox').keyup(function(e) {
                         var keyvalue = $(this).val();
                         var urlgetfile = '<?php echo url('/dashboard/searchmedia/'); ?>';   
                         if(keyvalue !="") {
                             var urlgetfile = '<?php echo url('/dashboard/searchmedia/'); ?>/'+keyvalue;   
                         }   
                         $.ajax({url: urlgetfile, success: function(result) {
                          $("#mainmedialist").html(result);                          
                         }
                        });                          
                      });

                    var $ = jQuery.noConflict();
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

                        var $ = jQuery.noConflict();
                        var urlgetfiled = '<?php echo url('dashboard/getfiles/'.$mediaCode); ?>';
                        Dropzone.autoDiscover = false;
                        $(".dropzone").each(function() {
                          $(this).dropzone({
                          complete: function(file) {
                            if (file.status == "success") {
                               $.ajax({url: urlgetfiled, success: function(result){                
                                    $("#mainmedialist").html(result);
                                    $(".dz-preview").remove();
                                    $(".dz-message").show();
                              }});
                            }
                            if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                                $( "#addMediacommnetmodal" ).modal();
                                $('#addMediacommnetmodal').on('shown.bs.modal', function(){                    
                                });
                            }
                          }
                          });
                        });        
                        function deleteQuoteFile(id){
                          var urlD = '<?php echo url('/progetti/deletefiles/'); ?>/'+id;
                            $.ajax({url: urlD, success: function(result){
                              $(".quoteFile_"+id).remove();
                              }});
                        }

                     function sociallinks(id){   
                        $("#social_id").val(id); 
                        $.ajax({
                            url:"{{url('social/image')}}",
                            type:'post',
                            data: { "_token": "{{ csrf_token() }}","idval": id },
                            success:function(data){
                                 $("#socialmedia").modal();
                                 $('#newsocial').html(data);
                            } 
                        });
                    }
                
                    </script>
                </table>
                </div>
</div>

<div class="modal fade newsocial-popu" id="socialmedia" role="dialog" aria-labelledby="modalTitle">
    <div class="modal-dialog modal-l">
        <div class="modal-content">

                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                    <h3 class="modal-title" id="modalTitle">{{trans('messages.keyword_social_media')}}</h3>
                </div>
                 <div class="modal-body">
                <input type="hidden" id="social_id" name="social_id" value="">
                <div class="row" id="newsocial">
            <?php 

                if(isset($socials)){
                    foreach ($socials as $social) { ?>
                    <div class="col-md-3 col-sm-4 col-xs-4">
                    <a href="" class="img-responsive">
                        <img src="{{ url('storage/app/images/social/'.$social->image)}}" alt="{{$social->title}}">
                    </a>
                    </div>    
                <?php   
                    }
                }
            ?>
            </div>
                  
            </div>
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
                <form action="{{ url('/progetti/mediacomment/').'/'.$mediaCode }}" name="commnetform" method="post" id="commnetform">
                    {{ csrf_field() }}
                    @include('common.errors')                       
                    <div class="row">
                        <div class="col-md-12">                                                           
                            <div class="form-group">
                                <label for="title" class="control-label"> {{ ucfirst(trans('messages.keyword_title')) }} </label>
                                <input value="{{ old('title') }}" type="text" name="title" id="title" class="form-control required-input" placeholder="{{ ucfirst(trans('messages.keyword_title')) }} ">
                            </div>
                            <div class="form-group">
                                <label for="url" class="control-label"> {{ ucfirst(trans('messages.keyword_url')) }}  </label>
                                <input value="{{ old('url') }}" type="text" name="url" id="url" class="form-control required-input" placeholder="{{ ucfirst(trans('messages.keyword_url')) }} ">
                            </div>
                            <div class="form-group">
                                <label for="descriptions" class="control-label"> {{ ucfirst(trans('messages.keyword_description')) }} </label>
                                <textarea rows="5" name="descriptions" id="descriptions" class="form-control required-input" placeholder="{{ ucfirst(trans('messages.keyword_description')) }}">{{ old('descriptions') }}</textarea>
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
<script type="text/javascript">
$(document).ready(function() {
    $("#commnetform").validate({            
            rules: {
                title: {
                    required: true
                },
                descriptions: {
                    required: true                    
                },
                url: {
                  required: true,
                  url:true  
                }
            },
            messages: {
                title: {
                    required: "{{trans('messages.keyword_please_enter_a_title')}}"
                },
                descriptions: {
                    required: "{{trans('messages.keyword_please_enter_a_description')}}"
                },
                url: {
                  required: "Please enter url",                    
                  url:"Please enter valid url" 
                }
            }
        });
    $(function(){
        $('#commnetform').on('submit',function(e){
            $.ajaxSetup({
                header:$('meta[name="_token"]').attr('content')
            })
            e.preventDefault(e);
                $.ajax({
                type:"POST",
                url:'{{ url('/progetti/mediacomment/').'/'.$mediaCode }}',
                data:$(this).serialize(),
                //dataType: 'json',
                success: function(data) {                    
                    if(data == 'success') {
                         $.ajax({url: urlgetfiled, success: function(result){                
                            $("#mainmedialist").html(result);
                            $(".dz-preview").remove();
                            $(".dz-message").show();
                        }});
                      $('#addMediacommnetmodal').modal('hide');
                    }
                },
                error: function(data){                   
                  if(data == 'success'){
                        $.ajax({url: urlgetfiled, success: function(result){                
                            $("#mainmedialist").html(result);
                            $(".dz-preview").remove();
                            $(".dz-message").show();
                        }});
                      $('#addMediacommnetmodal').modal('hide');
                    }
                }
            })
            });
        });
});
</script>