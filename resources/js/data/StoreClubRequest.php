<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClubRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'acronym'     => 'required|string|max:20',
            'description' => 'required|string|max:1000',
            'theme'       => 'required|string|in:code,robotics,ai,cyber,network,industrial,social,leadership,management',
        ];
    }
}