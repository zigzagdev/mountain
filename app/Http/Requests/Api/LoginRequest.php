<?php

namespace App\Http\Requests\Api;

use App\Consts\Api\MessageConst;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
            "address" => "required|string|email",
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
        return [
            'required' => ':attributeは入力必須となっております。',
            'string' => ':attributeの値が不正です。',
            'email' => 'メールアドレスの形式が正しくありません。',
        ];
    }


    // Not to send API Response 302, write down these codes.
    protected function failedValidation(validator $validator)
    {
        $errors = $validator->errors()->toArray();

        // resetFunction is get the first element form $errors Array.
        $response = [
            'statusCode'  => MessageConst::Bad_Request,
            'statusMessage' => reset($errors)[0]
        ];
        throw new HttpResponseException(
            response()->json($response, MessageConst::Bad_Request)
        );
    }
}
