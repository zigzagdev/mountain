<?php

namespace App\Http\Controllers\Api;

use App\Consts\Api\MessageConsts;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\ErrorResource;
use App\Http\Resources\Api\RegisterUserResource;
use App\Models\Admin;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;


class RegisterUserController extends Controller
{
    public function RegisterUser(ApiRequest $request)
    {
        try {
            $existUser = Admin::where('address', $request->address);

            DB::beginTransaction();

            if (!empty($existUser)) {
                $request->merge(['statusMessage' => sprintf(MessageConsts::Bad_Request, '会員登録')]);
                return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
            }
            DB::rollBack();

            $admin = Admin::create([
                'nickName' => $request->input('nickName'),
                'address' => $request->input('address'),
                'password' => $request->input('password'),
                'age' => $request->input('age'),
                'sex' => $request->input('sex'),
            ]);

            return new RegisterUserResource($request);
        } catch (\Exception $e) {

            return new ErrorResource($request);
        }
    }
}
