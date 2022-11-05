<?php

namespace App\Http\Controllers\Api;

use App\Consts\Api\MessageConst;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Resources\Api\AdminLoginResource;
use App\Http\Resources\Api\ErrorResource;
use App\Models\Api\AdminToken;
use App\Services\TokenMakeService;
use App\Models\Api\Admin;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {
            $loginUser = Admin::where('address', $request->address)->first();
            if (empty($loginUser)) {
                $request->merge(['statusMessage' => 'メールアドレスかパスワードが違います。']);
                return new ErrorResource($request);
            }
            $password = $request->password;
            // パスワードをハッシュ化
            if (!Hash::check($password, $loginUser->password) ) {
                $request->merge(['statusMessage' => 'メールアドレスかパスワードが違います。']);
                var_dump($loginUser->password);
                var_dump($password);
                return new ErrorResource($request);
            }
            DB::beginTransaction();

            //トークン生成
            $token = TokenMakeService::createToken($loginUser->id);

            DB::commit();
            $request->merge(['adminToken' => $token]);
            return new AdminLoginResource($request);
        } catch (\Exception $e) {
            DB::rollBack();
            $request->merge(['statusMessage' => "ログインに失敗致しました。"]);
            return new ErrorResource($request, MessageConst::Unauthorized);
        }
    }
}
