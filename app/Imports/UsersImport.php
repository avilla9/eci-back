<?php

namespace App\Imports;

use App\Models\Delegation;
use App\Models\Group;
use App\Models\Quartile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rules\Password;

class UsersImport implements
    ToModel,
    WithHeadingRow,
    SkipsOnFailure,
    WithValidation
{

    use Importable, SkipsErrors, SkipsFailures;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $delegationComposition = explode(' - ', $row['delegation']);
        $delegation = validateDelegation([
            'name' => ucwords(strtolower($delegationComposition[0])),
            'code' => $delegationComposition[1]
        ]);

        $role = validateRole([
            'name' => ucwords(strtolower($row['role']))
        ]);

        if (strlen($row['quartile'])) {
            $quartile = validateQuartile($row['quartile']);
        } else {
            $quartile = NULL;
        }

        if (strlen($row['group'])) {
            $group = validateGroup([
                'quartile' => $quartile,
                'group' => $row['group'],
            ]);
        } else {
            $group = NULL;
        }

        if (strlen($row['secicoins'])) {
            $seci = $row['secicoins'];
        } else {
            $seci = 0;
        }

        if (userExist($row['email'])) {
            User::where('email', $row['email'])->update(
                [
                    'dni' => '000000',
                    'user_code' => $row['code'],
                    'name' => $row['name'],
                    'last_name' => $row['last_name'],
                    'role_id' => $role,
                    'territorial' => $row['territorial'],
                    'password' => Hash::make($row['password']),
                    'active' => 1,
                    'secicoins' => $seci,
                    'delegation_code' => $delegation,
                    'quartile_id' => $quartile,
                    'group_id' => $group,
                ]
            );
        } else {
            return new User(
                [
                    'dni' => '000000',
                    'email', $row['email'],
                    'user_code' => $row['code'],
                    'name' => $row['name'],
                    'last_name' => $row['last_name'],
                    'role_id' => $role,
                    'territorial' => $row['territorial'],
                    'password' => Hash::make($row['password']),
                    'active' => 1,
                    'secicoins' => $seci,
                    'delegation_code' => $delegation,
                    'quartile_id' => $quartile,
                    'group_id' => $group,
                ]
            );
        }
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
        ];
    }

    public function customValidationMessages()
    {
        return [
            'email.required' => 'El campo email es requerido',
            'email.email' => 'El valor ingresado no corresponde a un formato de email válido',
            // 'email.unique' => 'El email ingresado ya se encuentra asignado a otro usuario',
        ];
    }
}

function validateDelegation($data)
{
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

function validateRole($data)
{
    $role = Role::where('name', '=', $data['name'])->first();
    if (is_null($role)) {
        $id = DB::table('roles')->insertGetId([
            'name' => $data['name']
        ]);
        return Role::where('id', '=', $id)->first()->id;
    } else {
        return $role->id;
    }
}

function validateQuartile($data)
{
    $quartile = Quartile::where('name', '=', $data)->first();
    if (is_null($quartile)) {
        $id = DB::table('quartiles')->insertGetId([
            'name' => $data
        ]);
        return $id;
    } else {
        return $quartile->id;
    }
}

function validateGroup($data)
{
    $group = Group::where('name', '=', $data['group'])->first();
    if (is_null($group)) {
        $id = DB::table('groups')->insertGetId([
            'name' => $data['group'],
            'quartile_id' => $data['quartile'],
        ]);
        return $id;
    } else {
        return $group->id;
    }
}

function userExist($email)
{
    $user = User::where('email', $email)->first();

    if (is_null($user)) {
        return false;
    } else {
        return true;
    }
}
