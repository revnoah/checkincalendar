<div id="update-organization" class="form-create">
  <form id="organization-update" action="{{ route('organization.update', ['organization' => $organization]) }}" method="post">
    {{ csrf_field() }}

    @if ($organization->id > 0)
      {{ method_field('PATCH') }}
    @endif

    <div class="row">
      <div class="form-group col-md-12 col-sm-12 col-xs-12">
        <label for="name">{{ __('Name') }}</label>
        <input type="text" id="name" name="name" value="{{ old('name') !== null ? old('name') : (isset($organization->name) ? $organization->name : '') }}" class="form-control form-input" placeholder="{{ __('Name') }}" required />
      </div>
    </div>

    <div class="row">
      <div class="form-group col-md-12 col-sm-12 col-xs-12">
        <label for="code">{{ __('Code') }}</label>
        <input type="text" id="code" name="code" value="{{ old('code') !== null ? old('code') : (isset($organization->code) ? $organization->code : '') }}" class="form-control form-input" placeholder="{{ __('Code') }}" required />
      </div>
    </div>

    <div class="row">
      <div class="form-group col-md-12 col-sm-12 col-xs-12">
        <label for="description">{{ __('Description') }}</label>
        <textarea id="description" name="description" class="form-control" rows="3" placeholder="{{ __('Description') }}">{{ old('description') !== null ? old('description') : (isset($organization->description) ? $organization->description : '') }}</textarea>
      </div>
    </div>

    <div class="row">
      <div class="form-group col-md-12 col-sm-12 col-xs-12">
        <button id="update" name="update" class="btn btn-primary">{{ $organization->id > 0 ? __('Update') : __('Create') }}</button>
      </div>
    </div>

  </form>
</div>
