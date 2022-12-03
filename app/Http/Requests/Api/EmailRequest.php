<?php

namespace App\Http\Requests\Api;

use App\Consts\Api\MessageConst;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EmailRequest extends FormRequest
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
            "address" => "required|max:100|unique:admins|email",
        ];
    }

    public function attributes()
    {
        return [
            'address' => 'メールアドレス',
        ];
    }

    public function errorMessages()
    {
        return [
            'required' => ':attributeは入力必須となっております。',
            'string' => ':attributeの値が不正です。',
            'email' => 'メールアドレスの形式が正しくありません。',
            'unique' => ':attributeは既に使用されています。',
            'max' => ':attributeの値は%d文字以下の文字数でお願いします。',
            'regex' => ':attributeは半角英数字のみ有効となっております。'
        ];
    }

    public function messages()
    {
        $message = $this->errorMessages();
        return  [
            //address
            "address.required" => $message['required'],
            "address.max" => sprintf($message['max'], 255),
            "address.email" => $message['email'],
            "address.unique" => $message['unique'],
        ];
    }


    protected function failedValidation(validator $validator)
    {
        $errors = $validator->errors()->toArray();

        $response = [
            'statusCode'  => MessageConst::Bad_Request,
            'statusMessage' => reset($errors)[0]
        ];
        throw new HttpResponseException(
            response()->json($response, MessageConst::Bad_Request)
        );
    }
}
