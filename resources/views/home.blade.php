@extends('layouts.app')

@section('content')

<div class="jumbotron">
    <div class="container text-center">
        <h1 class="display-3">{{ __('Check-In or Register') }}</h1>
        <p>{{ __('Check-in to an organization using a private code or register your organization and set up your check-in calendar.') }}</p>
    </div>
</div>

<div class="container pt-5">

    @if (session('status'))
        <div class="alert alert-success mb-3" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-4 col-xs-12 offset-md-2">
            <h2>{{ __('Check-In') }}</h2>
            <p class="mb-4">{{ __('Check-in to an organization using the private code they supplied you with.') }}</p>
            <p><a class="btn btn-secondary" href="{{ route('organization.index') }}" role="button">{{ __('Find Organization') }} &raquo;</a></p>
        </div>
        <div class="col-md-4 col-xs-12">
            <h2>{{ __('Register') }}</h2>
            <p class="mb-4">{{ __('Register your organization. Create locations, define private codes, restrict users, review check-ins.') }}</p>
            <p><a class="btn btn-secondary" href="{{ route('register') }}" role="button">{{ __('Register Organization') }} &raquo;</a></p>
        </div>
    </div>

    <hr>

</div> <!-- /container -->

@endsection
