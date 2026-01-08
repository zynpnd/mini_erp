<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskStatusRequest extends FormRequest
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
            'status' => ['required', 'in:todo,doing,done'],
        ];
    }
       public function messages(): array
    {
        return [
            'status.required' => 'Görev durumu zorunludur.',
            'status.in' => 'Geçersiz görev durumu.',
        ];
    }
}
