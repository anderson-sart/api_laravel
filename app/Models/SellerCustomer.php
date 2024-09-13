<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Filters\Filterable;

class SellerCustomer extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    protected $table = 'seller_customer';

    protected $fillable = [
        'id', 
        'seller', 
        'customer',
        'status'
    ];
}
