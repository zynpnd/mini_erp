<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],

            'department_id' => ['sometimes', 'exists:departments,id'],

            'assigned_user_id' => ['sometimes', 'nullable', 'exists:users,id'],

            // status burada YOK (bilerek)
            'due_date' => ['sometimes', 'nullable', 'date', 'after_or_equal:today'],
        ];
    }
    public function messages(): array
    {
        return [
            'department_id.exists' => 'Geçersiz departman.',
            'assigned_user_id.exists' => 'Geçersiz kullanıcı.',
            'due_date.after_or_equal' => 'Bitiş tarihi bugünden önce olamaz.',
        ];
    }
}
