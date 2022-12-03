<?php

namespace App\Http\Resources\Api;

use App\Consts\Api\Prefecture;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'statusCode' => Response::HTTP_OK,
            'statusMessage' => 'OK',
            'createdNews' => [
                'title' => $this->title,
                'content' => Str::limit($this->content, 15, '...'),
                'expiration' => Carbon::now()->addMonths(3),
            ]
        ];
    }
}
