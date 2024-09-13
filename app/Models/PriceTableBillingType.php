<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Filters\Filterable;

class PriceTableBillingType extends Model
{
    use HasFactory, SoftDeletes, Filterable;
    protected $table = 'price_table_billing_types';
    protected $fillable = [
        'id', 
        'price_table', 
        'billing_type', 
        'status'
    ];
}
