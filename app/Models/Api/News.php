<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $guarded = ['id', 'admin_id', 'created_at', 'updated_at'];

    protected $fillable = [
      'title',
      'content',
    ];
}
