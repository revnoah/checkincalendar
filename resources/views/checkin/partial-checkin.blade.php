<div id="checkin-form" class="form-create">
  <form id="form-checkin" action="{{ route('checkin.store') }}" method="post">
    {{ csrf_field() }}

    <div class="row">
      <div class="form-group col-md-12 col-sm-12 col-xs-12">
        <label for="code">{{ __('Code') }}</label>
        <input type="text" id="code" name="code" value="{{ old('code') !== null ? old('code') : '' }}" class="form-control form-input" placeholder="{{ __('Code') }}" required />
      </div>
    </div>

    <div class="row">
      <div class="form-group col-md-12 col-sm-12 col-xs-12">
        <label for="code">{{ __('Username') }}</label>
        <input type="text" id="username" name="username" value="{{ old('username') !== null ? old('username') : '' }}" class="form-control form-input" placeholder="{{ __('Username') }}" required />
      </div>
    </div>

    <div class="row">
      <div class="form-group col-md-12 col-sm-12 col-xs-12">
        <button id="checkin" name="checkin" class="btn btn-primary" type="submit">{{ __('Check In') }}</button>
      </div>
    </div>

  </form>
</div>
