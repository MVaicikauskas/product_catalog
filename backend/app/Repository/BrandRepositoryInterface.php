<?php

namespace App\Repository;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

interface BrandRepositoryInterface
{
    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @param string $name
     * @return Builder
     */
    public function getBrandByName(string $name): Builder;
}
