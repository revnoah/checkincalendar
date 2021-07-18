@extends('layouts.app')

@section('content')

@include('partials.info', [
  'title' => __('Sign In'), 
  'info' => __('Select a username. It should be unique within your organization.')
])

<div class="container py-5 col-4">
  <div id="form-create" class="panel panel-default">
    <div class="panel-body">
      @include('checkin/partial-username')
    </div>
  </div>
</div>

@endsection
