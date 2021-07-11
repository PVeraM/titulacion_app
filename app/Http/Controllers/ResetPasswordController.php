<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestForgetHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ResetPasswordController extends Controller
{
    public function updatePassword(Request $request){
        return $this->validateToken($request)->count() > 0 ? $this->changePassword($request) : $this->noToken();
    }

    private function validateToken($request){
        return DB::table('password_resets')->where([
            'token' => $request->passwordToken
        ]);
    }

    private function noToken() {
        return response()->json([
            'error' => 'Email o el token no son correctos.'
        ],Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    private function changePassword($request) {
        $userPwdDB = DB::table('password_resets')->where([
            'token' => $request->passwordToken
        ]);

        $user = User::whereEmail($userPwdDB->value("email"))->first();
        $user->update([
            'password'=>bcrypt($request->password)
        ]);
        $this->validateToken($request)->delete();
        return response()->json([
            'message' => 'La contraseña ha sido cambiada con éxito.'
        ],Response::HTTP_CREATED);
    }
}
