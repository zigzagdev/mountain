<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $guarded = ['id', 'admin_id', 'created_at'];

}
