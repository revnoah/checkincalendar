@extends('layouts.app')

@section('content')

@include('partials.info', [
  'title' => __('Clients'), 
	'info' => __('Every project has a client. Even if the client is you.'),
  'buttons' => [
    'add' => [
      'url' => action('ClientController@create'),
      'text' => __('Add Client')
    ]
  ]
])

<div class="bg-dark py-5">
  <div class="container">
  @if(!$clients->isEmpty())
    <div id="form-create" class="panel panel-default">
      @include('client.partial-cardstack')
      <p class="text-light">{{ $clients->count() }} {{ __('Clients') }}</p>
    </div>
  @else
    @include('partials.empty', [
      'title' => __('There Are No Clients'),
      'info' => __('Start by adding one')      
    ])
  @endif
  </div>
</div>

@endsection
