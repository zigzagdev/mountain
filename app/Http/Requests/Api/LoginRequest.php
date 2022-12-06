<?php

namespace App\Http\Requests\Api;

use App\Consts\Api\MessageConst;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends CommonRequest
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
            "password" => "required|string",
            "address" => "required|email|string",
        ];
    }

    public function attributes()
    {
        return [
            'address' => 'メールアドレス',
            'password' => 'パスワード',
        ];
    }

    public function messages()
    {
        $message = $this->errorMessages();
        return [
            //password
            "password.required" => $message['required'],
            "password.string" => $message['string'],
            //address
            "address.required" => $message['required'],
            "address.email" => $message['email'],
            "address.string" => $message['string'],
        ];
    }
}
