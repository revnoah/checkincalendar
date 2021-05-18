<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">{{ __('Name') }}</th>
      <th class="col-created" scope="col">{{ __('Created') }}</th>
      <th class="col-actions" scope="col">{{ __('Actions') }}</th>
    </tr>
  </thead>
  <tbody>
  @foreach($teams as $team)
    <tr>
      <td><a href="{{ action('TeamController@show', $team) }}" title="{{ __('Show Team') }}">{{ $team->name }}</a></td>
      <td>{{ $team->created_at->diffForHumans() }}</td>
      <td>
        <div class="d-flex flex-row">
          <form action="{{ action('TeamController@show', ['team' => $team]) }}" class="p-1">
            <button type="submit" class="btn btn-secondary btn-sm">{{ __('View') }}</button>
          </form>
          <form action="{{ action('ClientController@removeTeam', ['client' => $client]) }}" method="post" class="p-1">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <input type="hidden" name="team_id" value="{{ $team->id }}" />
            <button type="submit" class="btn btn-secondary btn-sm">{{ __('Remove') }}</button>
          </form>
        </div>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>