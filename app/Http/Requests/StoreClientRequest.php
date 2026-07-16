<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:200',
            'city' => 'nullable|string|max:50',
            'id_type' => 'required|in:INE,Pasaporte,Licencia,Otro',
            'id_number' => 'required|string|max:30',
            'nationality' => 'nullable|string|max:50',
            'email' => 'required|email|unique:users',
            'username' => 'required|string|max:50|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ];
    }
}
