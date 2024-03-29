<?php

namespace App\Http\Controllers\Api;

use App\Consts\Api\MessageConst;
use App\Consts\CommonConst;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AdminRequest;
use App\Http\Resources\Api\ErrorResource;
use App\Http\Resources\Api\RegisterUserResource;
use App\Mail\Api\RegisterSuccessMail;
use App\Models\Api\Admin;
use App\Services\TokenMakeService;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class RegisterUserController extends Controller
{
    public function post(AdminRequest $request)
    {
        try {
            DB::beginTransaction();
            $existUser = Admin::where('address', $request->address)->first();

            if (!empty($existUser)) {
                $request->merge(['statusMessage' => sprintf(CommonConst::ERR_08)]);
                $statusCode = MessageConst::Unauthorized;

                return new ErrorResource($request, $statusCode);
            }
            $admin = Admin::create([
                'nick_name' => $request->input('nickName'),
                'address' => $request->input('address'),
                'password' => Hash::make($request->input('password')),
                'age' => $request->input('age'),
                'sex' => $request->input('sex'),
                'statusMessage' => MessageConst::OK,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            $address = $admin->address;
            $nickName = $admin->nickName;

            Mail::to($address)->send(new RegisterSuccessMail($nickName));

            $token = TokenMakeService::createToken($admin->id);
            $request->merge(['token' => $token]);

            DB::commit();
            return new RegisterUserResource($request);
        } catch (\Exception $e) {
            DB::rollBack();
            $request->merge(['statusMessage' => sprintf(CommonConst::REGISTER_FAILED, 'アカウント')]);
            $statusMessage = $e->getMessage();
            print_r($statusMessage);
            return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
        }
    }

//    private function takeoverUser($request)
//    {
//        $admin = Admin::update([
//            'nickName' => $request->input('nickName'),
//            'address' => $request->input('address'),
//            'password' => $request->input('password'),
//            'age' => $request->input('age'),
//            'sex' => $request->input('sex'),
//            'status' => MessageConst::OK,
//            'created_at' => Carbon::now(),
//            'updated_at' => Carbon::now()
//        ]);
//
//        // Using for sending email with these elements.
//        $nickName = $admin->nickName;
//        $address = $admin->address;
//
//        DB::commit();
//        Mail::to($admin->address)->send(new RegisterSuccessMail($nickName, $address));
//
//    }

}
