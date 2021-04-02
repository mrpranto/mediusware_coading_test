<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Variant extends Model
{
    protected $fillable = [
        'title', 'description'
    ];


    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'product_variants',
            'product_id',
            'variant_id')
            ->withTimestamps();
    }

    public function productVariants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

}
