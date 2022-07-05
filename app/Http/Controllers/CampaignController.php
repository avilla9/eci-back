<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CampaignController extends Controller {
    public function store(Request $request) {

        Campaign::create($request->all());

        return redirect()->route('campaign-create')
            ->with('success', 'Campaña creada satisfactoriamente.');
    }

    public function delete(Request $request) {

        $delete = Campaign::where('id', $request->id)->delete();

        if ($delete) {
            return $request->id;
        } else {
            return false;
        }
    }

    public function update(Request $request) {
        /* $validator = Validator($request->all(), [
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
            $user = User::where('dni', $request->id);
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
        } */
    }
}
