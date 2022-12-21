<?php
namespace App\Models\Api;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model
{
    use SoftDeletes, CascadeSoftDeletes;
    protected $guarded = ['id'];
    protected $softCascade = ['articles', 'news'];
    protected $cascadeDeletes = ['articles', 'news'];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }
}
