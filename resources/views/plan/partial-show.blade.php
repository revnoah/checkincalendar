<div class="item item-organization">
	@if (Auth::check())
    <a href="{{ action('OrganizationController@edit', $organization) }}" title="{{ __('Edit') }}" class="btn btn-default pull-right">{{ __('Edit') }}</a>
	@endif
	<h3><a href="{{ action('OrganizationController@show', $organization) }}" title="{{ __('Show Organization') }}">{{ $organization->name }}</a></h3>
	<p class="website">{{ $organization->website }}</p>
	<p class="description">{{ $organization->description }}</p>
</div>
