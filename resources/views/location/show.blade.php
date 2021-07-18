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
    @if (Auth::check())
      <p class="text-muted text-uppercase">{{ $location->code }}</p>
    @endif
    <p class="description">{{ $location->description }}</p>

    <div class="row">
      <div class="col-6 col-xs-12">
        @include('checkin/partial-checkin')
      </div>
      @if (Auth::check())
        <div class="col-6 col-xs-12 text-right">
          <div class="text-center d-flex flex-column">
            <img src="{{ $qrcode }}" class="qrcode" />
            <span class="qrcode text-uppercase mt-2">{{ $location->code }}</span>
          </div>
        </div>
      @endif
    </div>
	</div>
</div>

@endsection
