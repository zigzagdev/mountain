<?php
namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    protected $table = 'articles';
    use SoftDeletes;

    public static function selectedAllArticles()
    {
        return self::select([
            'title', 'content', 'prefecture', 'mountain_name', 'mountain_rate','adminId'
        ])->leftjoin('admins', function ($join) {
            $join->on('articles.adminId', '=', 'admins.id');
        })->orderBy('articles.created_at', 'asc')
            ->get();
    }
}
