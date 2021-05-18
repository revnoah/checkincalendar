@if($location->id > 0)
  <div id="delete-location" class="form-create">
    <form id="location-delete" action="{{ route('location.destroy', ['location' => $location]) }}" method="post">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <div class="row">
            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                <button id="delete" name="delete" class="btn btn-danger">{{ __('Delete') }}</button>
            </div>
        </div>
    </form>
  </div>
@endif
