<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceResponse;
use Symfony\Component\HttpFoundation\Response;

class ErrorResource extends JsonResource
{
    public $statusCode;

    public function __construct($resource, $statusCode = 401)
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
            'statusMessage' => $request->statusMessage,
        ];
    }

    public function toResponse($request)
    {
        return (new ResourceResponse($this))->toResponse($request)->setStatusCode($this->statusCode);
    }
}
