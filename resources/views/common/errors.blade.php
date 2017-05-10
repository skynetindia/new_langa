@if(count($errors)>0)
    <!-- Form Error List -->
    <div class="alert alert-warning">
        
        <strong>Ops! C'è qualcosa che non va!</strong>

        <br><br>

        <ul>
            @foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif