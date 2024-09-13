<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Filters\Filterable;

class BillingType extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    protected $fillable = [
        'id', 
        'billing_type', 
        'billing_type_description', 
        'billing_perc', 
        'status'
    ];
}
