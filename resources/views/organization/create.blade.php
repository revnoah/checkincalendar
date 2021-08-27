@extends('layouts.app')

@section('content')

@include('partials.info', [
  'title' => __('Configure Organization'), 
	'info' => __('Configure your organization.')
])

<div class="container py-5 col-4">
  <div id="form-create" class="panel panel-default">
    <div class="panel-body">
      @include('organization/partial-edit')
    </div>
  </div>
</div>

@endsection
