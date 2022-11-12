<?php
namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    protected $guarded = ['id', 'adminId'];
    protected $dates = ['deleted_at'];
    use SoftDeletes;


    public function selectedArticle()
    {
        $selectArticle = Article::get('deleted_at', '<', Carbon::now());
    }
}






