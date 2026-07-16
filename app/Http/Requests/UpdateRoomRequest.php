<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $roomId = $this->route('room')->id;

        return [
            'room_number' => 'required|string|max:10|unique:rooms,room_number,' . $roomId,
            'room_type_id' => 'required|exists:room_types,id',
            'floor' => 'required|integer|min:1',
            'status' => 'required|in:disponible,reservada,ocupada,mantenimiento',
            'description' => 'nullable|string',
        ];
    }
}
