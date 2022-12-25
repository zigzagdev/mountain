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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PharIo\Manifest\Email;
use Symfony\Component\HttpFoundation\Response;

class AdminColumnChangeController extends Controller
{
    public function adminEmailChange(EmailRequest $request)
    {
        try {
            DB::beginTransaction();
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
            $checkAdmin->update([
                'address' => $request->address
            ]);
            DB::commit();
            return new SuccessResource($request);
        } catch (\Exception $e) {
            DB::rollBack();
            $request->merge(['statusMessage' => sprintf(CommonConst::UPDATE_FAILED, 'メールアドレス')]);
            return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
        }
    }

    public function adminPasswordChange(PasswordRequest  $request)
    {
        try {
            DB::beginTransaction();
            $adminId = $request->admin_id;
            $checkAdmin = Admin::find($adminId);

            if (empty($checkAdmin)) {
                $request->merge(['statusMessage' => CommonConst::ERR_05]);
                return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
            }

            if (empty($checkAdmin->password)) {
                $request->merge(['statusMessage' => CommonConst::ERR_05]);
                return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
            }

            $checkAdmin->update([
               'password' => Hash::make($request->password),
            ]);
            DB::commit();
            return new SuccessResource($request);
        } catch (\Exception $e) {
            DB::rollBack();
            $request->merge(['statusMessage' => sprintf(CommonConst::UPDATE_FAILED, 'パスワード')]);
            return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
        }
    }

    public function adminNameChange(NameRequest $request)
    {
        try {
            DB::beginTransaction();
            $adminId = $request->admin_id;
            $checkAdmin = Admin::find($adminId);

            if (empty($checkAdmin)) {
                $request->merge(['statusMessage' => CommonConst::ERR_05]);
                return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
            }

            if (empty($checkAdmin->nick_name)) {
                $request->merge(['statusMessage' => CommonConst::ERR_05]);
                return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
            }

            $checkAdmin->update([
                "nick_name" => $request->nickName
            ]);
            DB::commit();
            return new SuccessResource($request);
        } catch (\Exception $e) {
            DB::rollBack();
            $request->merge(['statusMessage' => sprintf(CommonConst::UPDATE_FAILED, '名前')]);
            return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
        }
    }
}
