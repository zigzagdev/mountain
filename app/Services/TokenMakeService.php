<?php
namespace App\Services;

use App\Consts\Api\MessageConst;
use Carbon\Carbon;
use App\Models\Api\AdminToken;

class TokenMakeService
{
    public static function createToken($loginUserId)
    {
        // Updating the expiration is used for not coexisting  usable tokens.
        $expiration = AdminToken::where('admin_id', $loginUserId)->where('expired_at', '>', Carbon::now());
        if (!empty($expiration)) {
            AdminToken::where('admin_id', $loginUserId)->where('expired_at', '>', Carbon::now())->update([
                'expired_at' => Carbon::now()
            ]);
        }

        // Making token here and register to adminToken record.
        $token = AdminToken::createToken();
        AdminToken::create([
            'token' => $token,
            'admin_id' => $loginUserId,
            'expired_at' => Carbon::now()->addDays(MessageConst::Month),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return $token;
    }
}
