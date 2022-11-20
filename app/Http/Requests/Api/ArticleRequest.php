<?php

namespace App\Http\Requests\Api;

use App\Consts\Api\MessageConst;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return  true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "title" => "required|max:255|min:5|string",
            "content" => "required|max:1000|min:10|string",
            "prefecture" => "between:1, 47|required",
            "rating" => "between:0, 5|integer",
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'タイトル',
            'content' => '投稿内容',
            'prefecture' => '都道府県',
            'rating' => 'レーティング'
        ];
    }

    public function errorMessages()
    {
        return [
            'required' => ':attributeは入力必須となっております。',
            'string' => ':attributeの値が不正です。',
            'integer' => ':attributeの値が不正です。',
            'min' => ':attributeの値は%d文字以上の入力が必要です。',
            'max' => ':attributeの値は%d文字以下の入力が必要です。',
            'between' => ':attributeは%dから%dの間の数字で入力してください。',
        ];
    }

    public function messages()
    {
        $message = $this->errorMessages();
        return  [
            //title
            "title.required" => $message['required'],
            "nickName.max" => sprintf($message['max'], 255),
            "nickName.min" => sprintf($message['min'], 5),
            "title.string" => $message['string'],

            //content
            "content.required" => $message['required'],
            "content.max" => sprintf($message['max'], 255),
            "content.min" => sprintf($message['min'], 5),
            "content.string" => $message['string'],

            //prefecture
            "prefecture.required" => $message['required'],
            "prefecture.between" => sprintf($message['between'], 1, 47),

            //rating
            "rating.between" => sprintf($message['between'], 0, 5),
            "rating.integer" => $message['integer']
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
