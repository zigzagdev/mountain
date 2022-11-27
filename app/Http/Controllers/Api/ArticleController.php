<?php

namespace App\Http\Controllers\Api;

use App\Consts\Api\MessageConst;
use App\Http\Resources\Api\RegisterArticleResource;
use App\Models\Api\Admin;
use App\Consts\CommonConst;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ErrorResource;
use App\Http\Requests\Api\ArticleRequest;
use App\Models\Api\Article;
use App\Models\Api\MountainRating;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\Consts\Api\Prefecture;
use Carbon\Carbon;


class ArticleController extends Controller
{
    // 記事投稿
    public function articleWrite(ArticleRequest $request)
    {
        try {
            $adminId = $request->adminId;

            // Whether admin is existed or not .
            $admin = Admin::where('id', $adminId)->first();
            if (!$admin) {
                $request->merge(['statusMessage' => CommonConst::ERR_05]);
                return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
            }
            Article::create([
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'prefecture' => $request->input('prefecture'),
                'statusMessage' => MessageConst::OK,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'mountainRate' => $request->input('mountainRate'),
                'mountainName' => $request->input('mountainName'),
                'adminId' => $adminId,
            ]);

            // MountainRating Records are created .
            if (!empty($request->input('mountainRate')))
                MountainRating::firstOrCreate([
                    'admin_id' => $adminId,
                    'mountainRate' => $request->input('mountainRate'),
                    'mountainName' => $request->input('mountainName'),
                    'prefecture' => $request->input('prefecture'),
                ]);

            return new RegisterArticleResource($request);
        } catch (\Exception $e) {
            DB::rollBack();
            $request->merge(['statusMessage' => "記事の投稿に失敗致しました。"]);
            $statusMessage = $e->getMessage();
            var_dump($statusMessage);
            return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
        }
    }


    // softDelete is needed ??

    //記事編集
//    public function articleReWrite($adminId, ArticleRequest $request)
//    {
//        try {
//
//        } catch (\Exception $e) {
//
//        }
//    }
}
