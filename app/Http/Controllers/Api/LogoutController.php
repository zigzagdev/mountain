<?php

namespace App\Http\Controllers\Api;

use App\Consts\CommonConst;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ErrorResource;
use App\Http\Resources\Api\SuccessResource;
use App\Models\Api\AdminToken;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        try {
            DB::beginTransaction();
            $expirationValid =  AdminToken::where('admin_id', $request->adminId)->orderBy('created_at', 'desc')->first();
            if ($expirationValid->expired_at <= Carbon::now()) {
                $request->merge(['statusMessage' => sprintf(CommonConst::FAILED, 'ログアウト')]);
                return new ErrorResource($request);
            }
            AdminToken::where('admin_id', $request->adminId)->orderBy('created_at', 'desc')
            ->where('expired_at', '>', Carbon::now())->update([
                'expired_at' => Carbon::now()
            ]);
            DB::commit();
            return new SuccessResource($request);
        } catch (\Exception $e) {
            DB::rollBack();
            $request->merge(['statusMessage' => sprintf(CommonConst::FAILED, 'ログアウト')]);
            return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
        }
    }
}
