<?php

namespace App\Http\Controllers\Api;


use App\Consts\CommonConst;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Resources\Api\AdminLoginResource;
use App\Http\Resources\Api\ErrorResource;
use App\Services\TokenMakeService;
use App\Models\Api\Admin;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {
            DB::beginTransaction();
            $loginUser = Admin::where('address', $request->address)->first();
            if (empty($loginUser)) {
                $request->merge(['statusMessage' => CommonConst::ERR_01]);
                return new ErrorResource($request, Response::HTTP_UNAUTHORIZED);
            }
            $password = $request->password;
            // パスワードをハッシュ化
            if (!Hash::check($password, $loginUser->password) ) {
                $request->merge(['statusMessage' => CommonConst::ERR_01]);
                return new ErrorResource($request, Response::HTTP_UNAUTHORIZED);
            }

            //トークン生成
            $token = TokenMakeService::createToken($loginUser->id);
            DB::commit();
            $request->merge(['adminToken' => $token, 'adminId' => $loginUser->id]);
            return new AdminLoginResource($request);
        } catch (\Exception $e) {
            DB::rollBack();
            $request->merge(['statusMessage' => CommonConst::ERR_01]);
            return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
        }
    }
}
