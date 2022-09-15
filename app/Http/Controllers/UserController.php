<?php

namespace App\Http\Controllers;

use App\Imports\DeleteUsersImport;
use App\Imports\UsersImport;
use App\Models\Delegation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

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

    public function getUserData(Request $request) {
        return User::where('id', $request->id)->first();
    }
    
    public function getUserRole(Request $request) {
        $role = DB::table('users')
        ->select('roles.name as role_name')
        ->where('users.id', $request->id)
        ->join('roles', 'roles.id', '=', 'users.role_id')
        ->first();
        return $role;
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
        $delegation = Delegation::where('id', $request->delegation_id)->first()->code;
        $request->merge(['delegation_code' => $delegation]);

        $request->validate([
            'dni' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'gender' => 'required',
            'territorial' => 'required',
            'role_id' => 'required|not_in:0',
            'delegation_id' => 'required|not_in:0',
            'quartile_id' => 'required|not_in:0',
            'group_id' => 'required|not_in:0',
        ]);

        $request->merge(['password' => Hash::make($request->password)]);

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
    public function update(Request $request) {
        $validator = Validator($request->all(), [
            'dni' => 'required',
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'gender' => 'required',
            'territorial' => 'required',
            'role_id' => 'required|not_in:0',
            'delegation_id' => 'required|not_in:0',
            'quartile_id' => 'required|not_in:0',
            'group_id' => 'required|not_in:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        } else {
            $request->merge(['password' => Hash::make($request->password)]);
            $user = User::where('dni', $request->id)->first();
            $user->dni = $request->dni;
            $user->name = $request->name;
            $user->gender = $request->gender;
            $user->email = $request->email;
            $user->territorial = $request->territorial;
            $user->secicoins = $request->secicoins;
            $user->password = $request->password;
            $user->role_id = $request->role_id;
            $user->delegation_id = $request->delegation_id;
            $user->group_id = $request->group_id;
            $user->quartile_id = $request->quartile_id;
            $user->save();
            return 'ok';
        }
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
            'users.secicoins',
            'users.territorial as territorial',
            'users.role_id',
            'roles.name as role_name',
            'roles.description as role_description',
            'quartiles.name as quartile',
            'quartiles.id as quartile_id',
            'groups.name as group',
            'groups.id as group_id',
            'delegations.code as delegation_code',
            'delegations.name as delegation_name',
            'delegations.id as delegation_id',
        )
            ->join(
                'roles',
                'users.role_id',
                '=',
                'roles.id'
            )
            ->join(
                'quartiles',
                'quartiles.id',
                '=',
                'users.quartile_id'
            )
            ->join(
                'groups',
                'groups.id',
                '=',
                'users.group_id'
            )
            ->join(
                'delegations',
                'delegations.code',
                '=',
                'users.delegation_code'
            )
            ->latest()
            ->get();
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
