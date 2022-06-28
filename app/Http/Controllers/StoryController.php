<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoryController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $data = [];
        $request->link ? $data['link'] = $request->link : '';
        $request->link && $request->button_name ? $data['button_name'] = $request->button_name : '';
        $request->image ? $data['file_id'] = $request->image : '';

        $story = Story::create($data);

        return $story;

        /* 
        SELECT
            *
        FROM
            users
        JOIN groups ON groups.id = users.group_id
        JOIN roles ON roles.id = users.role_id
        JOIN quartiles ON quartiles.id = users.quartile_id
        JOIN delegations ON delegations.code = users.delegation_code
        WHERE
            roles.id = 2
            OR roles.id = 3
            OR quartiles.id = 1.2
            OR delegations.id = 2 
        */
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function show(Story $story) {
        return DB::table('stories')
            ->join('files', 'files.id', '=', 'stories.file_id')
            ->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function edit(Story $story) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Story $story) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function destroy(Story $story) {
        //
    }
}
