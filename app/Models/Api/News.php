<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = ['admin_id', 'created_at', 'content', 'updated_at', 'title'];

}
