<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    protected $fillable = ['admin_id', 'created_at', 'content', 'updated_at', 'title'];
    protected $dates = ['deleted_at'];
    use SoftDeletes;

}
