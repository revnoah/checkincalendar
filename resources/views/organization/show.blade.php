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
    <h2>Locations</h2>
    @isset($organization->locations)
      <ul>
      @foreach ($organization->locations as $location)
        <li><a href="{{ route('location.show', ['location' => $location ]) }}">{{ $location->name }}</a></li>
      @endforeach
      </ul>
    @endisset
    @if(count($organization->locations)==0)
      <div class="alert alert-warning" role="alert">
        <p>There are no locations. Start by adding one.</p>
      </div>
    @endif
    <a href="{{route('location.create')}}" class="btn btn-primary">Add Location</a>
	</div>
</div>

@endsection
