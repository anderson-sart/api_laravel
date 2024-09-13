<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Filters\Filterable;

class PriceTablePaymentTerm extends Model
{
    use HasFactory, SoftDeletes, Filterable;
    protected $table = 'price_tables_payment_terms';
    protected $fillable = [
        'id', 
        'price_table', 
        'payment_term', 
        'status'
    ];
}
