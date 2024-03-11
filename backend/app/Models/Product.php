<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    public const COL_ID = 'id';
    public const COL_TITLE = 'title';
    public const COL_PRICE = 'price';
    public const COL_CONDITION = 'condition';
    public const COL_STOCK = 'stock';
    public const COL_MODEL = 'model';
    public const COL_IMAGE_URL = 'image_url';
    public const COL_PRODUCT_URL = 'product_url';
    public const COL_DELIVERY_PRICE = 'delivery_price';
    public const COL_DELIVERY_TIME = 'delivery_time';

    // Relation tables
    public const RELATION_TABLE_PRODUCT_BRAND = 'product_brand';
    public const RELATION_TABLE_PRODUCT_CATEGORY = 'product_category';
    //

    // Foreign keys
    public const FOREIGN_KEY_PRODUCT_ID = 'product_id';
    //

    // Related keys
    public const RELATED_PIVOT_KEY_BRAND_ID = 'brand_id';
    public const RELATED_PIVOT_KEY_CATEGORY_ID = 'category_id';
    //

    // Relations
    public const RELATION_BRAND = 'brand';
    public const RELATION_CATEGORY = 'category';
    //


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::COL_TITLE,
        self::COL_PRICE,
        self::COL_CONDITION,
        self::COL_STOCK,
        self::COL_MODEL,
        self::COL_IMAGE_URL,
        self::COL_PRODUCT_URL,
        self::COL_DELIVERY_PRICE,
        self::COL_DELIVERY_TIME,
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
     * The supergroup that has child groups.
     */
    public function category(): BelongsToMany
    {
        return $this->belongsToMany(Brand::class,
            self::RELATION_TABLE_PRODUCT_CATEGORY,
            self::FOREIGN_KEY_PRODUCT_ID,
            self::RELATED_PIVOT_KEY_CATEGORY_ID);
    }

    /**
     * Product that belongs to brand.
     */
    public function brand(): BelongsToMany
    {
        return $this->belongsToMany(Brand::class,
            self::RELATION_TABLE_PRODUCT_BRAND,
            self::FOREIGN_KEY_PRODUCT_ID,
            self::RELATED_PIVOT_KEY_BRAND_ID);
    }
}
