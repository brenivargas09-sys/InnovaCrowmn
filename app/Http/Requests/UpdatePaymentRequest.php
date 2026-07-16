<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reservation_id' => 'required|exists:reservations,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:efectivo,tarjeta_credito,tarjeta_debito,transferencia',
            'payment_date' => 'required|date|before_or_equal:today',
            'reference_number' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:500',
        ];
    }
}
