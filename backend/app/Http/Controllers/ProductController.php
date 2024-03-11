<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterProductsRequest;
use App\Http\Requests\ImportProductsRequest;
use App\Http\Requests\StoreProductRequest;
use App\Repository\BrandRepositoryInterface;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\ProductRepositoryInterface;
use App\Services\ProductService;

class ProductController extends Controller
{
    private $categoryRepository;
    private $brandRepository;
    private $productRepository;

    /**
     * @param CategoryRepositoryInterface $categoryRepository
     * @param BrandRepositoryInterface $brandRepository
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository, BrandRepositoryInterface $brandRepository, ProductRepositoryInterface $productRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->brandRepository = $brandRepository;
        $this->productRepository = $productRepository;
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        ProductService::storeProduct($request->validated('product'));
    }

    /**
     * @param ImportProductsRequest $request
     * @return
     */
    public function importXml(ImportProductsRequest $request): void {
        ProductService::importEmployees($request, $this->categoryRepository, $this->brandRepository);
    }

    /**
     * @return array
     */
    public function getMainData(): array
    {
        return ProductService::getMainData($this->categoryRepository, $this->brandRepository, $this->productRepository);
    }

    public function filterProducts(FilterProductsRequest $request): array
    {
        return ProductService::filter($this->productRepository, $request->validated());
    }
}
