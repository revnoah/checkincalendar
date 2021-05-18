@extends('layouts.app')

@section('content')

@include('partials.info', [
  'title' => __('Add A Location'), 
	'info' => __('You should have at least one location.')
])

<div class="container py-5 col-4">
  <div id="form-create" class="panel panel-default">
    <div class="panel-body">
      @include('location/partial-edit')
    </div>
  </div>
</div>

@endsection
