<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

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
            "nickName" => "required|max:255|regex:/^[A-Za-z\d_\-]+$/",
            "password" => "required|max:100|regex:/^[A-Za-z\d_\-]+$/",
            "address" => "required|max:100|unique:admins|email",
            "age" => "required|integer|between:10,120",
            "sex" => "required|integer|between:0,2",
        ];
    }







}
