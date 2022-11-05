<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminToken extends Model
{
    protected $table = 'admin_tokens';
    protected $fillable = [
        'token',
        'admin_id',
        'expired_at'
    ];
}
