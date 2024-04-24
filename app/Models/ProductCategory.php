<?php

// ProductCategory.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image'];

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class, 'product_category_id');
    }
}

