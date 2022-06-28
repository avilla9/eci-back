<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/users')->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/getAllUsers', 'getAllUsers')->name('get-all-users');
        Route::post('/delete', 'delete')->name('delete-users');
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