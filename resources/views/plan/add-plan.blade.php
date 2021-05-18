@extends('layouts.app')

@section('content')

@include('partials.info', [
  'title' => __('Add Team To Client'), 
	'info' => __('Add teams to the client')
])

<div class="container py-5">
  <div id="form-create" class="panel panel-default">
    @include('client/partial-add-team')
  </div>
</div>

@endsection
