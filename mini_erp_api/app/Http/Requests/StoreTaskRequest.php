<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],

            'department_id' => ['required', 'exists:departments,id'],

            'assigned_user_id' => ['nullable', 'exists:users,id'],

            'status' => ['nullable', 'in:todo,doing,done'],
            'due_date' => ['nullable', 'date', 'after_or_equal:today'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Görev başlığı zorunludur.',
            'department_id.required' => 'Departman seçilmelidir.',
            'department_id.exists' => 'Geçersiz departman.',
            'assigned_user_id.exists' => 'Geçersiz kullanıcı.',
            'status.in' => 'Geçersiz görev durumu.',
            'due_date.after_or_equal' => 'Bitiş tarihi bugünden önce olamaz.',
        ];
    }
}
