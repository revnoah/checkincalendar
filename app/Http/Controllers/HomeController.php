<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        if ($user) {
            // redirect('organization');

            $organization = $user->organization;

            if (!$organization) {
                return redirect('organization/create');
            }

            return view('organization.show', compact('organization'));
        } else {
            return view('home');
        }
    }
}
