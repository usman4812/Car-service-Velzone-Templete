<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobCard extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'car_manufacture_id',
        'sale_person_id',
        'job_card_no',
        'date',
        'name',
        'email',
        'phone',
        'car_model',
        'car_plat_no',
        'chassis_no',
        'manu_year',
        'full_car',
        'promo',
        'remarks',
        'full_car_price',
        'amount',
        'vat',
        'discount',
        'net_amount',
    ];
    public function carManufacture()
    {
        return $this->belongsTo(CarManufactures::class, 'car_manufacture_id');
    }

    /**
     * Get the sales person associated with the job card.
     */
    public function salesPerson()
    {
        return $this->belongsTo(SalesPerson::class, 'sale_person_id');
    }

    public function items()
    {
        return $this->hasMany(JobCardItem::class, 'job_card_id');
    }
}
