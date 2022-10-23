<?php

namespace App\Http\Requests\Api;

use App\Consts\CommonConst;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

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
            "address" => "required|max:100|unique:customers",
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

    public function messages()
    {
        return [
            'required' => ':attributesは入力必須となっております。',
            'string' => ':attributesの値が不正です。',
            'integer' => ':attributesの値が不正です。',
            'date' => ':attributesには日付のみ入力可能です。',
            'email' => 'メールアドレスの形式が正しくありません。',
            'unique' => ':attributesは既に使用されています。',
            'min' => ':attributesの値は%d文字以上の入力が必要です。',
            'max' => ':attributesの値は%d文字以下の入力が必要です。',
            'between' => ':attributesの値は%d文字から%d文字の間での入力となります。',
            'c_alpha' => ':attributesの入力形式が正しくありません。',
            'tel_num' => ':attributesの入力形式が正しくありません。',

        ];
    }
}
