<?php

namespace App\Http\Controllers\Api;

use App\Consts\Api\MessageConst;
use App\Consts\CommonConst;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ErrorResource;
use App\Http\Requests\Api\ArticleRequest;
use App\Http\Resources\Api\RegisterArticleResource;
use App\Models\Api\Article;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\Consts\Api\Prefecture;
use Carbon\Carbon;


class ArticleController extends Controller
{
    // 記事投稿
    public function articleWriting(ArticleRequest $request){
        try {
            $adminId = $request->adminId;

            // Whether admin is existed or not .
            $admin = Article::where('id', $adminId)->first();
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
                'userToken' => $request->userToken
            ]);

            return new RegisterArticleResource($request);
        } catch (\Exception $e) {
            DB::rollBack();
            $request->merge(['statusMessage' => "記事の投稿に失敗致しました。"]);
            return new ErrorResource($request, MessageConst::Not_Acceptable);
        }
    }

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
