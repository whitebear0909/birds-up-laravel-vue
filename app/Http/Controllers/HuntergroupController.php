<?php

namespace App\Http\Controllers;

use App\Models\HunterGroup;
use Illuminate\Http\Request;

class HuntergroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();  
        $huntergroups = HunterGroup::where('username', $user->username)->orderBy('groupName')->get();
        return response()->json($huntergroups); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $huntergroup = HunterGroup::create([
            'username' => $user->username,
            'propertyName' => $request->get('propertyName'),
            'groupName' => $request->get('groupName')
        ]);

        return response()->json($huntergroup);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $huntergroup = HunterGroup::findOrFail($id);
        $huntergroup->groupName = $request->get('groupName');
        $huntergroup->save();
        return response()->json($huntergroup);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        HunterGroup::destroy($id);
    }
}
