<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Filters\Filterable;

class CustomerBillingType extends Model
{
    use HasFactory, SoftDeletes, Filterable;
    protected $table = 'customer_billing_types';
    protected $fillable = [
        'id', 
        'customer', 
        'billing_type', 
        'status'
    ];
}
