<?php

namespace App\Http\Controllers\Api;

use App\Consts\CommonConst;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\NewsRequest;
use App\Http\Resources\Api\ErrorResource;
use App\Http\Resources\Api\NewsResource;
use App\Models\Api\Admin;
use App\Models\Api\News;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class NewsMakingController extends Controller
{
    public function newsMake(NewsRequest $request)
    {
        try {
            $adminId = $request->adminId;
            $admin = Admin::where('id', $adminId);

            if (empty($admin)) {
                $request->merge(['statusMessage' => CommonConst::ERR_05]);
                return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
            }
            News::create([
                'news_title' => $request->input('newsTitle'),
                'news_content' => $request->input('newsContent'),
                'admin_id' => $adminId,
                'expiration' => Carbon::now()->addMonths(3),
            ]);

            return new NewsResource($request);

        } catch (\Exception $e) {
            DB::rollBack();
            $request->merge(['statusMessage' => "ニュース投稿の投稿に失敗致しました。"]);
            $statusmessage = $e->getMessage();
            print_r($statusmessage);
            return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
        }

    }
}
