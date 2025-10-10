<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubCategory extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'status',
        'date',
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'sub_category_id');
    }

    public function jobCardItems()
    {
        return $this->hasMany(JobCardItem::class, 'sub_category_id');
    }
}
