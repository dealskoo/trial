<?php

namespace Dealskoo\Trial\Models;

use Dealskoo\Admin\Traits\HasSlug;
use Dealskoo\Brand\Traits\HasBrand;
use Dealskoo\Category\Traits\HasCategory;
use Dealskoo\Country\Traits\HasCountry;
use Dealskoo\Platform\Traits\HasPlatform;
use Dealskoo\Product\Traits\HasProduct;
use Dealskoo\Seller\Traits\HasSeller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Trial extends Model
{
    use HasFactory, SoftDeletes, HasSlug, HasCategory, HasCountry, HasSeller, HasBrand, HasPlatform, HasProduct, Searchable;

    protected $appends = [
        'cover', 'cover_url', 'refund_rate'
    ];

    protected $fillable = [
        'title',
        'slug',
        'refund',
        'quantity',
        'ship_fee',
        'clicks',
        'seller_id',
        'product_id',
        'category_id',
        'country_id',
        'brand_id',
        'platform_id',
        'approved_at',
        'start_at',
        'end_at'
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'start_at' => 'datetime',
        'end_at' => 'datetime'
    ];

    public function getCoverAttribute()
    {
        return $this->product->cover;
    }

    public function getCoverUrlAttribute()
    {
        return $this->product->cover_url;
    }

    public function getRefundRateAttribute()
    {
        return round(($this->refund / $this->product->price) * 100);
    }

    public function scopeApproved(Builder $builder)
    {
        return $builder->whereNotNull('approved_at');
    }

    public function scopeAvaiabled(Builder $builder)
    {
        $now = now();
        return $builder->whereNotNull('approved_at')->where('start_at', '<=', $now)->where('end_at', '>=', $now);
    }

    public function shouldBeSearchable()
    {
        return $this->approved_at ? true : false;
    }

    public function toSearchableArray()
    {
        return $this->only([
            'title',
            'slug',
            'seller_id',
            'product_id',
            'category_id',
            'country_id',
            'brand_id',
            'platform_id'
        ]);
    }
}
