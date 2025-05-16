<?php

namespace App\Models\Product;

use App\Models\Brand;
use Illuminate\Support\Str;
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
        'category_id',
        'brand_id',
        'description',
        'volume',
        'quantity',
        'price',
        'discount',
        'image',
        'gender',
    ];


    protected static function boot()
    {
        parent::boot();

        static::saving(function ($product) {
            if (!$product->slug || $product->isDirty('name')) {
                $product->slug = Str::slug($product->name);

                $originalSlug = $product->slug;
                $counter = 1;
                while (static::where('slug', $product->slug)->where('id', '!=', $product->id)->exists()) {
                    $product->slug = $originalSlug . '-' . $counter++;
                }
            }
        });
    }


    protected $casts = [
        'gender' => GenderIdentification::class,
    ];


    public function getRouteKeyName()
    {
        return 'slug';
    }





    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}
