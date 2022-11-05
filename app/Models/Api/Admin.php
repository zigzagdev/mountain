<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $guarded = ['created_at', 'updated_at', 'id'];

    protected $fillable = [
        'nickName',
        'address',
        'password',
        'age',
        'sex'
    ];
}
