<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Filters\Filterable;

class PaymentTerm extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    protected $fillable = [
        'id', 'payment_term', 'payment_term_description', 'status', 'payment_term_medium'
    ];
}
