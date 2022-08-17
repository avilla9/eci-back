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
	public function delete(Request $request) {
		Article::where('id', $request->id)->delete();
		return $request->id;
	}

	public function access(Request $request) {
		return DB::table('accesses')
			->join('users', 'users.id', '=', 'accesses.user_id')
			->where('accesses.article_id', $request->id)
			->get();
	}

	public function storyCreate(Request $request) {
		$data = [
			'title' => 'story',
			'button_name' => $request->button_name,
			'button_link' => $request->button_link,
			'created_at' => $request->date,
			'unrestricted' => $request->grant_all,
			'file_id' => $request->image,
			'section_id' => $request->section,
			'post_type' => 'story',
		];

		$articleid = DB::table('articles')->insertGetId($data);

		if ($data['unrestricted']) {
			return $articleid;
		} else {
			$filters = [
				'groups' => !is_null($request->groups) ? $request->groups : [0],
				'quartiles' => !is_null($request->quartiles) ? $request->quartiles : [0],
				'delegations' => !is_null($request->delegations) ? $request->delegations : [0],
				'roles' => !is_null($request->roles) ? $request->roles : [0],
				'users' => !is_null($request->users) ? $request->users : [0],
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

			return $users;
		}
	}

	public function showStories(Request $request) {
		$userId = $request->user_id;
		$stories = DB::table('articles')
			->select('articles.*', 'files.media_path', 'reactions.active as view')
			->leftJoin('accesses', 'accesses.article_id', '=', 'articles.id')
			//->leftJoin('reactions', 'reactions.article_id', '=', 'articles.id')
			->leftJoin('reactions', function ($join) use ($userId) {
				$join->on('reactions.article_id', '=', 'articles.id');
				$join->on('reactions.user_id', '=', DB::raw("'" . $userId . "'"));
			})
			->join('files', 'files.id', '=', 'articles.file_id')
			->where([
				['articles.active', 1],
				['articles.post_type', 'story'],
				['accesses.user_id', $request->user_id],
			])
			->whereRaw('DATEDIFF(CURDATE(), articles.created_at) BETWEEN 0 AND 1')
			->orWhere(function ($query) {
				$query->where([
					['articles.active', 1],
					['articles.post_type', 'story'],
					['articles.unrestricted', 1],
				]);
				$query->whereRaw('DATEDIFF(CURDATE(), articles.created_at) BETWEEN 0 AND 1');
			})
			->orWhere(function ($query) use($userId) {
				$query->where([
					['reactions.user_id', $userId],
					['articles.active', 1],
					['articles.post_type', 'story'],
				]);
				$query->whereRaw('DATEDIFF(CURDATE(), articles.created_at) BETWEEN 0 AND 1');
			})
			->distinct()
			->orderBy('view', 'asc')
			->orderBy('articles.created_at', 'desc')
			->orderBy('articles.id', 'desc')
			//->toSql();
			->get();

		return $stories;
	}

	public function viewStories(Request $request) {
		return DB::table('reactions')
			->updateOrInsert(
				[
					'user_id' => $request->user_id,
					'article_id' => $request->post_id,
				],
				[
					'user_id' => $request->user_id,
					'article_id' => $request->post_id,
					'active' => 1,
				]
			);
	}

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
				'groups' => !is_null($request->groups) ? $request->groups : [0],
				'quartiles' => !is_null($request->quartiles) ? $request->quartiles : [0],
				'delegations' => !is_null($request->delegations) ? $request->delegations : [0],
				'roles' => !is_null($request->roles) ? $request->roles : [0],
				'users' => !is_null($request->users) ? $request->users : [0],
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

			return $users;
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
				'groups' => !is_null($request->groups) ? $request->groups : [0],
				'quartiles' => !is_null($request->quartiles) ? $request->quartiles : [0],
				'delegations' => !is_null($request->delegations) ? $request->delegations : [0],
				'roles' => !is_null($request->roles) ? $request->roles : [0],
				'users' => !is_null($request->users) ? $request->users : [0],
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

			return $users;
		}
	}

	function knowledgeCreate(Request $request) {
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
				'groups' => !is_null($request->groups) ? $request->groups : [0],
				'quartiles' => !is_null($request->quartiles) ? $request->quartiles : [0],
				'delegations' => !is_null($request->delegations) ? $request->delegations : [0],
				'roles' => !is_null($request->roles) ? $request->roles : [0],
				'users' => !is_null($request->users) ? $request->users : [0],
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

			return $users;
		}
	}

	function rewardCreate(Request $request) {
		$data = [
			'title' => $request->title,
			'description' => $request->description,
			'short_description' => $request->short_description,
			'link_short_description' => $request->link_short_description,
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
				'groups' => !is_null($request->groups) ? $request->groups : [0],
				'quartiles' => !is_null($request->quartiles) ? $request->quartiles : [0],
				'delegations' => !is_null($request->delegations) ? $request->delegations : [0],
				'roles' => !is_null($request->roles) ? $request->roles : [0],
				'users' => !is_null($request->users) ? $request->users : [0],
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

			return $users;
		}
	}


	function roomCreate(Request $request) {
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
				'groups' => !is_null($request->groups) ? $request->groups : [0],
				'quartiles' => !is_null($request->quartiles) ? $request->quartiles : [0],
				'delegations' => !is_null($request->delegations) ? $request->delegations : [0],
				'roles' => !is_null($request->roles) ? $request->roles : [0],
				'users' => !is_null($request->users) ? $request->users : [0],
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

			return $users;
		}
	}

	function accessCreate(Request $request) {
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
				'groups' => !is_null($request->groups) ? $request->groups : [0],
				'quartiles' => !is_null($request->quartiles) ? $request->quartiles : [0],
				'delegations' => !is_null($request->delegations) ? $request->delegations : [0],
				'roles' => !is_null($request->roles) ? $request->roles : [0],
				'users' => !is_null($request->users) ? $request->users : [0],
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

			return $users;
		}
	}

	function roomSection(Request $request) {
		$data = [
			'file_id' => $request->image,
			'section_id' => $request->section,
		];

		$sections = DB::table('sections')
			->updateOrInsert(
				[
					'id' => $data['section_id'],
				],
				[
					'file_id' => $data['file_id'],
				]
			);

		if ($sections) {
			return DB::table('pages')
				->select('sections.*', 'files.media_path as img')
				->join('sections', 'sections.page_id', '=', 'pages.id')
				->leftJoin('files', 'files.id', '=', 'sections.file_id')
				->where('pages.title', 'Salas')
				->get();
		} else {
			return $sections;
		}
	}

	public function list(Request $request) {
		$user_id = $request->user_id;
		$page = $request->page;

		$sections = DB::table('pages')
			->select('sections.*', 'files.media_path as img')
			->join('sections', 'sections.page_id', '=', 'pages.id')
			->leftJoin('files', 'files.id', '=', 'sections.file_id')
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
				'id' => $section->id,
				'section' => $section->title,
				'description' => $section->description,
				'img' => $section->img,
				'subtitle' => $section->subtitle,
				'custom_class' => $section->custom_class,
				'articles' => $articles
			];
		}

		return $data;
	}

	/* public function reaction(Request $request) {
		$post = $request->post_id;
		$user = $request->user_id;
		$act = $request->action;
		$action = Action::where('name', $act)->first();

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
					'active' => '',
					'clicks' => '',

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
	} */

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

	public function view(Request $request) {
		$post = $request->post_id;
		$user = $request->user_id;
		$action = Action::where('name', 'view')->first();


		$articleExists = DB::table('reactions')
			->where([
				'user_id' => $user,
				'article_id' => $post,
				'action_id' => $action->id,
			])
			->get();

		$articleid = DB::table('reactions')
			->where([
				'user_id' => $user,
				'article_id' => $post,
				'action_id' => $action->id,
			])
			->updateOrInsert([
				'clicks' => property_exists($articleExists, 'clicks') ? $articleExists->clicks + 1 : 1,
			]);

		return $articleid;
	}


	public function getReaction(Request $request) {

		$data = [
			'user_id' => $request->user_id,
			'article_id' => $request->post_id,
		];

		$action = Action::where([
			['name', $request->action],
		])
			->first();

		$data['action_id'] = $action->id;

		$query = DB::table('reactions')
			->where($data)
			->get();

		return $query;
	}

	public function updateReaction(Request $request) {

		$data = [
			'user_id' => $request->user_id,
			'article_id' => $request->post_id,
		];

		$action = Action::where([
			['name', $request->action],
		])
			->first();

		$data['action_id'] = $action->id;

		$query = DB::table('reactions')
			->where($data)
			->get();


		$newData = [
			'user_id' => $data['user_id'],
			'article_id' => $data['article_id'],
			'action_id' => $data['action_id'],
			'clicks' => $query->clicks,
			'active' => $query->active,
		];

		// like
		if ($request->action == 'like') {
			array_key_exists('active', $newData) ? $newData['active'] = !$newData['active'] : $newData['active'] = 1;
			array_key_exists('clicks', $newData) ? $newData['clicks']++ : $newData['clicks'] = 1;
		} else if ($request->action == 'share') {
			# code...
		}

		$query = DB::table('reactions')
			->where($data)
			->updateOrInsert($newData);

		return $query;
	}
}