<?php

namespace App\Repository\Eloquent;

use App\Models\Brand;
use App\Repository\BrandRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class BrandRepository extends BaseRepository implements BrandRepositoryInterface
{

    /**
     * UserRepository constructor.
     *
     * @param Brand $model
     */
    public function __construct(Brand $model)
    {
        parent::__construct($model);
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->select([
            Brand::COL_ID,
            Brand::COL_NAME,
        ])->get();
    }

    /**
     * @param string $name
     * @return Builder
     */
    public function getBrandByName(string $name): Builder {
        return $this->model->where(Brand::COL_NAME, $name);
    }
}
