<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AvgRating extends Model
{
    protected $guarded = [];
    protected $table = 'average_rating';
    use SoftDeletes;
}
