<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportProductsRequest;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Repository\BrandRepositoryInterface;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\Eloquent\ProductRepository;
use App\Repository\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductService extends Controller
{
    public const MAIN_DATA_CATEGORIES = 'categories';
    public const MAIN_DATA_BRANDS = 'brands';
    public const MAIN_DATA_PRODUCTS = 'products';

    /**
     * @param ProductRepository $productRepository
     * @param array $filters
     * @return array
     */
    public static function filter(ProductRepository $productRepository, array $filters): array
    {
        /** @var Builder | null $products */
        $products = null;

        /** @var array $categories */
        $categories = [];

        /** @var array $brands */
        $brands = [];

        /** @var null | int $page */
        $page = null;

        /** @var null | int $perPage */
        $perPage = null;

        /**
         * @var string $key
         * @var string | null $filter
         */
        foreach ($filters['filters'] as $filter) {
            switch ($filter['filter']) {
                case 'categories':
                    $categories = $filter['value'];

                    break;

                case 'brands':
                    $brands = $filter['value'];

                    break;
            }
        }

        $products = $products->paginate(
            $perPage,
            '*',
            'page',
            $page);

        $recordsCount = $products->total();

        return [
            'products' => ProductResource::collection($products),
            'lastPage' => $products->lastPage(),
            'recordsCount' => $recordsCount,
            'currentPage' => $page,
        ];
    }

    /**
     * @param ImportProductsRequest $request
     * @param CategoryRepositoryInterface $categoryRepository
     * @param BrandRepositoryInterface $brandRepository
     * @return void
     */
    public static function importEmployees(ImportProductsRequest $request, CategoryRepositoryInterface $categoryRepository, BrandRepositoryInterface $brandRepository): void
    {
        /** @var string $path */
        $path = $request->file('file')->store('imports');

        if (File::exists(storage_path('app/' . $path))) {
            $xmlString = file_get_contents(storage_path('app/' . $path));
            $xmlObject = simplexml_load_string($xmlString);

            $json = json_encode($xmlObject);
            $products = json_decode($json, true);

            (new ProductService)->handleProductsImport($products, $categoryRepository, $brandRepository);
        }

        Storage::delete(storage_path('app/' . $path));
    }

    /**
     * @param array $products
     * @param CategoryRepositoryInterface $categoryRepository
     * @param BrandRepositoryInterface $brandRepository
     * @return void
     */
    private function handleProductsImport(array $products, CategoryRepositoryInterface $categoryRepository, BrandRepositoryInterface $brandRepository): void
    {
        if (!count($products)) {
            abort(404, 'No products found');
        }

        DB::beginTransaction();

        try {
            foreach ($products['product'] as $product) {
                if (floatval($product['price']) > 5 ) {
                    continue;
                }

                /** @var Category $category */
                $category = $categoryRepository->getCategoryByTitle($product['category_name'])->first();

                /** @var Brand $brand */
                $brand = $brandRepository->getBrandByName($product['manufacturer'])->first();

                /** @var Product $newProduct */
                $newProduct = new Product();

                if ($product['category_name'] && !$category) {
                    $category = new Category();
                    $category->{Category::COL_TITLE} = $product['category_name'];
                    $category->{Category::COL_EXTERNAL_ID} = $product['category_id'];
                    $category->{Category::COL_LINK} = $product['category_link'];
                    $category->save();
                }

                if ($product['manufacturer'] && !$brand) {
                    $brand = new Brand();
                    $brand->{Brand::COL_NAME} = $product['manufacturer'];
                    $brand->{Brand::COL_CODE} = $product['manufacturer_code'];
                    $brand->save();
                }

                $newProduct->{Product::COL_TITLE} = $product[Product::COL_TITLE];
                $newProduct->{Product::COL_PRICE} = floatval($product[Product::COL_PRICE]);
                $newProduct->{Product::COL_CONDITION} = $product[Product::COL_CONDITION];
                $newProduct->{Product::COL_STOCK} = $product[Product::COL_STOCK];
                $newProduct->{Product::COL_MODEL} = $product[Product::COL_MODEL];
                $newProduct->{Product::COL_IMAGE_URL} = $product[Product::COL_IMAGE_URL];
                $newProduct->{Product::COL_PRODUCT_URL} = $product[Product::COL_PRODUCT_URL];
                $newProduct->{Product::COL_DELIVERY_PRICE} = floatval($product[Product::COL_DELIVERY_PRICE]);
                $newProduct->{Product::COL_DELIVERY_TIME} = $product[Product::COL_DELIVERY_TIME];
                $newProduct->save();

                $newProduct->{Product::RELATION_BRAND}()->attach($brand->{Brand::COL_ID});
                $newProduct->{Product::RELATION_CATEGORY}()->attach($category->{Category::COL_ID});
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            abort(500, $e->getMessage());
        }
    }

    /**
     * @param CategoryRepositoryInterface $categoryRepository
     * @param BrandRepositoryInterface $brandRepository
     * @param ProductRepositoryInterface $productRepository
     * @return array[]
     */
    public static function getMainData(CategoryRepositoryInterface $categoryRepository, BrandRepositoryInterface $brandRepository, ProductRepositoryInterface $productRepository): array
    {
        return [
            self::MAIN_DATA_CATEGORIES => CategoryResource::collection($categoryRepository->all()),
            self::MAIN_DATA_BRANDS => BrandResource::collection($brandRepository->all()),
            self::MAIN_DATA_PRODUCTS => ProductResource::collection($productRepository->all()),
        ];
    }

    /**
     * @param array $product
     * @return void
     */
    public static function storeProduct(array $product): void
    {
        DB::beginTransaction();

        try {
            /** @var null | int $category */
            $category = null;

            if (array_key_exists(Product::RELATED_PIVOT_KEY_CATEGORY_ID, $product)) {
                $category = $product[Product::RELATED_PIVOT_KEY_CATEGORY_ID];
            }

            if (!$category) {
                /** @var Category $newCategory */
                $newCategory = new Category();
                $newCategory->{Category::COL_TITLE} = $product[Product::RELATION_CATEGORY];
                $newCategory->save();

                $category = $newCategory->{Category::COL_ID};
            }

            /** @var null | int $brand */
            $brand = null;

            if (array_key_exists(Product::RELATED_PIVOT_KEY_BRAND_ID, $product)) {
                $brand = $product[Product::RELATED_PIVOT_KEY_BRAND_ID];
            }

            if (!$brand) {
                /** @var Brand $newBrand */
                $newBrand = new Brand();
                $newBrand->{Brand::COL_NAME} = $product[Product::RELATION_BRAND];
                $newBrand->save();

                $brand = $newBrand->{Brand::COL_ID};
            }

            /** @var Product $newProduct */
            $newProduct = new Product();
            $newProduct->{Product::COL_TITLE} = $product[Product::COL_TITLE];
            $newProduct->{Product::COL_PRICE} = floatval($product[Product::COL_PRICE]);
            $newProduct->{Product::COL_CONDITION} = $product[Product::COL_CONDITION];
            $newProduct->{Product::COL_STOCK} = $product[Product::COL_STOCK];
            $newProduct->{Product::COL_MODEL} = $product[Product::COL_MODEL];
            $newProduct->{Product::COL_IMAGE_URL} = $product[Product::COL_IMAGE_URL];
            $newProduct->{Product::COL_PRODUCT_URL} = $product[Product::COL_PRODUCT_URL];
            $newProduct->{Product::COL_DELIVERY_PRICE} = floatval($product[Product::COL_DELIVERY_PRICE]);
            $newProduct->{Product::COL_DELIVERY_TIME} = $product[Product::COL_DELIVERY_TIME];
            $newProduct->save();

            $newProduct->{Product::RELATION_BRAND}()->attach($brand);
            $newProduct->{Product::RELATION_CATEGORY}()->attach($category);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            abort(500, $e->getMessage());
        }
    }
}
