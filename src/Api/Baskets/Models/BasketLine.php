<?php

namespace GetCandy\Api\Baskets\Models;

use GetCandy\Api\Scaffold\BaseModel;
use GetCandy\Api\Products\Models\ProductVariant;

class BasketLine extends BaseModel
{
    protected $hashids = 'basket';

    protected $fillable = ['quantity', 'product_variant_id', 'total'];

    public function getCurrentTotalAttribute()
    {
        $tieredPrice = app('api')->productVariants()->getTieredPrice($this->variant, $this->quantity, \Auth::user());
        if ($tieredPrice) {
            return $this->quantity * $tieredPrice->amount;
        }

        return $this->quantity * $this->variant->total_price;
    }

    public function getCurrentTaxAttribute()
    {
        return $this->quantity * $this->variant->tax_total;
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
}
