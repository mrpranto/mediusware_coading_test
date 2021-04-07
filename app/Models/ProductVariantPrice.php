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

}
