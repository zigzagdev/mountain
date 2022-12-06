<?php

namespace App\Http\Controllers\Api;

use App\Consts\CommonConst;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\EmailRequest;
use App\Http\Requests\Api\NameRequest;
use App\Http\Requests\Api\PasswordRequest;
use App\Http\Resources\Api\ErrorResource;
use App\Http\Resources\Api\SuccessResource;
use App\Models\Api\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use PharIo\Manifest\Email;
use Symfony\Component\HttpFoundation\Response;

class AdminColumnChangeController extends Controller
{
    public function adminEmailChange(EmailRequest $request)
    {
        // emailChangeFunction
        try {
            $adminId = $request->admin_id;
            $checkAdmin = Admin::find($adminId);
            if (empty($checkAdmin)) {
                $request->merge(['statusMessage' => CommonConst::ERR_05]);
                return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
            }
            if (empty($checkAdmin->address)) {
                $request->merge(['statusMessage' => CommonConst::ERR_05]);
                return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
            }
            if ($request->address == $checkAdmin) {
                $request->merge(['statusMessage' => CommonConst::ERR_08]);
                return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
            }
            DB::beginTransaction();
            $checkAdmin->update([
                'address' => $request->address
            ]);
            DB::commit();
            return new SuccessResource($request);
        } catch (\Exception $e) {
            DB::rollBack();
            $request->merge(['statusMessage' => "メールアドレスの更新に失敗致しました。"]);

            return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
        }
    }

    public function adminPasswordChange(PasswordRequest  $request)
    {
        try {
            $adminId = $request->adminId;
            $checkAdmin = Admin::find($adminId);

            if (empty($checkAdmin)) {
                $request->merge(['statusMessage' => CommonConst::ERR_05]);
                return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
            }

            if (empty($checkAdmin->password)) {
                $request->merge(['statusMessage' => CommonConst::ERR_05]);
                return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
            }
            if (Hash::make($request->password) !== $checkAdmin->password) {
                $request->merge(['statusMessage' => CommonConst::ERR_08]);
                return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
            }
            DB::beginTransaction();
            $checkAdmin->update([
               'password' => Hash::make($request->password),
            ]);
            DB::commit();
            return new SuccessResource($request);
        } catch (\Exception $e) {
            DB::rollBack();
            $request->merge(['statusMessage' => "パスワードの更新に失敗致しました。"]);
            return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
        }
    }

    public function adminNameChange(NameRequest $request)
    {
        try {
            $adminId = $request->adminId;
        } catch (\Exception $e) {
            DB::rollBack();
            $request->merge(['statusMessage' => "記事の投稿に失敗致しました。"]);
            return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
        }
    }
}
