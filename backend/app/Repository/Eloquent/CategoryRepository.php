<?php

namespace App\Repository\Eloquent;

use App\Models\Category;
use App\Repository\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{

    /**
     * UserRepository constructor.
     *
     * @param Category $model
     */
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->with([
            Category::RELATION_CHILD_CATEGORIES
        ])->select([
            Category::COL_ID,
            Category::COL_TITLE,
            Category::COL_PARENT_ID,
        ])->get();
    }

    /**
     * @param string $title
     * @return Builder
     */
    public function getCategoryByTitle(string $title): Builder
    {
        return $this->model->where(Category::COL_TITLE, $title);
    }
}
