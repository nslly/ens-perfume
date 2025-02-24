<?php

namespace App\Models\Product;

use App\Models\Brand;
use App\Models\Product\Category;
use App\Enums\GenderIdentification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'brand_id',
        'description',
        'volume',
        'quantity',
        'price',
        'discount',
        'images',
        'gender',
    ];


    protected $casts = [
        'gender' => GenderIdentification::class,
        'images' => 'array',
    ];



    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}
