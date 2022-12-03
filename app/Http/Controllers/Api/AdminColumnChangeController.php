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
use PharIo\Manifest\Email;
use Symfony\Component\HttpFoundation\Response;

class AdminColumnChangeController extends Controller
{
    public function adminEmailChange(EmailRequest $request)
    {
        // emailChangeFunction
        try {
            $adminId = $request->admin_id;
            $checkAdmin = Admin::where('id', $adminId)->get();
            $changeAdmin = $checkAdmin->toArray();
            if (empty($checkAdmin)) {
                $request->merge(['statusMessage' => CommonConst::ERR_05]);
                return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
            }

            $checkEmail = $changeAdmin['0']['address'];
            if (empty($checkEmail)) {
                $request->merge(['statusMessage' => CommonConst::ERR_05]);
                return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
            } elseif ($request->address == $checkEmail) {
                $request->merge(['statusMessage' => CommonConst::ERR_08]);
                return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
            } else {
                Admin::where('address', $checkEmail)
                    ->update([
                        'address' => $request->address
                    ]);
            }
            return new SuccessResource($request);
        } catch (\Exception $e) {
            DB::rollBack();
            $request->merge(['statusMessage' => "記事の投稿に失敗致しました。"]);
            $statusMessage = $e->getMessage();
            print_r($statusMessage);
            return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
        }
    }

    public function adminPasswordChange(PasswordRequest  $request)
    {
        try {
            $adminId = $request->adminId;
        } catch (\Exception $e) {
            DB::rollBack();
            $request->merge(['statusMessage' => "記事の投稿に失敗致しました。"]);
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
