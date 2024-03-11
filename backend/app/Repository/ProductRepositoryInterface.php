<?php

namespace App\Repository;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

interface ProductRepositoryInterface
{
    /**
     * @return Collection
     */
    public function all(): Collection;
}
