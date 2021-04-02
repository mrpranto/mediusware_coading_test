<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariantPrice extends Model
{

    protected $fillable = [
      'product_variant_one', 'product_variant_two', 'product_variant_three', 'title',
        'price', 'stock', 'product_id'
    ];


    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }


    public function productVariantOne(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class,'product_variant_one', 'id');
    }


    public function productVariantTwo(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class,'product_variant_two', 'id');
    }


    public function productVariantThree(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class,'product_variant_three', 'id');
    }
}
