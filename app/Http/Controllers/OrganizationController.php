<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    protected $basepath;

    function __construct()
    {
        $this->basepath = '/organization';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $organization = $user->organization;

        return view('organization.show', compact('organization') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $organization = new Organization();

        return view('organization.create', compact('organization') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function show(Organization $organization)
    {
        $user = Auth::user();

        //item index
        return view('organization.show', compact('organization') );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function edit(Organization $organization)
    {
        return view('organization.edit', compact('organization') );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Organization $organization)
    {
        $user = Auth::user();

        //update item
        $organization->name = $request->input('name');
        $organization->code = $request->input('code');
        $organization->description = $request->input('description');

        $organization->save();

        //display message to display to user
        $request->session()->flash('message', 'Successfully updated organization');
        $request->session()->flash('status', 'success');

        //set redirect to include query tokens
        $redirectUri = $this->basepath . '/' . $organization->id;

        return redirect($redirectUri);  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organization $organization)
    {
        //set to base path
        $redirectUri = $this->basepath;

        //TODO: add checks and validation
        $organization->delete();

        //redirect
        return redirect($redirectUri);  
    }
}
