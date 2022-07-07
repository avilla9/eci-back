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
            $create = Productivity::create([
                'policy_objective' => $request->policy_objective,
                'policy_raised' => $request->policy_raised,
                'bonus' => $request->bonus,
                'incentive' => $request->incentive,
                'user_id' => $user_id,
                'campaign_id' => $request->campaign_id,
            ]);

            if (!$create) {
                return false;
            }
        }

        return true;
    }

    public function campaign(Request $request) {
        $prod = DB::table('productivities')
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
        $import = new ProductivityImport;
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
}
