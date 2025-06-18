<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQueuedWebhookRequest extends FormRequest
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
            'status'          => ['sometimes', 'string', 'in:pending,inprogress,hold,failed'],
            'retry_attempts'  => ['sometimes', 'integer', 'min:0'],
            'last_attempt_at' => ['sometimes', 'date'],
            'response_log'    => ['sometimes', 'array'],
        ];
    }
}
