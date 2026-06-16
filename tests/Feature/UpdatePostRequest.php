<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categories'   => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ];
    }
}