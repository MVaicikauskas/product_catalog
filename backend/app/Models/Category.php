<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    public const COL_ID = 'id';
    public const COL_TITLE = 'title';
    public const COL_EXTERNAL_ID = 'external_id';
    public const COL_LINK = 'link';
    public const COL_PARENT_ID = 'parent_id';

    // Relation tables
    public const RELATION_TABLE_PRODUCT_CATEGORY = 'product_category';
    //

    // Foreign keys
    public const FOREIGN_KEY_CATEGORY_ID = 'category_id';
    //

    // Related keys
    public const RELATED_PIVOT_KEY_PRODUCT_ID = 'product_id';
    //

    // Relations
    public const RELATION_PRODUCTS = 'products';
    public const RELATION_CHILD_CATEGORIES = 'childCategories';
    public const RELATION_PARENT_CATEGORY = 'parentCategory';
    //

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::COL_TITLE,
        self::COL_EXTERNAL_ID,
        self::COL_LINK,
        self::COL_PARENT_ID,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    /**
     * The parent category that has child categories.
     */
    public function childCategories()
    {
        return $this->hasMany(self::class, self::COL_PARENT_ID);
    }

    /**
     * Category that belongs to parent category.
     */
    public function parentCategory()
    {
        return $this->belongsTo(self::class, self::COL_PARENT_ID);
    }

    /**
     * Category that belongs to products.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class,
            self::RELATION_TABLE_PRODUCT_CATEGORY,
            self::FOREIGN_KEY_CATEGORY_ID,
            self::RELATED_PIVOT_KEY_PRODUCT_ID);
    }
}
