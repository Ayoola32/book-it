<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
    public function rules()
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255',Rule::unique('users', 'email')->ignore($this->route('user'))],
            'phone' => ['required', 'regex:/^[+]?[0-9\s\-\(\)]{7,20}$/', Rule::unique('users', 'phone')->ignore($this->route('user'))],
            'status' => ['required', 'boolean'],
            'role' => ['required', 'in:user,employee,moderator'],
        ];

        if ($this->role === 'employee') {
            $rules = array_merge($rules, [
                'service' => ['nullable', 'array'],
                'slot_duration' => ['nullable', 'integer', 'min:10', 'max:60'],
                'break_duration' => ['nullable', 'integer', 'min:5', 'max:30'],
                'total_holiday_days' => ['nullable', 'integer', 'min:5', 'max:35'],
            ]);
        }

        return $rules;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'status' => $this->has('status') ? 1 : 0,
        ]);
    }
}
