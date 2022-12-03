<?php

namespace App\Http\Requests\Api;

use App\Consts\Api\MessageConst;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class NewsRequest extends FormRequest
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

    public function rules()
    {
        return [
            "title" => "required|min:5||max:30|string",
            "content" => "required|min:5|max:1000|string",
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'title' => '投稿ニュースの名前',
            'content' => '投稿ニュースの内容文字',
        ];
    }

    public function errorMessages()
    {
        return [
            'required' => ':attributeは入力必須となっております。',
            'string' => ':attributeの値が不正です。',
            'min' => ':attributeの値は%d文字以上の文字数が必要です。',
            'max' => ':attributeの値は%d文字以下の文字数でお願いします。',
            'between' => ':attributeは%dから%dの間の数字で入力してください。',
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
        ];
    }


    protected function failedValidation(validator $validator)
    {
        $errors = $validator->errors()->toArray();

        $response = [
            'statusCode' => MessageConst::Bad_Request,
            'statusMessage' => reset($errors)[0]
        ];
        throw new HttpResponseException(
            response()->json($response, MessageConst::Bad_Request)
        );
    }
}
