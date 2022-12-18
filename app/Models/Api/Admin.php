<?php
namespace App\Models\Api;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model
{
    use SoftDeletes, CascadeSoftDeletes;
    protected $guarded = ['id'];
    protected $softCascade = ['articles'];
    protected $cascadeDeletes = ['articles'];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
