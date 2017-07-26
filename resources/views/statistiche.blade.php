@extends('layouts.app')
@section('content')

<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('public/scripts/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/scripts/daterangepicker.js') }}"></script>
<script src="{{ asset('public/js/chart/chart-bundle.js') }}"></script>
<script src="{{ asset('public/js/chart/chart.js') }}"></script>

<link rel="stylesheet" href="{{ asset('build/css/bootstrap-table.min.css') }}">
<script src="{{ asset('build/js/bootstrap-table.min.js') }}"></script>
<script src="{{ asset('build/js/bootstrap-table-it-IT.min.js') }}"></script>

<!--<link rel="stylesheet" href="{{ asset('public/js/bootstrap-table/table.css') }}">
<script src="{{ asset('public/js/bootstrap-table/table.js') }}"></script>-->

<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/locale/bootstrap-table-it-IT.min.js"></script> -->

<!-- Include Date Range Picker -->

<link rel="stylesheet" type="text/css" href="{{ asset('public/js/daterangepicker/daterangepicker.css') }}" />

<div class="height20"></div>
<div class="row">
	<div class="col-md-8 col-sm-12 col-xs-12">
        <div class="btn-group">
            <h3 class="inline"><a href='{{url("/statistiche/economiche") . '/' . ($year - 1)}}'><i class="fa fa-arrow-left"></i>{{$year - 1}}</a></h3>
            <h3 class="inline orange"> {{$year}} </h3><h3 class="inline"><a href='{{url("/statistiche/economiche") . '/' . ($year + 1)}}'>{{$year + 1}}<i class="fa fa-arrow-right"></i></a></h3>
        </div>
    </div>

    <div class="col-md-4 col-sm-12 col-xs-12">

     <!--    <span class="datapicker-icon">
            <i class="fa fa-calendar" aria-hidden="true"></i>
        </span> 
        <span class="select-date">
            <input type="text" id="datepicker_to" name="datepicker_to[]" class="form-control" value="">
        </span> -->

        <div id="reportrange" class="pull-right reportrange pull-left-mobile" >
            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
            <span id="daterange"></span> <b class="caret"></b>
        </div>

    </div>


</div>


<div class="stat-graph row">
<div class="canvas-holder stat" id="stat">
	<div class="col-md-10 col-sm-12 col-xs-12">
	<canvas id="myChart" width="1080" height="540" style="display: block; width: 1080px; height: 540px;"></canvas>
    </div>
</div>
<div class="right-side-info">
        <div class="col-md-2 col-sm-12 col-xs-12">
        <hr>

        <div class="info-1">
            <h5> costo </h5> 
            <h1> <?php  echo array_sum($statistics['expense']); ?> <b> € </b> </h1> 
            <span><?php echo getLastCostPercentage($year,'1');?>% </span>  From last month 
        </div> 
        
        <div class="info-2"> 
            <h5> ricavo </h5> 
            <h1> <?php echo array_sum($statistics['revenue']); ?> <b> € </b> </h1>
            <span> <?php echo getLastRevenuePercentage($year,'1');?>% </span>  From last month 
        </div> 
        
        <div class="info-3"> 
            <h5> guadagno </h5>
            <h1> <?php echo array_sum($statistics['earn']); ?> <b> € </b> </h1>
            <span> <?php echo getLastProfitPercentage($year,'1');?>% </span>  From last month
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
            data: <?php echo json_encode($statistics['earn']); ?>,
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
            data: <?php echo json_encode($statistics['revenue']); ?>,
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
            data:  <?php echo json_encode($statistics['expense']); ?>,
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
</script>


<div class="clearfix"></div>
<div class="height50"></div>

<div class="statis-economic row">

	<div class="col-md-6 col-sm-12 col-xs-12">
    	<h4> {{ ucwords(trans('messages.keyword_costs')) }} </h4><hr>
        @if(checkpermission('5', '20', 'scrittura','true'))
        <div class="btn-group">
        	<a onclick="multipleAction('modify');" id="modifica" name="update" title="{{ trans('messages.keyword_edit_last_selected_format') }}" class="btn btn-primary">
	            <i class="fa fa-pencil"></i>
            </a>
            <a id="delete" onclick="multipleAction('delete');" class="btn btn-danger" name="remove" title="{{ trans('messages.keyword_delete_last_selected_lauout') }}">
				<i class="fa fa-trash"></i>
            </a>
        </div>
        @endif
      
      <div class="space30"></div>
        
        <div class="panel panel-default">
        <div class="panel-body mb16">
    	<table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="<?php echo url('costi/json');?>" data-classes="table table-bordered" id="table">
            <thead>
                <th data-field="id" data-sortable="true">
                {{ ucwords(trans('messages.keyword_code')) }} </th>
                <th data-field="ente" data-sortable="true">
                {{ ucwords(trans('messages.keyword_entity')) }} </th>
                <th data-field="oggetto" data-sortable="true">
                {{ ucwords(trans('messages.keyword_object')) }} </th>
                <th data-field="costo" data-sortable="true"> 
                {{ ucwords(trans('messages.keyword_cost')) }} </th>
                <th data-field="datainserimento" data-sortable="true">
                {{ ucwords(trans('messages.keyword_insertion_date')) }} </th>
            </thead>
        </table>
     
        
        <!-- COSTI -->

<!-- change variable name for case 'delete' like n to n2 And indici to indici2-->

        <script>
			var selezione2 = [];
			var indici2 = [];
			var n2 = 0;
			
			$('#table').on('click-row.bs.table', function (row, tr, el) {
                var cod = /\d+/.exec($(el[0]).children()[0].innerHTML);
                if (!selezione2[cod]) {
                    $('#table tr.selected').removeClass("selected");       
                    $(el[0]).addClass("selected");
                    selezione2[cod] = cod;
                    indici2[n] = cod;
                    n2++;
                } else {
                    $(el[0]).removeClass("selected");
                    selezione2[cod] = undefined;
                    for(var i = 0; i < n2; i++) {
                        if(indici2[i] == cod) {
                            for(var x = i; x < indici2.length - 1; x++)
                                indici2[x] = indici2[x + 1];
                            break;  
                        }
                    }
                    n2--;
                    $('#table tr.selected').removeClass("selected");       
                    $(el[0]).addClass("selected");
                    selezione2[cod] = cod;
                    indici2[n] = cod;
                    n2++;
                }
            })
			function check() { return confirm(" {{ trans('messages.keyword_sure') }} {{ trans('messages.keyword_costs') }} ?"); }
			function multipleAction(act) {
				var link = document.createElement("a");
				var clickEvent = new MouseEvent("click", {
					"view": window,
					"bubbles": true,
					"cancelable": false
				});
				var error = false;

					switch(act) {
	case 'delete':
		link.href = "{{ url('/costo/delete/') }}" + '/';
		if(check() && n2!=0) {
            n2--;
			link.href = "{{ url('/costo/delete') }}" + '/' + indici2[n];
			link.dispatchEvent(clickEvent);
			n2 = 0;
            selezione2 = undefined;
            link.dispatchEvent(clickEvent);

		}
    	break;
    	case 'modify':
    		if(n2 != 0) {
    			n2--;
    			link.target = "new";
    			link.href = "{{ url('/costi/modify') }}" + '/' + indici2[n];
    			n2 = 0;
    			selezione2 = undefined;
    			link.dispatchEvent(clickEvent);
    		}
    	break;
					}
			}
		</script>
        <!-- FINE COSTI -->
        
           </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12 col-xs-12">
    	<h4> {{ ucwords(trans('messages.keyword_revenues')) }} </h4><hr>
        @if(checkpermission('5', '20', 'scrittura','true'))
        <div class="btn-group">
<a onclick="mAction('modify');" id="modifica" class="btn btn-primary" name="update" title=" {{ trans('messages.keyword_edit_last_selected_format') }}">
	<i class="fa fa-pencil"></i>
</a>
<a id="duplicate" onclick="mAction('duplicate');" class="btn btn-info" name="duplicate" title=" {{ trans('messages.keyword_duplicates_selected_layouts') }} ">
	<i class="fa fa-files-o"></i>
</a>    
<a id="delete" onclick="mAction('delete');" class="btn btn-danger" name="remove" title=" {{ trans('messages.keyword_delete_last_selected_lauout') }} ">
	<i class="fa fa-trash"></i>
</a>
<a id="pdf" onclick="mAction('pdf');" class="btn" name="pdf" title=" {{ trans('messages.keyword_generate_pdf_selected_formats') }} ">
	<i class="fa fa-file-pdf-o"></i>
</a>
</div>
@endif


  <div class="space30"></div>
        
        <div class="panel panel-default">
        <div class="panel-body one-line-table mb16">

        <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="<?php echo url('/pagamenti/tranche/json');?>" data-classes="table table-bordered" id="tabella">
        <thead>
        	<th data-field="idfattura" data-sortable="true"> 
            {{ ucwords(trans('messages.keyword_invoicenumber')) }}  </th>
            <th data-field="id" data-sortable="true"> 
            {{ ucwords(trans('messages.keyword_no_disposition')) }} </th>
            <th data-field="nomequadro" data-sortable="true">
            {{ ucwords(trans('messages.keyword_picturename')) }} </th>
            <th data-field="tipo" data-sortable="true">
            {{ ucwords(trans('messages.keyword_type')) }} </th>
            <th data-field="datascadenza" data-sortable="true">
            {{ ucwords(trans('messages.keyword_deadline')) }} </th>
            <th data-field="percentuale" data-sortable="true">
            % </th>
            <th data-field="netto" data-sortable="true">
            {{ ucwords(trans('messages.keyword_net')) }} </th>
            <th data-field="scontoaggiuntivo" data-sortable="true">
            {{ ucwords(trans('messages.keyword_additional_discount')) }} </th>
            <th data-field="imponibile" data-sortable="true"> 
            {{ ucwords(trans('messages.keyword_taxable')) }} </th>
            <th data-field="prezzoiva" data-sortable="true"> 
            {{ ucwords(trans('messages.keyword_vat_price')) }} </th>
            <th data-field="dapagare" data-sortable="true">
            {{ ucwords(trans('messages.keyword_topay')) }} </th>
            <th data-field="statoemotivo" data-sortable="true">
            {{ ucwords(trans('messages.keyword_emotional_state')) }} </th>
        </thead>
    </table>
    <script>
var selezione = [];
var indici = [];
var n = 0;

$('#tabella').on('click-row.bs.table', function (row, tr, el) {
	var cod = /\d+/.exec($(el[0]).children()[1].innerHTML);
	if (!selezione[cod]) {
            $('#tabella tr.selected').removeClass("selected");  
		$(el[0]).addClass("selected");
		selezione[cod] = cod;
		indici[n] = cod;
		n++;  
	} else {
		$(el[0]).removeClass("selected");
		selezione[cod] = undefined;
		for(var i = 0; i < n; i++) {
			if(indici[i] == cod) {
				for(var x = i; x < indici.length - 1; x++)
					indici[x] = indici[x + 1];
				break;	
			}
		}
		n--;

        $('#tabella tr.selected').removeClass("selected");       
    $(el[0]).addClass("selected");
    selezione[cod] = cod;
    indici[n] = cod;
    n++;
	}    
});







function check2() { return confirm("{{ trans('messages.keyword_sure') }} {{ trans('messages.keyword_revenues') }} / {{ trans('messages.keyword_provisions') }} ?"); }
function mAction(act) {
	var link = document.createElement("a");
	var clickEvent = new MouseEvent("click", {
	    "view": window,
	    "bubbles": true,
	    "cancelable": false
	});
	var error = false;
		switch(act) {

        case 'delete':
        link.href = "{{ url('/pagamenti/tranche/delete/') }}" + '/';
        if(check2() && n!=0) {
            n--;
            link.href = "{{ url('/pagamenti/tranche/delete') }}" + '/' + indici[n];
            link.dispatchEvent(clickEvent);
            n = 0;
            selezione = undefined;
            link.dispatchEvent(clickEvent);

        }

			
			break;
			case 'modify':
                if(n != 0) {
					n--;
					link.href = "{{ url('/pagamenti/tranche/modifica') }}" + '/' + indici[n];
					n = 0;
					selezione = undefined;
					link.dispatchEvent(clickEvent);
				}
			break;
			case 'pdf':
               link.href = "{{ url('/pagamenti/tranche/pdf') }}" + '/';
			    for(var i = 0; i < n; i++) {
                    var url = link.href + indici[i];
                    var win = window.open(url, '_blank');
                    win.focus();
                }
                n = 0;
                selezione = undefined;
                setTimeout(function(){location.reload();},100*n);
			break;
            case 'duplicate':
				link.href = "{{ url('/pagamenti/tranche/duplicate') }}" + '/';
                for(var i = 0; i < n; i++) {
                    $.ajax({
                        type: "GET",
                        url : link.href + indici[i],
                        error: function(url) {
                            if(url.status==403) {
                                link.href = "{{ url('/pagamenti/tranche/duplicate') }}" + '/' + indici[n];
                                link.dispatchEvent(clickEvent);
                                error = true;
                            } 
                        }
                    });
                }
                selezione = undefined;
                if(error === false)
                    setTimeout(function(){location.reload();},100*n);
                n = 0;
			break;
		}
}    

</script>
    <!-- fine RICAVI -->
    </div>
    
    </div></div>


</div>


 <script type="text/javascript">

        // $("#datepicker_to").daterangepicker({
        //     autoApply: true,
        //     timePicker: true,
        //     timePickerIncrement: 30,
        //     locale: {
        //         format: 'MM/DD/YYYY h:mm A'
        //     }
        // });    
        
        // $('#datepicker_to').on("change", function() {

        //     var date = $('#datepicker_to').val();                        
        //     date = date.replace(/\//g, '-');     
        //     $.ajax({
        //         type:'POST',
        //         data: { 'date': date, '_token': '{{ csrf_token() }}' },
        //         url: '{{ url('statistiche/date') }}',
        //         success:function(data) {
        //             // console.log(data);  
        //             $("#stat").html(data);                        
        //         }
        //     });     
        // });

        // $('#daterange').on("change", function() {
        //     alert("hi");
        //     var date = $('#daterange').val();
        //     alert(date);
        // }); 

        // $('.applyBtn').click(function(){
        //     var date = $('#reportrange').val();
        //     alert(date);
        // }); 



        $.noConflict();  
        jQuery(document).ready(function($) {

            $(function() {
				var counter=1
                var start = moment().startOf('year');
                var end = moment().endOf('year');
                function cb(start, end) {
					
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                var startDate = start.format('YYYY-M-D');
                var endDate = end.format('YYYY-M-D');
				if(counter!=1)
				ajaxcall();
				counter++;
            }
            function ajaxcall()
			{
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

    </script>

@endsection