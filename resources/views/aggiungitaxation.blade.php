@extends('adminHome')
@section('page')
@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif
@include('common.errors')
<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>
<div class="row"> 
    <form action="{{url('/taxation/store')}}" id="taxation_form" method="post">
      {{ csrf_field() }}

      @if(isset($taxation))
          <div class="col-md-12 col-sm-12 col-xs-12"><h1>{{trans('messages.keyword_update_template_for_taxation')}}</h1></div>
          <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
              <label>{{trans("messages.keyword_taxation_name")}}</label>
              <input class="form-control" name="tassazione_nome" value="{{ $taxation->tassazione_nome }}">
            </div>
          </div>
          <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
              <label>{{trans("messages.keyword_percentage_taxation")}}</label>
              <input class="form-control" maxlength="4" name="tassazione_percentuale" value="{{ $taxation->tassazione_percentuale }}">
             </div>
          </div>
          <div class="col-md-12 col-sm-12 col-xs-12">          
            <input type="hidden" name="tassazione_id" value="{{ $taxation->tassazione_id }}">
            <input class="btn btn-warning" type="submit" value="{{trans('messages.keyword_modify')}}">
            </div>
      @else
          <div class="col-md-12 col-sm-12 col-xs-12"><h1>{{trans("messages.keyword_add_template_for_taxation")}}</h1></div>
          <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
              <label>{{trans("messages.keyword_taxation_name")}}</label>
              <input class="form-control" name="tassazione_nome" value="">
            </div>
          </div>
          <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
              <label>{{trans("messages.keyword_percentage_taxation")}}</label>
              <input class="form-control" maxlength="4"  name="tassazione_percentuale" value="">
            </div>
          </div>
           <div class="col-md-12 col-sm-12 col-xs-12">
          <input class="btn btn-warning" type="submit" value="{{trans('messages.keyword_add')}}">
          </div>
      @endif
    </form>
  </div>
  <script type="text/javascript">
  $(document).ready(function() {
     // validate taxation form on keyup and submit
        $("#taxation_form").validate({
            rules: {
                tassazione_nome: {
                    required: true,
                    maxlength: 35
                },
                tassazione_percentuale: {
                    required: true,
                    digits: true
                }
            },
            messages: {
                tassazione_nome: {
                    required: "{{trans('messages.keyword_please_enter_a_taxation_name')}}",
                    maxlength: "{{trans('messages.keyword_please_enter_less_than_35_charters')}}"
                },
                tassazione_percentuale: {
                    required: "{{trans('messages.keyword_please_enter_taxation_percentage')}}",
                    digits: "{{trans('messages.keyword_only_digits_allowed')}}"
                }
            }
        });
      });
  </script>
@endsection