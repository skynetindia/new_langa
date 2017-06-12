<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/scripts/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/scripts/daterangepicker.js') }}"></script>
<script src="{{ asset('public/js/chart/chart-bundle.js') }}"></script>
<script src="{{ asset('public/js/chart/chart.js') }}"></script>
<link rel="stylesheet" href="{{ asset('public/js/bootstrap-table/table.css') }}">
<script src="{{ asset('public/js/bootstrap-table/table.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('public/js/daterangepicker/daterangepicker.css') }}" />

<div class="main-dashbord-bacheca-user">
	<?php /*<div class="row">
    	<div class="col-sm-6">
        	<div class="bg-white">
            	<div class="information-user">
                	<img src="{{url('images/dashboard/user-infor.jpg')}}"/>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
        	<div class="bg-white">
            	<div class="your-project">
                	<img src="{{url('images/dashboard/your-project.jpg')}}"/>
                </div>
            </div>
        </div>
    </div>    
    <hr/>*/?>    
    <div class="row">
		<div class="col-sm-6">
        	<div class="set-height-lft-bacheca-user">
            	<!-- ================================ Wearther Section ========================== -->
                <div class="bg-white">
                    <h4><strong>Weather</strong></h4><hr>
                	<div class="wheather" id="wheather">
                        @include('dashboard.wheather')                    	
                    </div>
                </div>
                <!-- ================================ Statisctic section start ========================== -->
                <div class="bg-white">                    
                    <h4><strong>{{trans('messages.keyword_statistics')}}</strong></h4><hr>
                	<div class="statistics" id="statistics">
                    	@include('dashboard.statistics_ajax')
                    </div>
                </div>
                <!-- ================================ Statisctic section start ========================== -->

                <div class="bg-white">
                	<div class="preventiviti">
                    	<img src="{{url('images/dashboard/preventiviti.jpg')}}"/>
                    </div>
                </div>
                
            </div>
        </div>        
        <div class="col-sm-6">
        	<div class="set-height-right-bacheca-user">            
            	<div class="bg-white">
                <h4><strong> {{ trans('messages.keyword_calendar') }}</strong></h4><hr>
                	<div class=""><!-- widget -->
                    	@include('dashboard.calendar_ajax')
                    </div>
                </div>
                
                <div class="bg-white">
                	<div class="widget-quotes">
                    	<img src="{{url('images/dashboard/widget-quotes.jpg')}}"/>
                    </div>
                </div>
                
                <div class="bg-white">
                	<div class="image_upload_div">
                    	<img src="{{url('images/dashboard/uploader.jpg')}}"/>
                    </div>
                </div>
                <div class="dropdown-screen">
                	<div class="row">
                    	<div class="col-sm-6">
                        	<img src="{{url('images/dashboard/select-box1.jpg')}}"/>
                        </div>
                    	<div class="col-sm-6">
                        	<img src="{{url('images/dashboard/select-box2.jpg')}}"/>
                        </div>
                    </div>
                </div>                
            </div>
        </div>        
    </div>        
</div>
