<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\Article;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Resources\Api\RatingDisplayResource;

class DisplayController extends Controller
{
    public function ratingDisplay(Request $request)
    {
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
print_r($pushArray);
        // making a new array which has a total rating and how many rating it has.
        $totalRatingScore = $pushArray[0]['mountainRate'];
        $dividedRecord = 1;
        for ($i = 1; $i <= $count - 1; $i++) {
            if (intval($pushArray[$i - 1]['prefecture']) === intval($pushArray[$i]['prefecture'])) {
                $totalRatingScore += intval($pushArray[$i]['mountainRate']);
                $dividedRecord += 1;
            } else {
                array_push($reviews, array($totalRatingScore, $dividedRecord));
                $totalRatingScore = $pushArray[$i]['mountainRate'];
                $dividedRecord = 1;
            }
        }
print_r($reviews);
        $avg = [];
        foreach ($reviews as $key => $value) {
            $score = $value['0'] / $value['1'];
            $goalRating = round($score * 2, 0) / 2;
            array_push($avg, $goalRating);
        }
        return $avg;
//        return new RatingDisplayResource($avg);
    }
}
