<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'icon',
        'description',
        'is_active',
        'is_popular',
        'parent_category_id',
    ];

    // Parent relation
    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_category_id');
    }

    // Children relation
    public function children()
    {
        return $this->hasMany(ProductCategory::class, 'parent_category_id')->where('is_active', 'active');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
