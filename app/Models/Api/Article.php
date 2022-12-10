<?php
namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    protected $table = 'articles';
    use SoftDeletes;

    public static function selectedAllArticles($articleId)
    {
        return self::select([
            'title', 'content', 'prefecture', 'mountain_name', 'mountain_rate', 'adminId', 'address', 'nick_name'
        ])->leftjoin('admins', function ($join) {
            $join->on('articles.adminId', '=', 'admins.id');
        })->where('articles.id', $articleId)
            ->orderBy('articles.created_at', 'asc')
            ->first();
    }

}
