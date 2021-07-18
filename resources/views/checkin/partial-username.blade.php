<div id="signin-user" class="form-create">
  <form id="user-signin" action="{{ route('checkin.signedin') }}" method="post">
    {{ csrf_field() }}

    <div class="row">
      <div class="form-group col-md-12 col-sm-12 col-xs-12">
        <label for="username">{{ __('Username') }}</label>
        <input type="text" id="username" name="username" value="{{ old('username') !== null ? old('username') : ($username != '' ? $username : '') }}" class="form-control form-input" placeholder="{{ __('Username') }}" required />
      </div>
    </div>

    <div class="row">
      <div class="form-group col-md-12 col-sm-12 col-xs-12">
        <button id="signin" name="signin" class="btn btn-primary">{{ __('Signin') }}</button>
      </div>
    </div>

  </form>
</div>
