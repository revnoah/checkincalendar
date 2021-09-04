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
            $userAlphaNumeric = preg_replace("/[^a-zA-Z0-9]+/", "", $user->name);
            $organization->code = substr(strtolower($userAlphaNumeric) . uniqid(), 0, 32);

            $user->organization()->save($organization);
        }

        return $next($request);
    }
}
