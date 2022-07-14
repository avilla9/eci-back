<?php

namespace App\Http\Controllers;

use App\Models\Access;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\map;

class ArticleController extends Controller {
	public function homeCreate(Request $request) {
		$data = [
			'title' => $request->title,
			'description' => $request->description,
			'short_description' => $request->short_description,
			'button_name' => $request->button_name,
			'button_link' => $request->button_link,
			'internal_link' => $request->internal_link,
			'external_link' => $request->external_link,
			'created_at' => $request->date,
			'unrestricted' => $request->grant_all,
			'file_id' => $request->image,
			'section_id' => $request->section,
		];

		$filters = [
			'post_type' => $request->post_type,
			'groups' => count($request->groups) > 0 ? $request->groups : [0],
			'quartiles' => count($request->quartiles) > 0 ? $request->quartiles : [0],
			'delegations' => count($request->delegations) > 0 ? $request->delegations : [0],
			'roles' => count($request->roles) > 0 ? $request->roles : [0],
			'users' => count($request->users) > 0 ? $request->users : [0],
		];

		$articleid = DB::table('articles')->insertGetId($data);
		
		if ($data['unrestricted']) {
			return $articleid;
		} else {
			$users = DB::table('users')
				->select('users.*')
				->join('delegations', 'delegations.code', '=', 'users.delegation_code')
				->whereIn('delegations.id', $filters['delegations'])
				->orWhereIn('users.role_id', $filters['roles'])
				->orWhereIn('users.quartile_id', $filters['quartiles'])
				->orWhereIn('users.group_id', $filters['groups'])
				->orWhereIn('users.id', $filters['users'])
				->get();


			foreach ($users as $key => $user) {
				DB::table('accesses')
					->insert([
						'user_id' => $user->id,
						'article_id' => $articleid,
					]);
			}
		}
	}
}
