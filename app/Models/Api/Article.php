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

}
