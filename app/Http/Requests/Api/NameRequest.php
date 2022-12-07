<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class NameRequest extends CommonRequest
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
        ];
    }

    public function messages()
    {
        $message = $this->errorMessages();
        return [
            //nickName
            "nickName.required" => $message['required'],
            "nickName.min" => sprintf($message['min'], 4),
            "nickName.max" => sprintf($message['max'], 50),
            "nickName.regex" => $message['regex'],
        ];
    }
}
