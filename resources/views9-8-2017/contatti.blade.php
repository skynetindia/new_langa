@extends('layouts.app')
@section('content')
<h3><br><br> {{ trans('messages.keyword_contact_information') }}   <strong>LANGA</strong></h3><br>

<hr>
<h5>
<br><br>{{ trans('messages.keyword_this_is_contact_section') }} <strong>LANGA</strong>.<br><br>
{{trans('messages.keyword_you_will_find_official_mails_of_divisions') }} <strong>LANGA</strong>:<br><br><br>

<strong> {{ trans('messages.keyword_division') }} </strong> {{ trans('messages.keyword_administrative') }}: amministrazione@langa.tv<br><br>
<strong>{{ trans('messages.keyword_division') }}</strong> {{ trans('messages.keyword_commercial') }}: commerciale@langa.tv<br><br>
<strong>{{ trans('messages.keyword_division') }}</strong> {{ trans('messages.keyword_technical') }}: tecnico@langa.tv<br><br><br><br><br>

<strong>{{ trans('messages.keyword_department') }}</strong> {{ trans('messages.keyword_development_/_coding') }}: info@langaweb.it<br><br>
<strong>{{ trans('messages.keyword_department') }}</strong> {{ trans('messages.keyword_graphic_and_printing') }}: info@langaprint.it<br><br>
<strong>{{ trans('messages.keyword_department') }}</strong> {{ trans('messages.keyword_shooting_and_assembly') }}: info@langavideo.it<br><br><br>

<strong> {{ trans('messages.keyword_information') }} </strong> 
{{ trans('messages.keyword_general') }}: info@langa.tv<br><br><br><br><br>

*  {{ trans('messages.keyword_in_addition_each_interior') }} <strong>LANGA
</strong>  {{trans('messages.keyword_its_own_official_mail_always_composed') }} <strong>{{ trans('messages.keyword_surname') }}(id)@langa.tv</strong>; {{trans('messages.keyword_always_calls_for_unofficial mail') }}
!
</h5>
@endsection