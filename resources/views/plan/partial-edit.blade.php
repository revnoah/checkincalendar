<div id="update-client" class="form-create">
  <form id="client-update" action="{{ action('ClientController@update', $client) }}" method="post">
    {{ csrf_field() }}

    @if ($client->id > 0)
      {{ method_field('PATCH') }}
    @endif

    <div class="row">
      <div class="form-group col-md-12 col-sm-12 col-xs-12">
        <label for="name">{{ __('Name') }}</label>
        <input type="text" id="name" name="name" value="{{ old('name') !== null ? old('name') : (isset($client->name) ? $client->name : '') }}" class="form-control form-input" placeholder="{{ __('Name') }}" required />
      </div>
    </div>

    <div class="row">
      <div class="form-group col-md-12 col-sm-12 col-xs-12">
        <label for="caption">{{ __('Website') }}</label>
        <input type="text" id="website" name="website" value="{{ old('website') !== null ? old('website') : (isset($client->website) ? $client->website : '') }}" class="form-control form-input" placeholder="{{ __('Website') }}" />
      </div>
    </div>

    <div class="row">
      <div class="form-group col-md-12 col-sm-12 col-xs-12">
        <label for="description">{{ __('Description') }}</label>
        <textarea id="description" name="description" class="form-control" rows="3" placeholder="{{ __('Description') }}">{{ old('description') !== null ? old('description') : (isset($client->description) ? $client->description : '') }}</textarea>
      </div>
    </div>

    <div class="row">
      <div class="form-group col-md-12 col-sm-12 col-xs-12">
        <button id="update" name="update" class="btn btn-primary">{{ $client->id > 0 ? __('Update') : __('Create') }}</button>
      </div>
    </div>

  </form>
</div>
