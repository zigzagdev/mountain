<?php

namespace App\Http\Middleware;

use App\Consts\CommonConst;
use App\Http\Resources\Api\ErrorResource;
use App\Models\Api\AdminToken;
use Closure;
use Illuminate\Http\Request;
use App\Http\Middleware\TrustProxies as Middleware ;
use \Symfony\Component\HttpFoundation\Response;

class CheckToken extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->hasHeader('adminToken')) {
            $request->merge(['statusMessage' => CommonConst::ERR_14]);
            return new ErrorResource($request, Response::HTTP_UNAUTHORIZED);
        }
        $token = $request->header('adminToken');
        $validToken = AdminToken::latest('created_at')->first();

        if ($token != $validToken->toArray()['token']) {
            $request->merge(['statusMessage' => sprintf(CommonConst::FAILED, 'ユーザーの読み込み')]);
            return new ErrorResource($request, Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
