<script type="text/javascript" src="{{ asset('public/scripts/daterangepicker.js') }}"></script>
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
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="btn-group">
            <h3 style="display:inline"><a href="javascript:changeYear('{{($year - 1)}}')"><i class="fa fa-arrow-left"></i>{{$year - 1}}</a></h3>
            <h3 style="display:inline;color:#f37f0d"> {{$year}} </h3><h3 style="display:inline"><a href="javascript:changeYear('{{($year + 1)}}')">{{$year + 1}}<i class="fa fa-arrow-right"></i></a></h3>
        </div>
    </div>
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
            <span id="daterange"><?php echo (isset($startDate) != '0') ? date('F m, Y',strtotime($startDate)).' - '.date('F m, Y',strtotime($endDate)) : ''; ?></span> <b class="caret"></b>
        </div>
    </div>
</div>
<div class="canvas-holder" id="stat">
    <canvas id="myChart" width="1080" height="540" style="display: block; width: 1080px; height: 540px;"></canvas>
</div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">                            
    <div class="col-md-4 col-sm-4 col-xs-4">
        <h5 style="color: #0002fb">{{trans('messages.keyword_confirmed')}} </h5> 
        <h1 style="color: #0002fb"><?php  echo array_sum($statistics['confirm']); ?><b> € </b></h1> 
        <span style="color: #0002fb"><?php echo confirmPercentage($year,'1');?>% </span>  From last month
    </div>                                                         
    <div class="col-md-4 col-sm-4 col-xs-4">
        <h5 style="color: #fafe02">{{trans('messages.keyword_pending_confirmation')}}</h5> 
        <h1 style="color: #fafe02"><?php echo array_sum($statistics['pendingconfirm']); ?> <b> € </b> </h1>
        <span style="color: #fafe02"><?php echo pendingConfirmPercentage($year,'1');?>% </span>  From last month
    </div>
    <div class="col-md-4 col-sm-4 col-xs-4">                                                        
        <h5 style="color: #000000">{{trans('messages.keyword_non_confirmed')}}</h5>
        <h1 style="color: #000000"><?php echo array_sum($statistics['notconfirm']); ?> <b> € </b> </h1>
        <span style="color: #000000"><?php echo notConfirmPercentage($year,'1');?>% </span>  From last month
    </div> 
</div>
</div>
<script>
var ctx = $("#myChart");
var data = {
    labels: <?php echo json_encode($statistics['month']); ?>,
    datasets: [
        {
            label: " {{ trans('messages.keyword_confirmed') }} ",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "#0002fb",
            borderColor: "#0002fb",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "#333",
            pointBackgroundColor: "#333",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "#333",
            pointHoverBorderColor: "#0002fb",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php if(isset($statistics['confirm'])){ echo json_encode($statistics['confirm']); } else { echo json_encode($guadagno); }?>,
            iGaps: false,
        },
		{
            label: " {{ trans('messages.keyword_pending_confirmation') }} ",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "#fafe02",
            borderColor: "#fafe02",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "#333",
            pointBackgroundColor: "#333",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "#333",
            pointHoverBorderColor: "#fafe02",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php if(isset($statistics['pendingconfirm'])){ echo json_encode($statistics['pendingconfirm']); } else { echo json_encode($ricavi); }?>,
            iGaps: false,
        },
		{
            label: " {{ trans('messages.keyword_non_confirmed') }} ",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "#000000",
            borderColor: "#000000",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "#333",
            pointBackgroundColor: "#333",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "#333",
            pointHoverBorderColor: "#000000",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data:  <?php if(isset($statistics['notconfirm'])){ echo json_encode($statistics['notconfirm']); } else { echo json_encode($spese); }?>,
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
    var sy = new Date('01 01 '+year);
    var ey = new Date('12 31 '+year);    
    $('#reportrange span').html(moment(sy).format('MMMM D, YYYY') + ' - ' + moment(ey).format('MMMM D, YYYY'));
    ajaxcall();
    /*$.ajax({
            type:'POST',
            data: { 'year': year, '_token': '{{ csrf_token() }}' },
            url: '{{ url('dashboard/statistics/year') }}',
            success:function(data) {
                $("#statistics").html(data);                        
            }
    });*/
}

        //$.noConflict();  
        $(document).ready(function($) {
            $(function() {
                var counter=1
                var start = moment().startOf('year');
                var end = moment().endOf('year');                   
                //alert(start);

                <?php if(isset($startDate) && $startDate != '0'){ ?>                   
                    var start = moment(new Date('<?php echo date('F d, Y',strtotime($startDate));?>'));
                    var end = moment(new Date('<?php echo date('F d, Y',strtotime($endDate));?>'));
                 <?php } ?>               

                function cb(start, end) {                                           
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                   // var startDate = start.format('YYYY-M-D');
                   // var endDate = end.format('YYYY-M-D');
                    if(counter!=1)
                    ajaxcall();
                    counter++;
                }           
            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                   'Today': [moment(), moment()],
                   'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                   'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                   'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                   'This Month': [moment().startOf('month'), moment().endOf('month')],
                   'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                //  onSelect: ajaxcall()
            }, cb);

            $('#daterange').on("change", function() {
              ajaxcall();             
            });
            cb(start, end);            
            });
        });

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
                        url: '{{ url('dashboard/statistics/date') }}',
                        success:function(data) {
                            $("#statistics").html(data);                        
                        }
                });
                ;
            }
</script>
