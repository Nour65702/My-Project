<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryFormRequest extends FormRequest
{
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
            'parent_id' => ['nullable', 'integer', 'exists:categories,id'],
            'image' => ['required', 'image', 'dimensions:max_width=3840,max_height=2160',  'mimes:gif,png,jpg', 'max:2700'],
        ];
    }
}
