<?php

namespace App\Http\Controllers\Api;

use App\Consts\Api\Prefecture;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ErrorResource;
use App\Models\Api\Article;
use App\Models\Api\AvgRating;
use Illuminate\Http\Request;
use App\Http\Resources\Api\RatingDisplayCollection;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class DisplayController extends Controller
{
    public function ratingDisplay(Request $request)
    {
        try {
            // In here, searching SQL is selected from here .
            $useSQL = Article::withoutTrashed();
            $keyword = $request->keyword;
            $ratingRecords = $useSQL->where('mountainName', 'LIKE', '%' . $keyword . '%')
                ->orWhere('title', 'LIKE', '%' . $keyword . '%')
                ->orWhere('content', 'LIKE', '%' . $keyword . '%')
                ->get();

            // using as a searchQueryResults .
            $arrRecords = $ratingRecords->toArray();

            foreach ($arrRecords as $key => $value) {
                $arr[$key] = $value['prefecture'];
            }
            array_multisort($arr, SORT_ASC, $arrRecords);

            //Make a totalReview with Having mountainRating Records
            $pushArray = [];

            foreach ($arrRecords as $ratingRecord) {
                if (!empty($ratingRecord['mountainRate'])) {
                    array_push($pushArray, $ratingRecord);
                }
            }
            $count = count($pushArray);
            $reviews = [];

            // making a new array which has a total rating and how many rating it has.
            $totalRatingScore = $pushArray[0]['mountainRate'];
            $mountainName = $pushArray[0]['mountainName'];
            $prefecture = $pushArray[0]['prefecture'];
            $dividedRecord = 1;
            for ($i = 1; $i <= $count - 1; $i++) {
                if (intval($pushArray[$i - 1]['prefecture']) === intval($pushArray[$i]['prefecture'])) {
                    $totalRatingScore += intval($pushArray[$i]['mountainRate']);
                    $dividedRecord += 1;
                    $mountainName = $pushArray[$i]['mountainName'];
                    $prefecture = $pushArray[$i]['prefecture'];
                } else {
                    array_push($reviews, array($totalRatingScore, $dividedRecord, $mountainName, $prefecture));
                    $totalRatingScore = $pushArray[$i]['mountainRate'];
                    $dividedRecord = 1;
                }
            }

            $avg = [];
            foreach ($reviews as $key => $value) {
                $score = $value['0'] / $value['1'];
                $goalRating = round($score * 2, 0) / 2;
                array_push($avg, array($goalRating, $value['2'], Prefecture::eachPrefecture[$value['3']]));
                AvgRating::updateOrCreate([
                    'mountainName' => $value['2'],
                    'avgRate' => $goalRating,
                    'prefecture' => Prefecture::eachPrefecture[$value['3']],
                ]);
            }
            return new RatingDisplayCollection($avg);
        } catch (\Exception $e) {
            DB::rollBack();
            $request->merge(['statusMessage' => "検索内容にてエラーが発生しました。"]);
            return new ErrorResource($request, Response::HTTP_BAD_REQUEST);
        }
    }
}
