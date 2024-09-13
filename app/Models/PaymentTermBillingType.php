<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Filters\Filterable;

class PaymentTermBillingType extends Model
{
    use HasFactory, SoftDeletes, Filterable;
    protected $table = 'payment_term_billing_types';
    protected $fillable = [
        'id', 
        'payment_term', 
        'billing_type', 
        'status'
    ];
}
