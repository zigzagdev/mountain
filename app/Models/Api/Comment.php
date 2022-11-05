<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = ['id', 'article_id', 'created_at', 'updated_at'];

}
