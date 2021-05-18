<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    protected $basepath;

    function __construct()
    {
        $this->basepath = '/location';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $location = new Location();

        return view('location.create', compact('location') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $location = new Location;

        $location->name = $request->input('name');
        $location->code = $request->input('code');
        $location->description = $request->input('description');
        $location->organization_id = $user->organization->id;
  
        //save record with values
        $item_saved = $location->save();

        //handle item after saved
        if($item_saved) {
            //display message to display to user
            $request->session()->flash('message', 'Add location ' . $location->name);
            $request->session()->flash('status', 'success');
        } else {
            //display message to display to user
            $request->session()->flash('message', 'Unable to add location ' . $location->name);
            $request->session()->flash('status', 'error');
        }

        //redirect based on submit button
        if($location->id > 0) {
            $url = $this->basepath . '/create';
            return redirect($url);
        } else {
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        return view('location.show', compact('location') );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        return view('location.edit', compact('location') );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        $user = Auth::user();

        //update item
        $location->name = $request->input('name');
        $location->code = $request->input('code');
        $location->description = $request->input('description');

        $location->save();

        //display message to display to user
        $request->session()->flash('message', 'Successfully updated location');
        $request->session()->flash('status', 'success');

        //set redirect to include query tokens
        $redirectUri = $this->basepath . '/' . $location->id;

        return redirect($redirectUri);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        //set to base path
        $redirectUri = $location->organization->code;

        //TODO: add checks and validation
        $location->delete();

        //redirect
        return redirect($redirectUri);  
    }
}
