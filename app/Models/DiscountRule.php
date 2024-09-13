<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Filters\Filterable;

class DiscountRule extends Model
{
    use HasFactory, SoftDeletes, Filterable;
    protected $fillable = [
        'id',
        'discount_rule',
        'discount_rule_description', 
        'minimum_discount_percentage', 
        'maximum_discount_percentage',  
        'range_sale_value',  
        'range_sale_quantity',  
        'price_table', 
        'type_sale', 
        'status'
    ];

}
