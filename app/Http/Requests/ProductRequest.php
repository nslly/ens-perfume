<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Enums\GenderIdentification;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'description' => ['required', 'string', 'max:2000'], 
            'price' => ['required', 'numeric', 'min:0'], 
            'category_id' => ['required', 'exists:categories,id'], 
            'brand_id' => ['required', 'exists:brands,id'], 
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'], 
            'volume' => ['required', 'numeric', 'min:1'],
            'quantity' => ['required', 'integer', 'min:0'], 
            'discount' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'gender' => ['required', Rule::in(GenderIdentification::cases())], 
        ];
    }
}
