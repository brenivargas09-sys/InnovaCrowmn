<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HeroUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'hero_title' => 'nullable|string|max:200',
            'hero_subtitle' => 'nullable|string|max:200',
            'hero_description' => 'nullable|string|max:1000',
        ];
    }
}
