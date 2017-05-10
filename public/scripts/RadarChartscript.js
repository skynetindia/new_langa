var w = 300,
	h = 300;

var colorscale = d3.scale.category10();

//Legend titles
//var LegendOptions = ['Smartphone','Tablet'];
var LegendOptions = [];

//Data
var d = [
		  [
			{axis:"Eating",value:0.20},
			{axis:"Drinking",value:0.30},
			{axis:"Sleeping",value:0.42},
			{axis:"Designing",value:0.34},
			{axis:"Coding",value:0.48},
			{axis:"Cycling",value:0.14},
			{axis:"Running",value:0.14}
		  ],[
			{axis:"Eating",value:0.48},
			{axis:"Drinking",value:0.90},
			{axis:"Sleeping",value:0.27},
			{axis:"Designing",value:0.28},
			{axis:"Coding",value:0.46},
			{axis:"Cycling",value:0.29},
			{axis:"Running",value:0.29}
		  ]
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
	.attr("width", w+300)
	.attr("height", h)

//Create the title for the legend
var text = svg.append("text")
	.attr("class", "title")
	.attr('transform', 'translate(90,0)') 
	.attr("x", w - 70)
	.attr("y", 10)
	.attr("font-size", "12px")
	.attr("fill", "#404040")
	.text("What % of owners use a specific service in a week");
		
//Initiate Legend	
var legend = svg.append("g")
	.attr("class", "legend")
	.attr("height", 100)
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