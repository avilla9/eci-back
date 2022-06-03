<?php

namespace App\Http\Controllers;

use App\Imports\DeleteUsersImport;
use App\Imports\UsersImport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;

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
            'dni' => 'required',
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
            'users.dni',
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
        )->latest()->get();
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

    public function fileImport(Request $request) {
        $import = new UsersImport;
        Excel::import($import, $request->file('file')->store('files'));

        $errors = [];
        foreach ($import->failures() as $failure) {
            $errors[] = [
                'row' => $failure->row(),
                'attribute' => $failure->attribute(),
                'errors' => $failure->errors(),
                'values' => $failure->values(),
            ];
        }
        if (count($errors) > 0) {
            return $errors; /* redirect()->route('subir-usuarios')
                ->with('errors', $errors)
                ->send(); */
            /* return view('pages/users/upload') */
        } else {
            return 'Usuarios insertados correctamente';
        }

        /* return view('pages/users/upload', $errors); */
        /* return redirect()->back()->with('errors', $errors); */
    }

    public function deleteImport(Request $request) {
        Excel::import(new DeleteUsersImport, $request->file('file')->store('files'));
        return redirect()->back();
    }
}
