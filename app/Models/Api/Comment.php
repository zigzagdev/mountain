<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = ['id', 'article_id', 'created_at', 'updated_at'];

    protected $fillable = [
        'comments',
        'name'
    ];
}
