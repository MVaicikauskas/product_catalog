<?php

namespace App\Repository;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

interface CategoryRepositoryInterface
{
    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @param string $title
     * @return Builder
     */
    public function getCategoryByTitle(string $title): Builder;
}
