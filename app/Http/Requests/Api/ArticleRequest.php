<?php

namespace App\Http\Requests\Api;

use App\Consts\Api\MessageConst;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ArticleRequest extends CommonRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "title" => "required|min:5||max:255|string",
            "content" => "required|min:5|max:1000|string",
            "prefecture" => "between:1,47|required",
            "mountainRate" => "between:1,5|numeric|integer",
            "mountainName" => "string|required|min:4|max:100|"
        ];
    }

    public function messages()
    {
        $message = $this->errorMessages();
        return [
            //title
            "title.required" => $message['required'],
            "title.min" => sprintf($message['min'], 5),
            "title.max" => sprintf($message['max'], 255),
            "title.string" => $message['string'],

            //content
            "content.required" => $message['required'],
            "content.min" => sprintf($message['min'], 5),
            "content.max" => sprintf($message['max'], 1000),
            "content.string" => $message['string'],

            //prefecture
            "prefecture.required" => $message['required'],
            "prefecture.between" => sprintf($message['between'], 1, 47),

            //mountainRate
            "mountainRate.between" => sprintf($message['between'], 1, 5),
            "mountainRate.integer" => $message['integer'],

            //mountainName
            "mountainName.required" => $message['required'],
            "mountainName.min" => sprintf($message['min'], 5),
            "mountainName.max" => sprintf($message['max'], 1000),
            "mountainName.string" => $message['string'],
        ];
    }
}
