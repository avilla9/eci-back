<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $users = User::latest()->paginate(5);

        return view('pages/users/list', compact('users'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $request->merge(['active' => 1]);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'gender' => 'required',
            'role_id' => 'required|not_in:0',
        ]);

        User::create($request->all());

        return redirect()->route('crear-usuarios')
            ->with('success', 'Usuario creado satisfactoriamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user) {
        //
    }

    /* API */

    public function getAllUsers(Request $request) {

        $users = User::select(
            'users.active',
            'users.created_at',
            'users.deleted_at',
            'users.email',
            'users.email_verified_at',
            'users.gender',
            'users.id',
            'users.name',
            'users.photo',
            'users.role_id',
            'roles.name as role_name',
            'roles.description as role_description',
        )->join(
            'roles',
            'users.role_id',
            '=',
            'roles.id'
        )->get();
        return json_encode($users);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request) {
        User::where('id', $request->id)->delete();
        return true;
    }
}
