<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class CategoryUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'image' => ['nullable', 'image', 'mimes:png,jpeg,jpg,webp', 'max:3000'],
            'name' =>  ['required', 'string','max:255', Rule::unique('categories', 'name')->ignore($this->route('service_category'))],
            'status' => ['required', 'boolean'],
            'show_at_trending' => ['required', 'boolean'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'status' => $this->has('status') ? 1 : 0,
            'show_at_trending' => $this->has('show_at_trending') ? 1 : 0,
        ]);
    }
}
