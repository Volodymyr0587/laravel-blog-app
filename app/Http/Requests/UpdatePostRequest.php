<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'title' => 'required|string|min:1|max:300',
            'image_path' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'body' => 'required|string|min:1|max:5000',
            'category_id' => 'required|array',
            'category_id.*' => 'exists:categories,id',
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => 'The category field is required.',
        ];
    }
}
