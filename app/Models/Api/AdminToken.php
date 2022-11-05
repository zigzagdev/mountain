<?php

namespace App\Models\Api;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AdminToken extends Model
{
    protected $table = 'admin_tokens';
    protected $fillable = [
        'token',
        'admin_id',
        'expired_at'
    ];

    public static function createToken()
    {
        $token = Str::random(32);
        if (self::checkToken($token)) {
            return self::createToken();
        }
        return $token;
    }
    private static function checkToken($token)
    {
        return self::where('token', $token)->exists();
    }
}
