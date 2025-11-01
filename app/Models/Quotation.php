<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quotation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'quotation_no',
        'date',
        'customer_name',
        'customer_email',
        'customer_phone',
        'car_model',
        'car_plat_no',
        'chassis_no',
        'amount',
        'net_amount',
        'discount_amount',
        'discount_percent',
        'vat_amount',
        'total_payable'
    ];

    /**
     * Get the quotation items for this quotation.
     */
    public function items()
    {
        return $this->hasMany(QuotationItem::class);
    }
}
