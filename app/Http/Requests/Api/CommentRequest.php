<?php

namespace App\Http\Requests\Api;

use App\Consts\Api\MessageConst;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CommentRequest extends CommonRequest
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
            "name" => "required|min:5||max:30|string",
            "content" => "required|min:5|max:255|string",
        ];
    }


    public function messages()
    {
        $message = $this->errorMessages();
        return [
            //name
            "name.required" => $message['required'],
            "name.min" => sprintf($message['min'], 5),
            "name.max" => sprintf($message['max'], 30),
            "name.string" => $message['string'],

            //content
            "content.required" => $message['required'],
            "content.min" => sprintf($message['min'], 5),
            "content.max" => sprintf($message['max'], 255),
            "content.string" => $message['string'],
        ];
    }
}
