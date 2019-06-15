<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required',
            'text' => 'required',
            'publish_date' => 'date',
            'published' => 'boolean',
            'blog_content' => 'boolean',
            'tags_text' => 'present',
            'external_url' => '',
        ];
    }
}
