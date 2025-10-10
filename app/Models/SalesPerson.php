<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalesPerson extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'joining_date',
        'salary',
        'address',
        'status',
    ];

    public function jobCards()
    {
        return $this->hasMany(JobCard::class, 'sale_person_id');
    }
}
