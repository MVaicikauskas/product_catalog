<?php

namespace App\Http\Resources;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function toArray(Request $request): array
    {
        /** @var Product $product */
        $product = $this->resource;

        /** @var array $data */
        $data = $product->only([
            Product::COL_ID,
            Product::COL_TITLE,
            Product::COL_PRICE,
            Product::COL_CONDITION,
            Product::COL_STOCK,
            Product::COL_MODEL,
            Product::COL_IMAGE_URL,
            Product::COL_PRODUCT_URL,
            Product::COL_DELIVERY_PRICE,
            Product::COL_DELIVERY_TIME,
        ]);

        $data[Product::RELATION_BRAND . '_' . Brand::COL_NAME] = $product->{Product::RELATION_BRAND}->first()->{Brand::COL_NAME};
        $data[Product::RELATION_CATEGORY . '_' . Category::COL_TITLE] = $product->{Product::RELATION_BRAND}->first()->{Brand::COL_NAME};


        return $data;
    }
}
