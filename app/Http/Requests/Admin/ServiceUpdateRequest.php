<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class ServiceUpdateRequest extends FormRequest
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
            'image' => ['nullable', 'image', 'mimes:png,jpeg,jpg,webp', 'max:3000'],
            'name' =>  ['required', 'string','max:255', Rule::unique('service_sub_categories', 'name')->ignore($this->route('service'))],
            'status' => ['required', 'boolean'],
            'price' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'sale_price' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'status' => $this->has('status') ? 1 : 0,
        ]);
    }

}
