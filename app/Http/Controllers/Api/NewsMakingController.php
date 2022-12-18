<?php

namespace App\Http\Controllers\Api;

use App\Consts\CommonConst;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\NewsRequest;
use App\Http\Resources\Api\ErrorResource;
use App\Http\Resources\Api\NewsResource;
use App\Mail\Api\ArticleUpdateMail;
use App\Mail\Api\NewsCreateMail;
use App\Mail\Api\NewsUpdateMail;
use App\Models\Api\Admin;
use App\Models\Api\News;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class NewsMakingController extends Controller
{
    public function newsMake(NewsRequest $request)
    {
        try {
            DB::beginTransaction();
            $adminId = $request->adminId;
            $admin = Admin::where('id', $adminId);

            if (empty($admin)) {
                $request->merge(['statusMessage' => CommonConst::ERR_05]);
                return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
            }
            $recordNews = News::create([
                'news_title' => $request->input('newsTitle'),
                'news_content' => $request->input('newsContent'),
                'admin_id' => $adminId,
                'expiration' => Carbon::now()->addMonths(3),
            ]);
            DB::commit();
            Mail::to($recordNews->address)->send(new NewsCreateMail($recordNews, $admin));
            return new NewsResource($request);
        } catch (\Exception $e) {
            DB::rollBack();
            $request->merge(['statusMessage' => sprintf(CommonConst::REGISTER_FAILED, 'ニュース')]);
            return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
        }
    }

    public function newsReWrite(Request $request)
    {
        try {
            DB::beginTransaction();
            $adminId = $request->adminId;
            $newsId = $request->id;

            $findNews = News::selectedAllNews($newsId);
            if (empty($findNews)) {
                $request->merge(['statusMessage' => CommonConst::ERR_05]);
                return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
            }
            $findNews::where('id', $newsId)
                ->update([
                    'news_title' => $request->input('newsTitle'),
                    'news_content' => $request->input('newsContent'),
                    'admin_id' => $adminId,
                    'expiration' => Carbon::now()->addMonths(3),
                ]);
            DB::commit();

            Mail::to($findNews->address)->send(new NewsUpdateMail($findNews));
            return new NewsResource($request);
        } catch (\Exception $e) {
            DB::rollBack();
            $request->merge(['statusMessage' => sprintf(CommonConst::REGISTER_FAILED, 'ニュース')]);
            $statusMessage = $e->getMessage();
            print_r($statusMessage);
            return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
        }
    }
}
