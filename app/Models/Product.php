<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'title', 'sku', 'description'
    ];


    public function productImages(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }


    public function variants(): BelongsToMany
    {
        return $this->belongsToMany(
            Variant::class,
            'product_variants',
            'product_id',
            'variant_id')
            ->withPivot('variant')
            ->withTimestamps();
    }

    public function productVariants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }


    public function productVariantPrices(): HasMany
    {
        return $this->hasMany(ProductVariantPrice::class);
    }

}
