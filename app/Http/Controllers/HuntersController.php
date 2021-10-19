<?php

namespace App\Http\Controllers;

use App\Models\Hunter;
use Illuminate\Http\Request;

class HuntersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();  
        $hunters = Hunter::where('username', $user->username)->orderBy('hunterName')->get();
        return response()->json($hunters); 
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
        $hunter = Hunter::create([
            'username' => $user->username,
            'propertyName' => $request->get('propertyName'),
            'hunterName' => $request->get('hunterName'),
            'huntPartyName' => $request->get('huntPartyName')
        ]);

        return response()->json($hunter);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hunter  $hunter
     * @return \Illuminate\Http\Response
     */
    public function show(Hunter $hunter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hunter  $hunter
     * @return \Illuminate\Http\Response
     */
    public function edit(Hunter $hunter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hunter  $hunter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $hunter = Hunter::findOrFail($id);
        $hunter->hunterName = $request->get('hunterName');
        $hunter->save();
        return response()->json($hunter);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hunter  $hunter
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Hunter::destroy($id);
    }
}
