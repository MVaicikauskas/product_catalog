<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'product.' . Product::COL_TITLE => 'required|string',
            'product.' . Product::COL_PRICE => 'required|numeric',
            'product.' . Product::COL_CONDITION => 'required|string',
            'product.' . Product::COL_STOCK => 'required|integer',
            'product.' . Product::COL_MODEL => 'required|string',
            'product.' . Product::COL_IMAGE_URL => 'required|string|active_url',
            'product.' . Product::COL_PRODUCT_URL => 'required|string|active_url',
            'product.' . Product::COL_DELIVERY_PRICE => 'required|numeric',
            'product.' . Product::COL_DELIVERY_TIME => 'required|string',
            'product.' . Product::RELATION_BRAND => 'required_if:product.' . Product::RELATED_PIVOT_KEY_BRAND_ID . ',null|string|unique:brands,name',
            'product.' . Product::RELATED_PIVOT_KEY_BRAND_ID => 'required_if:product.' . Product::RELATION_BRAND . ',null|nullable|integer|exists:brands,id',
            'product.' . Product::RELATION_CATEGORY => 'required_if:product.' . Product::RELATED_PIVOT_KEY_CATEGORY_ID . ',null|string|unique:categories,title',
            'product.' . Product::RELATED_PIVOT_KEY_CATEGORY_ID => 'required_if:product.' . Product::RELATION_CATEGORY . ',null|nullable|integer|exists:categories,id',
        ];
    }
}
