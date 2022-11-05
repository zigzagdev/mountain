<?php

namespace App\Http\Controllers\Api;

use App\Consts\Api\MessageConst;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ErrorResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function makeColumn ($adminId,Request $request){
        try {
            DB::beginTransaction();

        } catch (\Exception $e) {
            DB::rollBack();
            $request->merge(['statusMessage' => "記事の登録に失敗致しました。"]);
            return new ErrorResource($request, MessageConst::Not_Acceptable);
        }
    }
}
