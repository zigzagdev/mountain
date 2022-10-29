<?php

namespace App\Http\Controllers\Api;

use App\Consts\Api\MessageConst;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AdminRequest;
use App\Http\Resources\Api\ErrorResource;
use App\Http\Resources\Api\RegisterUserResource;
use App\Mail\Api\RegisterSuccessMail;
use App\Models\Admin;
use Illuminate\Http\Exceptions\HttpResponseException;
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
                $request->merge(['statusMessage' => sprintf(MessageConst::Bad_Request, '既にそのメールアドレスは使われています。')]);
                $statusCode = MessageConst::Unauthorized;

                return new ErrorResource($request, $statusCode);
            }
            DB::commit();
            $admin = Admin::create([
                'nickName' => $request->input('nickName'),
                'address' => $request->input('address'),
                'password' => Hash::make($request->input('password')),
                'age' => $request->input('age'),
                'sex' => $request->input('sex'),
                'statusMessage' => MessageConst::OK,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

//            $address = $admin->address;
//            $nickName = $admin->nickName;
//
//            Mail::to($address)->send(new RegisterSuccessMail($nickName));

            DB::commit();
            return new RegisterUserResource($request);

        } catch (\Exception $e) {
            DB::rollBack();
            $request->merge(['statusMessage' => "会員情報の登録に失敗致しました。"]);
            return new ErrorResource($request, MessageConst::Not_Acceptable);
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
