@if(count($errors)>0)
    <!-- Form Error List -->
    <div class="alert alert-warning">
        
        <strong>{{trans('messages.keyword_ooops!_there_is_something_wrong!')}}</strong>

        <br><br>

        <ul>
            @foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif