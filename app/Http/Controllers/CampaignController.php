<?php

namespace App\Http\Controllers;

use App\Models\Access;
use App\Models\Article;
use App\Models\ArticleFilter;
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

        /* $campaigns = DB::table('campaigns as camp')
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
            ->get(); */

        $campaigns = DB::table('campaigns as camp')
            ->select(
                'camp.id as id',
                'camp.title as campaign_title',
            )
            ->join('pages as pag', 'pag.id', '=', 'camp.page_id')
            ->where([
                ['camp.page_id', '=', $page_id]
            ])
            ->orderBy('camp.id', 'desc')
            ->get();

        return $campaigns;
    }

    public function campaignData(Request $request) {
        $user_id = $request->user_id;
        $page = $request->page;
        $campaign_id = $request->campaign_id;

        /* return Access::where([
            'campaign_id' => $campaign_id,
            'user_id' => $user_id,
        ]); */

        $sections = DB::table('sections')
            ->select('sections.*')
            ->join('pages', 'pages.id', '=', 'sections.page_id')
            ->where('pages.title', $page)
            ->get();

        //return $sections;

        $data = [];
        foreach ($sections as $key => $section) {
            if ($section->title == 'Lo que he conseguido') {
                $production = DB::table('productivities')
                    ->where('campaign_id', $campaign_id)
                    ->get();
                $data[] = [
                    'section' => $section->title,
                    'articles' => $production,
                    'production' => true
                ];
            } else {
                $sectionId = $section->id;
                $articles = DB::table('articles')
                    ->select('articles.*', 'files.media_path')
                    ->leftJoin('accesses', 'accesses.article_id', '=', 'articles.id')
                    ->join('files', 'files.id', '=', 'articles.file_id')
                    ->where([
                        ['articles.active', 1],
                        ['articles.section_id', $sectionId],
                        ['articles.campaign_id', $campaign_id],
                        ['accesses.user_id', $user_id],
                    ])
                    ->orWhere(function ($query) use ($sectionId, $campaign_id) {
                        $query->where([
                            ['articles.unrestricted', 1],
                            ['articles.section_id', $sectionId],
                            ['articles.active', 1],
                            ['articles.campaign_id', $campaign_id],
                        ]);
                    })
                    ->distinct()
                    ->orderBy('articles.id', 'desc')
                    ->get();
                    
                $data[] = [
                    'section' => $section->title,
                    'articles' => $articles,
                    'production' => false
                ];
            }
        }

        return $data;
    }

    public function campaignFilters($id) {
        $articleFilters = ArticleFilter::where('article_id', $id)->get();

        return [
            'articleFilters' => $articleFilters
        ];
    }

    public function campaignUpdate(Request $request) {
        return $request;
    }
}
