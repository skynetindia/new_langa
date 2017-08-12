<style>
tr:hover {
	background: #f39538;
}
.selected {
	font-weight: bold;
	font-size: 16px;
}
th {
	cursor: pointer;
}
</style>
<div class="col-md-12">
    <div class="col-md-8">
        <div class="btn-group">
            <h3 style="display:inline"><a href="javascript:changeYear('{{($year - 1)}}')"><i class="fa fa-arrow-left"></i>{{$year - 1}}</a></h3>
            <h3 style="display:inline;color:#f37f0d"> {{$year}} </h3><h3 style="display:inline"><a href="javascript:changeYear('{{($year + 1)}}')">{{$year + 1}}<i class="fa fa-arrow-right"></i></a></h3>
        </div>
    </div>
    <?php /*<div class="col-md-4">
        <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
            <span id="daterange"></span> <b class="caret"></b>
        </div>
    </div>*/?>
</div>
<div class="canvas-holder" id="stat">
    <canvas id="myChart" width="1080" height="540" style="display: block; width: 1080px; height: 540px;"></canvas>
</div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 statistics-week">                            
    <div class="col-md-4 col-sm-4 col-xs-12">
    	<div class="info-1">
        <h5 style="color: red">{{trans('messages.keyword_cost')}} </h5> 
        <h1 style="color: red"><?php  echo array_sum($statistics['expense']); ?><b> € </b></h1> 
        <span style="color: red"><?php echo getLastCostPercentage($year,'1');?> % </span> From last month 
        </div>
    </div>                                                         
    <div class="col-md-4 col-sm-4 col-xs-12">
    <div class="info-2">
        <h5 style="color: DARKGREEN">{{trans('messages.keyword_proceeds')}}</h5> 
        <h1 style="color: DARKGREEN"><?php echo array_sum($statistics['revenue']); ?> <b> € </b> </h1>
        <span style="color: DARKGREEN"><?php echo getLastRevenuePercentage($year,'1');?>% </span> From last month 
        </div>
    </div>
    <div class="col-md-4 col-sm-4 col-xs-12">   
    <div class="info-3">                                                     
        <h5 style="color: DARKORANGE">{{trans('messages.keyword_profit')}}</h5>
        <h1 style="color: DARKORANGE"><?php echo array_sum($statistics['earn']); ?> <b> € </b> </h1>
        <span style="color: DARKORANGE"> <?php echo getLastProfitPercentage($year,'1');?>% </span> From last month
        </div>
    </div> 
</div>
</div>
<script>
var ctx = $("#myChart");
var data = {
    labels: <?php echo json_encode($statistics['month']); ?>,
    datasets: [
        {
            label: " {{ trans('messages.keyword_i_earn') }} ",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "#f37f0d",
            borderColor: "#f37f0d",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "#333",
            pointBackgroundColor: "#333",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "#333",
            pointHoverBorderColor: "#f37f0d",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php if(isset($statistics['earn'])){ echo json_encode($statistics['earn']); } else { echo json_encode($guadagno); }?>,
            iGaps: false,
        },
		{
            label: " {{ trans('messages.keyword_revenues') }} ",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "#64C64B",
            borderColor: "#64C64B",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "#333",
            pointBackgroundColor: "#333",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "#333",
            pointHoverBorderColor: "#64C64B",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php if(isset($statistics['revenue'])){ echo json_encode($statistics['revenue']); } else { echo json_encode($ricavi); }?>,
            iGaps: false,
        },
		{
            label: " {{ trans('messages.keyword_expenses') }} ",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "#E02424",
            borderColor: "#E02424",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "#333",
            pointBackgroundColor: "#333",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "#333",
            pointHoverBorderColor: "#E02424",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data:  <?php if(isset($statistics['expense'])){ echo json_encode($statistics['expense']); } else { echo json_encode($spese); }?>,
            iGaps: false,
        }
    ]
};
var myLineChart = new Chart(ctx, {
    type: 'line',
    data: data,
    options: {
		scales: {
            xAxes: [{
                display: true
            }]
        }
	}
});

                   
function changeYear(year){
    $.ajax({
            type:'POST',
            data: { 'year': year, '_token': '{{ csrf_token() }}' },
            url: '{{ url('dashboard/statistics/year') }}',
            success:function(data) {
                $("#statistics").html(data);                        
            }
    });
}

function ajaxcall() {
    var rangeval=$('#reportrange span').html();
    //console.log(rangeval)
    var $date=rangeval.split(' - ');
     var startDate = moment(new Date($date[0])).format('YYYY-MM-D');
    var endDate = moment(new Date($date[1])).format('YYYY-MM-D');
    //console.log(moment(startDate).format('YYYY-MM-D'));
    $.ajax({
            type:'POST',
            data: { 'startDate': startDate, 'endDate': endDate, '_token': '{{ csrf_token() }}' },
            url: '{{ url('statistiche/date') }}',
            success:function(data) {
                $("#stat").html(data);                        
            }
    });
    ;
}
</script>
