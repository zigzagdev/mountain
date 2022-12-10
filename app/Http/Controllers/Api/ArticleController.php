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
use Illuminate\Http\Client\Request;


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
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'mountain_rate' => $request->input('mountainRate'),
                'mountain_name' => $request->input('mountainName'),
                'adminId' => $adminId,
            ]);

            // MountainRating Records are created .
            if (!empty($request->input('mountainRate')))
                MountainRating::firstOrCreate([
                    'admin_id' => $adminId,
                    'mountain_rate' => $request->input('mountainRate'),
                    'mountain_name' => $request->input('mountainName'),
                    'prefecture' => $request->input('prefecture'),
                ]);

            return new RegisterArticleResource($request);
        } catch (\Exception $e) {
            DB::rollBack();
            $request->merge(['statusMessage' => "記事の投稿に失敗致しました。"]);
            return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
        }
    }

    //記事編集
    public function articleReWrite(Request $request)
    {
        try {
            var_dump($request->toArray());

        } catch (\Exception $e) {
            DB::rollBack();
            $request->merge(['statusMessage' => "記事の上書きに失敗致しました。"]);
            return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
        }
    }
}
