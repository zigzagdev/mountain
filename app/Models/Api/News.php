<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    use SoftDeletes;

}
