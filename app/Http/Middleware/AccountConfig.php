<?php

namespace App\Http\Middleware;

use App\Models\Organization;
use Auth;
use Closure;
use Illuminate\Http\Request;

class AccountConfig
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        //TODO: finish testing
        if (!$user->organization) {
            $organization = new Organization();
            $organization->name = $user->name;
            $organization->code = substr($user->name, 0, 32) . uniqid();

            $organization->save();

            $user->organization()->associate($organization->ID);
        }

        return $next($request);
    }
}
