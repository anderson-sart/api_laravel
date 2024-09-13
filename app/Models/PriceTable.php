<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Filters\Filterable;

class PriceTable extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    protected $fillable = [
        'id', 
        'price_table', 
        'price_table_code', 
        'price_table_description', 
        'status'
    ];
}
