<?php

namespace App\Http\Requests\Api;

use App\Consts\Api\MessageConst;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PasswordRequest extends CommonRequest
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
            "password" => "required|min:8|max:100|regex:/^[A-Za-z\d_\-]+$/"
        ];
    }

    public function messages()
    {
        $message = $this->errorMessages();
        return  [
            //password
            "password.required" => $message['required'],
            "password.min" => sprintf($message['max'], 8),
            "password.max" => sprintf($message['max'], 100),
            "password.email" => $message['email'],
            "password.unique" => $message['unique'],
            "password.regex" => $message['regex'],
        ];
    }
}
