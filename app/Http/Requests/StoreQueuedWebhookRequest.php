<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQueuedWebhookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'transaction_id' => ['required', 'uuid'],
            'event_type'     => ['required', 'string', 'in:TRANSACTION_CREATED,TRANSACTION_PENDING,TRANSACTION_FAILED,TRANSACTION_COMPLETED'],
            'payload'        => ['required', 'array'],
        ];
    }
}
