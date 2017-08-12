@extends('layouts.app')
@section('content')

<h1>{{ trans('messages.keyword_notifications_menu') }}</h1><hr>

@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif

@include('common.errors')

<div class="row">
	<div class="col-md-12">
    <div class="col-md-6">
    <?php echo Form::open(array('url' => '/valutaci/store/', 'files' => true)) ?>
    {{ csrf_field() }}
    	<div class="col-md-12">
    		<h6 style="text-align:left"><span class="fa fa-frown-o"></span> {{ trans('messages.keyword_we_regret_something_not_worked_as_ it') }}  Easy <strong>LANGA</strong> {{ trans('messages.keyword_fill_these_few_fields_to_allow_developers_fix_problem') }} .<h6 style="color:#f37f0d"><strong>{{ trans('messages.keyword_fill_these_few_fields_to_allow_developers_problem') }} </strong></h6>
            </h6>
            <h5 style="color:#f37f0d"> {{ trans('messages.keyword_which_page_were_you_problem_occurred') }}?</h5><input type="text" id="url" placeholder="http://easy.langa.tv/enti/modify/corporation/0" name="posizione" class="form-control">
            <h5 style="color:#f37f0d"> {{ trans('messages.keyword_describe_mistake_found') }} </h5><textarea rows="10" id="errore" placeholder="{{ trans('messages.keyword_oh_god_i_lost_all_my_entities') }}!" name="errore" class="form-control"></textarea>
            <h5 style="color:#f37f0d">{{ trans('messages.keyword_attach_an_image') }} </h5><input type="file" name="screen" class="form-control">
            <br><input type="submit" class="btn btn-warning" value="{{ trans('messages.keyword_send') }}" onclick="return controlla();">
        </div>
        <script>
		function controlla() {
			var url = document.getElementById("url").value;
			var errore = document.getElementById("errore").value;
			if(url == "" || errore == "") {
				alert("{{ trans('messages.keyword_be_careful_fill_all_fields_to_report_error') }}:)");
				return false;
			} else
				return true;
		}
		</script>
    </form>
    </div>
    <div class="col-md-6">
	<!-- <form action="{{url('/valutaci/store')}}" method="post"> -->
    <?php echo Form::open(array('url' => '/valutaci/store/', 'files' => true)) ?>
    {{ csrf_field() }}
    	<div class="col-md-12">
    		<h6 style="text-align:left"><span class="fa fa-smile-o"></span> {{ trans('messages.keyword_we_are_glad_that_everything_works_perfectly') }}  Easy <strong>LANGA</strong> {{ trans('messages.keyword_fill_these_fields_to_support_the_work_developers') }} .
            </h6>
            <h5 style="color:#f37f0d"> {{ trans('messages.keyword_tell_us_what_you_think_about') }} Easy</h5><textarea rows="15" id="love" placeholder="{{ trans('messages.keyword_i _could_ not_live_without_easy') }}!" name="love" class="form-control"></textarea>
            <h5 style="color:#f37f0d">{{ trans('messages.keyword_attach_an_image') }}</h5><input type="file" name="screen" class="form-control">
            <br><input type="submit" class="btn btn-warning" value="{{ trans('messages.keyword_send') }}" onclick="return controlla2();">
        </div>
        <script>
		function controlla2() {
			var msg = document.getElementById("love").value;
			if(msg == "") {
				alert("{{ trans('messages.keyword_be_careful_fill_out_all_fields_report_evaluation') }} ");
				return false;
			} else
				return true;
		}
		</script>
    </form>
    </div>
    </div>
</div>

@endsection