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
			'post_type' => $request->post_type,
		];

		$articleid = DB::table('articles')->insertGetId($data);

		if ($data['unrestricted']) {
			return $articleid;
		} else {
			$filters = [
				'groups' => count($request->groups) > 0 ? $request->groups : [0],
				'quartiles' => count($request->quartiles) > 0 ? $request->quartiles : [0],
				'delegations' => count($request->delegations) > 0 ? $request->delegations : [0],
				'roles' => count($request->roles) > 0 ? $request->roles : [0],
				'users' => count($request->users) > 0 ? $request->users : [0],
			];

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

	public function list(Request $request) {
		$user_id = $request->user_id;
		$page = $request->page;

		$sections = DB::table('sections')
			->select('sections.*')
			->join('pages', 'pages.id', '=', 'sections.page_id')
			->where('pages.title', $page)
			->get();

		//return $sections;

		$data = [];
		foreach ($sections as $key => $section) {
			$sectionId = $section->id;
			$articles = DB::table('articles')
				->select('articles.*', 'files.media_path')
				->leftJoin('accesses', 'accesses.article_id', '=', 'articles.id')
				->join('files', 'files.id', '=', 'articles.file_id')
				->where([
					['articles.active', 1],
					['articles.section_id', $sectionId],
					['accesses.user_id', $user_id],
				])
				->orWhere(function ($query) use ($sectionId) {
					$query->where([
						['articles.unrestricted', 1],
						['articles.section_id', $sectionId],
						['articles.active', 1],
					]);
				})
				->distinct()
				->orderBy('articles.id', 'desc')
				->get();

			$data[] = [
				'section' => $section->title,
				'articles' => $articles
			];
		}

		return $data;

		/* return DB::table('articles')
			->select('articles.*')
			->leftJoin('accesses', 'accesses.article_id', '=', 'articles.id')
			->where('articles.active', 1)
			->whereIn('articles.section_id', $sectionsId)
			->orWhere(function ($query) use ($sectionsId) {
				$query->where([
					['articles.unrestricted', 1],
					['articles.section_id', $sectionsId],
					['articles.active', 1],
				]);
			})
			->orWhere('accesses.user_id', $user_id)
			->orderBy('articles.created_at', 'asc')
			->get(); */
	}
}
