<?php


use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
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

Route::get('/email/verify/{id}/{hash}', function (Request $request) {
    $user = User::find($request->route('id'));

    if ($user->hasVerifiedEmail()) {
        return redirect(env('FRONT_URL') . '/email/failed');
    }

    if ($user->markEmailAsVerified()) {
        event(new Verified($user));
    }

    return redirect(env('FRONT_URL') . '/email/success');
})->middleware(['signed'])->name('verification.verify');

Route::get('/verify-email', function (){
    return response()->json([
        'message' => 'Por favor, primero debe revisar su correo electrónico y activar su cuenta mediante el enlace enviado.'
    ], 400);
})
->name('verification.notice');
