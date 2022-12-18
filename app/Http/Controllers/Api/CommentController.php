<?php

namespace App\Http\Controllers\Api;

use App\Consts\CommonConst;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CommentRequest;
use App\Http\Resources\Api\commentTotalCollection;
use App\Http\Resources\Api\CommentUpdateResource;
use App\Http\Resources\Api\ErrorResource;
use App\Mail\Api\ArticleUpdateMail;
use App\Mail\Api\CommentNoticeChange;
use App\Models\Api\Article;
use App\Models\Api\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\Api\CommentDeleteResource;



class CommentController extends Controller
{
    public function makeComment(CommentRequest $request) {
        try {
            DB::beginTransaction();
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
            DB::commit();
            return new CommentTotalCollection($comments);

        } catch (\Exception $e) {
            DB::rollBack();
            $request->merge(['statusMessage' => "コメントの投稿に失敗致しました。"]);
            return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
        }
    }

    public function changeComment(CommentRequest $request) {
        try {
            DB::beginTransaction();
            $articleId = $request->articleId;
            $commentId = $request->id;
            $selectedComment = Comment::selectedComment($articleId);

            if (empty($articleId)) {
                $request->merge(['statusMessage' => CommonConst::ERR_05]);
                return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
            }

            $selectedComment::where('id', $commentId)
                ->update([
                    'name' => $request->input('name'),
                    'content' => $request->input('content'),
                    'article_id' => $articleId,
                ]);

            DB::commit();
            $mailUserInform = Article::compilingComments($articleId);
            Mail::to($mailUserInform->address)->send(new CommentNoticeChange($mailUserInform));
            return new CommentUpdateResource($request);
        } catch (\Exception $e) {
            DB::rollBack();
            $request->merge(['statusMessage' => "コメントの更新に失敗致しました。"]);
            return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
        }
    }

    public function deleteComment(Request $request)
    {
        try {
            DB::beginTransaction();
            $commentId = $request->id;
            if (empty($commentId)) {
                $request->merge(['statusMessage' => CommonConst::ERR_05]);
                return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
            }
            if (Comment::find($commentId) == null) {
                $request->merge(['statusMessage' => CommonConst::ERR_05]);
                return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
            }
            Comment::find($commentId)->delete();
            DB::commit();

            return new CommentDeleteResource($request);
        } catch (\Exception $e) {
            DB::rollBack();
            $request->merge(['statusMessage' => "コメントの削除に失敗致しました。"]);
            return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
        }
    }
}
