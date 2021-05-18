<table class="table table-hover table-dark">
  <thead>
    <tr>
      <th scope="col">{{ __('Name') }}</th>
      <th class="col-created" scope="col">{{ __('Created') }}</th>
      <th class="col-actions" scope="col">{{ __('Actions') }}</th>
    </tr>
  </thead>
  <tbody>
  @foreach($clients as $client)
    <tr>
      <td><a href="{{ action('ClientController@show', $client) }}" title="{{ __('Show Client') }}">{{ $client->name }}</a></td>
      <td>{{ $client->created_at->diffForHumans() }}</td>
      <td>
        <div class="d-flex flex-row">
          <form action="{{ action('ClientController@show', ['client' => $client]) }}" class="p-1">
            <button type="submit" class="btn btn-secondary btn-sm">{{ __('View') }}</button>
          </form>
          <form action="{{ action('ClientController@destroy', ['client' => $client]) }}" method="post" class="p-1">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button type="submit" class="btn btn-secondary btn-sm">{{ __('Remove') }}</button>
          </form>
        </div>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>