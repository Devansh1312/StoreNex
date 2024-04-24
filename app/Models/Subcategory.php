<?php

// Subcategory.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable = ["product_category_id", "name", "image"];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, "product_category_id");
    }

    public function products()
    {
        return $this->hasMany(Product::class, "subcategory_id");
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
