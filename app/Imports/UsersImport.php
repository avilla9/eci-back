<?php

namespace App\Imports;

use App\Models\Delegation;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements
    ToModel,
    WithHeadingRow,
    SkipsOnFailure {

    use SkipsFailures;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row) {
        $delegation = validateDelegation([
            'name' => ucwords(strtolower($row['delegation_name'])),
            'code' => $row['delegation_code']
        ]);

        $role = validateRole([
            'name' => ucwords(strtolower($row['role'])),
            'level' => $row['role_level']
        ]);

        $user = validateUser([
            'email' => $row['email'],
        ]);

        if ($user) {
            return new User([
                'dni' => strval($row['dni']),
                'name' => $row['name'],
                'gender' => $row['gender'],
                'role_id' => $role,
                'email' => $row['email'],
                'territorial' => $row['territorial'],
                'password' => Hash::make($row['password']),
                'active' => 1,
                'delegation_code' => $delegation,
            ]);
        }
    }
}

function validateDelegation($data) {
    $delegation = Delegation::where('code', '=', $data['code'])->first();
    if (is_null($delegation)) {
        $id = DB::table('delegations')->insertGetId([
            'name' => $data['name'],
            'code' => $data['code']
        ]);
        return Delegation::where('id', '=', $id)->first()->code;
    } else {
        return $delegation->code;
    }
}

function validateRole($data) {
    $role = Role::where('name', '=', $data['name'])->first();
    if (is_null($role)) {
        $id = DB::table('roles')->insertGetId([
            'name' => $data['name'],
            'level' => $data['level']
        ]);
        return Role::where('id', '=', $id)->first()->id;
    } else {
        return $role->id;
    }
}

function validateUser($data) {
    $user = User::where('email', '=', $data['email'])->first();
    if (is_null($user)) {
        return  true;
    } else {
        return false;
    }
}
