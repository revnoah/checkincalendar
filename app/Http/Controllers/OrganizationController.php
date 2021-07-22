<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    protected $basepath;

    public function __construct()
    {
        $this->basepath = '/organization';
    }

    /**
     * Display the index
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $orgcode = session('orgcode', '');

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
        $user = Auth::user();

        //update item
        $organization = new Organization();
        $organization->user_id = $user->id;
        $organization->name = $request->input('name');
        $organization->code = $request->input('code');
        $organization->description = $request->input('description');

        $organization->save();

        //display message to display to user
        $request->session()->flash('message', 'Successfully setup organization');
        $request->session()->flash('status', 'success');

        //set redirect to include query tokens
        $redirectUri = $this->basepath . '/' . $organization->code;

        if ($user) {
            $organization = $user->organization;
            return redirect('organization/' . $organization->code);
        } elseif ($orgcode !== '') {
            return redirect('organization/' . $orgcode);
        }

        return view('organization.search');
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
        return view('organization.show', compact('organization'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function edit(Organization $organization)
    {
        return view('organization.edit', compact('organization'));
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
        $redirectUri = $this->basepath;

        return redirect($redirectUri);
    }

    /**
     * Search for organization by code
     *
     * @param Request $request
     * @return void
     */
    public function search(Request $request)
    {
        $code = $request->input('code');

        $organization = $this->findOrganizationByCode($code);

        $statusMessage = __('Code invalid, access denied');
        $statusCode = 'danger';

        if ($organization) {
            session(['orgcode' => $code]);

            $statusMessage = __('Access granted');
            $statusCode = 'success';
        }

        //set redirect to include query tokens
        return redirect($this->basepath)->with('message', $statusMessage)->with('status', $statusCode);
    }

    private function findOrganizationByCode(string $search)
    {
        $organization = Organization::where('code', '=', $search)->first();

        return $organization;
    }
}
