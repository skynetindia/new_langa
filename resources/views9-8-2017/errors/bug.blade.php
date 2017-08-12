ERRORE IN EASY LANGA.<br><br>
--- {{trans('messages.keyword_bug_details')}} ---<br>
{{trans('messages.keyword_user')}} : {{$user->name}} | {{$user->id}}<br>
{{trans('messages.keyword_url')}}: {{$url}}<br>
Errore: {{$errore}}<br>
@if($screen)
<a href="{{$screen}}">Screen</a>
@endif