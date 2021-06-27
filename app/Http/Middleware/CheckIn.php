<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class CheckIn
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

        $username = session('username');

        dd($username);

        if (!$username) {
            return redirect('checkin.signin');
        }

        $orgcode = session('orgcode');
        if (!$orgcode) {
            return redirect('organization.index');
        }

        /*
        $username = session('username');
        if (!$username) {
            return redirect('account.username');
        }
        */

        return $next($request);
    }
}
