<?php

namespace App\Http\Controllers;

use App\Models\Access;
use App\Models\Article;
use App\Models\ArticleFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleFilterController extends Controller {
    function refresh() {
        $articlesfilters = ArticleFilter::all();
        $result = [];
        foreach ($articlesfilters as $key => $filter) {
            $users = DB::table('users')
                ->select('users.*')
                ->join('delegations', 'delegations.code', '=', 'users.delegation_code')
                ->whereIn('delegations.id', $filter->delegations)
                ->orWhereIn('users.role_id', $filter->roles)
                ->orWhereIn('users.quartile_id', $filter->quartiles)
                ->orWhereIn('users.group_id', $filter->groups)
                ->orWhereIn('users.id', $filter->users)
                ->get();

            $delete = Access::where([
                'article_id' => $filter->article_id,
            ])->delete();
            foreach ($users as $key => $user) {

                $create = Access::create([
                    'user_id' => $user->id,
                    'article_id' => $filter->article_id,
                ]);

                $result[] = [
                    'filter' => $filter,
                    'create' => $create,
                    'delete' => $delete,
                ];
            }
        }

        return $result;
    }
}
