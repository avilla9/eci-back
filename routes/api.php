<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CampaignController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\DB;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/token/revoke', function (Request $request) {
    DB::table('oauth_access_tokens')
        ->where('user_id', $request->id)
        ->update([
            'revoked' => true
        ]);
    return response()->json('DONE');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/posts')->group(function () {
    Route::controller(ArticleController::class)->group(function () {
        Route::post('/list', 'list')->name('posts.list');
    });
});

Route::controller(ArticleController::class)->group(function () {
    Route::post('/like', 'like');
});

Route::prefix('/users')->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/getAllUsers', 'getAllUsers')->name('get-all-users');
        Route::post('/delete', 'delete')->name('delete-users');
        Route::post('/data', 'getUserData');
    });
});

Route::prefix('/campaign')->group(function () {
    Route::controller(CampaignController::class)->group(function () {
        Route::post('/list', 'campaignList');
        Route::post('/data', 'campaignData');
    });
});

Route::prefix('/roles')->group(function () {
    Route::controller(RoleController::class)->group(function () {
        Route::get('/all-roles', 'getAllRoles')->name('all-roles');
    });
});

Route::prefix('/stories')->group(function () {
    Route::controller(StoryController::class)->group(function () {
        Route::get('/', 'show')->name('all.stories');
    });
});
