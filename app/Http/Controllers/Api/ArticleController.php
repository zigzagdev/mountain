<?php

namespace App\Http\Controllers\Api;

use App\Consts\Api\MessageConst;
use App\Http\Resources\Api\RegisterArticleResource;
use App\Http\Resources\Api\SuccessResource;
use App\Mail\Api\ArticleDeleteNotificationMail;
use App\Mail\Api\ArticleUpdateMail;
use App\Models\Api\Admin;
use App\Consts\CommonConst;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ErrorResource;
use App\Http\Requests\Api\ArticleRequest;
use App\Models\Api\Article;
use App\Models\Api\Comment;
use App\Models\Api\MountainRating;
use App\Models\Api\News;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;
use App\Consts\Api\Prefecture;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Mail\Api\ArticleCreateMail;


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

            $newArticle = Article::create([
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

            Mail::to($admin->address)->send(new ArticleCreateMail($admin, $newArticle));
            return new RegisterArticleResource($request);
        } catch (\Exception $e) {
            DB::rollBack();
            $request->merge(['statusMessage' => sprintf(CommonConst::REGISTER_FAILED, '記事')]);
            return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
        }
    }

    //記事編集
    public function articleReWrite(ArticleRequest $request)
    {
        try {
            DB::beginTransaction();
            $adminId = $request->adminId;
            $articleId = $request->id;

            $findArticle = Article::selectedAllArticles($articleId);
            if (empty($findArticle)) {
                $request->merge(['statusMessage' => sprintf(CommonConst::UPDATE_FAILED, '該当記事')]);
                return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
            }
            $findArticle::where('id', $articleId)
                ->update([
                    'title' => $request->input('title'),
                    'content' => $request->input('content'),
                    'prefecture' => $request->input('prefecture'),
                    'updated_at' => Carbon::now(),
                    'mountain_rate' => $request->input('mountainRate'),
                    'mountain_name' => $request->input('mountainName'),
                    'adminId' => $adminId,
                ]);
            if (!empty($request->input('mountainRate')))
                MountainRating::updateOrCreate([
                    'admin_id' => $adminId,
                    'mountain_rate' => $request->input('mountainRate'),
                    'mountain_name' => $request->input('mountainName'),
                    'prefecture' => $request->input('prefecture'),
                ]);

            DB::commit();
            Mail::to($findArticle->address)->send(new ArticleUpdateMail($findArticle));
            return new RegisterArticleResource($request);
        } catch (\Exception $e) {
            DB::rollBack();
            $request->merge(['statusMessage' => sprintf(CommonConst::UPDATE_FAILED, '該当記事')]);
            return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
        }
    }

    public function articleDelete(Request $request)
    {
        try {
            DB::beginTransaction();
            $adminId = $request->adminId;
            $articleId = $request->id;

            $findArticle = Article::selectedAllArticles($articleId);
            if (empty($findArticle->id)) {
                $request->merge(['statusMessage' => CommonConst::ERR_05]);
                return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
            }
            if ($findArticle->adminId == null) {
                $request->merge(['statusMessage' => CommonConst::ERR_05]);
                return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
            }
            $address = $findArticle->address;
            DB::commit();
            Article::where([
                'adminId' => $adminId,
                'id' => $findArticle->id
            ])->delete();

            Mail::to($address)->send(new ArticleDeleteNotificationMail());
            return new SuccessResource($request);
        } catch (\Exception $e) {
            DB::rollBack();
            $request->merge(['statusMessage' => sprintf(CommonConst::DELETE_FAILED, '該当記事')]);
            $u = $e->getMessage();
            var_dump($u);
            return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
        }
    }
}
