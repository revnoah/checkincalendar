@extends('layouts.app')

@section('content')

<div class="container py-5">
	<div class="panel panel-default">
    @if (Auth::check())
      <div class="actions actions-right">
        <a href="{{ route('location.pdf', ['location' => $location ]) }}" title="{{ __('PDF') }}" class="btn btn-primary pull-right">{{ __('PDF') }}</a>
      	<a href="{{ route('location.edit', ['location' => $location ]) }}" title="{{ __('Edit') }}" class="btn btn-primary pull-right">{{ __('Edit') }}</a>
      </div>
    @endif
    <h1>{{ $location->name }}</h1>
    <p class="text-muted">{{ $location->code }}</p>
    <p class="description">{{ $location->description }}</p>
    @include('checkin/partial-checkin')
	</div>
</div>

@endsection
