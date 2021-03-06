 <script src="http://d3js.org/d3.v3.min.js"></script> 
 <script src="{{asset('public/scripts/RadarChart.js')}}"></script> 
 <div class="row">
<div class="col-md-12">
    <div class="bg-white image-upload-box">       
        <div class="chart-box-dash row">
        @foreach($projects as $keypro => $valkeypro)
        <div class="col-md-6">
          <div class="">
            <div id="body">
              
              <div class="chart-shadow"> <label> {{$valkeypro->nomeprogetto}}</label><br> <br>  <div id="chart_{{$keypro}}"></div></div>
            </div>
          </div>
        </div>
        @endforeach
        </div>                  
    </div>
  	<div class="col-md-12">  {{ $projects->links() }}  </div>
    </div>
</div>
<script>
var w = 150,
    h = 150;
var colorscale = d3.scale.category10();
//Legend titles
var LegendOptions = [];
<?php $value=0.10;?>
//value1=parseFloat(value1) + 0.1;
counter=0;

//Options for the Radar chart, other than default
var mycfg = {
  w: w,
  h: h,
  maxValue: 1.0,
  levels: 10,
   radius: 5,
	
	 factor: 1,
	 factorLegend: .85,
	 radians: 2 * Math.PI,
	 opacityArea: 0.5,
	 ToRight: 5,
	 TranslateX: 100,
	 TranslateY: 30,
	 ExtraWidthX: 248,
	 ExtraWidthY: 65,
}

//Data
@foreach($projects as $keypro => $valkeypro)
  <?php $chartspro = $chartdetails[$valkeypro->id]; ?>
var d = [                
          [
          @foreach($chartspro as $key => $oggettostatoval)  
          <?php  $label = (!empty($oggettostatoval->language_key)) ?  ucwords(strtolower(trans('messages.'.$oggettostatoval->language_key))) : (($oggettostatoval->nome));?>
            {axis:"{{ $label }}",value:{{($oggettostatoval->completedPercentage/100)}}},
          @endforeach
          ],                  
        ];
RadarChart.draw("#chart_{{$keypro}}", d, mycfg);
@endforeach


//Call function to draw the Radar chart
//Will expect that data is in %'s

////////////////////////////////////////////
/////////// Initiate legend ////////////////
////////////////////////////////////////////

var svg = d3.select('#body')
    .selectAll('svg')
    .attr("width", 350)
    .attr("height", 215)
	.attr("viewBox", "0 0 350 215")
	
        
//Initiate Legend   
var legend = svg.append("g")
    .attr("class", "legend")
    .attr("height", 200)
    .attr("width", 200)
    .attr('transform', 'translate(90,20)') 
    ;
    //Create colour squares
    legend.selectAll('rect')
      .data(LegendOptions)
      .enter()
      .append("rect")
      .attr("x", w - 65)
      .attr("y", function(d, i){ return i * 20;})
      .attr("width", 10)
      .attr("height", 10)
      .style("fill", function(d, i){ return colorscale(i);})
      ;
    //Create text next to squares
    legend.selectAll('text')
      .data(LegendOptions)
      .enter()
      .append("text")
      .attr("x", w - 52)
      .attr("y", function(d, i){ return i * 20 + 9;})
      .attr("font-size", "11px")
      .attr("fill", "#737373")
      .text(function(d) { return d; })
      ; 
</script>