<?php

namespace App\Http\Controllers;

use App\Models\Access;
use App\Models\Action;
use App\Models\Article;
use App\Models\Reaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MailController;
use App\Models\ArticleFilter;
use App\Models\File;
use App\Models\Section;
use App\Models\User;
use Dotenv\Validator;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Validator as FacadesValidator;

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
		$file = File::where('id', $request->image)
				->orWhere('media_path', $request->image)
				->get();
		$data = [
			'title' => 'story',
			'button_name' => $request->button_name,
			'button_link' => $request->button_link,
			'created_at' => $request->date,
			'unrestricted' => $request->grant_all,
			'file_id' => $file[0]->id,
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

			$filters['article_id'] = $articleid;
			ArticleFilter::create($filters);

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

	public function contentStoryFilters($id) {
		$articleFilters = ArticleFilter::where('article_id', $id)->get();
		return [
			"articleFilters" => $articleFilters
		];
	}

	public function contentStoryUpdate(Request $request) {
		$file = File::where('id', $request->image)
				->orWhere('media_path', $request->image)
				->get();
		$data = [
			'title' => 'story',
			'button_name' => $request->button_name,
			'button_link' => $request->button_link,
			'created_at' => $request->date,
			'unrestricted' => $request->grant_all,
			'file_id' => $file[0]->id,
			'section_id' => $request->section,
			'post_type' => 'story',
		];

		$articleid = DB::table('articles')->where('id', $request->id)->update($data);
		$articleUpdate = DB::table('articles')->where('id', $request->id)->first();

		if ($data['unrestricted']) {
			return $articleUpdate;
		} else {
			$filters = [
				'groups' => !is_null($request->groups) ? $request->groups : [0],
				'quartiles' => !is_null($request->quartiles) ? $request->quartiles : [0],
				'delegations' => !is_null($request->delegations) ? $request->delegations : [0],
				'roles' => !is_null($request->roles) ? $request->roles : [0],
				'users' => !is_null($request->users) ? $request->users : [0],
			];

			// $filters['article_id'] = $articleUpdate;
			ArticleFilter::updateOrCreate(
				[
					"article_id" => $articleUpdate->id
				],
				[
					'groups' => $filters['groups'],
					'quartiles' => $filters['quartiles'],
					'delegations' => $filters['delegations'],
					'roles' => $filters['roles'],
					'users' => $filters['users'],	
				]
			);

			$users = DB::table('users')
				->select('users.*')
				->join('delegations', 'delegations.code', '=', 'users.delegation_code')
				->whereIn('delegations.id', $filters['delegations'])
				->orWhereIn('users.role_id', $filters['roles'])
				->orWhereIn('users.quartile_id', $filters['quartiles'])
				->orWhereIn('users.group_id', $filters['groups'])
				->orWhereIn('users.id', $filters['users'])
				->get();

			$delete = Access::where('article_id', $articleUpdate->id)->delete();


			foreach ($users as $key => $user) {
				DB::table('accesses')
					->insert([
						'user_id' => $user->id,
						'article_id' => $articleUpdate->id,
					]);
			}

			return [
				"articleUpdate" => $articleUpdate,
				"delete" => $delete,
				"users" => $users,
			];
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
			->orWhere(function ($query) use ($userId) {
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

		return json_encode($stories, JSON_UNESCAPED_SLASHES);
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
		$file = File::where('id', $request->image)
				->orWhere('media_path', $request->image)
				->get();
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
			'file_id' => $file[0]->id,
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


			$filters['article_id'] = $articleid;
			ArticleFilter::create($filters);

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

	public function homeUpdate(Request $request) {
		$file = File::where('id', $request->image)
				->orWhere('media_path', $request->image)
				->get();
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
			'file_id' => $file[0]->id,
			'section_id' => $request->section,
			'post_type' => $request->post_type,
		];

		$articleid = DB::table('articles')->where('id', $request->id)->update($data);
		$article = DB::table('articles')->where('id', $request->id)->first();

		if ($data['unrestricted']) {
			return [
				"article" => $articleid,
				'message' => "Por aquí pasó"
			];
		} else {
			$filters = [
				'groups' => !is_null($request->groups) ? $request->groups : [0],
				'quartiles' => !is_null($request->quartiles) ? $request->quartiles : [0],
				'delegations' => !is_null($request->delegations) ? $request->delegations : [0],
				'roles' => !is_null($request->roles) ? $request->roles : [0],
				'users' => !is_null($request->users) ? $request->users : [0],
			];

			
			ArticleFilter::updateOrCreate(
				[
					"article_id" => $request->id
				],
				[
					'groups' => $filters['groups'],
					'quartiles' => $filters['quartiles'],
					'delegations' => $filters['delegations'],
					'roles' => $filters['roles'],
					'users' => $filters['users'],	
				]
			);
			$articleFilters = ArticleFilter::where('article_id', $request->id)->first();

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
				->where('article_id', $request->id)
				->update([
					"user_id" => $user->id
				]);
			}

			return [
				'users' => $users,
				'article' => $article,
				'articleFilters' => $articleFilters
			];
		}
	}

	public function homeDelete(Request $request) {
		Article::where('id', $request->id)->delete();
		ArticleFilter::where('article_id', $request->id)->delete();
		Access::where('article_id', $request->id)->delete();
	}

	public function campaignCreate(Request $request) {
		$file = File::where('id', $request->image)
				->orWhere('media_path', $request->image)
				->get();
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
			'campaign_id' => $file[0]->id,
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

			$filters['article_id'] = $articleid;
			ArticleFilter::create($filters);

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

	public function campaignUpdate(Request $request) {
		$file = File::where('id', $request->image)
				->orWhere('media_path', $request->image)
				->get();
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
			'file_id' => $file[0]->id,
			'section_id' => $request->section,
			'campaign_id' => $request->campaign,
			'post_type' => $request->post_type,
		];

		$article = DB::table('articles')->where('id', $request->id)->update($data);
		$updateArticle = DB::table('articles')->where('id', $request->id)->first();

		if ($data['unrestricted']) {
			return $article;
		} else {
			$filters = [
				'groups' => !is_null($request->groups) ? $request->groups : [0],
				'quartiles' => !is_null($request->quartiles) ? $request->quartiles : [0],
				'delegations' => !is_null($request->delegations) ? $request->delegations : [0],
				'roles' => !is_null($request->roles) ? $request->roles : [0],
				'users' => !is_null($request->users) ? $request->users : [0],
			];

			ArticleFilter::updateOrCreate(
				[
					'article_id' => $updateArticle->id
				],
				[
					'groups' => $filters['groups'],
					'quartiles' => $filters['quartiles'],
					'delegations' => $filters['delegations'],
					'roles' => $filters['roles'],
					'users' => $filters['users'],
				]
			);
			
			$users = DB::table('users')
				->select('users.*')
				->join('delegations', 'delegations.code', '=', 'users.delegation_code')
				->whereIn('delegations.id', $filters['delegations'])
				->orWhereIn('users.role_id', $filters['roles'])
				->orWhereIn('users.quartile_id', $filters['quartiles'])
				->orWhereIn('users.group_id', $filters['groups'])
				->orWhereIn('users.id', $filters['users'])
				->get();

			$delete = Access::where('article_id', $updateArticle->id)->delete();


			foreach ($users as $key => $user) {
				DB::table('accesses')
					->insert([
						'user_id' => $user->id,
						'article_id' => $updateArticle->id,
					]);
			}

			return [
				'users' => $users,
				'deleted' => $delete,
				'updateArticle' => $updateArticle
			];
		}
    }

	function knowledgeCreate(Request $request) {
		$file = File::where('id', $request->image)
				->orWhere('media_path', $request->image)
				->get();
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
			'file_id' => $file[0]->id,
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

			$filters['article_id'] = $articleid;
			ArticleFilter::create($filters);
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

	public function contentKnowledgeFilters($id) {
		$articleFilters = ArticleFilter::where('article_id', $id)->get();

		return [
			"articleFilters" => $articleFilters
		];
	}

	public function contentKnowledgeUpdate(Request $request) {
		$file = File::where('id', $request->image)
				->orWhere('media_path', $request->image)
				->get();
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
			'file_id' => $file[0]->id,
			'section_id' => $request->section,
			'post_type' => $request->post_type,
		];

		$article = DB::table('articles')->where('id', $request->id)->update($data);
		$articleUpdate = DB::table('articles')->where('id', $request->id)->first();

		if ($data['unrestricted']) {
			return $articleUpdate;
		} else {
			$filters = [
				'groups' => !is_null($request->groups) ? $request->groups : [0],
				'quartiles' => !is_null($request->quartiles) ? $request->quartiles : [0],
				'delegations' => !is_null($request->delegations) ? $request->delegations : [0],
				'roles' => !is_null($request->roles) ? $request->roles : [0],
				'users' => !is_null($request->users) ? $request->users : [0],
			];

			// $filters['article_id'] = $articleUpdate;
			ArticleFilter::updateOrCreate(
				[
					"article_id" => $articleUpdate->id
				], 
				[
					'groups' => $filters['groups'],
					'quartiles' => $filters['quartiles'],
					'delegations' => $filters['delegations'],
					'roles' => $filters['roles'],
					'users' => $filters['users'],	
				]
			);
			$users = DB::table('users')
				->select('users.*')
				->join('delegations', 'delegations.code', '=', 'users.delegation_code')
				->whereIn('delegations.id', $filters['delegations'])
				->orWhereIn('users.role_id', $filters['roles'])
				->orWhereIn('users.quartile_id', $filters['quartiles'])
				->orWhereIn('users.group_id', $filters['groups'])
				->orWhereIn('users.id', $filters['users'])
				->get();

				$delete = Access::where('article_id', $articleUpdate->id)->delete();

			foreach ($users as $key => $user) {
				DB::table('accesses')
					->insert([
						'user_id' => $user->id,
						'article_id' => $articleUpdate->id,
					]);
			}

			return [
				"articleUpdate" => $articleUpdate,
				"delete" => $delete,
				"users" => $users,
			];
		}
	}

	function rewardCreate(Request $request) {
		$file = File::where('id', $request->image)
				->orWhere('media_path', $request->image)
				->get();
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
			'file_id' => $file[0]->id,
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

			$filters['article_id'] = $articleid;
			ArticleFilter::create($filters);
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

	public function contentRewardFilters($id) {
		$articleFilters = ArticleFilter::where('article_id', $id)->get();
		return [
			'articleFilters' => $articleFilters
		];
	}

	public function contentRewardUpdate(Request $request) {
		$file = File::where('id', $request->image)
				->orWhere('media_path', $request->image)
				->get();
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
			'file_id' => $file[0]->id,
			'section_id' => $request->section,
			'post_type' => $request->post_type,
		];

		$article = DB::table('articles')->where('id', $request->id)->update($data);
		$articleUpdate = DB::table('articles')->where('id', $request->id)->first();

		if ($data['unrestricted']) {
			return $articleUpdate;
		} else {
			$filters = [
				'groups' => !is_null($request->groups) ? $request->groups : [0],
				'quartiles' => !is_null($request->quartiles) ? $request->quartiles : [0],
				'delegations' => !is_null($request->delegations) ? $request->delegations : [0],
				'roles' => !is_null($request->roles) ? $request->roles : [0],
				'users' => !is_null($request->users) ? $request->users : [0],
			];

			// $filters['article_id'] = $articleUpdate;
			ArticleFilter::updateOrCreate(
				[
					'article_id' => $articleUpdate->id
				],
				[
					'groups' => $filters['groups'],
					'quartiles' => $filters['quartiles'],
					'delegations' => $filters['delegations'],
					'roles' => $filters['roles'],
					'users' => $filters['users'],
				]
			);
			$users = DB::table('users')
				->select('users.*')
				->join('delegations', 'delegations.code', '=', 'users.delegation_code')
				->whereIn('delegations.id', $filters['delegations'])
				->orWhereIn('users.role_id', $filters['roles'])
				->orWhereIn('users.quartile_id', $filters['quartiles'])
				->orWhereIn('users.group_id', $filters['groups'])
				->orWhereIn('users.id', $filters['users'])
				->get();

			$delete = Access::where('article_id', $articleUpdate->id)->delete();

			foreach ($users as $key => $user) {
				DB::table('accesses')
					->insert([
						'user_id' => $user->id,
						'article_id' => $articleUpdate->id,
					]);
			}

			return [
				"articleUpdate" => $articleUpdate,
				"users" => $users,
				"delete" => $delete,
			];
		}
	}

	function roomCreate(Request $request) {
		$file = File::where('id', $request->image)
				->orWhere('media_path', $request->image)
				->get();
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
			'file_id' => $file[0]->id,
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

			$filters['article_id'] = $articleid;
			ArticleFilter::create($filters);
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

	public function roomFilters($id) {
		$articleFilters = ArticleFilter::where('article_id', $id)->get();

		return [
			'articleFilters' => $articleFilters
		];
	}

	public function roomUpdate(Request $request) {
		$file = File::where('id', $request->image)
				->orWhere('media_path', $request->image)
				->get();
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
			'file_id' => $file[0]->id,
			'section_id' => $request->section,
			'post_type' => $request->post_type,
		];

		$articleid = DB::table('articles')->where('id', $request->id)->update($data);
		$article = DB::table('articles')->where('id', $request->id)->first();

		if ($data['unrestricted']) {
			return $article;
		} else {
			$filters = [
				'groups' => !is_null($request->groups) ? $request->groups : [0],
				'quartiles' => !is_null($request->quartiles) ? $request->quartiles : [0],
				'delegations' => !is_null($request->delegations) ? $request->delegations : [0],
				'roles' => !is_null($request->roles) ? $request->roles : [0],
				'users' => !is_null($request->users) ? $request->users : [0],
			];

			// $filters['article_id'] = $article;
			ArticleFilter::updateOrCreate(
				[
					'article_id' => $article->id
				],
				[
					'groups' => $filters['groups'],
					'quartiles' => $filters['quartiles'],
					'delegations' => $filters['delegations'],
					'roles' => $filters['roles'],
					'users' => $filters['users'],
				]
			);

			$users = DB::table('users')
				->select('users.*')
				->join('delegations', 'delegations.code', '=', 'users.delegation_code')
				->whereIn('delegations.id', $filters['delegations'])
				->orWhereIn('users.role_id', $filters['roles'])
				->orWhereIn('users.quartile_id', $filters['quartiles'])
				->orWhereIn('users.group_id', $filters['groups'])
				->orWhereIn('users.id', $filters['users'])
				->get();

			$delete = Access::where('article_id', $article->id)->delete();
			foreach ($users as $key => $user) {
				DB::table('accesses')
					->insert([
						'user_id' => $user->id,
						'article_id' => $article->id,
					]);
			}

			return [
				"update" => $article,
				"users" => $users,
				"delete" => $delete
			];
		}
	}

	function sectionCreate(Request $request) {
		$data = [
			'title' => $request->title,
			'description' => $request->description,
			'created_at' => $request->date,
			'file_id' => $request->image,
			'page_id' => $request->page_id
		];


		$articleid = DB::table('sections')->insertGetId($data);

		$filters = [
			'groups' => !is_null($request->groups) ? $request->groups : [0],
			'quartiles' => !is_null($request->quartiles) ? $request->quartiles : [0],
			'delegations' => !is_null($request->delegations) ? $request->delegations : [0],
			'roles' => !is_null($request->roles) ? $request->roles : [0],
			'users' => !is_null($request->users) ? $request->users : [0],
		];

		$filters['article_id'] = $articleid;
		ArticleFilter::create($filters);
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

	public function sectionsDelete(Request $request) {
		Section::where('id', $request->id)->delete();

		ArticleFilter::where('article_id', $request->id)->delete();
		return $request->id;
	}

	function validateAccess(Request $request) {
		$article = Article::where('id', $request->article_id)->first();
		$access = $article->unrestricted;
		if (!$access) {
			$access = Access::where([
				'user_id' => $request->user_id,
				'article_id' => $request->article_id,
			])->first();
		}
		return $access ? 1 : 0;
	}

	// function validateSection(Request $request) {
	// 	$access = Access::where([
	// 		'user_id' => $request->user_id,
	// 		'article_id' => $request->article_id,
	// 	])->first();

	// 	return $access ? 1 : 0;
	// }

	function postDetails(Request $request) {
		$article = Article::select('articles.*', 'files.media_path')
			->join('files', 'files.id', '=', 'articles.file_id')->where('articles.id', $request->postId)->first();

		$reactions = DB::table('reactions')
			->select('reactions.*')
			->join('actions', 'actions.id', '=', 'reactions.action_id')
			->where([
				['article_id', $request->postId],
				['user_id', $request->userId],
				['actions.id', 1]
			])
			->first();

		$article['reactions'] = $reactions ? 1 : 0;

		return $article;
	}

	public function sectionDetails(Request $request, $articles) {
		return DB::table('pages')
			->select('sections.*', 'files.media_path as img')
			->join('sections', 'sections.page_id', '=', 'pages.id')
			->leftJoin('files', 'files.id', '=', 'sections.file_id')
			->where('sections.id', $articles)
			->get();
	}

	function accessCreate(Request $request) {
		$file = File::where('id', $request->image)
				->orWhere('media_path', $request->image)
				->get();
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
			'file_id' => $file[0]->id,
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

			$filters['article_id'] = $articleid;
			ArticleFilter::create($filters);
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

	public function contentAccessFilters($id) {
		$articleFilters = ArticleFilter::where('article_id', $id)->get();
		return [
			"articleFilters" => $articleFilters
		];
	}

	public function contentAccessUpdate(Request $request) {
		$file = File::where('id', $request->image)
				->orWhere('media_path', $request->image)
				->get();
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
			'file_id' => $file[0]->id,
			'section_id' => $request->section,
			'post_type' => $request->post_type,
		];

		$article = DB::table('articles')->where('id', $request->id)->update($data);
		$articleUpdate = DB::table('articles')->where('id', $request->id)->first();

		if ($data['unrestricted']) {
			return $articleUpdate;
		} else {
			$filters = [
				'groups' => !is_null($request->groups) ? $request->groups : [0],
				'quartiles' => !is_null($request->quartiles) ? $request->quartiles : [0],
				'delegations' => !is_null($request->delegations) ? $request->delegations : [0],
				'roles' => !is_null($request->roles) ? $request->roles : [0],
				'users' => !is_null($request->users) ? $request->users : [0],
			];

			// $filters['article_id'] = $articleUpdate;
			ArticleFilter::updateOrCreate(
				[
					"article_id" => $articleUpdate->id
				],
				[
					'groups' => $filters['groups'],
					'quartiles' => $filters['quartiles'],
					'delegations' => $filters['delegations'],
					'roles' => $filters['roles'],
					'users' => $filters['users'],
				]
			);

			$users = DB::table('users')
				->select('users.*')
				->join('delegations', 'delegations.code', '=', 'users.delegation_code')
				->whereIn('delegations.id', $filters['delegations'])
				->orWhereIn('users.role_id', $filters['roles'])
				->orWhereIn('users.quartile_id', $filters['quartiles'])
				->orWhereIn('users.group_id', $filters['groups'])
				->orWhereIn('users.id', $filters['users'])
				->get();

			$delete = Access::where('article_id', $articleUpdate->id)->delete();

			foreach ($users as $key => $user) {
				DB::table('accesses')
					->insert([
						'user_id' => $user->id,
						'article_id' => $articleUpdate->id,
					]);
			}

			return [
				"articleUpdate" => $articleUpdate,
				"delete" => $delete,
				"users" => $users
			];
		}
	}

	public function contentAdoptionFilters($id) {
		$articleFilters = ArticleFilter::where('article_id', $id)->get();

		return [
			"articleFilters" => $articleFilters
		];
	}

	public function contentAdoptionUpdate(Request $request) {
		$file = File::where('id', $request->image)
				->orWhere('media_path', $request->image)
				->get();
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
				'file_id' => $file[0]->id,
				'section_id' => $request->section,
				'campaign_id' => $request->campaign,
				'post_type' => $request->post_type,
			];

		$articleid = DB::table('articles')->where('id', $request->id)->update($data);
		$articleUpdate = DB::table('articles')->where('id', $request->id)->first();

		if ($data['unrestricted']) {
			return $articleUpdate;
		} else {
			$filters = [
				'groups' => !is_null($request->groups) ? $request->groups : [0],
				'quartiles' => !is_null($request->quartiles) ? $request->quartiles : [0],
				'delegations' => !is_null($request->delegations) ? $request->delegations : [0],
				'roles' => !is_null($request->roles) ? $request->roles : [0],
				'users' => !is_null($request->users) ? $request->users : [0],
			];

			// $filters['article_id'] = $articleUpdate;
			ArticleFilter::updateOrCreate(
				[
					"article_id" => $articleUpdate->id
				],
				[
					'groups' => $filters['groups'],
					'quartiles' => $filters['quartiles'],
					'delegations' => $filters['delegations'],
					'roles' => $filters['roles'],
					'users' => $filters['users'],
				]
			);

			$users = DB::table('users')
				->select('users.*')
				->join('delegations', 'delegations.code', '=', 'users.delegation_code')
				->whereIn('delegations.id', $filters['delegations'])
				->orWhereIn('users.role_id', $filters['roles'])
				->orWhereIn('users.quartile_id', $filters['quartiles'])
				->orWhereIn('users.group_id', $filters['groups'])
				->orWhereIn('users.id', $filters['users'])
				->get();

			$delete = Access::where('article_id', $articleUpdate->id)->delete();

			foreach ($users as $key => $user) {
				DB::table('accesses')
					->insert([
						'user_id' => $user->id,
						'article_id' => $articleUpdate->id,
					]);
			}

			return [
				"articleUpdate" => $articleUpdate,
				"delete" => $delete,
				"users" => $users,
			];
		}
	}

	function roomSection(Request $request) {
		$data = [
			'section_id' => $request->section,
			'title' => $request->title,
			'description' => $request->description,
			'file_id' => $request->image
		];

		$sections = DB::table('sections')
			->updateOrInsert(
				[
					'id' => $data['section_id'],
				],
				[
					'file_id' => $data['file_id'],
				],
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
	public function sectionsFilters($id) {
		$sectionsFilters = ArticleFilter::where('article_id', $id)->get();

		return [
			'sectionsFilters' =>	$sectionsFilters
		];
	}

	function sectionUpdate(Request $request, $articles) {
		$validator = FacadesValidator::make($request->all(), [
			'section' => "required",
			'title' => "required",
			'description' => "required",
			'image' => "required"
		]);
		if ($validator->fails()) {
			$error = $validator->errors();
			return [
				"status" => HttpResponse::HTTP_BAD_REQUEST,
				"message" => $error->first()
			];
		}

		$filters = [
			'groups' => !is_null($request->groups) ? $request->groups : [0],
			'quartiles' => !is_null($request->quartiles) ? $request->quartiles : [0],
			'delegations' => !is_null($request->delegations) ? $request->delegations : [0],
			'roles' => !is_null($request->roles) ? $request->roles : [0],
			'users' => !is_null($request->users) ? $request->users : [0],
		];

		ArticleFilter::where('article_id', $articles)->update(
			$filters
		);

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
				->where('article_id', $articles)
				->update([
					'user_id' => $user->id,
				]);
		}



		$sections = DB::table('sections')
			->where('id', $articles)
			->update([
				'title' => $request->title,
				'description' => $request->description,
				'file_id' => $request->image
			]);


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

		return json_encode($data, JSON_UNESCAPED_SLASHES);
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

	public function sendMail(Request $request) {
		$user = DB::table('users')
			->where('id', $request->user_id)
			->first();

		$data = [
			'dni' => $user->dni,
			'name' => $user->name,
			'email' => $user->email,
			'agent_code' => $request->agent_code,
			'type' => $request->type,
			'message' => $request->message,
		];
		new MailController($data);
		return true;
	}

	// CON ESTA FUNCIÓN OBTENGO LOS FILTROS DE MI ARTICULO
	public function articleFilters($id) {
		$articleFilters = ArticleFilter::where('article_id', $id)->get();

		return [
			'articleFilters' =>	$articleFilters
		];
	}
}
