<div id="addteam-client" class="form-create">
  <form id="client-addteam" action="{{ action('ClientController@addTeam', $client) }}" method="post">
    {{ csrf_field() }}

    <div class="row">
      <div class="form-group col-md-12 col-sm-12 col-xs-12">
        <label for="team">{{ __('Team') }}</label>&nbsp;
        <select name="team" id="team">
        @foreach ($teams as $team)
          <option value="{{$team->id}}" {{ $team->id == $client->team_id ? 'selected' : '' }} >{{$team->name}}</option>
        @endforeach
        </select>
        <a href="{{ action('TeamController@create') }}" title="{{ __('New Team') }}">{{ __('New Team') }}</a>
      </div>
    </div>

    <div class="row">
      <div class="form-group col-md-12 col-sm-12 col-xs-12">
        <button id="addteam" name="addteam" class="btn btn-primary">{{ __('Add') }}</button>
      </div>
    </div>

  </form>
</div>
