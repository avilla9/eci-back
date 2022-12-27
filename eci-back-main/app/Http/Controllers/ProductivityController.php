<?php

namespace App\Http\Controllers;

use App\Imports\ProductivityImport;
use App\Models\Productivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProductivityController extends Controller {
    public function create(Request $request) {
        foreach ($request->user_id as $key => $user_id) {
            $exists = DB::table('productivities')
                ->where([
                    ['user_id', $user_id],
                    ['campaign_id', $request->campaign_id]
                ])
                ->count() > 0;

            if ($exists) {
                $create = DB::table('productivities')
                    ->where([
                        ['user_id', $user_id],
                        ['campaign_id', $request->campaign_id]
                    ])
                    ->update([
                        'policy_objective' => $request->policy_objective,
                        'policy_raised' => $request->policy_raised,
                        'bonus' => $request->bonus,
                        'incentive' => $request->incentive,
                    ]);
            } else {
                $create = Productivity::create([
                    'policy_objective' => $request->policy_objective,
                    'policy_raised' => $request->policy_raised,
                    'bonus' => $request->bonus,
                    'incentive' => $request->incentive,
                    'user_id' => $user_id,
                    'campaign_id' => $request->campaign_id,
                ]);
            }


            if (!$create) {
                return false;
            }
        }

        return true;
    }

    public function campaign(Request $request) {
        $prod = DB::table('productivities')
            ->select(
                'productivities.id',
                'productivities.policy_objective as policy_objective',
                'productivities.policy_raised as policy_raised',
                'productivities.bonus as bonus',
                'productivities.incentive as incentive',
                'users.name as name',
                'users.dni as dni',
            )
            ->join('campaigns', 'campaigns.id', '=', 'productivities.campaign_id')
            ->join('users', 'users.id', '=', 'productivities.user_id')
            ->where('productivities.campaign_id', '=', $request->id)
            ->get();

        if (count($prod)) {
            return $prod;
        } else {
            return false;
        }
    }

    public function fileImport(Request $request) {
        $campaign_id = $request->campaign_id;
        $import = new ProductivityImport($campaign_id);
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
            return $errors;
        } else {
            return 'Productividad insertada correctamente';
        }
    }

    public function delete(Request $request) {
        Productivity::where('id', $request->id)->delete();
        return $request->id;
    }
}
