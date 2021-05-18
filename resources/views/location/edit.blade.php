@extends('layouts.app')

@section('content')

@include('partials.info', [
  'title' => __('Edit A Location'), 
	'info' => __('Modify this location')
])

<div class="container py-5 col-4">
  <div id="form-create" class="panel panel-default">
    @include('location/partial-edit')
    @include('location/partial-delete')
  </div>
</div>

@endsection
