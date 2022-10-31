<?php

namespace App\Http\Controllers\Api;

use App\Consts\Api\MessageConst;
use App\Http\Resources\Api\LoginResource;
use App\Http\Resources\Api\RegisterUserResource;
use App\Http\Resources\Api\SuccessResource;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Resources\Api\ErrorResource;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;


class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {
            $loginUser = Admin::where('address', $request->address)->first();
            if (empty($loginUser)) {
                $request->merge(['statusMessage' =>
                    sprintf(MessageConst::Bad_Request, 'メールアドレスかパスワードが間違っています。'
                    )]);
                return new ErrorResource($request);
            }
            if (!Hash::check($request->password, $loginUser->password)) {
                $request->merge(['statusMessage' =>
                    sprintf(MessageConst::Bad_Request, 'メールアドレスかパスワードが間違っています。'
                    )]);
                return new ErrorResource($request);
            }
            DB::beginTransaction();
            $loginUser->tokens()->delete();
            $token = $loginUser->createToken("login:user{$loginUser->id}")->plainTextToken;
            $request->merge(['adminToken' => $token]);

            DB::commit();
            return new RegisterUserResource($request);
        } catch (\Exception $e) {
            DB::rollBack();
            $request->merge(['statusMessage' => "ログインに失敗致しました。"]);
            return new ErrorResource($request, MessageConst::Unauthorized);
        }
    }
}
