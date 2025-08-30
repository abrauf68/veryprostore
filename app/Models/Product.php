<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'vendor_id',
        'sku',
        'short_description',
        'description',
        'main_image',
        'category_id',
        'price',
        'discount',
        'stock',
        'is_active',
        'is_popular',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }
}
