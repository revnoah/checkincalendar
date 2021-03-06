@extends('layouts.app')

@section('content')

@include('partials.info', [
  'title' => __('Edit Your Organization'), 
	'info' => __('Add some basic information about your organization.')
])

<div class="container py-5 col-4">
  <div id="form-create" class="panel panel-default">
    @include('organization/partial-edit')
    @include('organization/partial-delete')
  </div>
</div>

@endsection
