@if(!empty(Session::get('msg')))

    <script>

    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';

    document.write(msg);

    </script>

@endif

@include('common.errors')

<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>
<script src="{{ asset('public/scripts/jquery.raty.js') }}"></script>
<script src="{{ asset('public/scripts/labs.js') }}"></script>
<link rel="stylesheet" href="{{ asset('public/scripts/jquery.raty.css') }}">
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
  <!-- HTML Structure -->
<div class="right-side">

      <?php /*<div class="right-header">
        <div class="responsive-icons"> <img src="images/desktop.jpg"> <img src="images/tablet.jpg"> <img src="images/mobile.jpg"> </div>
      </div>*/?>
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
    
      <div class="right-content">
        <div class="img-wrap"><iframe src="{{$demodettagli->url}}"></iframe>  </div>
        <div class="right-footer">
          <div class="row">
          <?php $averageScore = 3; ?>
          @foreach($ratType as $ratType)
            <div class="col-md-4">
              <div class="rating" id="ratingdetail_{{$ratType->rating_id}}"></div>

            <?php  $score = DB::table('quiztype_user_rat')               
                ->where('quiz_rating_type_id', $ratType->rating_id)
                ->where('demo_detail_id', $demodettagli->id)
                ->where('quiz_id', $quizid)->first();

                if(!$score){ $score = DB::table('quiztype_user_rat')
                    ->select(DB::raw('AVG(rating) as average'))
                    ->where('demo_detail_id', $demodettagli->id)
                    ->where('quiz_rating_type_id', $ratType->rating_id)->first();
                } ?>

               <script>	               
                   var _token = $('input[name="_token"]').val();		
        			$('#ratingdetail_<?php echo $ratType->rating_id;?>').raty({
        				path : '<?php echo url('/public/images/raty');?>',
        				'score': '<?php if(isset($score->rating)){ echo $score->rating; } else { echo $score->average; }?>',
        				click: function(score, evt) {
        					$("#score_<?php echo $ratType->rating_id;?>").text(score.toFixed(2)+'/5');
        					var path = '/quiz/saveDetails/';
        					   $.ajax({
        							type:'POST',
        							data: {'quiz_id': '<?php echo $quizid;?>','quiz_rating_type_id':'<?php echo $ratType->rating_id;?>','rating':score, '_token' : _token, 'detail_id':'<?php echo $detail_id;?>', 'demo_detail_id': '<?php echo $demodettagli->id;?>'},
        							url: '{{ url("/quiz/saveDetails/") }}',
        							success:function(data) {
        								 $(".average").text(parseFloat(data).toFixed(2));
                                        setAverageRat();
        							}
        						});
        				  }
        				});
        			setAverageRat();	
        			function setAverageRat(score){
        				$('#overall_rating_<?php echo $demodettagli->id;?>').raty({
        						path : '<?php echo url('/public/images/raty');?>',
        						'score': score,
        						readOnly: true
        						});							
        				
        			}
                    </script>
                      <div class="stars"> <span class="score" id="score_<?php echo $ratType->rating_id;?>">

                      <?php if(isset($score->rating)) { 
                            $score = number_format($score->rating, 2, '.', ''); 
                            echo $score; 
                        } else { 
                            $score = number_format($score->average, 2, '.', '');
                            echo $score; 
                        }?>/5</span> </div>
                      <div class="starline"> {{ $ratType->titolo }} </div>
                    </div>
                    @endforeach
                    <div class="col-md-4">

                      <div class="rating" id="overall_rating_<?php echo $demodettagli->id;?>"> </div>  

                      <div class="rating">                                           
                        <div class="star-count" id="star-count_{{$demodettagli->id}}"><?php 
                        $tassomedio = number_format($demodettagli->tassomedio, 2, '.', '');  
                        ?>
                        <span class="average"><?php echo $tassomedio; ?></span><?php echo '/'.$demodettagli->tassototale;?></div>
                        </div>

                    </div>

                    <script>             
                    $('#overall_rating_<?php echo $demodettagli->id;?>').raty({
                        path : '<?php echo url('/public/images/raty');?>',
                        'score': '<?php echo $demodettagli->tassomedio;?>',
                        readOnly    : true, 
                        click: function(score, evt) {
                            $("#star-count_<?php echo $demodettagli->id;?>").text(score+'/5');
                          }
                        });
                    </script>

                      <div class="starline overall"> 
                      {{ trans('messages.keyword_total_score') }}  </div>
                    </div>
                  </div>                  
                </div>
              </div>
            </div>

<!-- JQeury code required for STEP wizard -->
  <script>
    $(document).ready(function () {

    //Initialize tooltips
    $('.nav-tabs > li a[title]').tooltip();
    
    //Wizard
    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

        var $target = $(e.target);
    
        if ($target.parent().hasClass('disabled')) {
            return false;
        }
    });

    $(".next-step").click(function (e) {

        var $active = $('.wizard .nav-tabs li.active');
        $active.next().removeClass('disabled');
        nextTab($active);

    });
    $(".prev-step").click(function (e) {

        var $active = $('.wizard .nav-tabs li.active');
        prevTab($active);

    });
});

function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
}
  
  </script>