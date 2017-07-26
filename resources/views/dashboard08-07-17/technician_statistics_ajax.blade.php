 <script src="http://d3js.org/d3.v3.min.js"></script> 
 <script src="{{asset('public/scripts/RadarChart.js')}}"></script> 
<div class="col-md-12">
    <div class="bg-white image-upload-box">
        <label> {{trans('messages.keyword_project_graph')}}</label><br> <br> 
        <div id="body">
          <div id="chart"></div>
        </div>              
    </div>
</div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">                            
    <div class="col-md-4 col-sm-12 col-xs-12">
        <h5 style="color: #0002fb">Web </h5> 
        <h1 style="color: #0002fb">52.5%</h1> 
        <span style="color: #0002fb">+2% </span>  From last week 
    </div>                                                         
    <div class="col-md-4 col-sm-12 col-xs-12">
        <h5 style="color: #fafe02">Print</h5> 
        <h1 style="color: #fafe02">63.5 %</h1>
        <span style="color: #fafe02"> +1% </span>  From last week 
    </div>
    <div class="col-md-4 col-sm-12 col-xs-12">                                                        
        <h5 style="color: #000000">Video</h5>
        <h1 style="color: #000000">52.5%</h1>
        <span style="color: #000000"> +2% </span>  From last week 
    </div> 
</div>
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
//Data
var d = [
        @foreach($chartdetails as $keypro => $valkeypro)        
          [
          @foreach($valkeypro as $key => $oggettostatoval)        
            {axis:"{{ $oggettostatoval->nome }}",value:{{($oggettostatoval->completedPercentage/100)}}},
            @endforeach
          ],          
        @endforeach
        ];
//Options for the Radar chart, other than default
var mycfg = {
  w: w,
  h: h,
  maxValue: 1.0,
  levels: 10,
  ExtraWidthX: 100
}

//Call function to draw the Radar chart
//Will expect that data is in %'s
RadarChart.draw("#chart", d, mycfg);

////////////////////////////////////////////
/////////// Initiate legend ////////////////
////////////////////////////////////////////

var svg = d3.select('#body')
    .selectAll('svg')
    .append('svg')
    .attr("width", w+250)
    .attr("height", h)

//Create the title for the legend
/*var text = svg.append("text")
    .attr("class", "title")
    .attr('transform', 'translate(90,0)') 
    .attr("x", w - 60)
    .attr("y", 10)
    .attr("font-size", "12px")
    .attr("fill", "#404040")
    .text("What % of owners use a specific service in a week");*/
        
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