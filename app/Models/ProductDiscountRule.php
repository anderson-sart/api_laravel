<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Filters\Filterable;

class ProductDiscountRule extends Model
{
    use HasFactory, SoftDeletes, Filterable;
    protected $fillable = [
        'id',
        'product',
        'color', 
        'price_table', 
        'discount_perc_type', 
        'minimum_discount_percentage', 
        'maximum_discount_percentage',  
        'range_sale_value',  
        'range_sale_quantity',  
        'product_discount_rule',
        'status'
    ];

}
