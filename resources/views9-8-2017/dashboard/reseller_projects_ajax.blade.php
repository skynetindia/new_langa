 <script src="http://d3js.org/d3.v3.min.js"></script> 
 <script src="{{asset('public/scripts/RadarChart.js')}}"></script> 
<div class="col-md-12">
    <div class="bg-white image-upload-box">       
        <div>
        @foreach($project as $keypro => $valkeypro)
        <div class="col-md-6">
          <div class="bg-white">
            <div id="body">
              <label> {{$valkeypro->nomeprogetto}}</label><br> <br> 
              <div id="chart_{{$keypro}}"></div>
            </div>
          </div>
        </div>
        @endforeach
        </div>                  
    </div>
    {{ $project->links() }}  
</div>
<script>
var w = 250,
    h = 250;
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
  ExtraWidthX: 100
}

//Data
@foreach($project as $keypro => $valkeypro)
  <?php $chartspro = $chartdetails[$valkeypro->id]; ?>
var d = [                
          [
          @foreach($chartspro as $key => $oggettostatoval)        
            {axis:"{{ $oggettostatoval->nome }}",value:{{($oggettostatoval->completedPercentage/100)}}},
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
    .append('svg')
    .attr("width", w+250)
    .attr("height", h)
        
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