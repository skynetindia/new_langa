@extends('layouts.app')
@section('content')
<div class="headerwhite">
<h1><?php echo (isset($page_title)) ? ucwords($page_title) : 'New Page' ?> 
</h1> <hr>
 </div>   
<?php echo (isset($page->language_value)) ?  $page->language_value : 'No Content found' ?>

@endsection