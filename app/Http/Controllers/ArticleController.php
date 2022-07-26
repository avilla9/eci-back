<?php

namespace App\Http\Controllers;

use App\Models\Access;
use App\Models\Action;
use App\Models\Article;
use App\Models\Reaction;
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

	public function campaignCreate(Request $request) {
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
			'campaign_id' => $request->campaign,
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

			foreach ($articles as $key => $article) {
				$reactions = DB::table('reactions')
					->select('reactions.*', 'actions.name')
					->join('actions', 'actions.id', '=', 'reactions.action_id')
					->where([
						['article_id', $article->id],
						['user_id', $user_id],
						['user_id', $user_id],
					])
					->get();

				if (Count($reactions)) {
					$article->reactions = $reactions;
				} else {
					$article->reactions = [];
				}
			}

			$data[] = [
				'section' => $section->title,
				'articles' => $articles
			];
		}

		return $data;
	}

	public function delete(Request $request) {
		Article::where('id', $request->id)->delete();
		return $request->id;
	}

	public function like(Request $request) {
		$post = $request->post_id;
		$user = $request->user_id;
		$action = Action::where('name', 'like')->first();


		$articleExists = DB::table('reactions')
			->where([
				'user_id' => $user,
				'article_id' => $post,
				'action_id' => $action->id,
			])
			->get();

		if (Count($articleExists)) {
			DB::table('reactions')
				->where([
					'user_id' => $user,
					'article_id' => $post,
					'action_id' => $action->id,
				])
				->delete();
			$articleid = 0;
		} else {
			$articleid = DB::table('reactions')->insertGetId([
				'user_id' => $user,
				'article_id' => $post,
				'action_id' => $action->id,
			]);
		}


		return $articleid;
	}
}
