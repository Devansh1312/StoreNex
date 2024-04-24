<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePageBlog extends Model
{
    use HasFactory;

    protected $fillable = ['title','sub-title', 'image'];
}
