@extends('layouts.app')

@section('content')

@include('partials.info', [
  'title' => __('Edit A Client'), 
	'info' => __('Every project has a client. Even if it is you.')
])

<div class="container py-5 col-4">
  <div id="form-create" class="panel panel-default">
    @include('client/partial-edit')
    @include('client/partial-delete')
  </div>
</div>

@endsection
