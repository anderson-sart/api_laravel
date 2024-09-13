<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Filters\Filterable;

class PaymentTermMedium extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    protected $table = 'payment_term_medium';
    protected $fillable = [
        'id', 'payment_term_medium', 'minimum_discount_percentage', 'status', 'maximum_discount_percentage'
    ];
}
