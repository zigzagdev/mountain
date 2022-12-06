<?php

namespace App\Http\Requests\Api;

use App\Consts\Api\MessageConst;
use App\Consts\CommonConst;
use App\Http\Requests\Api\CommonRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdminRequest extends CommonRequest
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
            "nickName" => "required|min:4|max:50|regex:/^[A-Za-z\d_\-]+$/",
            "password" => "required|min:8|max:255|regex:/^[A-Za-z\d_\-]+$/",
            "address" => "required|max:255|unique:admins|email",
            "age" => "required|integer|between:10,120",
            "sex" => "required|integer|between:0,2",
        ];
    }
    public function messages()
    {
        $message = $this->errorMessages();
        return  [
            //nickName
            "nickName.required" => $message['required'],
            "nickName.min" => sprintf($message['min'], 4),
            "nickName.max" => sprintf($message['max'], 50),
            "nickName.regex" => $message['regex'],
            //password
            "password.required" => $message['required'],
            "password.min" => sprintf($message['min'], 8),
            "password.max" => sprintf($message['max'], 255),
            "password.regex" => $message['regex'],
            //address
            "address.required" => $message['required'],
            "address.max" => sprintf($message['max'], 255),
            "address.email" => $message['email'],
            "address.unique" => $message['unique'],
            //age
            "age.required" => $message['required'],
            "age.integer" => $message['integer'],
            "age.between" => sprintf($message['between'], 10, 120),
            //sex
            "sex.required" => $message['required'],
            "sex.integer" => $message['integer'],
            "sex.between" => sprintf($message['between'], 0, 2),
        ];
    }
}
