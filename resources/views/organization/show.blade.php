@extends('layouts.app')

@section('content')

<div class="container py-5">
	<div class="panel panel-default">
    @if (Auth::check())
      <div class="actions actions-right">
        <a href="{{ route('organization.edit', ['organization' => $organization]) }}" title="{{ __('Edit') }}" class="btn btn-default btn-primary pull-right">{{ __('Edit') }}</a>
      </div>
    @endif
    <h1>{{ $organization->name }}</h1>
    <p class="text-muted">{{ $organization->code }}</p>
    <p class="description">{{ $organization->description }}</p>
    <h2>{{ __('Locations') }}</h2>
    @isset($organization->locations)
      <div>
      @foreach ($organization->locations as $location)
      <div class="card" style="width: 18rem;">
        <img class="card-img-top" src="..." alt="Card image cap">
        <div class="card-body">
          <h3 class="card-title"><a href="{{ route('location.show', ['location' => $location ]) }}">{{ $location->name }}</a></h3>
          <p class="card-text">{{ $location->description }}</p>
          <a href="{{ route('location.show', ['location' => $location ]) }}" class="btn btn-primary">{{ __('View Location') }}</a>
        </div>
      </div>
      @endforeach
      </div>
    @endisset

    <div class="my-4">

      @if(count($organization->locations)==0)
        <p class="mb-2">{{ __('There are no locations. Start by adding one.') }}</p>
      @else
        <p class="mb-2">{{ __('Add another location.') }}</p>
      @endif

      <a href="{{route('location.create')}}" class="btn btn-secondary">{{ __('Add New Location') }}</a>
    </div>
</div>

@endsection
