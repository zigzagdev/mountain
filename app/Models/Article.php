<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at', 'admin_id'];

    protected $fillable = [
        'title',
        'content',
        'prefecture'
    ];

}
