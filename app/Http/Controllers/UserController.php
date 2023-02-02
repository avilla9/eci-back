<?php

namespace App\Http\Controllers;

use App\Imports\DeleteUsersImport;
use App\Imports\UsersImport;
use App\Models\Delegation;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

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
        $request->validate(
            [
                'dni' => 'required',
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => [
                    'required',
                    Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                        ->uncompromised()
                ],
                'gender' => 'required',
                'territorial' => 'required',
                'role_id' => 'required|not_in:0',
                'delegation_id' => 'required|not_in:0',
                'quartile_id' => 'required|not_in:0',
                'group_id' => 'required|not_in:0',
            ],
            [
                "password.min" => "El campo :attribute debe contener al menos :min caracteres.",
                "password.mixedCase" => "El campo :attribute debe contener al menos una letra mayúcula y una minúscula.",
            ],
        );

        $request->merge(['active' => 1]);
        $delegation = Delegation::where('id', $request->delegation_id)->first()->code;
        $request->merge(['delegation_code' => $delegation]);

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
            'password' => [
                'nullable',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
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
            $user = User::where('dni', $request->dni)->first();
            if ($request->password) {
                $request->merge(['password' => Hash::make($request->password)]);
                $user->password = $request->password;
            }
            $delegation = Delegation::where('id', $request->delegation_id)->first();
            $delegation = Delegation::where('id', $request->delegation_id)->first();
            $user->name = $request->name;
            $user->gender = $request->gender;
            $user->email = $request->email;
            $user->territorial = $request->territorial;
            $user->secicoins = $request->secicoins;
            $user->group_id = $request->group_id;
            $user->role_id = $request->role_id;
            $user->delegation_code = $delegation->code;
            $user->quartile_id = $request->quartile_id;
            $user->save();
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

    public function password(Request $request) {
        $validated = Validator::make($request->all(), [
            "email" => 'required|email|max:255|exists:users,email'
        ]);

        if ($validated->fails()) {
            return [
                "status" => Response::HTTP_BAD_REQUEST,
                "errors" => $validated->errors(),
            ];
        }

        $emailExist = User::where([
            'email' => $request->email,
            'deleted_at' => NULL
        ])->first();

        if(!$emailExist) {
            return [
                "status" => Response::HTTP_BAD_REQUEST,
                "errors" => ['email' => 'El usuario no se encuentra activo.'],
            ];
        }

        $data = [
            "id" => $emailExist->id,
            "name" => $emailExist->name,
            "email" => $emailExist->email,
            "origin" => $request->origin
        ];

        $user = User::find($emailExist->id);


        $user->notify(new ResetPasswordNotification($data));

        return [
            "status" => Response::HTTP_ACCEPTED,
            "message" => "¡Te hemos enviado un correo!"
        ];
    }

    public function newPassword($id) {
        $user = User::where('id', Crypt::decrypt($id))->get();
        $userId = Crypt::encrypt($user[0]->id);

        return view('pages.users.get_password', ['layout' => 'login', "user" => $userId]);
    }

    public function resetPassword(Request $request) {
        $validated = Validator::make($request->all(), [
            'password' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
            "password_check" => "required|same:password",
        ]);

        if ($validated->fails()) {
            return [
                "status" => Response::HTTP_BAD_REQUEST,
                "errors" => $validated->errors()
            ];
        }

        $id = Crypt::decrypt($request->id);

        $affected = DB::table('users')
            ->where('id', $id)
            ->update([
                'password' => Hash::make($request->password)
            ]);


        return [
            "status" => Response::HTTP_ACCEPTED,
            "message" => "Contraseña Actualizada",
            "affected" => $affected
        ];
    }
    public function changePassword(Request $request) {
        $user = User::where(['id' => $request->user_id])->first();

        if (Hash::check($request->old_password, $user->getAuthPassword())) {
            $validator = Validator($request->all(), [
                'new_password' => [
                    'required',
                    Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                        ->uncompromised()
                ],
            ]);

            if ($validator->fails()) {
                $error = $validator->errors();
                return [
                    "status" => Response::HTTP_BAD_REQUEST,
                    "message" => $error->first()
                ];    
                // return response()->json($validator->errors()->error , 404);
            }
            $user->password = Hash::make($request->new_password);
            $user->save();
            return [
                "status" => Response::HTTP_ACCEPTED,
                "message" => "Contraseña actualizada correctamente.",
            ];
        } else {
            return [
                "status" => Response::HTTP_BAD_REQUEST,
                "message" => "La contraseña anterior no es correcta.",
            ];
        }
    }
}
