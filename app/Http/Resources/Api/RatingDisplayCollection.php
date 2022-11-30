<?php

namespace App\Http\Resources\Api;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RatingDisplayCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'statusCode' => Response::HTTP_OK,
            'statusMessage' => 'OK',
            'ratingList' => $this->collection->map(function ($item) {
                return [
                    'averageRating' => $item['0'],
                    'mountainName' => $item['1'],
                    'prefecture' => $item['2']
                ];
            })
        ];
    }
}
