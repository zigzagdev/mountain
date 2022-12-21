<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    use SoftDeletes;


    public static function selectedAllNews($newsId)
    {
        return self::select([
            'news_title', 'news_content', 'address', 'nick_name', 'news.id'
        ])->leftjoin('admins', function ($join) {
            $join->on('news.admin_id', '=', 'admins.id');
        })->where('news.id', $newsId)
            ->first();
    }
}
