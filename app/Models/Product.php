<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'sub_category_id',
        'name',
        'price',
        'warranty',
        'description',
        'date',
        'status',
        'code',
        'image',
    ];
    // Relation with Category
    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    // Relation with SubCategory
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function jobCardItems()
    {
        return $this->hasMany(JobCardItem::class, 'product_id');
    }
}
