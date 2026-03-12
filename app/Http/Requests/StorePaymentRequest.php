<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min:0.01'],
            'payment_method' => ['required', Rule::in(['cash', 'card', 'bank_transfer', 'wallet', 'upi'])],
            'payment_type' => ['required', Rule::in(['advance', 'full', 'security_deposit', 'extra_charge'])],
            'notes' => ['nullable', 'string'],
        ];
    }
}
