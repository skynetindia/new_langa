<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/scripts/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/scripts/daterangepicker.js') }}"></script>
<script src="{{ asset('public/js/chart/chart-bundle.js') }}"></script>
<script src="{{ asset('public/js/chart/chart.js') }}"></script>
<link rel="stylesheet" href="{{ asset('public/js/bootstrap-table/table.css') }}">
<script src="{{ asset('public/js/bootstrap-table/table.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('public/js/daterangepicker/daterangepicker.css') }}" />
<div class="main-dashbord-bacheca-user">	
    <div class="row">
		<div class="col-md-6 col-sm-12 col-xs-12">
        	<div class="set-height-lft-bacheca-user">
            	<div class="bg-white">                  
                    <h4><strong>Hey</strong></h4><hr>                    
                    <div class="widget-quotes hey_media_list" id="media_list">
                      @include('dashboard.media_list')
                    </div>
                </div>               
            </div>
        </div>            
        <div class="col-md-6 col-sm-12 col-xs-12">
        	<div class="set-height-right-bacheca-user">
             @foreach($departments as $keyd => $val)
                <div class="bg-white">                    
                    <h4><strong>{{$val->nomedipartimento}}</strong></h4><hr>
                    <div class="statistics client-statistics" id="responsabilelanga">
                        <div class="">                      
                            <div class="col-md-6">
                                <div class="btn-group">        
                                    <p><strong>{{$val->nomereferente}}</strong></p>                                    
                                    <p>{{trans('messages.keyword_telephone_company')}} : {{$val->telefonodipartimento}}, {{$val->cellularedipartimento}}</p>
                                    <p>{{trans('messages.keyword_email')}} : {{$val->email}}, {{$val->emailsecondaria}}</p>
                                    <p>{{trans('messages.keyword_vat_number')}} : {{$val->piva}}</p>
                                    <p>{{trans('messages.keyword_fiscal_code')}} : {{$val->cf}}</p>
                                    <p>{{trans('messages.keyword_address')}} : {{$val->indirizzo}}</p>
                                </div>
                            </div>
                                <div class="col-md-6">
                                <div class="text-center">
                                    <div class="btn-group">
                                        <p></p>
                                        <p>{{$val->noteenti}}</p>
                                    </div>
                                </div>            
                                </div>                           
                        </div> <div class="clearfix"></div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>    
    </div>        
</div>