<div class="row">
    @foreach($clients as $client)
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
            <svg class="bd-placeholder-img card-img-top" width="100%" height="{{ $client->cardLabelHeight }}" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="{{ $client->name }}"><rect width="100%" height="100%" fill="{{ $client->getHexFromString($client->name) }}"></rect></svg>
            <div class="card-body">
                <h3>{{ $client->name }}</h3>
                <p class="card-text">{{ $client->description }}</p>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                        <form action="{{ action('ClientController@show', ['client' => $client]) }}" class="p-1">
                            <button type="submit" class="btn btn-outline-secondary btn-sm">{{ __('View') }}</button>
                        </form>
                        <form action="{{ action('ClientController@destroy', ['client' => $client]) }}" method="post" class="p-1">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-outline-secondary btn-sm">{{ __('Remove') }}</button>
                        </form>
                    </div>
                    <small class="text-muted">-</small>
                </div>
            </div>
            </div>
        </div>
    @endforeach
</div>
