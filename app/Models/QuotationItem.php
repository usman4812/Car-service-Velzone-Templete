<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuotationItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'quotation_id',
        'category_id',
        'sub_category_id',
        'product_id',
        'qty',
        'price',
        'sub_total',
        'total',
        'amount',
        'vat',
        'discount',
        'net_amount',
    ];

    /**
     * Get the category for this quotation item.
     */
    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    /**
     * Get the sub category for this quotation item.
     */
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    /**
     * Get the product for this quotation item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
