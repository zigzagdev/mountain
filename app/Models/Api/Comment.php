<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    use SoftDeletes;

    public static function selectedComment($articleId)
    {
        return self::select([
            'name', 'comments.id', 'articles.id'
        ])->leftjoin('articles', function ($join) {
            $join->on('comments.article_id', '=', 'articles.id');
        })->where('articles.id', $articleId)
            ->orderBy('comments.created_at', 'asc')
            ->first();
    }


}
