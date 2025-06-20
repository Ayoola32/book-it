<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'regex:/^[+]?[0-9\s\-\(\)]{7,20}$/', 'unique:' . User::class],
            'status' => ['required', 'boolean'],
            'role' => ['required', 'in:user,employee,moderator'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'status' => $this->has('status') ? 1 : 0,
        ]);
    }
}
