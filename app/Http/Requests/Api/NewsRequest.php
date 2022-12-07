<?php

namespace App\Http\Requests\Api;

use App\Consts\Api\MessageConst;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class NewsRequest extends CommonRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "newsTitle" => "required|min:5||max:100|string",
            "newsContent" => "required|min:5|max:1000|string",
        ];
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function messages()
    {
        $message = $this->errorMessages();
        return [
            //title
            "newsTitle.required" => $message['required'],
            "newsTitle.min" => sprintf($message['min'], 5),
            "newsTitle.max" => sprintf($message['max'], 255),
            "newsTitle.string" => $message['string'],

            //content
            "newsContent.required" => $message['required'],
            "newsContent.min" => sprintf($message['min'], 5),
            "newsContent.max" => sprintf($message['max'], 1000),
            "newsContent.string" => $message['string'],
        ];
    }
}
