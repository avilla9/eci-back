<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Page;
use App\Models\Productivity;
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
    }

    public function campaignList(Request $request) {
        $page_id = Page::where('title', $request->page_name)->first()->id;

        $campaigns = DB::table('campaigns as camp')
            ->select(
                'camp.id as campaign_title',
                'camp.title as campaign_title',
                'prod.*'
            )
            ->join('productivities as prod', 'prod.campaign_id', '=', 'camp.id')
            ->join('pages as pag', 'pag.id', '=', 'camp.page_id')
            ->where([
                ['prod.user_id', '=', $request->user_id],
                ['camp.page_id', '=', $page_id]
            ])
            ->orderBy('camp.created_at', 'desc')
            ->get();

        return $campaigns;
    }
}
