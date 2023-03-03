<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticleFilterController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\NotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PasswordController;
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
        Route::post('/room/creation', 'sectionCreate');
        Route::post('/validate', 'validateAccess');
        Route::get('/sections-filters/{id}', 'sectionsFilters');
        Route::delete('/delete-section/{id}', 'sectionsDelete');
        // Route::post('/validation', 'validateSection');
        Route::post('/list', 'list')->name('posts.list');
        Route::post('/postDetails', 'postDetails');
        Route::get('/room/{articles}', 'sectionDetails');
        Route::put('/room/{articles}', 'sectionUpdate');
        Route::prefix('/stories')->group(function () {
            Route::post('/', 'showStories')->name('stories.list');
            Route::post('/view', 'viewStories')->name('viewStories');
        });
        Route::prefix('/rooms')->group(function() {
            Route::get('filter/{id}', 'roomFilters')->name('content.room.filters');
            Route::put('/update', 'roomUpdate');
        });

        Route::prefix('/reward')->group(function() {
            Route::get('filters/{id}', 'contentRewardFilters');
            Route::put('update', 'contentRewardUpdate');
        });
        Route::prefix('/access')->group(function() {
            Route::get('filters/{id}', 'contentAccessFilters');
            Route::put('/update', 'contentAccessUpdate');
        });
        Route::prefix('/adoption')->group(function() {
            Route::get('filters/{id}', 'contentAdoptionFilters');
            Route::put('update', 'contentAdoptionUpdate');
        });
        Route::prefix('knowledge')->group(function() {
            Route::get('filters/{id}', 'contentKnowledgeFilters');
            Route::put('/update', 'contentKnowledgeUpdate');
        });
    });
});

Route::prefix('/articles')->group(function () {
    Route::controller(ArticleFilterController::class)->group(function () {
        Route::get('/refresh', 'refresh');
    });
});

Route::controller(ArticleController::class)->group(function () {
    Route::post('/like', 'like');
    Route::post('/view', 'view');
    Route::post('/sendmail', 'sendMail');
});

Route::prefix('/users')->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/getAllUsers', 'getAllUsers')->name('get-all-users');
        Route::post('/delete', 'delete')->name('delete-users');
        Route::post('/data', 'getUserData');
        Route::post('/level', 'getUserRole');
        Route::post('/password', 'password')->name('users.password');
        Route::put('/reset-password', 'resetPassword')->name('users.reset.password');
        Route::post('/change-password', 'changePassword');
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
        Route::post('/delete', 'destroy')->name('delete-roles');
    });
});

Route::prefix('/notification')->group(function () {
    Route::controller(NotificationController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::post('/show', 'show');        
        Route::put('/update', 'update');
    });
});
