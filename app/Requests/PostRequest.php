<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|min:10',
            'content' => 'required|string',
            'category_id' => 'nullable|integer'
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => '標題',
            'content' => '內容',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => ':attribute 必填',
            'content.required' => ':attribute 必填',
            'title.min' => ':attribute 至少要 :min 個字元',
        ];
    }
}