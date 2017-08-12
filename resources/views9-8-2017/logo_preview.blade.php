<div class="langa-slider">
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Wrapper for slides -->
  <div class="carousel-inner">
    <div class="item langa-slider-1 <?php echo (isset($currenttype) && $currenttype == "adminlogo") ? 'active' : '';?>">
        @include('logo_preview_admin')       
      <div class="carousel-caption">       
      </div>
    </div>
    <div class="item langa-slider-2 <?php echo (isset($currenttype) && $currenttype == "frontlogo") ? 'active' : '';?>">
     @include('logo_preview_front_one')
      <div class="carousel-caption">
        
      </div>
    </div>
     <div class="item langa-slider-3 <?php echo (isset($currenttype) && $currenttype == "pdflogo") ? 'active' : '';?>">
      @include('logo_preview_front_two')
      <div class="carousel-caption">
        
      </div>
    </div>
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
  </a>
</div>
</div>
<script>
$(function () {
    $('#carousel-example-generic').carousel({
        interval:false,
        pause: "true"
    });
});
</script>