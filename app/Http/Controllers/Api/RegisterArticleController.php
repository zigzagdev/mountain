<?php

namespace App\Http\Controllers\Api;

use App\Consts\Api\MessageConst;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ArticleRequest;
use App\Http\Resources\Api\ErrorResource;
use App\Http\Resources\Api\RegisterArticleResource;
use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RegisterArticleController extends Controller
{
    public function post (ArticleRequest $request) {
        try {
            DB::beginTransaction();
            $existUser = Article::where('id', $request->address)->first();

            if (!empty($existUser)) {
                $request->merge(['statusMessage' => sprintf(MessageConst::Bad_Request, '既にそのメールアドレスは使われています。')]);
                $statusCode = MessageConst::Unauthorized;

                return new ErrorResource($request, $statusCode);
            }
            DB::commit();
            Article::create([
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'prefecture' => $request->input('prefecture'),
                'statusMessage' => MessageConst::OK,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            DB::commit();
            return new RegisterArticleResource($request);
        } catch (\Exception $e) {
            DB::rollBack();
            $request->merge(['statusMessage' => "記事の作成に失敗致しました。"]);
            return new ErrorResource($request, MessageConst::Unauthorized);
        }
    }
}



