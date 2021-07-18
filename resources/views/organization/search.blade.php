@extends('layouts.app')

@section('content')

@include('partials.info', [
  'title' => __('Find An Organization'), 
  'info' => __('Each organization has a secret sharing code.')
])

<div class="container py-5 col-4">

  <div id="form-search" class="panel panel-default">
     <form id="organization-search" action="{{ route('organization.search') }}" method="post">
     {{ csrf_field() }}

      <div class="row">
        <div class="form-group col-md-12 col-sm-12 col-xs-12">
          <label for="code">{{ __('Organization Sharing Code') }}</label>
          <input type="text" id="code" name="code" value="{{ old('code') !== null ? old('code') : (isset($organization->code) ? $organization->code : '') }}" class="form-control form-input" placeholder="{{ __('code') }}" required />
        </div>
      </div>

      @include('partials.messages')

      <div class="row">
        <div class="form-group col-md-12 col-sm-12 col-xs-12">
          <button id="checkin" name="checkin" class="btn btn-primary">{{ __('Checkin') }}</button>
        </div>
      </div>

     </form>
  </div>
</div>

@endsection
