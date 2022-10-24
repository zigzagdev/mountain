<?php

namespace App\Http\Requests\Api;

use App\Consts\Api\MessageConst;
use App\Consts\CommonConst;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdminRequest extends FormRequest
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
            "nickName" => "required|max:255",
            "password" => "required|max:100",
            "address" => "required|max:100|unique:admins",
            "age" => "required|integer|between:10,120",
            "sex" => "required|integer|between:0,2",
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'メールアドレス',
            'password' => 'パスワード',
            'nickName' => '名前(ニックネーム)',
            'age' => '年齢',
            'sex' => '性別',
            'prefecture' => '都道府県',

        ];
    }

    public function errormessage()
    {
        return [
            'required' => ':attributeは入力必須となっております。',
            'string' => ':attributeの値が不正です。',
            'integer' => ':attributeの値が不正です。',
            'date' => ':attributeには日付のみ入力可能です。',
            'email' => 'メールアドレスの形式が正しくありません。',
            'unique' => ':attributeは既に使用されています。',
            'min' => ':attributeの値は%d文字以上の入力が必要です。',
            'max' => ':attributeの値は%d文字以下の入力が必要です。',
            'between' => ':attributeの値は%d文字から%d文字の間での入力となります。',
        ];
    }

    public function messages()
    {
        $message = $this->errormessage();
        return  [
            //firstname
            "nickName.required" => $message['required'],
            "nickName.max" => sprintf($message['max'], 255),
            //password
            "password.required" => $message['required'],
            "password.max" => sprintf($message['max'], 255),
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
