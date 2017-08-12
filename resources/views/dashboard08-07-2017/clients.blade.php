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
		<div class="col-md-6 col-sm-12 col-xs-12">
        	<div class="set-height-lft-bacheca-user">
            	<div class="bg-white">                    
                    <h4><strong>{{trans('messages.keyword_your_responsible_langa')}}</strong></h4><hr>
                    <div class="statistics" id="responsabilelanga">
                        <div class="col-md-12">
                            @foreach($responsabilelanga as $key => $val)
                            <div class="col-md-4">
                                <div class="btn-group">        
                                <strong>{{$val->nomereferente}}</strong>
                                <span>{{trans('messages.keyword_telephone_company')}} : {{$val->telefonoresponsabile}}</span><br>
                                <span>Mobile : {{$val->cellulareazienda}}</span><br>
                                <span>Email : {{$val->email}}</span><br>
                                </div>
                            </div>                            
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- ================================ Statisctic section start ========================== -->
                <div class="bg-white">                    
                    <h4><strong>{{trans('messages.keyword_projects')}}</strong></h4><hr>
                	<div class="statistics" id="statistics">
                    	@include('dashboard.client_projects_ajax')
                    </div>
                </div>
                <!-- ================================ Statisctic section start ========================== -->
            </div>
        </div>                 
    </div>        
</div>
<script type="text/javascript">
        $(function() {
            $('.statistics').on('click', '.pagination a', function(e) {
                e.preventDefault();
                $('#statistics a').css('color', '#dfecf6');
                $('#statistics').html('<img width="100" height="100" src="{{url('images/loading.gif')}}" />');
                var url = $(this).attr('href');
                var arrurl = url.split("?");                
                url = "{{url('dashboard/client/charts')}}"+"?"+arrurl[1];                
                getArticles(url);
                /*window.history.pushState("", "", url);*/
            });

            function getArticles(url) {
                $.ajax({
                    url : url
                }).done(function (data) {
                    $('#statistics').html(data);
                }).fail(function () {
                    alert('Articles could not be loaded.');
                });
            }
        });
    </script>