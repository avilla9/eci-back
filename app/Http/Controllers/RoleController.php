<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller {

    public function index(Request $request) {
        $roles = Role::latest()->paginate(10);
        return view('pages/roles/list', compact('roles'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        Role::create($request->all());

        return redirect()->route('create-role')
            ->with('success', 'Rol creado satisfactoriamente.');
    }

    public function show(Request $request) {
        $role = Role::findOrFail($request->id);
        return $role;
    }

    public function update(Request $request) {
        $role = Role::findOrFail($request->id);

        $role->name = $request->name;
        $role->description = $request->description;
        $role->content = $request->content;

        $role->save();

        return $role;
    }

    public function destroy(Request $request) {
        $role = Role::destroy($request->id);
        return $role;
    }

    public function getAllRoles(Request $request) {
        $roles = Role::all();
        return json_encode($roles);
    }
}
