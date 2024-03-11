<?php

namespace App\Providers;

use App\Repository\BrandRepositoryInterface;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\CompanyRepositoryInterface;
use App\Repository\DocumentCategoryRepositoryInterface;
use App\Repository\DocumentRepositoryInterface;
use App\Repository\CompanyPositionRepositoryInterface;
use App\Repository\Eloquent\BrandRepository;
use App\Repository\Eloquent\CategoryRepository;
use App\Repository\Eloquent\CompanyRepository;
use App\Repository\Eloquent\DocumentCategoryRepository;
use App\Repository\Eloquent\DocumentRepository;
use App\Repository\Eloquent\CompanyPositionRepository;
use App\Repository\Eloquent\ProductRepository;
use App\Repository\Eloquent\RoleRepository;
use App\Repository\EloquentRepositoryInterface;
use App\Repository\ProductRepositoryInterface;
use App\Repository\RoleRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Repository\Eloquent\UserRepository;
use App\Repository\Eloquent\BaseRepository;
use Illuminate\Support\ServiceProvider;

/**
 * Class RepositoryServiceProvider
 * @package App\Providers
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(BrandRepositoryInterface::class, BrandRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
