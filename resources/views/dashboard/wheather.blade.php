<script src="{{ asset('public/scripts/jquery-ui.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('public/scripts/jquery-ui.css') }}" />
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
@if(isset($forecastday[0]))
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="col-md-4 col-sm-12 col-xs-12">
        <div class="btn-group">        
        <strong>{{$forecastday[0]['date']['weekday']}}</strong>
        <span><?php         
           echo date('h:i A',strtotime($forecastday[0]['date']['hour'].':'.$forecastday[0]['date']['min'].':'.$forecastday[0]['date']['sec'])).' '.$forecastday[0]['high']['fahrenheit'].' '.$forecastday[0]['high']['celsius'];
            ?></span><br>
            <img src="{{$forecastday[0]['icon_url']}}">        
        </div>
    </div>
    <div class="col-md-8 col-sm-12 col-xs-12">        
        <input type="text" name="searchbox" id="weathersearchbox" class="form-control" value="{{$location}}" placeholder="Input your location here..">
    </div>
</div>
</div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12"><?php
    /*$str = file_get_contents('http://api.wunderground.com/api/2d5fc4594633a8dc/forecast10day/q/India/Jamnagar.json');        
    $json = json_decode($str, true);    
    $forecastday = $json['forecast']['simpleforecast']['forecastday']*/
?>
    @foreach($forecastday as $key => $forecastdayVal)
        @if($key > 5)
            <?php break;?>
        @endif
    <div class="col-md-2 col-sm-2 col-xs-2">    
        <h5>{{$forecastdayVal['date']['weekday_short']}}</h5>
        <h5>{{$forecastdayVal['high']['celsius'].'°'}}</h5>
        <img src="{{$forecastdayVal['icon_url']}}">
        <h5>{{$forecastdayVal['avewind']['kph']}} km/h</h5>
    </div>                                                         
    @endforeach
</div>
</div>
@else 
<h4>{{trans('messages.keyword_weather_information_not_available')}}</h4>
@endif
<script type="text/javascript">     
$('#weathersearchbox').autocomplete({
    source: function (request, response) {             
        $.post('dashboard/weatherautocomplete', { 'query': request.term, '_token': '{{ csrf_token() }}' }, function(data) {
            response($.map(data.RESULTS, function (value, key) {
                return {
                    label: value.name,
                    value: value.name
                };
            })
            );
        });
    },
    select: function( event, ui ) {         
        getweatherdetails(ui.item.value); 
      },
    minLength: 2,
    delay: 100
});
function getweatherdetails(location){
     $.ajax({
        type:'POST',
        data: { 'location': location, '_token': '{{ csrf_token() }}' },
        url: '{{ url('dashboard/getweatherdetails') }}',
        success:function(data) {
            $("#wheather").html(data); 
            $(this).find('#weathersearchbox').autocomplete();                                 
        }
    });
}
</script>
