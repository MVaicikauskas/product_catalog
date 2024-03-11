<?php

namespace App\Http\Requests;

use App\Models\Group;
use Illuminate\Foundation\Http\FormRequest;

class FilterProductsRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'categories' => 'required|array',
            'categories.*' => 'integer|exists:categories,id',
            'brands' => 'required|array',
            'brands.*' => 'integer|exists:brands,id',
            'price' => 'nullable|min:0|max:5',
        ];
    }
}
