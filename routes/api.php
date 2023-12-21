<?php

use App\Http\Middleware\ApiAuthentication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Http\Controllers\JsonApiController;
use LaravelJsonApi\Laravel\Routing\ResourceRegistrar;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

JsonApiRoute::server('v1')->prefix('v1')->middleware(ApiAuthentication::class)->resources(function (ResourceRegistrar $server) {
    $server->resource('countries', JsonApiController::class)
        ->relationships(function ($relations) {
            $relations->hasMany('sites');
        });

    $server->resource('leagues', JsonApiController::class)
        ->relationships(function ($relations) {
            $relations->hasOne('site');
            $relations->hasMany('teams');
        });

    $server->resource('sites', JsonApiController::class)
        ->relationships(function ($relations) {
            $relations->hasMany('teams');
            $relations->hasMany('leagues');
            $relations->hasOne('country');
            $relations->hasOne('sport');
        });

    $server->resource('sports', JsonApiController::class)
        ->relationships(function ($relations) {
            $relations->hasMany('sites');
        });

    $server->resource('teams', JsonApiController::class)
        ->relationships(function ($relations) {
            $relations->hasOne('site');
            $relations->hasOne('league');
            $relations->hasMany('users');
        });

    $server->resource('users', JsonApiController::class)
        ->relationships(function ($relations) {
            $relations->hasOne('userRole')->readOnly();
            $relations->hasMany('teams');
        });
});
