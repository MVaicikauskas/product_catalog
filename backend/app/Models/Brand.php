<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Brand extends Model
{
    use HasFactory;

    public const COL_ID = 'id';
    public const COL_NAME = 'name';
    public const COL_CODE = 'code';

    // Relation tables
    public const RELATION_TABLE_PRODUCT_BRAND = 'product_brand';
    //

    // Foreign keys
    public const FOREIGN_KEY_BRAND_ID = 'brand_id';
    //

    // Related keys
    public const RELATED_PIVOT_KEY_PRODUCT_ID = 'product_id';
    //

    // Relations
    public const RELATION_PRODUCTS = 'products';
    //

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::COL_NAME,
        self::COL_CODE,
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
     * Brand that belongs to products.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Brand::class,
            self::RELATION_TABLE_PRODUCT_BRAND,
            self::FOREIGN_KEY_BRAND_ID,
            self::RELATED_PIVOT_KEY_PRODUCT_ID);
    }
}
