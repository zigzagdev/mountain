<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = ['id'];

    public static function selectedComment($articleId)
    {
        return self::select([
            'name'
        ])->leftjoin('articles', function ($join) {
            $join->on('comments.article_id', '=', 'articles.id');
        })->where('articles.id', $articleId)
            ->orderBy('comments.created_at', 'asc')
            ->first();
    }
}
