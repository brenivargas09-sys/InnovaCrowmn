<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InfoUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'hotel_name' => 'nullable|string|max:200',
            'hotel_subtitle' => 'nullable|string|max:200',
            'about_text' => 'nullable|string|max:3000',
            'mission' => 'nullable|string|max:1000',
            'vision' => 'nullable|string|max:1000',
            'values' => 'nullable|string|max:1000',
            'contact_address' => 'nullable|string|max:300',
            'contact_phone' => 'nullable|string|max:50',
            'contact_phone2' => 'nullable|string|max:50',
            'contact_email' => 'nullable|string|max:150',
            'contact_email2' => 'nullable|string|max:150',
            'schedule_weekdays' => 'nullable|string|max:100',
            'schedule_weekends' => 'nullable|string|max:100',
            'social_facebook' => 'nullable|string|max:300',
            'social_instagram' => 'nullable|string|max:300',
            'social_twitter' => 'nullable|string|max:300',
            'social_whatsapp' => 'nullable|string|max:300',
            'footer_text' => 'nullable|string|max:500',
            'map_latitude' => 'nullable|numeric|between:-90,90',
            'map_longitude' => 'nullable|numeric|between:-180,180',
            'map_zoom' => 'nullable|integer|min:1|max:21',
        ];
    }
}
