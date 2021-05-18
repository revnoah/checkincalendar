@extends('layouts.app')

@section('content')

@include('partials.info', [
  'title' => __('Add A Client'), 
	'info' => __('Every project has a client. Even if it is you.')
])

<div class="container py-5 col-4">
  <div id="form-create" class="panel panel-default">
    <div class="panel-body">
      @include('client/partial-edit')
    </div>
  </div>
</div>

@endsection
