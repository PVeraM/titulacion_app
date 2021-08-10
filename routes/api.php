<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\CommentUserController;
use App\Http\Controllers\EnterprisesController;
use App\Http\Controllers\ForgetPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\StoresController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group([
    'prefix' => 'auth',
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/me', [AuthController::class, 'me']);
});

Route::post('/forgot-password', [ForgetPasswordController::class, 'reqForgotPassword']);
Route::post('/reset-password', [ResetPasswordController::class, 'updatePassword']);

Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->middleware(['signed'])->name('verification.verify');

Route::apiResource('enterprises', EnterprisesController::class)
->middleware("auth:api");

Route::apiResource('stores', StoresController::class)
->middleware("auth:api");
Route::post('/stores-services/{store_id}', [StoresController::class, 'updateStores'])
->middleware("auth:api");

Route::apiResource('services', ServicesController::class)
->middleware("auth:api");

Route::apiResource('comments', CommentsController::class)
->middleware("auth:api");

Route::apiResource('likes', CommentUserController::class)
->middleware("auth:api");

Route::post('/search/{entity}', [SearchController::class, 'search'])
->middleware("auth:api");
