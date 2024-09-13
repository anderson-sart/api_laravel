<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Filters\Filterable;

class SaleDeliveryPeriod extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    protected $table = 'sale_delivery_periods';

    protected $fillable = [
        'id', 
        'sale_delivery_period', 
        'description_period' ,
        'initial_date', 
        'final_date' ,
        'date_change' ,
        'data_reference' ,
        'status'
    ];

}
