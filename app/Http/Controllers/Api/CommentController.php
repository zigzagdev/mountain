<?php

namespace App\Http\Controllers\Api;

use App\Consts\CommonConst;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CommentRequest;
use App\Http\Resources\Api\commentTotalCollection;
use App\Http\Resources\Api\ErrorResource;
use App\Models\Api\Article;
use App\Models\Api\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;



class CommentController extends Controller
{
    public function makeComment(CommentRequest $request) {
        try {
            $articleId = $request->articleId;
            $article = Article::where('id', $articleId);

            if (empty($article)) {
                $request->merge(['statusMessage' => CommonConst::ERR_05]);
                return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
            }
            Comment::create([
                'name' => $request->input('name'),
                'content' => $request->input('content'),
                'article_id' => $articleId,
            ]);

            $comments = Comment::where('article_id', $articleId)->get();

            $comments->toArray();

            return new CommentTotalCollection($comments);

        } catch (\Exception $e) {
            DB::rollBack();
            $request->merge(['statusMessage' => "コメントの投稿に失敗致しました。"]);
            return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
        }
    }

    public function changeComment() {
        try {

        } catch (\Exception $e) {

        }

    }
}
