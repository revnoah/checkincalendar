@extends('layouts.app')

@section('content')

<div class="container py-5">
	<div class="panel panel-default">
    <h1>{{ $organization->name }}</h1>
    <ul>
      <li><strong>Active:</strong> {{ $organization->active == 1 ? 'yes' : 'no' }}</li>
    </ul>
    <h2>Locations</h2>
    @isset($organization->locations)
      <ul>
      @foreach ($organization->locations as $location)
        <li>{{ $location->name }}</li>
      @endforeach
      </ul>
    @endisset
    @if(count($organization->locations)==0)
      <div class="alert alert-warning" role="alert">
        <p>There are no locations. Start by adding one.</p>
        <a href="{{route('location.create')}}" class="btn btn-default">Add Location</a>
      </div>
    @endif
	</div>
</div>

@endsection
