<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    use SoftDeletes;


    public static function selectedAllNews()
    {
        return self::select([
            'news_title', 'news_content', 'admin_id'
        ])->leftjoin('admins', function ($join) {
            $join->on('news.admin_id', '=', 'admins.id');
        })->orderBy('news.created_at', 'asc')
            ->get();
    }
}
