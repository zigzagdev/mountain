<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceResponse;

class RegisterUserResource extends JsonResource
{
    public function __construct($resource, $statusCode = 201)
    {
        parent::__construct($resource);
        $this->statusCode = $statusCode;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
          'statusCode' => $this->statusCode,
          'statusMessage' => 'OK'
        ];
    }
}



