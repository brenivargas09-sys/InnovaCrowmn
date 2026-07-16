<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user')->id;

        return [
            'username' => 'required|string|max:50|unique:users,username,' . $userId,
            'email' => 'required|email|max:100|unique:users,email,' . $userId,
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|in:admin,recepcionista,cliente',
            'status' => 'required|in:activo,inactivo',
        ];
    }
}
