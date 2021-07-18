<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Checkin;
use App\Models\Location;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CheckinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('checkin.create', compact('checkin'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $code = $request->get('code');
        $username = $request->get('username');

        $this->checkinUser($code, $username);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Checkin  $checkin
     * @return \Illuminate\Http\Response
     */
    public function show(Checkin $checkin)
    {
        return view('checkin.show', compact('checkin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Checkin  $checkin
     * @return \Illuminate\Http\Response
     */
    public function edit(Checkin $checkin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Checkin  $checkin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Checkin $checkin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Checkin  $checkin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Checkin $checkin)
    {
        //
    }

    public function qrcode(Request $request, Organization $organization, string $code)
    {
        $matchLocation = $this->matchCodeHash($organization, $code);

        if ($matchLocation) {
            echo 'display form';
        } else {
            return redirect('/')->with('statusCode', 'error')->with('statusMessage', 'No matching code');
        }
    }

    public function signin(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            session(['username' => $user->name]);

            return redirect('organizatin')->with('statusCode', 'success')->with('statusMessage', 'Signed in as ' . $user->name);
        }

        $username = session('username');

        return view('checkin.username', compact('username'));
    }

    public function signedin(Request $request)
    {
        $username = $request->input('username');

        if ($username) {
            session(['username' => $username]);

            return redirect('/')->with('statusCode', 'success')->with('statusMessage', 'Signed in as ' . $username);
        }

        return view('checkin.username', compact('username'));
    }

    private function matchCodeHash(Organization $organization, string $code):?Location
    {
        $locations = $organization->locations;
        foreach ($locations as $location) {
            if ($location->hashed == $code) {
                return $location;
            }
        }
        
        return false;
    }

    /**
     * Checkin user by code
     *
     * @param string $code
     * @return boolean
     */
    private function checkinUser(string $code, string $username):bool
    {
        $location = $this->getLocationByCode($code);

        $checkin = new Checkin([
            'location_id' => $location->id,
            'username' => $username,
            'ip_address' => $this->getUserIpAddr()
        ]);

        if ($checkin->save()) {
            return true;
        }

        return false;
    }

    /**
     * Get location by code
     *
     * @param string $code
     * @return Location
     */
    private function getLocationByCode(string $code):Location
    {
        $location = Location::where('code', '=', $code)->firstOrFail();

        return $location;
    }

    /**
     * Get user IP address using several fallback methods
     *
     * @return string
     */
    private function getUserIpAddr():string
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}
